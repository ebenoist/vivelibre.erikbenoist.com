<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"<?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?> | <?php bloginfo('description'); ?></title>

<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/reset.css" type="text/css" />
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/fonts.css" type="text/css" />
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/printstyle.css" type="text/css" media="print" />

<link rel="alternate" type="application/rss+xml" title="<?php printf(__('%s RSS Feed', 'kubrick'), get_bloginfo('name')); ?>" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="<?php printf(__('%s Atom Feed', 'kubrick'), get_bloginfo('name')); ?>" href="<?php bloginfo('atom_url'); ?>" /> 
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />


<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.page-scroller-306.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/bookmarker.js"></script>


<?php wp_head(); ?>
</head>
<body>

<!-- bookmarker -->
<div id="bookmarker"></div>
<!-- /bookmarker -->

<!-- header menu -->
<div id="header_menu_bg">
	<div id="header_menu_container">
		<div id="header_menu_inner">
			<!-- left menu -->
			<div id="header_menu_left">
					<ul>
						<li><a id="bookmarker_switch">bookmarker on/off</a></li>
					</ul>
			</div><!-- /left menu -->
			<!-- right menu -->
			<div id="header_menu_right">
					<ul>
						<li><a href="<?php bloginfo('home'); ?>">home</a></li>
						<!--
						<li><a href="">about</a></li>
						<li><a href="">twitter</a></li>
						-->
						<li><a href="#top">pagetop</a></li>
					</ul>
			</div><!-- /right menu -->
		</div><!-- /header_menu_inner -->
	</div><!-- /header_menu_container -->
</div><!-- /header menu -->


<!-- container -->
<div id="container">

	<!-- inner -->
	<div id="inner">

	<!-- header -->
	<div id="header">
		<h1><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
		<p id="blog_description"><?php bloginfo('description'); ?></p>

		<!-- search form -->
		<form id="searchform" method="get" action="<?php bloginfo('url'); ?>">
		<input class="isearch" type="text" name="s" id="keywords" value="Search in blog..." onfocus="if(this.value==this.defaultValue){this.value=''}" onblur="if(this.value==''){this.value=this.defaultValue}" />
		<input class="ibutton" type="submit" value="" />
		</form><!-- /search form -->

		<!-- rss feed -->
		<div id="feed">
			<p><a href="<?php bloginfo('rss2_url'); ?>"><img src="<?php bloginfo('template_url'); ?>/images/rssfeedicon.jpg" width="12" height="12" alt="RSS feed" />rss feed</a></p>
					<a id="top"></a><!-- to page top -->

		</div><!-- /rss feed -->

	</div><!-- /header -->


