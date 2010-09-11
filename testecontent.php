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
<div class="grid_16">
    <h2 id="page-heading" class="">Twitter trending topics from all the places in the World in one simple page!</h2>
</div>
<div class="clear"></div>


<div class="grid_16">
    <!-- menu -->
    <ul class="nav main">
        <li>
            <a href="#Worldwide"  title="Show All" class="lancelot-menu">All</a>
        </li>
        <li>
            <a href="#Country" title="Filter Countries" class="lancelot-menu">Country</a>
            <ul>
                <?php foreach($country as $c ):?>
                <li class="country">
                    <a href="#<?= str_replace(" ", "_", $c->{'country'}) ?>" class="lancelot-menu">
                        <span class="country"  data-country="<?=$c->{'countryCode'}?>"><?=$c->{'country'} ?></span>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </li>
        <li>
            <a href="#Town" title="Filter Tows" class="lancelot-menu">Town</a>
            <ul>
                <?php foreach($town as $t ):?>
                <li class="town" >
                    <a href="#<?= str_replace(" ", "_", $t->{'name'}) ?>" class="lancelot-menu">
                        <span class="country"  data-country="<?=$t->{'countryCode'}?>"><?=$t->{'country'} ?></span> -
                        <span class="name" data-woeid="<?=$t->{'woeid'}?>"><?=$t->{'name'}?></span>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </li>
    </ul>
    <!-- end menu -->
</div>
<div class="clear"></div>


<!-- locations -->
<ul id="locations">
    <?php
    $i=0;
    foreach ($placetype as $location) :
        ?>
        <?php
        foreach ($location as $local) ://mostra a trend de cada local
            $i++;
            $trends = $tt->topics($local->{'woeid'});
            if(isset ($trends->{'trends'})):
                ?>
    <!-- local -->
    <li class="grid_4 local" data-placeType="<?=$local->placeType->{'code'}?>" data-id="<?=$local->{'woeid'}?>" data-countryCode="<?=$local->{'countryCode'}?>" >
        <div class="box">
            <h2>
                <a name="<?= str_replace(" ", "_", $local->{'name'}) ?>">
                                <? if($local->placeType->{'code'}==7) : //town ?>
                    <span class="country"><?=$local->{'country'} ?></span> -
                                <? endif;?>
                    <span class="name"><?=$local->{'name'}?></span>
                </a>
            </h2>

            <ul class="block">
                            <?php
                            foreach ($trends->{'trends'} as $trend) :
                                ?>
                <li class="topic">
                    <span class="name">
                        <a href="<?=$trend->{'url'} ?>" class="lancelot"><?=$trend->{'name'} ?></a>
                    </span>
                </li>
                            <?php endforeach; ?>
            </ul>

        </div>
    </li>
    <!-- end local -->
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endforeach; ?>
</ul>

<div class="clear"></div>
<!-- end locations -->


<?php
$content = ob_get_contents();
ob_end_clean();
return $content;