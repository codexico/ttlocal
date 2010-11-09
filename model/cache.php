<?php

require_once('lib/util.php');
//require_once('model/twitter.php');
//require_once('model/trendingTopic.php');
require_once 'model/twitterTrend.php';
require_once 'model/wttTrend.php';
require_once 'model/twitterLocation.php';

class Cache {

    var $location;
    var $trend;

    /**
     * Determina se o limite de requisições foi atingido
     * ou o twitter esta baleiando
     *
     * @var boolean
     */
    private static $limit = true;

    function __construct() {
        debug('cache');
        $this->location = new twitterLocation();
        //$trend = new twitterTrend();
        $this->trend = new wttTrend();
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

    public function updateHtmlCache() {
        debug('update html');
        $viewdata['trends'] = $this->trend->getAllWithLocationsSortedByPlacetype();
        $viewdata['places'] = $this->location->getAllSorted();
        $data = $this->getView('view/index.php', $viewdata);
        
        return $this->writeHtmlCache($data, "cache/index.html");
    }

    static function updateCache($url, $dest_file) {

        if (Cache::$limit)
            debug("updateCache");
        if (PRODUCTION) {
            $data = getUrlCurl($url);
        } else {
            $data = getUrl($url);
        }

        if ($data != false) {//die("teve resposta");
            $json_data = json_decode($data);
            if (!isset($json_data->{'error'})) {//die("resposta sem erro");
                if (!writeFile($data, $dest_file)) {
                    debug('problema ao escrever');
                    return false;
                }
            } else {//limite de requisicoes atingido ou twitter baleiando
                $this->limit = false;
                debug("limit");
                return false;
            }
            return true;
        } else {
            debug("curl"); //problema no curl
            return false;
        }
        return true;
    }

    private function trendCacheExpired() {
        if (!file_exists("cache/1.json") || @filemtime("cache/1.json") < (time() - WOEID_REFRESH_INTERVAL))
            return true;
    }

    private function locationCacheExpired() {
        if (!file_exists("cache/available.json") || @filemtime("cache/available.json") < (time() - LOCATIONS_REFRESH_INTERVAL)) {
            return true;
        }
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