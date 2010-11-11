<?php
class trend {

    var $location;
    var $locations;

    public function getAll() {
        debug('wtt  trend getAll');
        $this->locations = $this->location->getAll();
        //debug($this->locations);
        return $this->mergeTrends($this->locations);
    }

    public function getAllWithLocationsSortedByPlacetype($definitions = false) {
        debug('getAllWithLocationsSorted');
        $this->locations = $this->location->getAllSortedByPlacetype();
        //debug($this->locations);
        return $this->mergeLocationsWithTrends($this->locations, $definitions);
    }

    public function getAllWithLocations() {
        $this->locations = $this->location->getAll();
        return $this->mergeLocationsWithTrends($this->locations);
    }

    public function getWhithDefinitions($woeidtrends) {
        debug("getWhithDefinitions");
//        debug($woeidtrends);
        $trendsWhithDefinitions = array();

        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        /* check connection */
        if (mysqli_connect_errno ()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
        foreach ($woeidtrends->trends as $trend) {
            if (!isset($trend->description->text))
                $trend->description = new stdClass();

            $trend->description->text = $this->getDefinition($trend, $mysqli);

            $trendsWhithDefinitions[] = $trend;
        }
        $mysqli->close();
//        debug($trendsWhithDefinitions);
        return $trendsWhithDefinitions;
    }

    public function getDefinition($trend, $mysqli = false) {
        $close = false;

        if (!$mysqli) {
            $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            /* check connection */
            if (mysqli_connect_errno ()) {
                printf("Connect failed: %s\n", mysqli_connect_error());
                exit();
            }
            $close = true;
        }
//        debug("SELECT text FROM trend WHERE name = {$trend->name}");
        /* create a prepared statement */
        $stmt = $mysqli->prepare("SELECT text FROM trend WHERE name=?");
        if ($stmt) {
            /* bind parameters for markers */
            $stmt->bind_param("s", $trend->name);
            /* execute query */
            $stmt->execute();

            /* bind result variables */
            $stmt->bind_result($definition);

            /* fetch value */
            $stmt->fetch();

//            debug("Affected rows (SELECT):" . $mysqli->affected_rows);
            /* close statement */
            $stmt->close();
        }
        /* close connection */
        if ($close)
            $mysqli->close();

        return $definition;
    }

    public function updateAll() {
        debug("updating trends");
        $this->locations = $this->location->getAll();
//        debug($this->locations);
        foreach ($this->locations as $local) {
            debug($local);
            if (!$this->updateByWoeid($local->woeid))//TODO: try catch? try again?
            debug("trend updateAll(".$local->woeid.") falhou!!" );
        }
    }

    private function mergeTrends($locations) {
        $trendings = array();
        foreach ($locations as $local) {
            $trendings = array_merge($trendings, $this->getByWoeid($local->woeid)->trends);
        }
        return $trendings;
    }

    private function mergeLocationsWithTrends($locations, $definitions = false) {
        debug('mergeLocationsWithTrends');

        foreach ($locations as $local) {
            $trendings[$local->woeid] = $this->getByWoeid($local->woeid, $definitions);
            $trendings[$local->woeid]['locations'] = $local;
        }
        //debug($trendings);
        return $trendings;
    }

}
