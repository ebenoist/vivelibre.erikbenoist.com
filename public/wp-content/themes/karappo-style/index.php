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
		</div>

<?php endwhile; ?>

		<div class="prevnext"><?php next_posts_link('« prev'); ?> <?php previous_posts_link('next »'); ?></div>

<?php else : ?>
	<h2>Not Found</h2>
	<p>Sorry, but you are looking for something that isn't here.</p>
<?php endif; ?>

		<p class="topagetop"><a href="#top"><img src="<?php bloginfo('template_url'); ?>/images/pagetop.jpg" width="80" height="20" alt="pagetop" /></a></p>
		</div><!-- /main -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>