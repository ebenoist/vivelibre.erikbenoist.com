<?php
/** index.php
 *
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @author		Konstantin Obenland
 * @package		The Bootstrap
 * @since		1.0.0 - 05.02.2012
 */
?>

<html class="no-js" <?php language_attributes(); ?>>
	<head>
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="<?php echo get_bloginfo('template_url')?>/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo get_bloginfo('template_url')?>/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="<?php echo get_bloginfo('template_url')?>/css/docs.css" rel="stylesheet">
    <link href="<?php echo get_bloginfo('template_url')?>/js/google-code-prettify/prettify.css" rel="stylesheet"> 
    <link href="<?php echo get_bloginfo('template_url')?>/style.css" rel="stylesheet">
    <title>BronwynMead</title>
	</head>
  <body data-spy="scroll" data-target=".subnav" data-offset="50">
<div class="container">
<header class="jumbotron masthead">
  <div class="inner">
     <img src="<?php echo get_bloginfo('template_url') . '/images/new800pxbanner.png';?>">
  </div>
<hr class="soften">
  <div class="bs-links">
    <ul class="quick-links">

<?php
  $pages = get_pages('exclude=16'); 
  foreach ( $pages as $page ) {
    $option = '<li><a href=' . get_page_link( $page->ID ) . "a>";
    $option .= $page->post_title;
    $option .= "</a></li>";
	  echo $option;
  }
 ?>
    </ul></div>
</header>
<div class="marketing">

<div class="span4">
<?php 

if ( have_posts() ) {
  while ( have_posts() ) {
    the_post();
    get_template_part( '/partials/content', get_post_format() );
  }
}
else {
  get_template_part( '/partials/content', 'not-found' );
}
?>
</div>
</div>
</body>
