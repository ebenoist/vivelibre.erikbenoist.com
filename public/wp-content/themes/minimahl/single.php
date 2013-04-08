<?php get_header(); ?>

<div id="left-wrapper">
<div id="content">

<?php if (have_posts()) : ?>
  <?php while (have_posts()) : the_post(); ?>

    <div class="post_meta">
    
      <div class="date">
        <?php the_time('F j Y'); ?>
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

  	<?php if (function_exists('the_tags')): ?>
		<span class="tags posttags"><?php if (get_the_tags()) the_tags(); ?></span>
	<?php endif; ?>
    
   
    
    <?php comments_template(); // Get wp-comments.php template ?>


  <?php endwhile; else: ?> 
    
    <div class="error">
      We are sorry, but you are looking for something that is not here.
    </div>
    
<?php endif; ?>


</div> <!-- end content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
