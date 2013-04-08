
<div id="sidebar">
<ul>
     
	 <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('left_menu') ) : ?>
   
   <li>
				<?php include (TEMPLATEPATH . "/searchform.php"); ?>
	 </li>
      	
	 <li>
      <h2><span class="sidebar-h2">Archive</span></h2>
			<ul>
				<?php wp_get_archives('type=monthly'); ?>
			</ul>
	 </li>
	 
	 
	 <?php if (function_exists('wp_list_categories')) 
              wp_list_categories("show_count=0&title_li=<h2><span class='sidebar-h2'>Categories</span></h2>");
    
    elseif (!function_exists('wp_list_categories'))
             { echo ('<li><h2><span class="sidebar-h2">Categories</span></h2><ul>');
              wp_list_cats();
              echo ('</ul></li>'); }; ?>   	
	 
	 <li>    
	     
	       <?php if (function_exists('wp_list_bookmarks')) 
	                 {
                    wp_list_bookmarks('title_li=Blogroll&categorize=1&title_before=<h2><span class="sidebar-h2">&title_after=</span></h2>&category_before=&category_after=');
                    }
                    
                elseif (!function_exists('wp_list_bookmarks'))
                  { echo ('<h2><span class="sidebar-h2">Blogroll</span></h2>');
                    echo ('<ul>');
                    get_links('-1', '<li>', '</li>', '<br />', FALSE, 'id', FALSE, FALSE, -1, TRUE, TRUE);
                    echo ('</ul>');
                    }; 
                ?>
           
	 </li>
	 
	 <li>
	   <h2><span class="sidebar-h2">Meta</span></h2>
	   <ul>
	     <li><?php wp_loginout(); ?></li>
	     <li><a href="http://validator.w3.org/check?uri=referer">Valid XHTML</a></li>
	     <li><a href="http://www.wordpress.org">Wordpress</a></li>
	   </ul>
	  </li>
	 
	 <?php endif; ?>
 
</ul>
</div> <!-- end sidebar -->
</div> <!-- end left-wrapper -->
<?php
		global $phpFlickr;
		$phpFlickr->auth_checkToken();
?>


<div id="right-wrapper">
			<div class="flickr-photos"> 

					<?php if ( isset($phpFlickr) && get_option('fg-user_id') ) : ?>
						<?php 
							$photos = $phpFlickr->people_getPublicPhotos(get_option('fg-user_id'), null, 8);
							if ( $photos === false ) {
								_e('The Flickr API has returned the following error message.', 'flickr-gallery');
								echo "<br />" . $phpFlickr->getErrorCode() . ': ' .$phpFlickr->getErrorMsg();
							} else {
								
								
								
								?>
									<!--<p><?php _e("Some of your Flickr photos should appear below.", 'flickr-gallery'); ?></p>-->
										<?php foreach ( $photos['photo'] as $photo ) : ?>
										
											
											
										<?php
											/*$sizes = $phpFlickr->photos_getSizes($photo['id']);
											$horiz = false;
											foreach ( $sizes as $size ) {
												if ( $size['label'] == 'Original' ) {
													break;
												}
											}
											
											/*echo $size['width'];
											echo $size['height'];
											if ($size['width'] > $size['height']) 
												{ 
												echo "<div class=\"flickr-gallery image none rotate\">";
											} else {
											*/
																					$photo_info  = $phpFlickr->photos_getInfo($photo['id']);

												echo "<div class=\"flickr-gallery ";
												echo $photo_info['media'];
												echo " none\">";
											//}
											
	
										//print_r($photo);
										?>
				
											<a style="border: 0px;" href="http://flickr.com/photos/<?php echo get_option('fg-user_id') ?>/<?php echo $photo['id'] ?>" onclick="javascript:_gaq.push(['_trackEvent','outbound-article','www.flickr.com']);">
											<img class="<?php if ( 'video' == $photo_info['media'] ) { echo "flickr video"; } else { echo "flickr small"; } ?>" src="<?php echo $phpFlickr->buildPhotoURL($photo, 'small') ?>"  width="200" height="200" alt="<?php echo addslashes($photo['title']) ?>" title="<?php echo addslashes($photo['title']) ?>: <?php echo addslashes($photo['description']) ?>" />	

											</a>
											</div>

										<?php endforeach; ?>
								<?php
							}
						?>
						
					
					<?php else : ?>
						<?php _e('When you enter your API key and Flickr User ID, your photos should appear here.', 'flickr-gallery') ?>
					<?php endif; ?>
				</div>
				</div>
<!-- Remove this comment to enable advertisements. -->
<!--     
    <a href="#">
      <img src="<?php bloginfo('template_directory'); ?>/images/ad.jpg" alt="ad" />
    </a>
-->    
<!-- Remove this comment to enable advertisements. -->   
</div>
 