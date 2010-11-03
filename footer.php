<?php
//require_once("ttlocal.php");
//$tt = new ttlocal();
?>
<div id="footer">
    <a href="http://codexico.com.br/blog" title="Codexico blog">codexico</a>
    <span class="update">Last Update:
    <?php
        //echo $tt->getLastUpdate();
        echo date("i", strtotime("now") - @filemtime("cache/1.json"))
    ?> minutes ago.</span>
</div>