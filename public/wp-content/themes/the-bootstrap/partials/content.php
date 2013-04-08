<?php
/** content.php
 *
 * The default template for displaying content
 *
 * @author		Konstantin Obenland
 * @package		The Bootstrap
 * @since		1.0.0 - 05.02.2012
 */

?>
<article id="post-<?php the_ID(); ?>">
<p class="muted">	
  	<?php
		the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'the-bootstrap' ) );
	?>
</p>
</article>
<!-- #post-<?php the_ID(); ?> -->

