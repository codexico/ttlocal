<?php
//require_once("ttlocal.php");
//$tt = new ttlocal();
?>
<div class="footer">
    <ul class="nav">
                    <li class="">
                        <a href="http://codexico.com.br/blog" title="Codexico blog">codexico</a>
                    </li>
        <li class="secondary">
            <span class="update">Last Update: <?php
//            echo $tt->getLastUpdate();
            echo date("i",strtotime("now")-@filemtime("cache/1.json"))
            ?> minutes ago.</span>
        </li>
    </ul>
</div>