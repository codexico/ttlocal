<?php
require_once('lib/util.php');
require_once('model/twitter.php');
require_once('model/trendingTopic.php');

class Cache {

    public function updateTwitterData() {
        $twitter = new Twitter();
        return $twitter->update();
    }

    public function updateHtmlCache() {
        $tt = new TrendingTopic();
        $locationsWithTrendings = $tt->locationsWithTrendsSorted();
        $data = $this->getView('view/index.php', $locationsWithTrendings);
        return $this->writeHtmlCache($data, "cache/index.html");
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

}