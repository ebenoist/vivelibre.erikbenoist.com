<?php get_header(); ?>

<div id="left-wrapper">
<div id="content">

<?php if (have_posts()) : ?>
  <?php while (have_posts()) : the_post(); ?>

    <div class="post_meta">
    
      <div class="date">
        <?php the_time('j F Y'); ?>
      </div>
    
      <h2>
        <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">
          <?php the_title(); ?>
        </a>
      </h2>
           
    </div>

    <div class="post_content">
      <?php the_content('Read more...'); ?>
    </div>
    
    <div class="comments_link">
	  	<?php if (function_exists('the_tags')): ?>
			<span class="tags"><?php if (get_the_tags()) the_tags(); ?></span>
		<?php endif; ?>

      <a href="<?php comments_link(); ?>">
        <?php comments_number('NO COMMENTS', '1 COMMENT', '% COMMENTS'); ?>
      </a>
    </div>
    <div class="comments_line"></div>


  <?php endwhile; ?> 
  
    <div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
		</div>
    
  <?php else: ?>
    
    <div class="error">
      We are sorry, but you are looking for something that is not here.
    </div>
    
<?php endif; ?>


</div> <!-- end content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
