<?php
$hash = str_replace(" ", "_", $local['locations']->name);
?>
<!-- local -->
<li class="grid_4 local"
    data-placeType="<?= $local['locations']->placeType->code ?>"
    data-id="<?= $local['locations']->woeid ?>"
    data-countryCode="<?= $local['locations']->countryCode ?>"
    data-hash="<?= $hash ?>" >
    <div class="box">
        <h2>
            <a name="<?= $hash ?>">
                <? if ($local['locations']->placeType->code == 7) : //town ?>
                    <span class="country"><?= $local['locations']->country ?></span> -
                <? endif; ?>
                    <span class="name"><?= $local['locations']->name ?></span>
                </a>
            </h2>

            <ul class="block">
            <?php foreach ($local as $trend) : ?>
                        <li class="topic">


                <?php include 'trend.php'; ?>


                    </li>
            <?php endforeach; //trend ?>
        </ul>
    </div>
</li>
<!-- end local -->