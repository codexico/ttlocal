<?php
require_once 'config.php';

if (PRODUCTION) {

    //use cache in production
    require_once('cache/index.html');

} else {

    require_once 'lib/util.php';

    // Requiring the model
//    require_once 'model/trendingTopic.php';

    // Using the model
//    $tt = new TrendingTopic();
//    $viewdata['trends'] = $tt->locationsWithTrendsSorted();
//    $viewdata['places'] = $tt->placesSorted();


    require_once 'model/twitterLocation.php';
    require_once 'model/wttTrend.php';
        $location = new twitterLocation();
        $trend = new wttTrend();
        $viewdata['trends'] = $trend->getAllWithLocationsSortedByPlacetype();
        $viewdata['places'] = $location->getAllSorted();
//        $data = $this->getView('view/index.php', $viewdata);
    
    // Requiring the view
    require('view/index.php');
}
