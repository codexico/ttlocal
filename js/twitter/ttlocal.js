jQuery(document).ready(function($) {

    /**************
    * update cache
    **************/

    function updateCacheTT(){
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
    }

    function cronTT(){//quem nao tem cron vai de setInterval
        window.setInterval(updateCacheTT, 610000);//10min,10s
    }
    updateCacheTT();
    cronTT();
    //end update

    // get the first collection
    var $applications = $('#locations');

    // clone applications to get a second collection
    var $data = $applications.clone();


    /***********
    * lancelot
    ***********/

    var googleSearch = function(obj){
        //obj is a reference to each $('.lancelot')
        var search = obj.text().replace(/^#/,'');
        return "http://www.google.com/search?q="+search;
    };

    var lancelotLinks = function(){
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
    lancelotLinks();

    var launchQuicksand = function(obj) {
        //obj is a reference to each $('.lancelot')
        var $filteredMenu = '';
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
                var woeid = obj.find('span.name').first().attr('data-woeid');
                if(woeid){
                    $filteredMenu = $data.find('li[data-id=' + woeid + ']');
                }else{
                    var countrycode = obj.find('span.country').first().attr('data-country');
                    $filteredMenu = $data.find('li[data-countryCode=' + countrycode + ']');
                }
                break;
        }
        $applications.quicksand($filteredMenu, function() {
            lancelotLinks();//reappend lancelot lost when $applications.clone();
        });
    }

    $('.lancelot-menu').lancelot({
        hoverTime: 800,
        speed: "slow",
        aclass: "lancelotsimples",
        element: "span",
        launch: launchQuicksand
    });
    //end lancelot
    

    /***********
    * quicksand
    ***********/



    var $menunav = $('ul.nav li a');
    $menunav.click(function(e){
        var menuhref = $(this).attr('href');

        var $filteredMenu = $data.find('li.local');
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
        $applications.quicksand($filteredMenu, function() {
            lancelotLinks();//reappend lancelot lost when $applications.clone();
        });
        e.preventDefault();
    });


    var $country = $('.nav li.country a');
    $country.click(function(e){
        var countrycode = $(this).find('span.country').first().attr('data-country');

        var $filteredCountry = $data.find('li[data-countryCode=' + countrycode + ']');

        $applications.quicksand($filteredCountry, function() {
            lancelotLinks();//reappend lancelot lost when $applications.clone();
        });
        e.preventDefault();
    });


    var $town = $('.nav li.town a');
    $town.click(function(e){
        var woeid = $(this).find('span.name').first().attr('data-woeid');

        var $filteredTown = $data.find('li[data-id=' + woeid + ']');

        $applications.quicksand($filteredTown, function() {
            lancelotLinks();//reappend lancelot lost when $applications.clone();
        });
        e.preventDefault();
    });
    //end quicksand

});