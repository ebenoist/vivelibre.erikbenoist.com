
</div><!-- end container -->

<div id="footer">

  <ul id="menu-footer">
      <li<?php if(is_home()) {echo " class=\"page_item current_page_item\"";} else {echo " class=\"page_item\"";} ?>><a href="<?php echo get_settings('home'); ?>/">Home</a></li>
      <?php wp_list_pages('title_li='); ?>
  </ul>
  
  <p id="menu-footer-right">
      <span class="minim">minim</span><span class="ahl">ahl</span> by <a href="http://www.ahlera.com">Ahlera</a>
  </p>

</div> <!-- end footer -->
<?php wp_footer(); ?>

</body>
</html>
