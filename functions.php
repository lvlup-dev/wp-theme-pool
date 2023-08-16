<?php

require get_template_directory() . '/blocks/subcategories-block/render.php';
require get_template_directory() . '/blocks/breadcrumbs-block/render.php';

function register_custom_blocks()
{
    register_block_type('lvlup-dev/subcategories-block', array(
        'editor_script' => 'file:./blocks/subcategories-block/build/index.js', // Fichier JS de l'éditeur
        'editor_style' => 'file:./blocks/subcategories-block/build/index.css', // Fichier CSS de l'éditeur
        'style' => 'file:./blocks/subcategories-block/build/style.css', // Fichier CSS du front-end
        'render_callback' => 'render_subcategories_block',
    ));

    register_block_type('lvlup-dev/breadcrumbs-block', array(
        'editor_script' => 'file:./blocks/breadcrumbs-block/build/index.js', // Fichier JS de l'éditeur
        'editor_style' => 'file:./blocks/breadcrumbs-block/build/index.css', // Fichier CSS de l'éditeur
        'style' => 'file:./blocks/breadcrumbs-block/build/style.css', // Fichier CSS du front-end
        'render_callback' => 'render_breadcrumbs_block',
    ));
}

add_action('init', 'register_custom_blocks');
