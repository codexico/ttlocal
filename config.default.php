<?php

define("DEBUG", true);
define("PRODUCTION", false); //TODO: detectar automaticamente

if (PRODUCTION) {
    define("LOCATIONS_REFRESH_INTERVAL", 1800); //30min
    define("TWITTER_WOEID_REFRESH_INTERVAL", 540); //9min
    define("WTT_WOEID_REFRESH_INTERVAL", 2700); //45min
} else {
    define("LOCATIONS_REFRESH_INTERVAL", 1800); //30min
    define("WOEID_REFRESH_INTERVAL", 3600); //60min
}


define("WTT_API_KEY", "");


if (PRODUCTION) {
    define("DB_HOST", "");
    define("DB_USER", "");
    define("DB_NAME", "");
    define("DB_PASS", "");
} else {
    define("DB_HOST", "localhost");
    define("DB_USER", "root");
    define("DB_NAME", "ttlocal");
    define("DB_PASS", "");
}