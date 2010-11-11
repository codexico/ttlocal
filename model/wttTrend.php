<?php
require_once 'model/wttLocation.php';
require_once 'model/trend.php';

class wttTrend extends trend {

    function __construct() {
        debug("wttTrend constructor");
        $this->location = new wttLocation();
    }

    public function getByWoeid($woeid, $definitions = false) {
//        debug("wtt getByWoeid");
        $dest_file = "cache/wtt/" . $woeid . ".json";
        debug($dest_file);
        $woeidtrends = json_decode(file_get_contents($dest_file));
        if ($definitions) {
            $woeidtrends = $this->getWhithDefinitions($woeidtrends);
        }
        return $woeidtrends;
    }

    public function updateByWoeid($woeid) {
        debug("wtt updateWoeid");
        $url = "http://api.whatthetrend.com/api/v2/trends.json?api_key=" . WTT_API_KEY . "&woeid=" . $woeid;
        $dest_file = "cache/wtt/" . $woeid . ".json";

        if (!Cache::updateCache($url, $dest_file))
            debug("updateByWoeid(".$woeid.") falhou!!" );
    }

}