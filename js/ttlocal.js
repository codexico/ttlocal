jQuery(document).ready(function ($) {


    //Revealing Module Pattern
    var TTlocal = (function () {

        // get the first collection
        var $applications = $('#locations'),
        // clone applications to get a second collection
        $data = $applications.clone(),
        //menu pieces
        $menuMainNav = $('ul.nav li a'),
        $menuCountry = $('.nav li.country a'),
        $menuTown = $('.nav li.town a');


        ////////////////
        // update cache
        ////////////////
        function updateCacheTT() {
            $.ajax({
                type: "POST",
                url: "update.php",
                success: function (data) {
                    if (data === "updated") {
                        if (window.console) {
                            window.console.log("Updated! You can refresh now.");
                        }
                    }//TODO: add some visual alert? auto-refresh content?
                }
            });
        }
        function cronTT() {//quem nao tem cron vai de setInterval
            window.setInterval(updateCacheTT, 610000);//10min,10s
        }


        /////////////
        // lancelot
        /////////////
        function googleSearch(obj) {
            //obj is a reference to each $('.lancelot')
            var search = obj.text().replace(/^#/, '');
            return "http://www.google.com/search?q=" + search;
        }
        function lancelotLinks() {
            $('.lancelot').lancelot({
                hoverTime: 2000,
                speed: "slow"
            }).lancelot({
                hoverTime: 2000,
                aclass: "lancelotGo2",
                speed: "slow",
                alink: googleSearch
            });
        }
        //connect lancelot to quicksand
        function lancelotMenuLaunchQuicksand(obj) {
            //obj is a reference to each $('.lancelot')
            var $filteredMenu, woeid, countrycode;
            switch (obj.attr("href")) {
                case "#Worldwide":
                    $filteredMenu = $data.find('li.local');
                    break;
                case "#Town":
                    $filteredMenu = $data.find('li[data-placeType=7]');
                    break;
                case "#Country":
                    $filteredMenu = $data.find('li[data-placeType=12]');
                    break;
                default:
                    woeid = obj.find('span.name').first().attr('data-woeid');
                    if (woeid) {
                        $filteredMenu = $data.find('li[data-id=' + woeid + ']');
                    } else {
                        countrycode = obj.find('span.country').first().attr('data-country');
                        $filteredMenu = $data.find('li[data-countryCode=' + countrycode + ']');
                    }
                    break;
            }
            $applications.quicksand($filteredMenu, function () {
                lancelotLinks();//reappend lancelot lost when $applications.clone();
            });
        }
        function lancelotMenu() {
            $('.lancelot-menu').lancelot({
                hoverTime: 800,
                speed: "slow",
                aclass: "lancelotsimples",
                element: "span",
                launch: lancelotMenuLaunchQuicksand
            });
        }


        ////////////////
        // quicksand
        ////////////////
        function reappendQuicksand($all, $filtered) {
            $all.quicksand($filtered, function () {
                lancelotLinks();//reappend lancelot lost when $applications.clone();
            });
        }
        function menuMainOnClickQuicksand() {
            $menuMainNav.click(function (e) {
                var menuhref = $(this).attr('href'),
                $filteredMenu = $data.find('li.local');
                switch (menuhref) {
                    case "#Town":
                        $filteredMenu = $data.find('li[data-placeType=7]');
                        break;
                    case "#Country":
                        $filteredMenu = $data.find('li[data-placeType=12]');
                        break;
                    default:
                        break;
                }
                reappendQuicksand($applications, $filteredMenu);
                e.preventDefault();
            });
        }
        function menuCountryOnClickQuicksand() {
            $menuCountry.click(function (e) {
                var countrycode = $(this).find('span.country').first().attr('data-country'),
                $filteredCountry = $data.find('li[data-countryCode=' + countrycode + ']');

                reappendQuicksand($applications, $filteredCountry);
                e.preventDefault();
            });
        }
        function menuTownOnClickQuicksand() {
            $menuTown.click(function (e) {
                var woeid = $(this).find('span.name').first().attr('data-woeid'),
                $filteredTown = $data.find('li[data-id=' + woeid + ']');

                reappendQuicksand($applications, $filteredTown);
                e.preventDefault();
            });
        }
        function menusOnClickQuicksand() {
            menuMainOnClickQuicksand();
            menuCountryOnClickQuicksand();
            menuTownOnClickQuicksand();
        }

        function init() {
            updateCacheTT();
            cronTT();
            lancelotLinks();
            lancelotMenu();
            menusOnClickQuicksand();
        }
        // reveal all things private by assigning public pointers
        return {
            init: init
        };
    }());


    TTlocal.init();

});