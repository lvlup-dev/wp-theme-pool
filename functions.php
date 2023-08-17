<?php

// styles
function enqueue_theme_styles()
{
    wp_enqueue_style('theme-styles', get_template_directory_uri() . '/style.css', [], '1.0.0');
}

add_action('wp_enqueue_scripts', 'enqueue_theme_styles');

require "inc/blocks.php";
require "inc/category/image.php";
require "inc/category/descriptions.php";
