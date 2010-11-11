<?php
require_once 'model/cache.php';
class cron {

    var $cache;

    function __construct() {
        debug('cron construct');
        $this->cache = new Cache();

        $this->production();
    }

    function production() {
        if (PRODUCTION) {
            if ($this->cache->locationCacheExpired()) {
                $this->updateLocations();
            }
            if ($this->cache->twitterTrendCacheExpired()) {
                $this->updateTrendsTwitter();
                $this->updateHtmlCache();
            }
            if ($this->cache->wttTrendCacheExpired()) {
                $this->updateTrendsWTT();
                $this->updateTrendsDefinitions();
            }
        }
    }

    function development($testes) {
        if (!PRODUCTION) {
            foreach ($testes as $teste) {
                debug("testando... ".$teste);
                $this->$teste();
            }
        }
    }

    private function updateLocations() {
        $this->cache->updateLocations();
        echopre("locations updated");
    }

    private function updateTrendsTwitter() {
        $this->cache->updateTrendsTwitter();
        echopre("twitter trends updated");
    }

    private function updateHtmlCache() {
        $this->cache->updateHtmlCache(true);
        echopre("html updated");
    }

    private function updateTrendsWTT() {
        $this->cache->updateTrendsWTT();
        echopre("wtt trend updated");
    }

    private function updateTrendsDefinitions() {
        $this->cache->updateTrendsDefinitions();
        echopre("definitions updated");
    }
}
