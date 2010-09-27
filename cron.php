<?php

require_once("util.php");
require_once("ttlocal.php");
$tt = new ttlocal();

if ($tt->update()) {
    echo "updated";
} else {
    echo "nothing";
}

