<?php
define( "LOCATIONS_REFRESH_INTERVAL", 1800 );//30min
define( "WOEID_REFRESH_INTERVAL", 540 );//9min
/**
 * Locations available from twitter and their trending topics.
 *
 * @version beta 0.4
 * @author codexico
 */
class ttlocal {
    private $limit = true;
    private $available;
    private $placetype;
    /**
     * @return int  minutos desde a ultima atualizacao
     */
    public function getLastUpdate() {
        return date("i",strtotime("now")-@filemtime("cache/1.json"));
    }

    public function locations() {
        $this->available = json_decode(file_get_contents("cache/available.json"));
        return $this->available;
    }

    public function supername() {
        return $this->placetype['supername'];
    }
    public function country() {
        return $this->placetype['country'];
    }
    public function town() {
        return $this->placetype['town'];
    }


    public function topics($woeid) {
        $dest_file = "cache/".$woeid.".json";
        $topics = json_decode(file_get_contents($dest_file));
        return $topics[0];//json do woeid eh um pouco diferente
    }

    public function update() {
        if(!file_exists("cache/available.json") || @filemtime("cache/available.json") < (time()-LOCATIONS_REFRESH_INTERVAL)) {
            $this->updateLocations();
        }
        if(!file_exists("cache/1.json") || @filemtime("cache/1.json") < (time()-WOEID_REFRESH_INTERVAL)) {
            $locations = $this->locations();
            foreach ($locations as $local) {
                if($this->limit)
                    if(!$this->updateWoeid($local->{'woeid'}))
                        return false;
            }
            //update html element
            $this->writeHtmlCache("cache/tt.html");
            return true;
        }
        return false;
    }

    private function updateLocations() {
        $url = "http://api.twitter.com/1/trends/available.json";
        $dest_file = "cache/available.json";

        $this->updateCache($url, $dest_file);
    }

    private function updateWoeid($woeid) {
        $url = "http://api.twitter.com/1/trends/".$woeid.".json";
        $dest_file = "cache/".$woeid.".json";

        if(!$this->updateCache($url, $dest_file))
            return false;

        return true;
    }

    private function updateCache($url, $dest_file) {
        $data = $this->getUrl($url);
        if($data != false) {//die("teve resposta");
            $json_data = json_decode($data);
            if(!isset ($json_data->{'error'})) {//die("resposta sem erro");
                if(!$this->writeCache($data, $dest_file))
                    return false;
            }else {
                $this->limit = false;
                return false;
            }
            return true;
        }else {
            return false;
        }
        return true;
    }

    private function getUrl($url) {
        //return file_get_contents($url);

        $ch = curl_init();// create a new cURL resource
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_TIMEOUT, 30); // Timeout (for when Twitter is down)
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//return the transfer as a string
        $data = curl_exec($ch);// grab URL and pass it to the browser
        curl_close($ch);// close cURL resource, and free up system resources
        return $data;
    }

    private function writeCache($data, $dest_file) {
        $fp = @fopen($dest_file,"w");
        if(!$fp) {
            return false;
        }
        fwrite($fp,$data);
        fclose($fp);
        return true;
    }

    private function writeHtmlCache($dest_file) {
        $content = require_once 'content.php';
        $this->writeCache($content, $dest_file);
    }

}