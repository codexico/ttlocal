<span class="name">
    <a href="<?= $trend->url ?>" class="trendname"
    <?php if (isset($trend->description->text)) : ?>
           title="<?= preg_replace('/"/', "'", $trend->description->text); ?>"
       <? endif; ?>>
           <?= $trend->name ?>
    </a>
    <a href="<?= $trend->url ?>" class="twittericon lancelot"
       title="twitter search: <?= $trend->name ?>"></a>
    <a href="http://www.google.com/search?q=<?= preg_replace('/#/', '', $trend->name) ?>" class="googleicon lancelot"
       title="google search: <?= $trend->name ?>"></a>
</span>