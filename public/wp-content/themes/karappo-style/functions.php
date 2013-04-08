<?php
if ( function_exists('register_sidebar') )
    register_sidebar();
?>
<?php  
function theme_comments($comment, $args, $depth) {
$GLOBALS['comment'] = $comment; ?>
	<div class="comment_entry" id="ul-comment-<?php comment_ID() ?>">
		<div class="author-id-<?php echo $comment->user_id; ?>">
		<div class="avatar_photo"><?php echo get_avatar($comment,$size='42',$default='<path_to_url>'); ?></div>
		<div class="everyone_comment"><?php comment_text() ?></div>
		<div class="comment_author">
			<?php printf(__('%s'), get_comment_author_link()) ?>
			( <?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?>
			<?php edit_comment_link(__('[Edit]'),'  ','') ?> )
		</div>

		</div>		
	</div>
<?php } ?>
