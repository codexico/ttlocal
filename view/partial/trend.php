<span class="name">
    <a href="<?= $trend->url ?>" class="trendname" data-definition="
    <?php if (isset($trend->description->text)) : ?>
            <?= preg_replace('/"/i', "'", $trend->description->text); ?>
        <?php else : ?>
               Not explained yet.<br>
               <a target='_blank' href='http://whatthetrend.com/trend/<?= $trend->name; ?>'>Add a defintion!</a>
       <?php endif; ?>">
           <?= $trend->name ?>
         <span class="definition">
            <?php if (isset($trend->description->text)) : ?>
                <?= htmlspecialchars(preg_replace('/"/i', "'", $trend->description->text)); ?>
            <?php endif; ?>
            </span>
        </a>
        <a href="<?= $trend->url ?>" class="twittericon lancelot search"
           title="twitter search: <?= $trend->name ?>"></a>
        <a href="http://www.google.com/search?q=<?= preg_replace('/#/', '', $trend->name) ?>"
           class="googleicon lancelot search"
           title="google search: <?= $trend->name ?>"></a>
        <a href="http://www.youtube.com/results?search_query=<?= preg_replace('/#/', '', $trend->name) ?>"
           class="youtubeicon search" target="_blank"
           data-query="<?= preg_replace('/#/', '', $trend->name) ?>"
           title="youtube video search: <?= $trend->name ?>"></a>
</span>