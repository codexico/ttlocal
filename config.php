<?php

define("DEBUG", true);
define("PRODUCTION", false);//TODO: detectar automaticamente

define("LOCATIONS_REFRESH_INTERVAL", 1800); //30min

if (PRODUCTION) {
    define("WOEID_REFRESH_INTERVAL", 540); //9min
} else {
    define("WOEID_REFRESH_INTERVAL", 3600); //60min
}