

  <form id="search_form" method="get" name="searchbox" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div class="search_input_div">
    <input class="search_input" name="s" type="text" value="<?php echo wp_specialchars($s, 1); ?>" />
    </div>
    
    <input class="search_button" name="submit" type="button" value="search" />
    
  </form>
  

