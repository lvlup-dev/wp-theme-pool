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


// descriptions des catégories
function add_category_content_field() {
    wp_editor('', 'term_content', array('media_buttons' => true));
}
add_action('category_add_form_fields', 'add_category_content_field', 10, 2);

// Ajouter l'éditeur WYSIWYG à la page d'édition de catégorie
function edit_category_content_field($term) {
    $content = get_term_meta($term->term_id, 'term_content', true);
    wp_editor($content, 'term_content', array('media_buttons' => true));
}
add_action('category_edit_form_fields', 'edit_category_content_field', 10, 2);

// Sauvegarder le contenu lors de l'ajout ou de la mise à jour d'une catégorie
function save_category_content($term_id) {
    if (isset($_POST['term_content'])) {
        update_term_meta($term_id, 'term_content', $_POST['term_content']);
    }
}
add_action('create_category', 'save_category_content');
add_action('edit_category', 'save_category_content');
