<?php get_header(); ?>
<div class="row">
					<div class="span4">
						<?php
					  		$pages = get_pages('exclude=16'); 
					  		foreach ( $pages as $page ) {
								$option = '<li><a href=' . get_page_link( $page->ID ) . ">";
								$option .= $page->post_title;
								$option .= "</a></li>";
						  		echo $option;
					  		}
					 	?>				
					</div>
				</div>
			</header>
			<div class="row">
				<div class="span4">
				<?php
					if ( have_posts() ) {
					  while ( have_posts() ) {
						the_post();
						get_template_part( '/partials/content', get_post_format() );
					  }
					}
					else {
					  get_template_part( '/partials/content', 'not-found' );
					}
				?>
				</div>
				<div class="span5">
					<div class="span1" style="margin-left:-20px">
						<img src= "<?php echo get_bloginfo('template_url') ?>/images/skinny_left_bracket.png">
					</div>
					<div class="span3" style="margin-left:-20px;width:380px;padding-right:10px">
					<ul>
						 <?php
        					$lastposts = get_posts('numberposts=10');
        					foreach($lastposts as $post) {
        						setup_postdata($post);
        						echo "<p><li><a href=";
        						the_permalink();
        						echo ">";
        						the_title();
        						the_excerpt();
        						echo "</a></li></p>";
        					}
        				?>
					</ul>
					</div>											
					<div class="span1 offset4" style="margin-left:-20px">
						<img src= "<?php echo get_bloginfo('template_url') ?>/images/skinny_right_bracket.png">
					</div>
				</div>
			</div>
		</div>
		<?php get_footer(); ?>
	</div><!-- /container -->

  

	</body>
</html>
