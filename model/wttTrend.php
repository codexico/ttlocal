<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'model/wttLocation.php';
require_once 'model/twitterTrend.php';
/**
 * Description of WTTTrend
 *
 * @author francisco
 */
class wttTrend extends twitterTrend{

    function __construct() {
        $this->location = new wttLocation();
    }

    public function getAllWithLocationsSortedByPlacetype() {
                debug('getAllWithLocationsSorted');
        $this->locations = $this->location->getAllSortedByPlacetype();
//        debug($this->locations);
        return $this->mergeLocationsWithTrends($this->locations);
    }

    public function updateByWoeid($woeid) {
        debug("wtt updateWoeid");
        $url = "http://api.whatthetrend.com/api/v2/trends.json?api_key=".WTT_API_KEY."&woeid=" . $woeid;
        $dest_file = "cache/wtt/" . $woeid . ".json";

        if (Cache::updateCache($url, $dest_file))
            return true;

        return false;
    }

    private function mergeLocationsWithTrends($locations) {

        foreach ($locations as $local) {
//            debug($local);
            $trendings[$local->{'woeid'}] = $this->getByWoeid($local->{'woeid'});
            $trendings[$local->{'woeid'}]->{'locations'} = $local;
        }
        //debug($trendings);
        return $trendings;
    }


    private function getByWoeid($woeid) {
        $dest_file = "cache/wtt/" . $woeid . ".json";
        debug($dest_file);
        $trends = json_decode(file_get_contents($dest_file));
        //debug($trends);
        return $trends;
    }
}