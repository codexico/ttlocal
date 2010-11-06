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
            easing: 'easeInOutQuad',
            useScaling: false,
            adjustHeight: false
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
                    $filteredMenu = $initialLocations.find('li.local');
                    break;
                case "#Town":
                    $filteredMenu = $initialLocations.find('li[data-placeType=7]');
                    break;
                case "#Country":
                    $filteredMenu = $initialLocations.find('li[data-placeType=12]');
                    break;
                default:
                    woeid = lancelotObj.find('span.name').first().attr('data-woeid');
                    if (woeid) {
                        $filteredMenu = $initialLocations.find('li[data-id=' + woeid + ']');
                    } else {
                        countrycode = lancelotObj.find('span.country').first().attr('data-country');
                        $filteredMenu = $initialLocations.find('li[data-countryCode=' + countrycode + ']');
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


        ////////////////
        // quicksand
        ////////////////
        function reappendQuicksand($all, $filtered) {
            $all.quicksand($filtered, quicksandOptions, function () {
                lancelotLinks();//reappend lancelot lost when $locations.clone();
                showSearchLink();
            });
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
                reappendQuicksand($locations, $filteredMenu);
                e.preventDefault();
            });
        }
        function menuCountryOnClickQuicksand() {
            $menuCountry.click(function (e) {
                var countrycode = $(this).find('span.country').first().attr('data-country'),
                $filteredCountry = $initialLocations.find('li[data-countryCode=' + countrycode + ']');

                reappendQuicksand($locations, $filteredCountry);
                e.preventDefault();
            });
        }
        function menuTownOnClickQuicksand() {
            $menuTown.click(function (e) {
                var woeid = $(this).find('span.name').first().attr('data-woeid'),
                $filteredTown = $initialLocations.find('li[data-id=' + woeid + ']');

                reappendQuicksand($locations, $filteredTown);
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
                    reappendQuicksand($locations, $filteredHash);
                }
            }
        }

        function showSearchLink(){
            $('.topic').hover(
                function () {
                    $(this).find('.lancelot').show();
                },
                function () {
                    $(this).find('.lancelot').hide();
                }
            );
        }

        function init() {
            //            updateCacheTT();
            //            cronTT();
            lancelotLinks();
            lancelotMenu();
            menusOnClickQuicksand();
            urlAnchor();
            showSearchLink();
        }
        // reveal all things private by assigning public pointers
        return {
            init: init
        };
    }());


    TTlocal.init();


});