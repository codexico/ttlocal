<!doctype html>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>ttlocal - Local Twitter Trending Topics</title>
    <meta name="description"
          content="Check out Twitter Trending Topics from all the places in the World in one simple view."/>
    <meta http-equiv="content-language" content="en" />
    <meta name="author" content="codexico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta property="og:title" content="Local Twitter Trending Topics"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="http://ttlocal.info"/>
    <meta property="og:site_name" content="ttlocal"/>
    <meta property="fb:admins" content="100000471561695"/>
    <meta property="fb:app_id" content="151028201584145"/>
    <meta property="og:description"
          content="Check out Twitter Trending Topics from all the places in the World in one simple view."/>

    <link rel="shortcut icon" href="favicon.ico">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">


    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.css" media="screen" />


    <link rel="stylesheet" type="text/css" href="css/lancelot.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="css/ttlocal.css?v=3" media="screen" />

    <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
    <script src="js/libs/modernizr.js"></script>

  </head>
  <body>
    <div id="container">

      <header class="container-fluid">
        <!-- top -->
        <div class="row-fluid">
          <div class="span12">
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
        </div>
      </header>

      <div id="main">
        <!-- top -->
        <div class="container-fluid">
          <div class="row-fluid">
            <div class="span12">
              <?php include 'view/partial/menu.php'; ?>
            </div>
          </div>
        </div>

        <!-- content -->
        <div class="container-fluid">
          <div class="row-fluid">
            <?php include 'view/partial/locations.php'; ?>
            <!-- end content -->
          </div>
        </div>

        <?php include 'view/partial/tweetBox.php'; ?>
      </div>
      <footer id="footer" class="container-fluid">
        <div class="row-fluid">
          <div class="span12">
            <!-- footer -->
            <?php include 'view/partial/footer.php'; ?>
            <!-- end footer -->
          </div>
        </div>
      </footer>
    </div><!--! end of #container -->

    <!-- jquery -->
    <?php if (PRODUCTION) : ?>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
      <script>!window.jQuery && document.write(unescape('%3Cscript src="js/libs/jquery-1.7.1.min.js"%3E%3C/script%3E'))</script>
    <?php else : ?>
      <script src="js/libs/jquery-1.7.1.min.js"></script>
    <?php endif; ?>

    <?php if (PRODUCTION) : ?>
      <script src="js/libs/jquery.quicksand.min.js"></script>
      <script src="js/libs/jquery.lancelot.js"></script>
      <script src="js/libs/bootstrap.min.js"></script>
      <script src="js/ttlocal2.js"></script>

    <?php else : ?>

  <!-- <script src="js/jquery.easing.1.3.js"></script> -->
      <script src="js/libs/jquery.quicksand.min.js"></script>
      <!-- <script src="js/jquery.tipTip.js"></script> -->
      <script src="js/libs/jquery.lancelot.js"></script>
      <!-- <script src="js/jquery.simplemodal-1.4.1.js"></script> -->
      <script src="js/libs/bootstrap.min.js"></script>

      <script src="js/ttlocal2.js"></script>
    <?php endif; ?>

    <?php if (PRODUCTION) : ?>
      <!-- facebook goodies -->
      <div id="fb-root"></div>
      <script >
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
      <script src="http://platform.twitter.com/widgets.js"></script>
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

      <!-- asynchronous google analytics: mathiasbynens.be/notes/async-analytics-snippet
           change the UA-XXXXX-X to be your site's ID -->
      <script>
        var _gaq = [['_setAccount', 'UA-17676120-1'], ['_trackPageview']];
        (function(d, t) {
          var g = d.createElement(t),
          s = d.getElementsByTagName(t)[0];
          g.async = true;
          g.src = ('https:' == location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
          s.parentNode.insertBefore(g, s);
        })(document, 'script');
      </script>

    <?php endif; ?>

  </body>
</html>