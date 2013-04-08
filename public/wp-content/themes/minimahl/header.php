<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
if(self != top) { top.location = self.location; }
</script>

  <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
  <meta name="description" content="" />
  <meta name="keywords" content="" />
  <meta name="author" content="" />
  <meta name="robots" content="all,follow" />

  <title><?php bloginfo('name'); ?><?php wp_title(); ?></title>

  <style type="text/css">
    <!--
    @import url("<?php bloginfo('stylesheet_url'); ?>");
    -->
  </style>
  
  <!--[if IE 6]>
  <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/style.ie6.css" />
  <![endif]-->

  <link rel="icon" href="/favicon.ico" type="image/x-icon" /><!-- edit the content line if needed -->
  <link rel="EditURI" type="application/rsd+xml" title="RSD" href="http://scott-m.net/xmlrpc.php?rsd" />

  <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />

  <?php wp_head(); ?>

</head>


<body>
  <div id="container">

    
  <div id="header">
      <h1>
        <a href="<?php echo get_settings('home'); ?>/">
          <?php bloginfo('name'); ?>
        </a>
      </h1>
          
      <ul id="menu-header">
                          <li class="page_item page-item-7"><a href="http://vivelibre.erikbenoist.com/durazno" title="El Durazno">El Durazno Project |</a></li> 

          <li<?php if(is_home()) {echo " class=\"page_item current_page_item\"";} else {echo " class=\"page_item\"";} ?>><a href="<?php echo get_settings('home'); ?>/">Home</a></li>

          <?php wp_list_pages('title_li='); ?>

      </ul>
  </div> 
  <span class="clearer"></span>
  <h2 class="description"><?php bloginfo('description'); ?></h2>
  
