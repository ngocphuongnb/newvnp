<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>{$META.title}</title>
        {for $_TagContent in $METATAGS as $_TagName}
        <meta name="{$_TagName}" content="{$_TagContent}"/>
        {/for}
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {$CssComponents}
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lobster">
        <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Lato:400,700'>
        <link rel="stylesheet" type="text/css" href="{#CDN_SERVER#}/assets/bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" href="{#CDN_SERVER#}/assets/css/style.css">
        <link rel="shortcut icon" href="{#CDN_SERVER#}/assets/ico/favicon.ico">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{#CDN_SERVER#}/assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{#CDN_SERVER#}/assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{#CDN_SERVER#}/assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="{#CDN_SERVER#}/assets/ico/apple-touch-icon-57-precomposed.png">
        {$Hook.header}
        <script type="text/javascript">var CDN_SERVER = '{#CDN_SERVER#}';</script>
    </head>
    
    <body>
    	<!-- Header -->
        <div class="container">
            <div class="header row">
                <div class="logo span4">
                    <h1><a href="">Web2c.vn</a> <span></span></h1>
                </div>
                <div class="call-us span8">
                    <p>Tel: <span>0039 123 45 789</span> | Skype: <span>info@domain.it</span></p>
                </div>
            </div>
        </div>

        <!-- Coming Soon -->
        <div class="coming-soon">
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="span12">
                            <h2>We're Coming Soon</h2>
                            <p>We are working very hard on the new version of our site. It will bring a lot of new features. Stay tuned!</p>
                            <div class="timer">
                                <div class="days-wrapper">
                                    <span class="days"></span> <br>days
                                </div>
                                <div class="hours-wrapper">
                                    <span class="hours"></span> <br>hours
                                </div>
                                <div class="minutes-wrapper">
                                    <span class="minutes"></span> <br>minutes
                                </div>
                                <div class="seconds-wrapper">
                                    <span class="seconds"></span> <br>seconds
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="container">
            <div class="row">
                <div class="span12 subscribe">
                    <h3>Subscribe to our newsletter</h3>
                    <p>Sign up now to our newsletter and you'll be one of the first to know when the site is ready:</p>
                    <form class="form-inline" action="assets/sendmail.php" method="post">
                        <input type="text" name="email" placeholder="Enter your email...">
                        <button type="submit" class="btn">Subscribe</button>
                    </form>
                    <div class="success-message"></div>
                    <div class="error-message"></div>
                </div>
            </div>
            <div class="row">
                <div class="span12 social">
                    <a href="" class="facebook" rel="tooltip" data-placement="top" data-original-title="Facebook"></a>
                    <a href="" class="twitter" rel="tooltip" data-placement="top" data-original-title="Twitter"></a>
                    <a href="" class="dribbble" rel="tooltip" data-placement="top" data-original-title="Dribbble"></a>
                    <a href="" class="googleplus" rel="tooltip" data-placement="top" data-original-title="Google Plus"></a>
                    <a href="" class="pinterest" rel="tooltip" data-placement="top" data-original-title="Pinterest"></a>
                    <a href="" class="flickr" rel="tooltip" data-placement="top" data-original-title="Flickr"></a>
                </div>
            </div>
        </div>

        <!-- Javascript -->
        <script src="{#CDN_SERVER#}/assets/js/jquery-1.8.2.min.js"></script>
        <script src="{#CDN_SERVER#}/assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="{#CDN_SERVER#}/assets/js/jquery.backstretch.min.js"></script>
        <script src="{#CDN_SERVER#}/assets/js/jquery.countdown.js"></script>
        <script src="{#CDN_SERVER#}/assets/js/scripts.js"></script>
    </body>
</html>