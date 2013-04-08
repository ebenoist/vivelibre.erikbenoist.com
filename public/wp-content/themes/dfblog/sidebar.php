<div id="sidebar">
	<ul>

		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) { ?>

		<li>
			<h2><?php _e('calendar', 'default'); ?></h2>
			<?php get_calendar(); ?>
		</li>

		<?php wp_list_categories('show_count=1&title_li=<h2>' . __('categories', 'default'). '</h2>'); ?>

		<li>
			<h2><?php _e('tag cloud', 'default'); ?></h2>
			<?php wp_tag_cloud('smallest=8&largest=18'); ?>
		</li>

		<li>
			<h2><?php _e('meta', 'default'); ?></h2>
			<ul>
				<?php wp_register(); ?>
				<li><?php wp_loginout(); ?></li>
				<li><a href="http://validator.w3.org/check/referer" title="<?php _e('This page validates as XHTML 1.0 Transitional', 'simple'); ?>"><?php _e('Valid <abbr title="eXtensible HyperText Markup Language">XHTML</abbr>', 'simple'); ?></a></li>
				<li><a href="http://gmpg.org/xfn/"><abbr title="<?php _e('XHTML Friends Network', 'simple'); ?>"><?php _e('XFN', 'simple'); ?></abbr></a></li>
				<li><a href="http://wordpress.org/" title="<?php _e('Powered by WordPress, state-of-the-art semantic personal publishing platform.', 'simple'); ?>">WordPress</a></li>
				<?php wp_meta(); ?>
			</ul>
		</li>

		<?php } ?>
	</ul>
</div>

