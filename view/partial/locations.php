<!-- locations -->
<ul id="locations">
    <?php foreach ($viewdata['trends'] as $local) : ?>
        <?php if (isset($local->{'trends'})): ?>


            <?php include 'location.php'; ?>


        <?php endif; //trends ?>
    <?php endforeach; ?>
</ul>
<!-- end locations -->