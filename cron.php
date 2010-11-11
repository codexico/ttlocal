<?php

require_once 'config.php';
require_once 'lib/util.php';
require_once 'model/cron.php';


$cron = new cron();


$testar = array();
//array_push($testar, "updateLocations");
//array_push($testar, "updateTrendsTwitter");
//array_push($testar, "updateHtmlCache");
//array_push($testar, "updateTrendsWTT");
//array_push($testar, "updateTrendsDefinitions");

$cron->development($testar);


