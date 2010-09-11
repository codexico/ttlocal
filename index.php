<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>TTlocal - Local Twitter Trending Topics</title>
        <meta name="description" content="Check out Twitter Trending Topics from all the places in the World in one simple view." />
        <meta http-equiv="content-language" content="en" />


        <!-- 960 -->
        <link rel="stylesheet" type="text/css" href="css/reset.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="css/text.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="css/grid.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="css/layout.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="css/nav.css" media="screen" />
        <!-- end 960 -->


        <link rel="stylesheet" type="text/css" href="css/lancelot.css" media="screen" />

        <link rel="stylesheet" type="text/css" href="css/ttlocal.css" media="screen" />

        
        <!-- 960 ieca -->
        <!--[if IE 6]><link rel="stylesheet" type="text/css" href="css/ie6.css" media="screen" /><![endif]-->
        <!--[if IE 7]><link rel="stylesheet" type="text/css" href="css/ie.css" media="screen" /><![endif]-->
        <!-- end 960 ieca -->


        <!-- google analytics -->
        <script type="text/javascript">
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-17676120-1']);
            _gaq.push(['_trackPageview']);
            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();
        </script>
        <!-- end google analytics -->


    </head>
    <body>
        <div class="container_16">


            <!-- top -->
            <div class="grid_16">
                <h1 id="branding">
                    <a href="http://ttlocal.info">TTlocal</a>

                    <!-- facebook like button -->
                    <fb:like href="http://ttlocal.info"
                             layout="button_count"
                             show_faces="false"
                             width="90"
                             colorscheme="dark">
                    </fb:like>
                    <!-- end facebook like button -->


                    <!-- twitter followButton -->
                    <span id="follow-twitterapi" class=""></span>
                    <a href="http://twitter.com/share" class="twitter-share-button"
                       data-count="horizontal"
                       data-via="ttlocal"
                       data-related="codexico:ttlocal developer"></a>
                    <!-- end twitter followButton -->
                </h1>
            </div>
            <div class="clear"></div>
            <!-- end top -->


            <!-- content -->
            <?php
            include_once 'cache/tt.html';
            ?>
            <!-- end content -->


            <!-- twitter tweetBox -->
            <div id="tbox" class=" suffix_3 grid_10 prefix_3 box"></div>
            <div class="clear"></div>
            <!-- end twitter tweetBox -->


            <!-- footer -->
            <?php
            include_once 'footer.php';
            ?>
            <!-- end footer -->


        </div>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery.lancelot.js"></script>
        <script type="text/javascript" src="js/jquery.quicksand.min.js"></script>

        <script type="text/javascript" src="js/ttlocal.js"></script>

        <!-- twitter goodies -->
        <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
        <script src="http://platform.twitter.com/anywhere.js?id=7xd5gQGwuWDsOBSc5Wa7Hg&v=1" type="text/javascript"></script>
        <!--
        <script type="text/javascript">
            twttr.anywhere(function (T) {
                T('#follow-twitterapi').followButton("ttlocal");
            });
        </script>
        -->
        <script type="text/javascript">
            twttr.anywhere(function (T) {
                T("#tbox").tweetBox({
                    label: "What do you think of @TTlocal?",
                    defaultContent: "@ttlocal "
                });
            });
        </script>
        <!-- end twitter goodies -->

        <div id="fb-root"></div>
        <script>
            window.fbAsyncInit = function() {
                FB.init({appId: '151028201584145', status: true, cookie: true,
                    xfbml: true});
            };
            (function() {
                var e = document.createElement('script'); e.async = true;
                e.src = document.location.protocol +
                    '//connect.facebook.net/en_US/all.js';
                document.getElementById('fb-root').appendChild(e);
            }());
        </script>

    </body>
</html>