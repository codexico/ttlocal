jQuery(document).ready(function ($) {


  //Revealing Module Pattern
  var TTlocal = (function () {

    // get the first collection
    var $locations = $('#locations'),

    // clone applications to get a second collection
    $initialLocations = $locations.clone(),

    //menu pieces
    $menuMainNav = $('ul.nav li a'),
    $menuCountry = $('.nav li.country a'),
    $menuTown = $('.nav li.town a'),

    //animation
    quicksandOptions = {
      easing: 'easeInOutQuad',
      useScaling: false,
      adjustHeight: false
    }


    /////////////
    // lancelot
    /////////////
    function lancelotLinks() {
      $('.lancelot').lancelot();
    }

    function reappendAll($all, $filtered) {
      reappendQuicksand($all, $filtered);
    }
    

    ////////////////
    // quicksand
    ////////////////
    function reappendQuicksand($all, $filtered) {
      $all.quicksand($filtered, quicksandOptions, function () {
        lancelotLinks();//reappend lancelot lost when $locations.clone();
      })
    }
    function menuMainOnClickQuicksand() {
      $menuMainNav.click(function (e) {
        var menuhref = $(this).attr('href'),
        $filteredMenu = $initialLocations.find('li.local');
        switch (menuhref) {
          case "#Town":
            $filteredMenu = $initialLocations.find('li[data-placeType=7]');
            break;
          case "#Country":
            $filteredMenu = $initialLocations.find('li[data-placeType=12]');
            break;
          default:
            break;
        }
        reappendAll($locations, $filteredMenu);
        e.preventDefault();
      });
    }
    function menuCountryOnClickQuicksand() {
      $menuCountry.click(function (e) {
        var countrycode = $(this).find('span.country').first().attr('data-country'),
        $filteredCountry = $initialLocations.find('li[data-countryCode=' + countrycode + ']');

        reappendAll($locations, $filteredCountry);
        e.preventDefault();
      });
    }
    function menuTownOnClickQuicksand() {
      $menuTown.click(function (e) {
        var woeid = $(this).find('span.name').first().attr('data-woeid'),
        $filteredTown = $initialLocations.find('li[data-id=' + woeid + ']');

        reappendAll($locations, $filteredTown);
        e.preventDefault();
      });
    }
    function menusOnClickQuicksand() {
      menuMainOnClickQuicksand();
      menuCountryOnClickQuicksand();
      menuTownOnClickQuicksand();
    }
    function urlAnchor(){
      var locationHash = window.location.hash,
      lhash, //hash sem '#'
      $filteredHash; //lista do local do hash
      if(locationHash){
        lhash = locationHash.replace(/^#/, '');
        $filteredHash = $initialLocations.find('li[data-hash=' + lhash+ ']');
        if($filteredHash.size()){//encontrou algo
          reappendAll($locations, $filteredHash);
        }
      }
    }

    function showSearchLink(){
      $('#locations').on('hover', '.topic', function () {
          $(this).find('.search').toggle();
      })
    }

    function toolTipInit(){
      $('#locations').tooltip({
        selector: "a[rel=tooltip]",
        delay: { show: 100, hide: 700 }
      })
    }

    function init() {
      lancelotLinks();
      menusOnClickQuicksand();
      urlAnchor();
      showSearchLink();
      toolTipInit();
    }
    // reveal all things private by assigning public pointers
    return {
      init: init
    };
  }());


  TTlocal.init();


});