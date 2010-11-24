<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:og="http://opengraphprotocol.org/schema/"
      xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
        <title>ttlocal - Local Twitter Trending Topics</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="description"
              content="Check out Twitter Trending Topics from all the places in the World in one simple view."/>
        <meta http-equiv="content-language" content="en" />

        <meta property="og:title" content="Local Twitter Trending Topics"/>
        <meta property="og:type" content="website"/>
        <meta property="og:url" content="http://ttlocal.info"/>
        <meta property="og:site_name" content="ttlocal"/>
        <meta property="fb:admins" content="100000471561695"/>
        <meta property="fb:app_id" content="151028201584145"/>
        <meta property="og:description"
              content="Check out Twitter Trending Topics from all the places in the World in one simple view."/>
	<link rel="shortcut icon" href="favicon.ico">
        <!-- 960 -->
        <link rel="stylesheet" type="text/css" href="css/reset.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="css/text.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="css/grid.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="css/layout.css" media="screen" />
        <!-- end 960 -->

        <link rel="stylesheet" type="text/css" href="css/tipTip.css" media="screen" />

        <link rel="stylesheet" type="text/css" href="css/lancelot.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="css/ttlocal.css" media="screen" />

        <!-- 960 ieca -->
        <!--[if IE 6]><link rel="stylesheet" type="text/css" href="css/ie6.css" media="screen" /><![endif]-->
        <!--[if IE 7]><link rel="stylesheet" type="text/css" href="css/ie.css" media="screen" /><![endif]-->
        <!-- end 960 ieca -->

        <?php if (PRODUCTION) : ?>
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
        <?php endif; ?>

        </head>
        <body>
            <div id="container" class="container_16 omega alpha">


                <!-- top -->
                <div class="grid_16">
                    <h1 id="branding">

                        <a href="http://ttlocal.info">
                            <img src="images/ttlocal-blue-big-blend-320.png" alt="ttlocal-logo" width="320" height="90" />
                        </a>
                        <img src="images/ttlocal-definition.png" width="248" height="131"
                             alt="The best way to discover the trending topics in your world." />

                </h1>
                <div id="like-buttons">                        
                    <?php include 'view/partial/fblike.php'; ?>


                    <?php include 'view/partial/twitterFollowButton.php'; ?>
                </div>
            </div>
            <div class="clear"></div>


            <?php include 'view/partial/menu.php'; ?>
                    <div class="clear"></div>

                    <!-- content -->
            <?php include 'view/partial/locations.php'; ?>
                    <!-- end content -->

                    <div class="clear"></div>


            <?php include 'view/partial/tweetBox.php'; ?>


                    <!-- footer -->
            <?php include 'view/partial/footer.php'; ?>
                    <!-- end footer -->


                </div>

                <!-- jquery -->
        <?php if (PRODUCTION) : ?>
                        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
        <?php else : ?>
                            <script type="text/javascript" src="js/jquery-1.4.3.min.js"></script>
        <?php endif; ?>

                            <!-- <script type="text/javascript" src="js/jquery.easing.1.3.js"></script> -->
                            <script type="text/javascript" src="js/jquery.quicksand.min.js"></script>
                            <script type="text/javascript" src="js/jquery.tipTip.minified.js"></script>
                            <script type="text/javascript" src="js/jquery.lancelot.js"></script>

        <?php if (PRODUCTION) : ?>
                                <script type="text/javascript" src="js/ttlocal.js"></script>
        <?php else : ?>
                                    <script type="text/javascript" src="js/testettlocal.js"></script>
        <?php endif; ?>

        <?php if (PRODUCTION) : ?>
                                        <!-- facebook goodies -->
                                        <div id="fb-root"></div>
                                        <script type="text/javascript" >
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
                                        <!-- end facebook goodies -->

                                        <!-- twitter goodies -->
                                        <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
                                        <script src="http://platform.twitter.com/anywhere.js?id=7xd5gQGwuWDsOBSc5Wa7Hg&v=1" type="text/javascript"></script>
                                        <script type="text/javascript">
                                            
                                            twttr.anywhere(function (T) {
                                                T("#tbox").tweetBox({
                                                    label: "What do you think of ttlocal?",
                                                    defaultContent: "@ttlocal "
                                                });
                                            });
                                             
                                        </script>
                                        <!-- end twitter goodies -->
        <?php endif; ?>

    </body>
</html>
