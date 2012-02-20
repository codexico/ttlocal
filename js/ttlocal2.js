TTLOCAL = {
  quicksandOptions : {
    useScaling: false,
    adjustHeight: false
  },
  locationHashChanged : function () {
    var lhash = window.location.hash.replace(/^#/, ''),
    $filteredLocations = TTLOCAL.$locationsClone.find('article.local');//all
    if (lhash === "Town") {
      $filteredLocations = TTLOCAL.$locationsClone.find('article[data-placeType=7]');
    } else if (lhash === "Country") {
      $filteredLocations = TTLOCAL.$locationsClone.find('article[data-placeType=12]');
    } else if (lhash === "" || lhash === "Worldwide") {
      $filteredLocations = TTLOCAL.$locationsClone.find('article');
    } else {
      $filteredLocations = TTLOCAL.$locationsClone.find('a[name='+lhash+']').parents('article');
    //TODO : se for country mostrar tambem as cidades
    }
    
    $('#locations').quicksand($filteredLocations, TTLOCAL.quicksandOptions);
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

/*    $.modal(modalcontent,
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
*/    
    
    
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
    this.locationHashChanged();
    this.tooltipInit();
    this.showSearchLink();
    this.lancelotLinks();
    this.youtubeInit();
  }
}

jQuery(document).ready(function ($) {

  // clone applications to get a second collection
  TTLOCAL.$locationsClone = $('#locations').clone();

  TTLOCAL.init();

});