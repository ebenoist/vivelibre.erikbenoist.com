<?php get_header(); ?>

		<div id="main">

<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>

		<div class="entry">
			<h2 class="entrytitle"><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
			<div class="date">posted by <?php the_author_posts_link(); ?> on <?php the_time('Y.m.d'); ?>, under <?php the_category(', '); ?></div>
			<div class="dateonly"><?php the_time('d'); ?>:</div>
			<!-- <div class="dateonly"><?php the_time('jS'); ?>:</div> 21th 2nd -->
			<!-- <div class="dateonly"><?php the_time('dS'); ?>:</div> 21th 02nd -->
			<?php the_content('<p class="continue">continue reading...</p>'); ?>
			<div class="entry_footer">{ <a href="<?php comments_link('file', display); ?>"><?php comments_number('no comment', '1 comment', '% comments'); ?></a> } :|  { Tags: <?php the_tags('', ', ', ''); ?> }</div>
		
		<!-- comment -->
		<div id="comment">
			<?php if (function_exists('wp_list_comments')): ?>
			<!-- WP 2.7 and above -->
			<?php comments_template('', true); ?>
			
			<?php else : ?>
			<!-- WP 2.6 and below -->
			<?php comments_template(); ?>
			<?php endif; ?>
		</div> <!-- Closes Comment -->

		<div id="extrastuff">
			<?php if (pings_open()): ?>
			<p>TrackBack <abbr title="Universal Resource Locator">URL</abbr> :<br />
			<input type="text" name="trackback_url" size="60" value="<?php trackback_url() ?>" readonly="readonly" class="trackback-url" onfocus="this.select()" /></p>
			<?php endif; ?>
		</div>

		<div class="cleared"></div>

</div>	
	

		
<?php endwhile; ?>


<?php else : ?>
	<h2>Not Found</h2>
	<p>Sorry, but you are looking for something that isn't here.</p>
<?php endif; ?>

		<p class="topagetop"><a href="#top"><img src="<?php bloginfo('template_url'); ?>/images/pagetop.jpg" width="80" height="20" alt="pagetop" /></a></p>
		</div><!-- /main -->


<?php get_sidebar(); ?>
<?php get_footer(); ?>

