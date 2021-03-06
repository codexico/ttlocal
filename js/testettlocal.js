jQuery(document).ready(function ($) {


  //Revealing Module Pattern
  var TTlocal = (function () {

    var updateTime = 610000,//10min,10s

    // get the first collection
    $locations = $('#locations'),

    // clone applications to get a second collection
    $initialLocations = $locations.clone(),

    //menu pieces
    $menuMainNav = $('ul.nav li a'),
    $menuCountry = $('.nav li.country a'),
    $menuTown = $('.nav li.town a'),

    //animation
    quicksandOptions = {
      //easing: 'easeInOutQuad',
      useScaling: false,
      adjustHeight: false
    },
    qtipOptions = {
      position: {
        corner: {
          target: 'topMiddle',
          tooltip: 'bottomLeft'
        }
      },
      style: {
        border: {
          width: 5,
          radius: 10
        },
        padding: 10,
        'font-size': '1.2em',
        tip: true, // Give it a speech bubble tip with automatic corner detection
        name: 'cream' // Style it according to the preset 'cream' style
      }
    },
    tipTipOptions = {
      defaultPosition: "left",
      keepAlive: true,
      attribute: "data-definition"
    };


    ////////////////
    // update cache
    ////////////////
    function updateCacheTT() {
      $.ajax({
        type: "POST",
        url: "cron.php",
        success: function (data) {
          if (window.console) {
            window.console.log(data);
          }//TODO: add some visual alert? auto-refresh content?
        }
      });
    }
    function cronTT() {//quem nao tem cron vai de setInterval
      window.setInterval(updateCacheTT, updateTime);
    }


    /////////////
    // lancelot
    /////////////
    function googleSearch(lancelotObj) {
    //lancelotObj is a reference to each $('.lancelot')
    //var search = lancelotObj.text().replace(/^#/, '');
    //return "http://www.google.com/search?q=" + search;
    }
    function lancelotLinks() {
      /*
            $('.lancelot').lancelot({
                hoverTime: 2000,
                speed: "slow"
            }).lancelot({
                hoverTime: 2000,
                aclass: "lancelotGo2",
                speed: "slow",
                alink: googleSearch
            });
            */
      $('.lancelot').lancelot();
    }
    //connect lancelot to quicksand
    function lancelotMenuLaunchQuicksand(lancelotObj) {
      //lancelotObj is a reference to each $('.lancelot')
      var $filteredMenu, woeid, countrycode;
      switch (lancelotObj.attr("href")) {
        case "#Worldwide":
          $filteredMenu = $initialLocations.find('article.local');
          break;
        case "#Town":
          $filteredMenu = $initialLocations.find('article[data-placeType=7]');
          break;
        case "#Country":
          $filteredMenu = $initialLocations.find('article[data-placeType=12]');
          break;
        default:
          woeid = lancelotObj.find('span.name').first().attr('data-woeid');
          if (woeid) {
            $filteredMenu = $initialLocations.find('article[data-id=' + woeid + ']');
          } else {
            countrycode = lancelotObj.find('span.country').first().attr('data-country');
            $filteredMenu = $initialLocations.find('article[data-countryCode=' + countrycode + ']');
          }
          break;
      }
      $locations.quicksand($filteredMenu, quicksandOptions, function () {
        lancelotLinks();//reappend lancelot lost when $locations.clone();
      });
    }
    function lancelotMenu() {
    /*
            $('.lancelot-menu').lancelot({
                hoverTime: 800,
                speed: "slow",
                aclass: "lancelotsimples",
                element: "span",
                launch: lancelotMenuLaunchQuicksand
            });
            */
    }
        
    function reappendAll($all, $filtered) {
      reappendQuicksand($all, $filtered);
    }


    function reappendToolTip() {
      $('.trendname').tipTip(tipTipOptions);
    }


    ////////////////
    // quicksand
    ////////////////
    function reappendQuicksand($all, $filtered) {
      $all.quicksand($filtered, quicksandOptions, function () {
        lancelotLinks();//reappend lancelot lost when $locations.clone();
        //reappendToolTip();
      });
    }
    function menuMainOnClickQuicksand() {
      $menuMainNav.click(function (e) {
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
        reappendAll($locations, $filteredMenu);
        e.preventDefault();
      });
    }
    function menuCountryOnClickQuicksand() {
      $menuCountry.click(function (e) {
        var countrycode = $(this).find('span.country').first().attr('data-country'),
        $filteredCountry = $initialLocations.find('article[data-countryCode=' + countrycode + ']');

        reappendAll($locations, $filteredCountry);
        e.preventDefault();
      });
    }
    function menuTownOnClickQuicksand() {
      $menuTown.click(function (e) {
        var woeid = $(this).find('span.name').first().attr('data-woeid'),
        $filteredTown = $initialLocations.find('article[data-id=' + woeid + ']');

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
        $filteredHash = $initialLocations.find('article[data-hash=' + lhash+ ']');
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
      //$('.trendname').tipTip(tipTipOptions);
      $('#locations').tooltip({
        selector: "a[rel=tooltip]",
        delay: { show: 100, hide: 700 }
      })
    }

    function mostrarVideo(data) {
      var videoid = data.feed.entry[0].media$group.yt$videoid.$t,
      youtubesrc = "http://www.youtube.com/embed/" + videoid + "?autoplay=1";

      $("#tiptip_holder").hide();

      $.modal('<iframe src="' + youtubesrc + '" height="100%" width="99%" style="border:0;margin:0 0 0 0.5%;padding:0">',
      {
        containerCss:{
          backgroundColor:"#fff",
          borderColor:"#fff",
          height:"95%",
          padding:0,
          margin:0,
          width:"95%"
        },
        close: true,
        overlayClose: true
      });
    }

    function youtubeSearch(q) {
      var src = "http://gdata.youtube.com/feeds/api/videos";
            
      $.getJSON(src,
      {
        q : q,
        orderby: "published",
        time: "today",
        "max-results" : 1,
        v: 2,
        alt: "json"
      },
      function(data) {
        if(data.feed.openSearch$totalResults.$t === 0){ //not found
          window.location.href = "http://www.youtube.com/results?search_query=" + q;
        } else {
          mostrarVideo(data);
        }
      });

    }

    function youtubeInit() {
      $("#locations").delegate(".youtubeicon", "click", function(e){
        e.preventDefault();
        youtubeSearch($(this).data('query'));
        return false;
      })
    }

    function init() {
      //            updateCacheTT();
      //            cronTT();
      lancelotLinks();
      lancelotMenu();
      menusOnClickQuicksand();
      urlAnchor();
      showSearchLink();
      toolTipInit();
      youtubeInit();
    }
    // reveal all things private by assigning public pointers
    return {
      init: init
    };
  }());


  TTlocal.init();


});