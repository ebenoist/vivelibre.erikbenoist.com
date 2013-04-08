<?php get_header(); ?>
			<div class="row">
				<div class="span10">
				<section>
				<article>
				<div class="hero-unit" style="background-color: #FFF">
				<?php
					if ( have_posts() ) {
					  while ( have_posts() ) {
					  	echo "<h1>";
					  	the_title();
					  	echo "</h1>";
					  	the_date();
						the_post();
						get_template_part( '/partials/content', get_post_format() );
					  }
					}
					else {
					  get_template_part( '/partials/content', 'not-found' );
					}
				?>
				</article>
				</section>
				</div>
				</div>
			</div>
		<?php get_footer(); ?>
	</div><!-- /container -->

	</body>
</html>
