<?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if (!empty($post->post_password)) { // if there's a password
		if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
			?>

			<p><?php _e('Enter your password to view comments.'); ?></p>

			<?php
			return;
		}
	}

	/* This variable is for alternating comment background */
	$oddcomment = 'class="alt" ';
?>


  <div class="comments_header">
    <div class="comments_header_left">
      <?php comments_number('NO COMMENTS', '1 COMMENT', '% COMMENTS'); ?>
    </div>
    
    <?php if ( comments_open() ) : ?>
    
	  <div class="comments_header_right">
      <a href="#postcomment" title="<?php _e("Leave a comment"); ?>">LEAVE A COMMENT</a>
    </div>
    <?php endif; ?>
  </div> <!-- end comments_header -->
  <div class="comments_line"></div>
  <a name="comments"></a>

<?php if ( $comments ) : ?>

  <div class="comment_list">

<?php foreach ($comments as $comment) : ?>
	
	<div class="comment_end"></div>
  <div class="comment_header">
    <div class="comment_author">
	   <?php comment_author_link() ?>
	</div>

    <div class="comment_date">  
      <?php comment_date('F j, Y') ?>
    </div>
  </div>
  <div class="comment_content">
    <img src="<?php bloginfo('template_directory'); ?>/images/comments-border.png" alt="ad" />
      
    <div class="comment_avatar">
    	  <?php
	      if (function_exists('get_avatar')) {
	      echo get_avatar($comment, 93);
	   } else {
	      //alternate gravatar code for < 2.5
	      $grav_url = "http://www.gravatar.com/avatar.php?gravatar_id=" . md5($comment->comment_author_email) . "&default=" . urlencode($default) . "&size=93";
	      echo "<img src='$grav_url' class='avatar' />";
	   }

	      ?>
    </div>
  
    <div class="comment_text">  
      <?php comment_text() ?>
	  </div>
	</div>
	
<?php endforeach; ?>

  </div> <!-- end comment_list -->
  <div class="comment_end"></div>
  
  <div class="comments_line"></div>
  

<?php else : // If there are no comments yet ?>
	
<?php endif; ?>



<?php if ( comments_open() ) : ?>



<?php if ( get_option('comment_registration') && !$user_ID ) : ?>

  <p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.'), get_option('siteurl')."/wp-login.php?redirect_to=".urlencode(get_permalink()));?></p>
  
<?php else : ?>


<fieldset id="fieldset">
<legend class="post_comment"><a name="postcomment"></a><?php _e('Post a comment'); ?></legend>
  <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( $user_ID ) : ?>

       
    <p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php if (function_exists('wp_logout_url')) echo wp_logout_url(get_permalink());
                                                                                                                                          elseif (!function_exists('wp_logout_url')) { $retezec=get_option('siteurl')."/wp-login.php?action=logout"; echo $retezec; }; ?>" title="Log out of this account">Log out &raquo;</a></p>
    
<?php else : ?>

    <p>
      <label for="author"><?php _e('Your name'); ?></label>
      <input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
   </p>

    <p>
      <label for="email"><?php _e('Your email');?></label>
      <input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
   </p>


<?php endif; ?>

    <p>
      <label for="comment"><?php _e('Your comment');?></label>
      <textarea name="comment" id="comment" cols="100%" rows="10" tabindex="3"></textarea>
    </p>

    <p>
      <input name="submit" type="submit" id="submit" tabindex="4" value="<?php if (function_exists('attribute_escape')) echo attribute_escape(__('post comment'));
                                                                               elseif  (!function_exists('attribute_escape')) echo ('post comment'); ?>" />
      <input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
    </p>
  
<?php do_action('comment_form', $post->ID); ?>

  </form>
</fieldset>

<?php endif; // If registration required and not logged in ?>

<?php else : // Comments are closed ?>
<p><?php _e('Sorry, the comment form is closed at this time.'); ?></p>
<?php endif; ?>
