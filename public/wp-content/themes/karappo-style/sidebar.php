		<!-- /side -->
		<div id="side">
			<!-- sidebar -->
			<div id="sidebar">
			<h2>Categories</h2>
				<ul>
					<?php wp_list_categories('show_count=0&title_li='); ?>
				</ul>
			<h2>Blog Archives</h2>
				<ul>
					<?php wp_get_archives('type=monthly&show_post_count='); ?>
				</ul>
			<h2>Blogroll</h2>
				<ul>
					<?php wp_list_bookmarks('title_li=&categorize=0'); ?>
				</ul>
			</div><!-- /sidebar -->
			<!-- sidebar for widget -->
			<div id="widgetbar">
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(1) ) : ?>  
				<?php endif; ?>  
			</div><!-- /sidebar for widget -->
		</div><!-- /side -->




		<div class="clear"><hr /></div><!-- /clearfix -->
