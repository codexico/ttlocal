<?php

require_once 'config.php';

if (PRODUCTION) {
    //use cache in production
    require_once 'cache/index.html';
} else {
    //monta a view agora

    require_once 'lib/util.php';

    require_once 'model/twitterLocation.php';
    require_once 'model/twitterTrend.php';
    $location = new twitterLocation();
    $trend = new twitterTrend();

    $viewdata['trends'] = $trend->getAllWithLocationsSortedByPlacetype(true);
//    debug($viewdata['trends']);
    $viewdata['places'] = $location->getAllSorted();
//    debug($viewdata['places']);
    // Requiring the view
    require_once 'view/index.php';
}
