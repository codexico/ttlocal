<?php


require_once("util.php");
require_once("ttlocal.php");
$tt = new ttlocal();

if(isAjax() && isPost()) {
    if($tt->update()){
        echo "updated";
    }else{
        echo "nothing";
    }
}else {
    echo "erro ajax post";
}

