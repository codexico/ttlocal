<?php
require_once("testettlocal.php");
$tt = new ttlocal();

function cmpCountry($a, $b) {
    if ($a->{'country'} == $b->{'country'}) {
        return 0;
    }
    return ($a->{'country'} > $b->{'country'}) ? -1 : 1;
}

$locations = $tt->locations();
foreach ($locations as $b) {
    switch (($b->{'placeType'}->{'name'})) {
        case 'Country':
            $country[] = $b;
            break;
        case 'Town':
            $town[] = $b;
            break;
        case 'Supername':
            $supername[] = $b;
            break;
        default:
            $other[] = $b;
            break;
    }
}
usort($country, "cmpCountry");
foreach ($town as $key => $t) {
    $c[$key] = $t->{'country'};
    $n[$key] = $t->{'name'};
}
array_multisort($c, SORT_DESC, $n, SORT_ASC, $town);
$placetype[0] = $supername;
$placetype[1] = $country;
$placetype[2] = $town;
?>

<?php
ob_start();
?>
<div id="menu" class="">
    <!-- menu -->
        <span class="filter">Filter: </span>
    <ul class="nav main">
        <li>
            <a href="#Worldwide"  title="Show All" class="lancelot-menu">All</a>
        </li>
        <li>
            <a href="#Country" title="Filter Countries" class="lancelot-menu">Country</a>
            <ul>
                <?php foreach ($country as $c): ?>
                    <li class="country">
                        <a href="#<?= str_replace(" ", "_", $c->{'country'}) ?>"
                       class="lancelot-menu">
                        <span class="country"
                              data-woeid="<?= $t->{'woeid'} ?>"
                              data-country="<?= $c->{'countryCode'} ?>"><?= $c->{'country'} ?></span>
                    </a>
                </li>
                <?php endforeach; //country ?>
            </ul>
        </li>
        <li>
            <a href="#Town" title="Filter Tows" class="lancelot-menu">City</a>
            <ul>
                <?php foreach ($town as $t): ?>
                <li class="town" >
                    <a href="#<?= str_replace(" ", "_", $t->{'countryCode'} . "_" . $t->{'name'}) ?>"
                       class="lancelot-menu">
                        <span class="country"
                              data-country="<?= $t->{'countryCode'} ?>"><?= $t->{'country'} ?></span> -
                        <span class="name"
                              data-woeid="<?= $t->{'woeid'} ?>"><?= $t->{'name'} ?></span>
                    </a>
                </li>
                <?php endforeach; //town ?>
            </ul>
        </li>
    </ul>
    <!-- end menu -->
</div>
<div class="clear"></div>


<!-- locations -->
<ul id="locations">
    <?php
        $i = 0;
        foreach ($placetype as $location) :

            foreach ($location as $local) ://mostra a trend de cada local
                $i++;
                $trends = $tt->topics($local->{'woeid'});
                if (isset($trends->{'trends'})):

                    $isTown = false;
                    $hash = str_replace(" ", "_", $local->{'name'});
                    if ($local->placeType->{'code'} == 7) {
                        $isTown = true;
                        //$hash = str_replace(" ", "_", $local->{'countryCode'} . "|" . $local->{'name'});//inclui o pais?
                        $hash = str_replace(" ", "_", $local->{'name'});
                    }
    ?>
    <!-- local -->
    <li class="grid_4 local"
        data-placeType="<?= $local->placeType->{'code'} ?>"
        data-id="<?= $local->{'woeid'} ?>"
        data-countryCode="<?= $local->{'countryCode'} ?>"
        data-hash="<?= $hash ?>" >
        <div class="box">
            <h2>
                <a name="<?= $hash ?>">
                    <? if ($isTown) : ?>
                    <span class="country"><?= $local->{'country'} ?></span> -
                    <? endif; ?>
                    <span class="name"><?= $local->{'name'} ?></span>
                </a>
            </h2>

            <ul class="block">
                <?php foreach ($trends->{'trends'} as $trend) :?>
                <li class="topic">
                    <span class="name">
                        <a href="<?= $trend->{'url'} ?>" class="trendname"><?= $trend->{'name'} ?></a>
                        <a href="<?= $trend->{'url'} ?>" class="twittericon lancelot" title="twitter search: <?= $trend->{'name'} ?>"></a>
                        <a href="http://www.google.com/search?q=<?= preg_replace('/#/', '', $trend->{'name'}) ?>" class="googleicon lancelot" 
                           title="google search: <?= $trend->{'name'} ?>"></a>
                    </span>
                </li>
                <?php endforeach; //trend ?>
            </ul>
        </div>
    </li>
    <!-- end local -->
                <?php endif; //trends ?>
            <?php endforeach; //location ?>
        <?php endforeach; //placetype ?>
</ul>
<!-- end locations -->
            
<?php
$content = ob_get_contents();
ob_end_clean();
return $content;