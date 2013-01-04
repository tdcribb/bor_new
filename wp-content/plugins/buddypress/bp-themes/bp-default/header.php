<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
	<head profile="http://gmpg.org/xfn/11">
		<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
		<?php if ( current_theme_supports( 'bp-default-responsive' ) ) : ?><meta name="viewport" content="width=device-width, initial-scale=1.0" /><?php endif; ?>
		<title><?php wp_title( '|', true, 'right' ); bloginfo( 'name' ); ?></title>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		
		<?php do_action( 'bp_head' ); ?>
		<?php wp_head(); ?>

		<script>
  			var $ = jQuery.noConflict();    
		</script>
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo esc_url( home_url( '/' ) ); ?>wp-content/plugins/buddypress/bp-themes/bp-default/bor.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo esc_url( home_url( '/' ) ); ?>wp-content/plugins/buddypress/bp-themes/bp-default/iphone.css" />
		<link rel="shortcut icon" href="<?php echo esc_url( home_url( '/' ) ); ?>favicon.ico" />

		<script src="<?php echo esc_url( home_url( '/' ) ); ?>wp-content/themes/twentyeleven/jquery.easing.1.3.js"></script>
		<script src="<?php echo esc_url( home_url( '/' ) ); ?>wp-content/themes/twentyeleven/jquery.columnizer.min.js"></script>
		<script src="<?php echo esc_url( home_url( '/' ) ); ?>wp-content/themes/twentyeleven/jquery.fullscreenr.js"></script>
		<script>
  			var $ = jQuery.noConflict();    
		</script>
		<script src="<?php echo esc_url( home_url( '/' ) ); ?>wp-content/plugins/buddypress/bp-themes/bp-default/bor.js"></script>

		<script type="text/javascript">

		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-36827559-1']);
		  _gaq.push(['_trackPageview']);
		
		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
		
		</script>

		<script>
			// var FullscreenrOptions = { width: 1012, height: 790, bgID: '#wood-bg' }; //black leather
			// var FullscreenrOptions = { width: 2000, height: 1333, bgID: '#wood-bg' }; //brown leather
			var FullscreenrOptions = { width: 1280, height: 1080, bgID: '#wood-bg' }; //wood grain
			jQuery.fn.fullscreenr(FullscreenrOptions); 
		</script>

	</head>

	<body <?php body_class(); ?> id="bp-default">

		<img id="wood-bg" src="/wp-content/images/content/wood.jpg" />
		<!-- <img id="wood-bg" src="/wp-content/images/content/leather.jpg" /> -->
		<!-- <img id="wood-bg" src="/wp-content/images/content/blackleather.jpg" /> -->

		<?php do_action( 'bp_before_header' ); ?>

		<div id="header">



				<?php do_action( 'bp_search_login_bar' ); ?>

			<div id="navigation" role="navigation">
				<!-- <img id="header-bg" src="/wp-content/images/header/header-bookmark.png" /> -->
				<img id="header-bg" src="/wp-content/images/header/garnet-header-ribbon.png" />
				

				<img class="header-book-img" src="/wp-content/images/header/book-logo-h150.png" />
				<div id="website-title">
					<a class="logo-url" href="/">
						<img id="header-title" src="/wp-content/images/header/title.png" />
					</a>
				</div>
				<div id="tag-line">
					<img src="<?php echo esc_url(home_url('/')); ?>wp-content/images/tag-line.png" />
				</div>

<!-- 			<?php if (! is_user_logged_in() ) { ?>
				<div id="header-login-register">
					<a class="header-register" href="/membership-options/" tabindex="10">REGISTER </a>
					<a class="header-login-left" href="/"> LOGIN</a>

					<div class="iphone-header-text-only">or </div><a class="iphone-header-text-only" href="#sidebar-login-form"> Login Below</a>
				</div>
			<?php } else { ?>
				<div id="header-login-register">
					<a href="">Welcome, <?php global $current_user; get_currentuserinfo(); echo $current_user->display_name; ?> </a>
					<a class="logout" href="<?php echo 
						esc_url( home_url( '/' ) ); ?>wp-login.php?action=logout&redirect_to=http%3A%2F%2Fbookofrelations.com%2F%3Faction%3Dlogout%26redirect_to%3Dhttp%253A%252F%252Fbookofrelations.com%252Factivity%26_wpnonce%3D8a3adccefa&_wpnonce=8a3adccefa">Log Out</a>
				</div>
			<?php } ?> -->
				<div id="header-login-register">
					<?php echo do_shortcode('[flexible-frontend-login]'); ?>
					
				</div>
				<div id="header-search-cont">
					<div class="search-text">Begin your search here...</div></br>
					<?php get_search_form(); ?>
				</div>
				<?php wp_nav_menu( array( 'container' => false, 'menu_id' => 'nav', 'theme_location' => 'primary', 'fallback_cb' => 'bp_dtheme_main_nav' ) ); ?>
			</div>

			<?php do_action( 'bp_header' ); ?>

		</div><!-- #header -->

		<?php do_action( 'bp_after_header'     ); ?>
		<?php do_action( 'bp_before_container' ); ?>

		<div id="container">



			<div id="left-nav">
				<img id="left-nav-border" src="/wp-content/images/content/longvert-wood-border.jpg" />
				<div class="left-nav-link">
					<img class="left-nav-img book-front" src="/wp-content/images/sidebar/small-blank-book.png" />
					<div class="left-top-text"><div>BECOME A MEMBER</div></div>
					<img class="left-nav-img book-page" src="/wp-content/images/sidebar/small-blank-page.png" />
					<div class="left-nav-text">
						<span><a href="/membership-options">Member Options</a></span>
					</div>
					<img class="content-bottom-border" src="/wp-content/images/content/long-horiz-wood-border.jpg" />
				</div>
				<div class="left-nav-link">
					<img class="left-nav-img book-front" src="/wp-content/images/sidebar/small-blank-book.png" />
					<div class="left-top-text"><div>ADD YOUR OWN CHAPTER</div></div>
					<img class="left-nav-img book-page" src="/wp-content/images/sidebar/small-blank-page.png" />
					<div class="left-nav-text">
						<span><a href="/add-your-history">Add Your Chapter</a></span></br></br>
						<span><a href="/membership-options/dashboard/">Chapter Review</a></span>
					</div>
					<img class="content-bottom-border" src="/wp-content/images/content/long-horiz-wood-border.jpg" />
				</div>
				<div class="left-nav-link">
					<img class="left-nav-img book-front" src="/wp-content/images/sidebar/small-blank-book.png" />
					<div class="left-top-text"><div>STORIES</div></div>
					<img class="left-nav-img book-page" src="/wp-content/images/sidebar/small-blank-page.png" />
					<div class="left-nav-text">
						<span><a href="/activity">Browse Stories</a></span>
					</div>
					<img class="content-bottom-border" src="/wp-content/images/content/long-horiz-wood-border.jpg" />
				</div>
				<div class="left-nav-link">
					<img class="left-nav-img book-front" src="/wp-content/images/sidebar/small-blank-book.png" />
					<div class="left-top-text"><div>BROWSE MEMBERS</div></div>
					<img class="left-nav-img book-page" src="/wp-content/images/sidebar/small-blank-page.png" />
					<div class="left-nav-text">
						<span><a href="/members">Browse Members</a></span>
					</div>
					<img class="content-bottom-border" src="/wp-content/images/content/long-horiz-wood-border.jpg" />
				</div>
				<div class="left-nav-link">
					<img class="left-nav-img book-front" src="/wp-content/images/sidebar/small-blank-book.png" />
					<div class="left-top-text"><div>BOOK STORE</div></div>
					<img class="left-nav-img book-page" src="/wp-content/images/sidebar/small-blank-page.png" />
					<div class="left-nav-text">
						<span><a href="/store/products">Book Store</a></span></br></br>
						<span><a href="/e-books">E-Book Store</a></span></br></br>
						<span><a href="/store/shopping-cart">Cart</a></span>
					</div>
					<img class="content-bottom-border" src="/wp-content/images/content/long-horiz-wood-border.jpg" />
				</div>
			</div>













