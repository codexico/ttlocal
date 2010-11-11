<?php

require_once('lib/util.php');
require_once 'model/twitterTrend.php';
require_once 'model/wttTrend.php';
require_once 'model/twitterLocation.php';

class Cache {

    var $location;
    var $trend;
    var $wtt;
    /**
     * Determina se o limite de requisições foi atingido
     * ou o twitter esta baleiando.
     * True se tudo ok.
     * False se problemas.
     *
     * @var boolean
     */
    private static $limit = true;

    function __construct() {
        debug('cache construtor');
        $this->location = new twitterLocation();
        $this->trend = new twitterTrend();
        $this->wtt = new wttTrend();
    }

    public function updateTwitterData() {
        if ($this->locationCacheExpired()) {
            $this->location->updateAll();
        }
        if ($this->trendCacheExpired()) {
            if (!$this->trend->updateAll())
                return false;
        }
        return true;
    }

    public function updateLocations() {
        $this->location->updateAll();
    }

    public function updateTrendsTwitter() {
        $this->trend->updateAll();
    }

    public function updateTrendsWTT() {
        $this->wtt->updateAll();
    }

    public function updateHtmlCache($definitions = false) {
        debug('update html');
        $viewdata['trends'] = $this->trend->getAllWithLocationsSortedByPlacetype($definitions);
//        debug($viewdata['trends']);
        $viewdata['places'] = $this->location->getAllSorted();
//        debug($viewdata['places']);
        $data = $this->getView('view/index.php', $viewdata);

        return $this->writeHtmlCache($data, "cache/index.html");
    }

    public function updateTrendsDefinitions() {
        $trends = $this->wtt->getAll();

        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        /* check connection */
        if (mysqli_connect_errno ()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
        foreach ($trends as $trend) {
            $this->updateTrendDB($trend, $mysqli);
        }
        $mysqli->close();
    }

    private function updateTrendDB($trend, $mysqli = false) {
        $close = false;
        debug($trend);
        if (isset($trend->{'description'}->{'text'})) {
            debug("INSERT INTO trend(name, text) VALUES({$trend->name}, {$trend->description->text})
                ON DUPLICATE KEY UPDATE text = {$trend->description->text}");

            if (!$mysqli) {
                $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                /* check connection */
                if (mysqli_connect_errno ()) {
                    printf("Connect failed: %s\n", mysqli_connect_error());
                    exit();
                }
                $close = true;
            }
            /* create a prepared statement */
            $stmt = $mysqli->prepare("INSERT INTO trend(name, text) VALUES(?, ?) ON DUPLICATE KEY UPDATE text = ?;");
            if ($stmt) {
                /* bind parameters for markers */
                $stmt->bind_param("sss", $trend->name, $trend->description->text, $trend->description->text);
                /* execute query */
                $stmt->execute();

                debug("Affected rows (INSERT):" . $mysqli->affected_rows);
                /* close statement */
                $stmt->close();
            }
            /* close connection */
            if ($close)
                $mysqli->close();
        }
    }

    static function updateCache($url, $dest_file) {

        if (Cache::$limit) {
            debug("updateCache");
            if (PRODUCTION) {
                $data = getUrlCurl($url);
            } else {
                $data = getUrl($url);
            }

            if ($data != false) {//teve resposta
                $json_data = json_decode($data);
                if (!isset($json_data->{'error'})) {//resposta sem erro
                    if (!writeFile($data, $dest_file)) {
                        debug('problema ao escrever');
                        return false;
                    }
                } else {//limite de requisicoes atingido ou twitter baleiando
                    Cache::$limit = false;
                    debug("limit max");
                    return false;
                }
                return true;
            } else {
                debug("problema no curl"); //problema no curl
                return false;
            }
        }

        return true;
    }

    public function locationCacheExpired() {
        if (!file_exists("cache/available.json") || @filemtime("cache/available.json") < (time() - LOCATIONS_REFRESH_INTERVAL)) {
            return true;
        }
    }

    public function twitterTrendCacheExpired() {
        if (!file_exists("cache/1.json") || @filemtime("cache/1.json") < (time() - TWITTER_WOEID_REFRESH_INTERVAL))
            return true;
    }

    public function wttTrendCacheExpired() {
        if (!file_exists("cache/wtt/1.json") || @filemtime("cache/wtt/1.json") < (time() - WTT_WOEID_REFRESH_INTERVAL))
            return true;
    }

    private function getView($view, $viewdata) {
        ob_start();
        include_once $view;
        $data = ob_get_contents();
        ob_end_clean();
        return $data;
    }

    private function writeHtmlCache($data, $dest_file) {
        return writeFile($data, $dest_file);
    }

    /**
     * @return int  minutos desde a ultima atualizacao
     */
    static function getLastUpdate() {
        return date("i", strtotime("now") - @filemtime("cache/1.json"));
    }

    /**
     * Atualiza os arquivos json de locations e trends e
     * o cache html.
     * @deprecated
     * @return boolean
     */
    public function update() {
        debug("update");
        $this->updateLocations();

        if (!$this->updateTrends())
            return false;

        return true;
    }

}