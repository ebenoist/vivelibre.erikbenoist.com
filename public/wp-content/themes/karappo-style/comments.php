<?php // Do not delete these lines
	if (isset($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');
	
	if ( post_password_required() ) { ?>
		<p class="nocomments">This post is password protected. Enter the password to view comments.</p> 
	<?php
		return;
	}
?>

<!-- You can start editing here. -->

<?php if ( have_comments() ) : ?>
	<div id="comment">

		<h2>comment</h2>

		<?php wp_list_comments('type=comment&callback=theme_comments'); ?>

	</div>

 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ('open' == $post->comment_status) : ?>
		<!-- If comments are open, but there are no comments. -->
		<p class="nocomments">There are no comments.</p>
	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments">Comments are closed.</p>

	<?php endif; ?>
<?php endif; ?>

<?php if ('open' == $post->comment_status) : ?>


<h2 class="printhide">Please Leave a Reply</h2>

<div id="cancel-comment-reply"> 
	<?php cancel_comment_reply_link() ?>
</div> 

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">logged in</a> to post a comment.</p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( $user_ID ) : ?>

<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Logout &raquo;</a></p>

<?php else : ?>


<div id="commentform">

	<p><input type="text" name="author" class="textform" value="<?php echo $comment_author; ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
	<label for="author">Name (required)</label></p>

	<p><input type="text" name="email" class="textform" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
	<label for="email">Mail (will not be published)</label></p>

	<p><input type="text" name="url" class="textform" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
	<label for="url">Website</label></p>

</div>

<?php endif; ?>

<!-- <p class="usetags"><?php printf(__('<strong>XHTML:</strong> You can use these tags: <code>%s</code>', 'kubrick'), allowed_tags()); ?></p> -->

<p><textarea name="comment" class="textbox" rows="10" tabindex="4"></textarea></p>

<p><input name="submit" type="submit" class="submit_btn" tabindex="5" value="submit comment" />
<?php comment_id_fields(); ?> 
</p>
<?php do_action('comment_form', $post->ID); ?>

</form>

<?php endif; // If registration required and not logged in ?>



<?php endif; // if you delete this the sky will fall on your head ?>
