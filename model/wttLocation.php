<?php
require_once 'model/twitterLocation.php';
class wttLocation extends twitterLocation {

   function __construct() {
       debug('wttLocation construct');
       parent::__construct();
   }

}
