<?php
if ( function_exists('register_sidebar') )
    register_sidebar(array('name'=>'left_menu',
        'before_title' => '<h2><span class="sidebar-h2">',
        'after_title' => '</span></h2>',
    ));
           
?>
