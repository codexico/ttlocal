<?php
require_once 'model/twitterLocation.php';
require_once 'model/trend.php';

class twitterTrend extends trend {

    function __construct() {
        debug("twitterTrend constructor");
        $this->location = new twitterLocation();
    }

    public function getByWoeid($woeid, $definitions = false) {
//        debug("twitter getByWoeid");
        $dest_file = "cache/" . $woeid . ".json";
        debug($dest_file);
        $woeidtrends = json_decode(file_get_contents($dest_file));
        if ($definitions) {
            $woeidtrends[0] = $this->getWhithDefinitions($woeidtrends[0]);
        }
        return $woeidtrends[0]; //json do woeid eh um pouco diferente
    }

    public function updateByWoeid($woeid) {
        debug("twitter updateWoeid");
        $url = "http://api.twitter.com/1/trends/" . $woeid . ".json";
        $dest_file = "cache/" . $woeid . ".json";

        if (!Cache::updateCache($url, $dest_file))
            return false;

        return true;
    }

}