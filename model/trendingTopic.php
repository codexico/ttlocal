<?php

/**
 * Locations available from twitter and their trending topics.
 *
 * @version 1.0
 * @author codexico
 */
class TrendingTopic {

    static public function locations() {
        return json_decode(file_get_contents("cache/available.json"));
        ;
    }

    public function locationsWithTrends() {
        return $this->mergeLocationsWithTrends($this->locations());
    }

    public function locationsWithTrendsSorted() {
        return $this->mergeLocationsWithTrends($this->locationsSorted());
    }

    private function mergeLocationsWithTrends($locations) {
        foreach ($locations as $local) {
            $trendings[$local->{'woeid'}] = $this->trendsByLocation($local->{'woeid'});
            $trendings[$local->{'woeid'}]->{'locations'} = $local;
        }
        return $trendings;
    }

    /**
     * Ordena locations por placeType
     * deixando primeiro world depois countries e no fim towns
     *
     * @return array
     */
    private function locationsSorted() {
        $places = $this->placesSorted();

        $locations = array_merge(
                        $places['supername'],
                        $places['country'],
                        $places['town'],
                        $places['other']); //junta tudo no formato original
        return $locations;
    }

    public function placesSorted() {

        $locations = $this->locations();
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

    private function trendsByLocation($woeid) {
        $dest_file = "cache/" . $woeid . ".json";
        $trends = json_decode(file_get_contents($dest_file));
        return $trends[0]; //json do woeid eh um pouco diferente
    }

}