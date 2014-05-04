<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en"> <!--<![endif]-->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>{$META.title}</title>
        {for $_TagContent in $METATAGS as $_TagName}
        <meta name="{$_TagName}" content="{$_TagContent}"/>
        {/for}
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {$CssComponents}
        <link rel="stylesheet" href="{#CDN_SERVER#}/mooncake/css/zerogrid.css">
	<link rel="stylesheet" href="{#CDN_SERVER#}/mooncake/css/style.css">
    <link rel="stylesheet" href="{#CDN_SERVER#}/mooncake/css/responsive.css">
	<link rel="stylesheet" href="{#CDN_SERVER#}/mooncake/css/flexslider.css" type="text/css" media="screen" />
	
	<!--[if lt IE 8]>
       <div style=' clear: both; text-align:center; position: relative;'>
         <a href="http://windows.microsoft.com/en-US/internet-explorer/products/ie/home?ocid=ie6_countdown_bannercode">
           <img src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today." />
        </a>
      </div>
    <![endif]-->
    <!--[if lt IE 9]>
		<script src="{#CDN_SERVER#}/mooncake/js/html5.js"></script>
		<script src="{#CDN_SERVER#}/mooncake/js/css3-mediaqueries.js"></script>
	<![endif]-->
	
	<link href='{#CDN_SERVER#}/mooncake/images/favicon.ico' rel='icon' type='image/x-icon'/>
	
	<script src="{#CDN_SERVER#}/mooncake/js/jquery.min.js"></script>
	<script src="{#CDN_SERVER#}/mooncake/js/jquery.flexslider-min.js"></script>
	<script src="{#CDN_SERVER#}/mooncake/js/kwiks.js"></script>
	
	<script type="text/javascript">
		var Main = Main || {};

		jQuery(window).load(function() {
			window.responsiveFlag = jQuery('#responsiveFlag').css('display');
			Main.gallery = new Gallery();
			
			jQuery(window).resize(function() {
				Main.gallery.update();
			});
		});

		function Gallery(){
			var self = this;
				container = jQuery('.flexslider'),
				clone = container.clone( false );
				
			this.init = function (){
				if( responsiveFlag == 'block' ){
					var slides = container.find('.slides');
					
					slides.kwicks({
						max : 500,
						spacing : 0
					}).find('li > a').click(function (){
						return false;
					});
				} else {
					container.flexslider();
				}
			}
			this.update = function () {
				var currentState = jQuery('#responsiveFlag').css('display');
				
				if(responsiveFlag != currentState) {
				
					responsiveFlag = currentState;
					container.replaceWith(clone);
					container = clone;
					clone = container.clone( false );
					
					this.init();	
				}
			}
			
			this.init();
		}
	</script>
        {$Hook.header}
        <script type="text/javascript">var CDN_SERVER = '{#CDN_SERVER#}';</script>
    </head>
    
    <body>
    	<!--------------Header--------------->
<div class="wrap-header">
<header> 
	<div id="logo"><a href="#"><img src="{#CDN_SERVER#}/mooncake/images/logo.png"/></a></div>
	
	<nav>
		<ul>
			<li class="current"><a href="#">Home</a></li>
			<li><a href="#">Blog</a></li>
			<li><a href="#">Gallery</a></li>
			<li><a href="#">About</a></li>
			<li><a href="#">Contact</a></li>
		</ul>
	</nav>
</header>
</div>
<!--------------Slideshow--------------->


<section class="featured">
	<div id="container">
		<div class="flexslider">
			<ul class="slides">
				<li>
					<a href="#"><img src="{#CDN_SERVER#}/mooncake/images/img01.jpg" /></a>
					<div class="flex-caption">
						<h3>Lorem ipsum dolor sit amet</h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In venenatis porttitor massa eget pretium. Mauris vel erat sem, id tempor est. Pellentesque lobortis iaculis massa quis auctor.</p>
					</div>
				</li>
				<li>
					<a href="#"><img src="{#CDN_SERVER#}/mooncake/images/img02.jpg" /></a>
					<div class="flex-caption">
						<h3>Lorem ipsum dolor sit amet</h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In venenatis porttitor massa eget pretium. Mauris vel erat sem, id tempor est. Pellentesque lobortis iaculis massa quis auctor.</p>
					</div>
				</li>
				<li>
					<a href="#"><img src="{#CDN_SERVER#}/mooncake/images/img03.jpg" /></a>
					<div class="flex-caption">
						<h3>Lorem ipsum dolor sit amet</h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In venenatis porttitor massa eget pretium. Mauris vel erat sem, id tempor est. Pellentesque lobortis iaculis massa quis auctor.</p>
					</div>
				</li>
				<li>
					<a href="#"><img src="{#CDN_SERVER#}/mooncake/images/img04.jpg" /></a>
					<div class="flex-caption">
						<h3>Lorem ipsum dolor sit amet</h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In venenatis porttitor massa eget pretium. Mauris vel erat sem, id tempor est. Pellentesque lobortis iaculis massa quis auctor.</p>
					</div>
				</li>
			</ul>
	    </div>
	</div>
	<span id="responsiveFlag"></span>
</section>
			
<!--------------Content--------------->
<section id="content">
	<div class="zerogrid">		
		<div class="row">
			<div id="main-content" class="col-2-3">
				<article>
					<div class="heading">
						<h2><a href="#">Sed accumsan libero quis mi commodo et suscipit enim lacinia</a></h2>
						<div class="info">
							<ul><li><span>By: </span>Admin</li><li><span>Date: </span>November 26, 2012</li><li><span>Categories: </span>Cake</li><li><span>Comments: </span>5</li></ul>
							<div class="clearboth"></div>
						</div>
						<img src="{#CDN_SERVER#}/mooncake/images/inacup_vanilla.jpg"/>
					</div>
					<div class="content">
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam viverra convallis auctor. Sed accumsan libero quis mi commodo et suscipit enim lacinia. Morbi rutrum vulputate est sed faucibus. Nulla sed nisl mauris, id tristique tortor. Sed iaculis dapibus urna nec dictum. Proin non enim odio. Proin vitae turpis libero, eget feugiat enim. Sed fringilla facilisis convallis.</p>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam viverra convallis auctor. Sed accumsan libero quis mi commodo et suscipit enim lacinia. Morbi rutrum vulputate est sed faucibus. Nulla sed nisl mauris, id tristique tortor. Sed iaculis dapibus urna nec dictum. Proin non enim odio.</p>
						<a class="more" href="#">Read more --></a>
					</div>
				</article>
				<article>
					<div class="heading">
						<h2><a href="#">Sed accumsan libero quis mi commodo et suscipit enim lacinia</a></h2>
						<div class="info">
							<ul><li><span>By: </span>Admin</li><li><span>Date: </span>November 26, 2012</li><li><span>Categories: </span>Cake</li><li><span>Comments: </span>5</li></ul>
							<div class="clearboth"></div>
						</div>
						<img src="{#CDN_SERVER#}/mooncake/images/inacup_samoa.jpg" />
					</div>
					<div class="content">
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam viverra convallis auctor. Sed accumsan libero quis mi commodo et suscipit enim lacinia. Morbi rutrum vulputate est sed faucibus. Nulla sed nisl mauris, id tristique tortor. Sed iaculis dapibus urna nec dictum. Proin non enim odio. Proin vitae turpis libero, eget feugiat enim. Sed fringilla facilisis convallis.</p>
						<a class="more" href="#">Read more --></a>
					</div>
				</article>
				<article>
					<div class="heading">
						<h2><a href="#">Sed accumsan libero quis mi commodo et suscipit enim lacinia</a></h2>
						<div class="info">
							<ul><li><span>By: </span>Admin</li><li><span>Date: </span>November 26, 2012</li><li><span>Categories: </span>Cake</li><li><span>Comments: </span>5</li></ul>
							<div class="clearboth"></div>
						</div>
						<img src="{#CDN_SERVER#}/mooncake/images/inacup_pumpkin.jpg" />
					</div>
					<div class="content">
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam viverra convallis auctor. Sed accumsan libero quis mi commodo et suscipit enim lacinia. Morbi rutrum vulputate est sed faucibus. Nulla sed nisl mauris, id tristique tortor. Sed iaculis dapibus urna nec dictum. Proin non enim odio. Proin vitae turpis libero, eget feugiat enim. Sed fringilla facilisis convallis.</p>
						<a class="more" href="#">Read more --></a>
					</div>
				</article>
			</div>
			<div id="sidebar" class="col-1-3">
				<section>
					<div class="wrap-search">
						<div id="search">
							<div class="button-search"></div>
							<input type="text" value="Search..." onfocus="if (this.value == &#39;Search...&#39;) {this.value = &#39;&#39;;}" onblur="if (this.value == &#39;&#39;) {this.value = &#39;Search...&#39;;}">
						</div>
					</div>
					<div class="social">
						<a href="#"><img src="{#CDN_SERVER#}/mooncake/images/facebook-icon.png" title="Facebook" /></a>
						<a href="#"><img src="{#CDN_SERVER#}/mooncake/images/rss-icon.png" title="Rss"/></a>
						<a href="#"><img src="{#CDN_SERVER#}/mooncake/images/google-icon.png" title="Google Plus"/></a>
						<a href="#"><img src="{#CDN_SERVER#}/mooncake/images/linkedin-icon.png" title="Linkedin"/></a>
					</div>
				</section>
				<section>
					<div class="heading"><h2>About us</h2></div>
					<div class="content">
						<img src="{#CDN_SERVER#}/mooncake/images/zerotheme.png" style="border:none;"/>
						<p>Free Html5 Templates created by <a href="http://www.zerotheme.com">Zerotheme</a>. You can use and modify the template for both personal and commercial use. You must keep all copyright information and credit links in the template and associated files.</p>
					</div>
				</section>
				<section>
					<div class="heading"><h2>Categories</h2></div>
					<div class="content">
						<ul>
							<li><a href="http://www.zerotheme.com">Free Html5 Templates</a></li>
							<li><a href="http://www.zerotheme.com">Free Responsive Themes</a></li>
							<li><a href="http://www.zerotheme.com">Free Html5 and Css3 Themes</a></li>
						</ul>
					</div>
				</section>
				<section>
					<div class="heading"><h2>Gallery</h2></div>
					<div class="content">
						<div class="gallery">
							<a href="#"><img src="{#CDN_SERVER#}/mooncake/images/port1.jpg" class="grayscale"/></a>
							<a href="#"><img src="{#CDN_SERVER#}/mooncake/images/port2.jpg" class="grayscale"/></a>
							<a href="#"><img src="{#CDN_SERVER#}/mooncake/images/port3.jpg" class="grayscale"/></a>
							<a href="#"><img src="{#CDN_SERVER#}/mooncake/images/port1.jpg" class="grayscale"/></a>
							<a href="#"><img src="{#CDN_SERVER#}/mooncake/images/port2.jpg" class="grayscale"/></a>
							<a href="#"><img src="{#CDN_SERVER#}/mooncake/images/port3.jpg" class="grayscale"/></a>
						</div>
					</div>
				</section>
				<section>
					<div class="heading"><h2>Popular Post</h2></div>
					<div class="content">
						<div class="post">
							<img src="{#CDN_SERVER#}/mooncake/images/port1.jpg" width="50px"/>
							<h4><a href="#">Lorem ipsum dolor sit amet</a></h4>
							<p>November 11 ,2012</p>
						</div>
						<div class="post">
							<img src="{#CDN_SERVER#}/mooncake/images/port2.jpg" width="50px"/>
							<h4><a href="#">Aliquam viverra convallis</a></h4>
							<p>November 11 ,2012</p>
						</div>
						<div class="post">
							<img src="{#CDN_SERVER#}/mooncake/images/port3.jpg" width="50px"/>
							<h4><a href="#">TSed accumsan libero</a></h4>
							<p>November 11 ,2012</p>
						</div>
						<div class="post">
							<img src="{#CDN_SERVER#}/mooncake/images/port1.jpg" width="50px"/>
							<h4><a href="#">Lorem ipsum dolor sit amet</a></h4>
							<p>November 11 ,2012</p>
						</div>
						<div class="post">
							<img src="{#CDN_SERVER#}/mooncake/images/port2.jpg" width="50px"/>
							<h4><a href="#">Aliquam viverra convallis</a></h4>
							<p>November 11 ,2012</p>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>
</section>
<!--------------Footer--------------->
<div class="wrap-footer">
	<footer>
		<div class="wrapfooter">
		<p>Copyright © 2012 - <a href="http://www.zerotheme.com/432/free-responsive-html5-css3-website-templates.html" target="_blank">Free Responsive Html5 Templates</a> by <a href="http://www.zerotheme.com" target="_blank">Zerotheme.com</a></p>
		</div>
	</footer>
</div>
    </body>
</html>