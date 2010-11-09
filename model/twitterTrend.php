<?php

require_once 'model/wttLocation.php';

class twitterTrend {

    var $location;
    var $locations;

    function __construct() {
        $this->location = new twitterLocation();
    }

    public function getAllWithLocations() {
        $this->locations = $this->location->getAll();
        return $this->mergeLocationsWithTrends($this->locations);
    }

    public function getAllWithLocationsSortedByPlacetype() {
                debug('getAllWithLocationsSorted');
        $this->locations = $this->location->getAllSortedByPlacetype();
//        debug($this->locations);
        return $this->mergeLocationsWithTrends($this->locations);
    }

    public function updateAll() {
        debug("updating trends");
        $this->locations = $this->location->getAll();
        debug($this->locations);
        foreach ($this->locations as $local) {
            debug($local);
            if (!$this->updateByWoeid($local->{'woeid'}))
                return false;
        }
        return true; // atualizou
    }

    public function updateByWoeid($woeid) {
        debug("updateWoeid");
        $url = "http://api.twitter.com/1/trends/" . $woeid . ".json";
        $dest_file = "cache/" . $woeid . ".json";

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
        return $trendings;
    }

    private function getByWoeid($woeid) {
        $dest_file = "cache/" . $woeid . ".json";
        debug($dest_file);
        $trends = json_decode(file_get_contents($dest_file));
        return $trends[0]; //json do woeid eh um pouco diferente
    }

}