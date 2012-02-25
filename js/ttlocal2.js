var TTLOCAL = {
  quicksandOptions : {
    useScaling: false,
    adjustHeight: false
  },
  locationHashChanged : function () {
    var lhash = window.location.hash.replace(/^#/, ''),
    $filteredLocations = TTLOCAL.$locationsClone.find('article.local'),//all
    $location, woeid, country;
    if (lhash === "Town") {
      $filteredLocations = TTLOCAL.$locationsClone.find('article[data-placeType=7]');
    } else if (lhash === "Country") {
      $filteredLocations = TTLOCAL.$locationsClone.find('article[data-placeType=12]');
    } else if (lhash === "" || lhash === "Worldwide") {
      $filteredLocations = TTLOCAL.$locationsClone.find('article');
    } else {
      $location = $('#menu a[href=' + window.location.hash + ']');
      woeid = $location.data('woeid');
      country = $location.data('country');
      if(country !== undefined) {
        $filteredLocations = TTLOCAL.$locationsClone.find('article[data-countryCode=' + country + ']');
      } else {
        $filteredLocations = TTLOCAL.$locationsClone.find('article[data-id=' + woeid + ']');  
      }
    }
    $('#locations').quicksand($filteredLocations, TTLOCAL.quicksandOptions, function () {
      $('html,body').animate({
        scrollTop : $('#locations').offset().top - 344 //article height
      }, 300);
    });
    
  },
  showSearchLink : function () {
    $('#locations').on('hover', '.topic', function () {
      $(this).find('.search').toggle();
    })
  },
  tooltipInit : function () {
    $('#locations').tooltip({
      selector: "a[rel=tooltip]",
      delay: {
        show: 100, 
        hide: 700
      }
    })
  },
  lancelotLinks : function () {
    $('body').on('hover', '.topic', function () {
      $(this).find('.lancelot').lancelot();
    })
  },
  showVideo : function (data) {
    var videoid = data.feed.entry[0].media$group.yt$videoid.$t,
    youtubesrc = "http://www.youtube.com/embed/" + videoid + "?autoplay=1",
    modalcontent;

    modalcontent = '<iframe src="' + youtubesrc + '" height="100%" width="99%" style="border:0;margin:0 0 0 0.5%;padding:0">';

    $('<div id="modal">').html(modalcontent).modal();
    
  },
  youtubeSearch : function (q) {
    var src = "http://gdata.youtube.com/feeds/api/videos";
    
    $.getJSON(src, {
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
        TTLOCAL.showVideo(data);
      }
    });
  },
  youtubeInit : function () {
    $("#locations").on("click", ".youtubeicon", function (e) {
      e.preventDefault();
      TTLOCAL.youtubeSearch($(this).data('query'));
      return false;
    })
  },
  init : function () {
    window.onhashchange = this.locationHashChanged;
    if(window.location.hash !== "") {
      this.locationHashChanged();
    }
    this.tooltipInit();
    this.showSearchLink();
    this.lancelotLinks();
    this.youtubeInit();
  }
}

jQuery(document).ready(function ($) {

  // clone locations to get a second collection
  TTLOCAL.$locationsClone = $('#locations').clone();

  TTLOCAL.init();

});