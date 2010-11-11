<?php

class twitterLocation {

   function __construct() {
   }

    public function getAll() {
        return json_decode(file_get_contents("cache/available.json"));
    }

    public function getAllSorted() {

        $locations = $this->getAll();
        $supername = $country = $town = $other = array();
        foreach ($locations as $b) {//separa para ordenar internamente
            switch (($b->{'placeType'}->{'name'})) {
                case 'Supername':
                    $supername[] = $b;
                    break;
                case 'Country':
                    $country[] = $b;
                    break;
                case 'Town':
                    $town[] = $b;
                    break;
                default:
                    $other[] = $b;
                    break;
            }
        }
        usort($country, "cmpCountry"); //ordena por country alfabeticamente

        foreach ($town as $key => $t) {//separa para ordenar as towns
            $c[$key] = $t->{'country'};
            $n[$key] = $t->{'name'};
        }
        array_multisort($c, SORT_DESC, $n, SORT_ASC, $town); //ordena town dentro de country
        $locations['supername'] = $supername;
        $locations['country'] = $country;
        $locations['town'] = $town;
        $locations['other'] = $other;
        return $locations;
    }

    /**
     * Ordena locations por placeType
     * deixando primeiro world depois countries e no fim towns
     *
     * @return array
     */
    public function getAllSortedByPlacetype() {
        $places = $this->getAllSorted();

        $locations = array_merge(
                        $places['supername'],
                        $places['country'],
                        $places['town'],
                        $places['other']); //junta tudo no formato original
        return $locations;
    }

    public function updateAll() {
        debug("updating locations available");

        $url = "http://api.twitter.com/1/trends/available.json";
        $dest_file = "cache/available.json";

        if (Cache::updateCache($url, $dest_file))
            return true;

        return false;
    }

}
