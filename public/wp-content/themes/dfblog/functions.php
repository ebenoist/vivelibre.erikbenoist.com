<?php
define( 'THEMEVERSION', '1.1.3' );

if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));

add_filter('comments_template', 'legacy_comments');

function legacy_comments($file) {
	if(!function_exists('wp_list_comments')) 	$file = TEMPLATEPATH . '/legacy.comments.php';
	return $file;
}

/* dfBlog Theme admin
***************************************************************************** */
function df_get_stylelist( $style_dir_path ) {

	$r = array();
	$dir = TEMPLATEPATH.$style_dir_path.'/';

	if( $fd = opendir( $dir ) ) {
		while( ( $file = readdir( $fd ) ) !== false )
			if( is_dir( $dir.$file ) && $file!="." && $file!=".." ) $r[$file] = $file;
		closedir($fd);
	}
	return( $r );
}

function df_get_admintextlabel( $value ) {

	switch( $value ) {
		case "header":
			return (__('Header Style', 'default').'<br /><small>'.__('must be a directory in', 'default').' \'/images/styles\'</small>');
		case "background":
			return (__('Background Style', 'default').'<br /><small>'.__('must be a directory in', 'default').' \'/images/styles\'</small>');
		case "logo":
			return (__('Logo type', 'default').'<br /><small>'.__('Default: ','default').__('Show as text', 'default').'</small>');
		case "labelmenu":
			return (__('Label of the first menu item', 'default').'<br /><small>'.__('Default: ','default').__('Home', 'default').'</small>');
		case "feed":
			return (__('Subscribe to Feed visibility', 'default').'<br /><small>'.__('Default: ','default').__('Show', 'default').'</small>');
		case "head":
			return ('<h4>'.__('Header', 'default').'</h4>');
		case "bg":
			return ('<h4>'.__('Background', 'default').'</h4>');
		case "menu":
			return ('<h4>'.__('Menu', 'default').'</h4>');
		default:
			return('Eing?');
	}
}

$themename = "dfBlog";
$shortname = "dfblog";
$dir = get_bloginfo ( 'template_directory' );

$options = array (
	array(
		"name" => "head",
		"type" => "separator"
	),
	array(
		"name" => "header",
		"id" => $shortname."_hd_style",
		"type" => "select",
		"std" => "default",
		"options" => df_get_stylelist("/images/styles")
	),
	array(
		"name" => "logo",
		"id" => $shortname."_logo_visibility",
		"type" => "radio",
		"std" => "off"
	),
	array(
		"name" => "bg",
		"type" => "separator"
	),
	array(
		"name" => "background",
		"id" => $shortname."_bg_style",
		"type" => "select",
		"std" => "default",
		"options" => df_get_stylelist("/images/styles")
	),
	array(
		"name" => "menu",
		"type" => "separator"
	),
	array(  "name" => "labelmenu",
			"id" => $shortname."_home_label",
			"type" => "text",
			"std" => __('Home', 'default')
			),
	array(
		"name" => "feed",
		"id" => $shortname."_feed_visibility",
		"type" => "radio",
		"std" => "on"
	)
);

foreach ($options as $value) {
    if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); } }
    
    
function mytheme_add_admin() {

  global $themename, $shortname, $options;

  if ( $_GET['page'] == basename(__FILE__) ) {
    if ( 'save' == $_REQUEST['action'] ) {
      foreach ($options as $value) {
        update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
      foreach ($options as $value) {
        if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }
      wp_redirect("themes.php?page=functions.php&saved=true");
      die;
    } else if( 'reset' == $_REQUEST['action'] ) {
      foreach ($options as $value) {
          delete_option( $value['id'] ); }
      header("Location: themes.php?page=functions.php&reset=true");
      die;
    }
  }
  add_theme_page($themename." Options", __('Theme Options', 'default'), 'edit_themes', basename(__FILE__), 'mytheme_admin');
}

function mytheme_admin() {

  global $themename, $shortname, $options;

  if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' '.__('settings saved', 'default').'.</strong></p></div>';
  if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' '.__('settings reset', 'default').'.</strong></p></div>'; 
?>
<div class="wrap">
<h2><?php echo $themename; ?> <?php _e('settings', 'default'); ?></h2>

<form method="post">
	<p class="submit">
		<input name="reset" type="submit" value="<?php _e('Reset', 'default'); ?>" />
		<input type="hidden" name="action" value="reset" />
	</p>
</form>

<form method="post">

<table class="optiontable" cellspacing="12px">

<?php foreach ($options as $value) { 
    
	if ($value['type'] == "text") { ?>
        
	<tr valign="top"> 
	  <td align="right"><?php echo df_get_admintextlabel($value['name']); ?></td>
	  <td>
	      <input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_option( $value['id'] ) != "") { echo get_option( $value['id'] ); } else { echo $value['std']; } ?>" />
	  </td>
	</tr>

	<?php } elseif ($value['type'] == "select") { ?>

	<tr valign="top"> 
	  <td align="right"><?php echo df_get_admintextlabel($value['name']); ?></td>
	  <td>
			<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
			    <?php foreach ($value['options'] as $key => $val) { ?>
			    <option value="<?php echo $val; ?>"<?php if (get_option ( $value['id'] )) {if ( get_option( $value['id'] ) == $val) { echo ' selected="selected"'; }} elseif ($val == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $key; ?></option>
			    <?php } ?>
			</select>
	  </td>
	</tr>

	<?php } elseif ($value['type'] == "textarea") { ?>

	<tr valign="top">
		<td align="right"><?php echo df_get_admintextlabel($value['name']); ?></td>
		<td>
			<textarea cols="100" rows="10" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
				<?php if ( get_option( $value['id'] ) != "") { echo get_option( $value['id'] ); } else { echo $value['std']; } ?>
			</textarea>
		</td>
	</tr>

	<?php } elseif ( $value['type'] == "radio" ) {
	
		if($value['name'] == "logo") { ?>

	<tr valign="top">
		<td align="right"><?php echo df_get_admintextlabel($value['name']); ?></td>
		<td>
			<label>
				<input  name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="radio" value="on"<?php if ( get_option( $value['id'] ) == "on") { echo " checked"; } ?> />
					<?php _e('Show as image', 'default'); ?>
			</label>
			<br />
			<label>
				<input  name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="radio" value="off"<?php if ( get_option( $value['id'] ) == "off") { echo " checked"; } ?> />
					<?php _e('Show as text', 'default'); ?>
			</label>
		</td>
	</tr>

		<?php } elseif($value['name'] == "feed") { ?>

	<tr valign="top">
		<td align="right"><?php echo df_get_admintextlabel($value['name']); ?></td>
		<td>
			<label>
				<input  name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="radio" value="on"<?php if ( get_option( $value['id'] ) == "on") { echo " checked"; } ?> />
					<?php _e('Show', 'default'); ?>
				</label>
			<br />
			<label>
				<input  name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="radio" value="off"<?php if ( get_option( $value['id'] ) == "off") { echo " checked"; } ?> />
					<?php _e('Hide', 'default'); ?>
				</label>
		</td>
	</tr>

		<?php } ?>


	<?php } elseif ( $value['type'] == "separator" ) { ?>

	<tr valign="top">
		<td align="left" colspan="2"><?php echo df_get_admintextlabel($value['name']); ?><hr /></td>
	</tr>

	<?php } ?>

<?php } ?>

		<td colspan="2" align="right">
			<p class="submit">
				<input name="save" type="submit" value="<?php _e('Save changes', 'default'); ?>" />
				<input type="hidden" name="action" value="save" />
			</p>
		</td>
	</tr>

</table>

</form>

<?php
}

add_action('admin_menu', 'mytheme_add_admin'); 

/* Language path...
***************************************************************************** */
function theme_init(){
	load_theme_textdomain('default', get_template_directory().'/languages');
}
add_action ('init', 'theme_init');



/*
*  df_get_postmetadata()
*
*  Escribe tipo de metadatos de un post incluidos en $meta, entre etiquetas
*  $label con la clase $meta[i].
*
*  array $meta      - "date", "author", "comment", "category", "tag", "edit"
*  str   $label     - "div", "span", "ul"
*  str   $before    - <TAG ... >
*  str   $after     - </TAG>
*
*  return - null
*/
function df_get_postmetadata( $meta, $label ) {

	echo( $before );
	if( $label == "ul" ) {
		$label = "li";
		echo("<ul>");
	}

	foreach( $meta as $key => $value ) {
		switch( $value ) {
	
			case "date":
				echo( "<".$label." class='".$value."'>" );
				printf( __("Posted in %s", "default"), get_the_time(get_option('date_format'))." &not; ".get_the_time(get_option('time_format'))."h." );
				echo( "</".$label.">" );
				break;
	
			case "author":
				echo( "<".$label." class='".$value."'>" );
				the_author();
				echo( "</".$label.">" );
				break;
	
			case "comment":
				comments_popup_link(
							"<".$label." class='".$value."'>".__('No Comments &#187;')."</".$label.">", 
							"<".$label." class='".$value."'>".__('1 Comment &#187;')."</".$label.">", 
							"<".$label." class='".$value."'>".__('% Comments &#187;')."</".$label.">"
							);
				break;
	
			case "category":
				echo( "<".$label." class='".$value."'>" );
				the_category(', ');
				echo( "</".$label.">" );
				break;
	
			case "tag":
				the_tags( "<".$label." class='".$value."'>", ", ", "</".$label.">" );
				break;
	
			case "edit":
				edit_post_link( __('Edit'), "<".$label." class='".$value."'>", "</".$label.">" );
				break;
	
			default:
				_e( '-Post metadata unknown-', 'default' );
		}
	}

	if( $label == "li" ) {
		echo("</ul>");
	}
	echo( $after );
}

/*
*  df_pagenavigator() based on Plugin Name: WP-PageNavi
*  Plugin URI: http://lesterchan.net/portfolio/programming/php/
*  Description: Adds a more advanced paging navigation to your WordPress blog.
*  Version: 2.40
*  Author: Lester 'GaMerZ' Chan
*  Author URI: http://lesterchan.net
*
*  Genera un navegador de páginas.
*
*  return - null
*/
function df_pagenavigator($before = '', $after = '') {

	global $wpdb, $wp_query;

	if (!is_single()) {
		$request = $wp_query->request;
		$posts_per_page = intval(get_query_var('posts_per_page'));
		$paged = intval(get_query_var('paged'));

		$numposts = $wp_query->found_posts;
		$max_page = $wp_query->max_num_pages;

		if(empty($paged) || $paged == 0) {
			$paged = 1;
		}
		$pages_to_show = 5;
		$pages_to_show_minus_1 = $pages_to_show-1;
		$half_page_start = floor($pages_to_show_minus_1/2);
		$half_page_end = ceil($pages_to_show_minus_1/2);
		$start_page = $paged - $half_page_start;
		if($start_page <= 0) {
			$start_page = 1;
		}
		$end_page = $paged + $half_page_end;
		if(($end_page - $start_page) != $pages_to_show_minus_1) {
			$end_page = $start_page + $pages_to_show_minus_1;
		}
		if($end_page > $max_page) {
			$start_page = $max_page - $pages_to_show_minus_1;
			$end_page = $max_page;
		}
		if($start_page <= 0) {
			$start_page = 1;
		}
		if($max_page > 1) {
			$pages_text = str_replace("%CURRENT_PAGE%", number_format_i18n($paged), __('Page %CURRENT_PAGE% of %TOTAL_PAGES%','default'));
			$pages_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pages_text);

			echo( $before );

			if(!empty($pages_text)) {
				echo '<span class="pages alignright">&#8201;'.$pages_text.'&#8201;</span>';
			}
			echo '<span class="alignleft">';
			if ($start_page >= 2 && $pages_to_show < $max_page) {
				$first_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), __('First','default'));
				echo '<a class="first" href="'.clean_url(get_pagenum_link()).'" title="'.$first_page_text.'">&#8201;'.$first_page_text.'&#8201;</a>';
				echo '<span class="extend">'.__('&#8201;...&#8201;','default').'</span>';
			}
			previous_posts_link(__('&laquo; Previous','default'));
			for($i = $start_page; $i  <= $end_page; $i++) {
				if($i == $paged) {
					$current_page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), '%PAGE_NUMBER%');
					echo '<span class="current">&#8201;'.$current_page_text.'&#8201;</span>';
				} else {
					$page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), '%PAGE_NUMBER%');
					echo '<a class="page" href="'.clean_url(get_pagenum_link($i)).'" title="'.$page_text.'">&#8201;'.$page_text.'&#8201;</a>';
				}
			}
			next_posts_link(__('Next &raquo;','default'), $max_page);
			if ($end_page < $max_page) {
				echo '<span class="extend">'.__('&#8201;...&#8201;','default').'</span>';
				$last_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), __('Last','default'));
				echo '<a class="last" href="'.clean_url(get_pagenum_link($max_page)).'" title="'.$last_page_text.'">&#8201;'.$last_page_text.'&#8201;</a>';
			}

			echo( '</span>'.$after."\n" );

		}
	}
}
?>