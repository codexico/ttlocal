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
      useScaling: false,
      adjustHeight: false
    }


    /////////////
    // lancelot
    /////////////
    function lancelotLinks() {
      //$('.lancelot').lancelot();
      $('body').on('hover', '.topic', function () {
        $(this).find('.lancelot').lancelot();
      })
    }
    

    ////////////////
    // quicksand
    ////////////////
    function menuMainOnClickQuicksand() {
      $menuMainNav.click(function (e) {
        e.preventDefault();
        var menuhref = $(this).attr('href'),
        $filteredMenu = $initialLocations.find('article.local');
        switch (menuhref) {
          case "#Town":
            $filteredMenu = $initialLocations.find('article[data-placeType=7]');
            break;
          case "#Country":
            $filteredMenu = $initialLocations.find('article[data-placeType=12]');
            break;
          default:
            break;
        }
        $locations.quicksand($filteredMenu, quicksandOptions);
      });
    }
    function menuCountryOnClickQuicksand() {
      $menuCountry.click(function (e) {
        e.preventDefault();
        var countrycode = $(this).find('span.country').first().attr('data-country'),
        $filteredCountry = $initialLocations.find('article[data-countryCode=' + countrycode + ']');

        $locations.quicksand($filteredCountry, quicksandOptions);
      });
    }
    function menuTownOnClickQuicksand() {
      $menuTown.click(function (e) {
        e.preventDefault();
        var woeid = $(this).find('span.name').first().attr('data-woeid'),
        $filteredTown = $initialLocations.find('article[data-id=' + woeid + ']');

        $locations.quicksand($filteredTown, quicksandOptions);
      });
    }
    function menusOnClickQuicksand() {
      menuMainOnClickQuicksand();
      menuCountryOnClickQuicksand();
      menuTownOnClickQuicksand();
    }
    function urlAnchor(){
      var locationHash,
      lhash, //hash sem '#'
      $filteredHash; //lista do local do hash
      locationHash = window.location.hash;
      if(locationHash !== ""){
        lhash = locationHash.replace(/^#/, '');
        $filteredHash = $initialLocations.find('.local[data-hash=' + lhash+ ']');
        if($filteredHash.size()){//encontrou algo
          $locations.quicksand($filteredHash, quicksandOptions);
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
        delay: {
          show: 100, 
          hide: 700
        }
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