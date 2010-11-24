<span class="name">
    <a href="<?= $trend->url ?>" class="trendname" title="
    <?php if (isset($trend->description->text)) : ?>
           <?= preg_replace('/"/', "'", $trend->description->text); ?>
       <?php else : ?>
            Not explained yet.<br />
            <a target='_blank' href='http://whatthetrend.com/trend/<?= $trend->name; ?>'>
                Add a defintion!
            </a>
       <?php endif; ?>">
           <?= $trend->name ?>
     </a>
     <a href="<?= $trend->url ?>" class="twittericon lancelot"
        title="twitter search: <?= $trend->name ?>"></a>
     <a href="http://www.google.com/search?q=<?= preg_replace('/#/', '', $trend->name) ?>"
        class="googleicon lancelot"
        title="google search: <?= $trend->name ?>"></a>
</span>