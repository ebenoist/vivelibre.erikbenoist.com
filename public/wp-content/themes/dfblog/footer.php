				</div><!-- end #container -->
<div class="clear">&nbsp;</div>
			</div><!-- end #wrap -->

			<div id="bottom">
				<div id="footer">
					<p class="alignleft"><?php _e('Powered by ' ); ?><a href="http://wordpress.org/">WordPress</a> &not; <a class="resalted" href="http://www.danielfajardo.com/dfblog/">dfBlog</a> Theme (Version <?php echo( THEMEVERSION ); ?>) design by <a href="http://www.danielfajardo.com" target="_blank" title="danielfajardo diseño">danielfajardo web</a><br /><?php printf(__('%d processes generated in %s seconds.', 'default'), get_num_queries(), timer_stop(0,3)); ?></p>
					<span id="gototop" class="alignright"><a href="#page" title="<?php _e('GoTo top', 'default'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icons/gototop.png" border="0"></a></span>
				</div>
			</div>

		</div><!-- end #wrapper -->
	</div><!-- end #page -->
	<?php wp_footer(); ?>

</body>
</html>
