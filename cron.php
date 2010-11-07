<?php
require_once 'config.php';
require_once 'lib/util.php';
require_once 'model/cache.php';


$cache = new Cache();

if (PRODUCTION) {
    if ($cache->updateTwitterData()) {
        echo "trends updated <br>";
    } else {
        echo "trends already up to date <br>";
    }
}

if ($cache->updateHtmlCache()) {
    echo "html updated <br>";
} else {
    echo "html not updated <br>";
}