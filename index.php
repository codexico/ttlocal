<?php
require_once 'config.php';

if (PRODUCTION) {

    //use cache in production
    require_once('cache/index.html');

} else {

    require_once 'lib/util.php';

    // Requiring the model
    require_once 'model/trendingTopic.php';

    // Using the model
    $tt = new TrendingTopic();
    $viewdata = $tt->locationsWithTrendsSorted();

    // Requiring the view
    require('view/index.php');
}
