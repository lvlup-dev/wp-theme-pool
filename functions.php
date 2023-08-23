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

function enqueue_font_awesome() {
    $version = "6.4.2";
    wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/fontawesome-free-'.$version.'-web/css/all.min.css', array(), $version );
}
add_action( 'wp_enqueue_scripts', 'enqueue_font_awesome' );

function register_my_theme_menus() {
    register_nav_menus(
        array(
            'primary' => __( 'Primary Menu', 'textdomain' ),
        )
    );
}
add_action( 'after_setup_theme', 'register_my_theme_menus' );
