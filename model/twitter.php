<?php

require_once 'lib/util.php';
require_once 'trendingTopic.php';

class Twitter {

    /**
     * Determina se o limite de requisições foi atingido
     * ou o twitter esta baleiando
     *
     * @var boolean
     */
    private $limit = true;

    /**
     * Atualiza os arquivos json de locations e trends e
     * o cache html.
     *
     * @return boolean
     */
    public function update() {
        debug("update");
        $this->updateLocations();

        if (!$this->updateTrends())
            return false;

        return true;
    }

    private function updateLocations() {
        debug("updateLocations");
        if (!file_exists("cache/available.json") || @filemtime("cache/available.json") < (time() - LOCATIONS_REFRESH_INTERVAL)) {
            $url = "http://api.twitter.com/1/trends/available.json";
            $dest_file = "cache/available.json";

            $this->updateCache($url, $dest_file);
        }
    }

    private function updateTrends() {
        if (!file_exists("cache/1.json") || @filemtime("cache/1.json") < (time() - WOEID_REFRESH_INTERVAL)) {
            $locations = TrendingTopic::locations();
            debug($locations);
            foreach ($locations as $local) {
                printpre($local);
                if ($this->limit)
                    if (!$this->updateWoeid($local->{'woeid'}))
                        return false;
            }
        }else {
            debug('woeid cache dentro do time');
            return false; //nao precisou
        }

        return true; // atualizou
    }

    private function updateWoeid($woeid) {
        debug("updateWoeid");
        $url = "http://api.twitter.com/1/trends/" . $woeid . ".json";
        $dest_file = "cache/" . $woeid . ".json";

        if ($this->updateCache($url, $dest_file))
            return true;

        return false;
    }

    private function updateCache($url, $dest_file) {
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

    /*
      public function locationTrends($woeid) {
      $dest_file = "cache/" . $woeid . ".json";
      $topics = json_decode(file_get_contents($dest_file));
      return $topics[0]->{'trends'}; //json do woeid eh um pouco diferente
      }
     */
}