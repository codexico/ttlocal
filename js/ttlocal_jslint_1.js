jQuery(document).ready(function ($) {


    // Define a local copy of jQuery
    var TTL = function () {
        // The jQuery object is actually just the init constructor 'enhanced'
        return new TTL.fn.init();
    };

    // get the first collection
    TTL.$applications = $('#locations'),

    // clone applications to get a second collection
    TTL.$data = TTL.$applications.clone();

    TTL.$menunav = $('ul.nav li a');

    TTL.$country = $('.nav li.country a');

    TTL.$town = $('.nav li.town a');




    TTL.fn = TTL.prototype = {
        init: function() {
        //            TTL.updateCacheTT();
        //            TTL.cronTT();
        },


        ////////////////
        // update cache
        ////////////////
        updateCacheTT : function() {
            $.ajax({
                type: "POST",
                url: "update.php",
                success: function(data) {
                    if(data=="updated"){
                        if(window.console) {
                            console.log("Updated! You can refresh now.");
                        }
                    }
                //TODO: add some visual alert
                //TODO: auto-refresh content?
                }
            });
        },

        cronTT : function() {//quem nao tem cron vai de setInterval
            window.setInterval(updateCacheTT, 610000);//10min,10s
        },

        googleSearch : function(obj){
            //obj is a reference to each $('.lancelot')
            var search = obj.text().replace(/^#/,'');
            return "http://www.google.com/search?q="+search;
        },


        ////////////
        // lancelot
        ////////////
        lancelotLinks : function(){
            $('.lancelot').lancelot({
                hoverTime: 2000,
                speed: "slow"
            }).lancelot({
                hoverTime: 2000,
                aclass: "lancelotGo2",
                speed: "slow",
                alink: TTL.fn.googleSearch
            });
        },

        //connect lancelot to quicksand
        menuQuicksand : function(obj){
            //obj is a reference to each $('.lancelot')
            var $filteredMenu = '';
            switch (obj.attr("href")) {
                case "#Worldwide":
                    $filteredMenu = TTL.$data.find('li.local');
                    break;
                case "#Town":
                    $filteredMenu = TTL.$data.find('li[data-placeType=7]');
                    break;
                case "#Country":
                    $filteredMenu = TTL.$data.find('li[data-placeType=12]');
                    break;
                default:
                    var woeid = obj.find('span.name').first().attr('data-woeid');
                    if(woeid){
                        $filteredMenu = TTL.$data.find('li[data-id=' + woeid + ']');
                    }else{
                        var countrycode = obj.find('span.country').first().attr('data-country');
                        $filteredMenu = TTL.$data.find('li[data-countryCode=' + countrycode + ']');
                    }
                    break;
            }
            TTL.$applications.quicksand($filteredMenu, function() {
                TTL.fn.lancelotLinks();//reappend lancelot lost when TTL.$applications.clone();
            });
        }

    };

    TTL();


    ////////////////
    // lancelot
    ////////////////
    TTL.fn.lancelotLinks();


    $('.lancelot-menu').lancelot({
        hoverTime: 800,
        speed: "slow",
        aclass: "lancelotsimples",
        element: "span",
        launch: TTL.fn.menuQuicksand
    });
    //end lancelot
    

    ////////////////
    // quicksand
    ////////////////
    TTL.$menunav.click(function(e){
        var menuhref = $(this).attr('href');

        var $filteredMenu = TTL.$data.find('li.local');
        switch (menuhref) {
            case "#Town":
                $filteredMenu = TTL.$data.find('li[data-placeType=7]');
                break;
            case "#Country":
                $filteredMenu = TTL.$data.find('li[data-placeType=12]');
                break;
            default:
                break;
        }
        TTL.$applications.quicksand($filteredMenu, function() {
            TTL.fn.lancelotLinks();//reappend lancelot lost when TTL.$applications.clone();
        });
        e.preventDefault();
    });


    TTL.$country.click(function(e){
        var countrycode = $(this).find('span.country').first().attr('data-country');

        var $filteredCountry = TTL.$data.find('li[data-countryCode=' + countrycode + ']');

        TTL.$applications.quicksand($filteredCountry, function() {
            TTL.fn.lancelotLinks();//reappend lancelot lost when TTL.$applications.clone();
        });
        e.preventDefault();
    });


    TTL.$town.click(function(e){
        var woeid = $(this).find('span.name').first().attr('data-woeid');

        var $filteredTown = TTL.$data.find('li[data-id=' + woeid + ']');

        TTL.$applications.quicksand($filteredTown, function() {
            TTL.fn.lancelotLinks();//reappend lancelot lost when TTL.$applications.clone();
        });
        e.preventDefault();
    });

//end quicksand

});