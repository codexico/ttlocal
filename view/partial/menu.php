<nav id="menu">
  <!-- menu -->
  <span class="filter">Filter: </span>
  <ul class="nav main">
    <li class="placetype" >
      <a href="#Worldwide"  title="Show All" class="lancelot-menu first">All</a>
    </li>
    <li class="placetype" >
      <a href="#Country" title="Filter Countries" class="lancelot-menu first">Country</a>
      <ul>
        <?php foreach ($viewdata['places']['country'] as $c): ?>
          <li>
            <a href="#<?= str_replace(" ", "_", $c->{'country'}) ?>"
               class="lancelot-menu country"
               data-woeid="<?= $c->{'woeid'} ?>"
               data-country="<?= $c->{'countryCode'} ?>"><?= $c->{'country'} ?></a>
          </li>
        <?php endforeach; //country ?>
      </ul>
    </li>
    <li class="placetype" >
      <a href="#Town" title="Filter Tows" class="lancelot-menu first">City</a>
      <ul>
        <?php foreach ($viewdata['places']['town'] as $t): ?>
          <li class="town" >
            <a href="#<?= str_replace(" ", "_", $t->{'name'}) ?>"
               class="lancelot-menu"
               data-woeid="<?= $t->{'woeid'} ?>"><?= $t->{'name'} ?></a>
          </li>
        <?php endforeach; //town ?>
      </ul>
    </li>
  </ul>
  <!-- end menu -->
</nav>