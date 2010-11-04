<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:og="http://opengraphprotocol.org/schema/"
      xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
        <title>TTlocal - Local Twitter Trending Topics</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />

        <meta property="og:title" content="Local Twitter Trending Topics"/>
        <meta property="og:type" content="website"/>
        <meta property="og:url" content="http://ttlocal.info"/>
        <meta property="og:site_name" content="TTlocal"/>
        <meta property="fb:admins" content="USER_ID"/>
        <meta property="og:description"
              content="Check out Twitter Trending Topics from all the places in the World in one simple view."/>

        <meta name="description"
              content="Check out Twitter Trending Topics from all the places in the World in one simple view."/>
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
        <!-- end google analytics -->


    </head>
    <body>
        <div class="container_16">


            <!-- top -->
            <div class="grid_16">
                <h1 id="branding">
                    <a href="http://ttlocal.info">
                        <img src="images/ttlocal-blue-big-blend.png" alt="ttlocal-logo" />
                    </a>
                    <!-- <span class="version" title="Wait.." >BETA 0.4</span>-->


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

<div class="grid_10 prefix_3 suffix_3">
    <h2 id="page-heading" class="">The best way to discover the trending topics in your world.</h2>
</div>
<div class="clear"></div>

            <!-- content -->
            <?php
            include_once 'testecontent.php';
            echo $content;
            ?>
            <?php
            //include_once 'cache/tt.html';
            ?>
            <!-- end content -->


            <div class="clear"></div>
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
        <script type="text/javascript" src="js/jquery-1.4.3.min.js"></script>
        <!-- <script type="text/javascript" src="js/jquery.lancelot-compiled.js"></script> -->
        
        <script type="text/javascript" src="js/jquery.quicksand.min.js"></script>

        <script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
            <!-- lancelot -->
        <script type="text/javascript" src="js/jquery.lancelot.js"></script>

        <script type="text/javascript" src="js/testettlocal.js"></script>

        <!-- facebook goodies -->
        <!-- end facebook goodies -->

        <!-- twitter goodies -->
        <!-- end twitter goodies -->

    </body>
</html>