<?php
function add_category_content_field()
{
    echo '<div class="form-field term-content-wrap">';
    echo '<label for="content">Description longue</label>';
    wp_editor('', 'content', array('media_buttons' => true));
    echo '</div>';
}

add_action('category_add_form_fields', 'add_category_content_field', 10, 2);

// Ajouter l'éditeur WYSIWYG à la page d'édition de catégorie
function edit_category_content_field($term)
{
    $content = get_term_meta($term->term_id, 'content', true);
    wp_editor($content, 'content', array('media_buttons' => true));
}

add_action('category_edit_form_fields', 'edit_category_content_field', 10, 2);

// Sauvegarder le contenu lors de l'ajout ou de la mise à jour d'une catégorie
function save_category_content($term_id)
{
    if (isset($_POST['content'])) {
        update_term_meta($term_id, 'content', $_POST['content']);
    }
}

add_action('create_category', 'save_category_content');
add_action('edit_category', 'save_category_content');

// Supprimer la colonne de description existante
function custom_remove_category_description_column($columns)
{
    unset($columns['description']);
    return $columns;
}

add_filter('manage_edit-category_columns', 'custom_remove_category_description_column');

// Ajouter de nouvelles colonnes pour les descriptions
function custom_add_category_columns($columns)
{
    $columns['short_description'] = 'Description Courte';
    $columns['long_description'] = 'Description Longue';
    return $columns;
}

add_filter('manage_edit-category_columns', 'custom_add_category_columns');

// Remplir les nouvelles colonnes
function custom_category_columns_content($out, $column_name, $term_id)
{
    if ($column_name == 'short_description') {
        $term = get_term($term_id, 'category');
        return wp_trim_words($term->description, 20, '...');
    }
    if ($column_name == 'long_description') {
        $long_desc = get_term_meta($term_id, 'content', true);
        return wp_trim_words($long_desc, 20, '...');
    }
    return $out;
}

add_filter('manage_category_custom_column', 'custom_category_columns_content', 10, 3);

function register_category_meta()
{
    register_meta('term', 'content', array(
        'show_in_rest' => true,
        'type' => 'string',
        'single' => true,
        'sanitize_callback' => 'wp_kses_post',
    ));
}

add_action('init', 'register_category_meta');

function save_category_content_meta($term_id)
{
    if (isset($_POST['content'])) {
        update_term_meta($term_id, 'content', sanitize_text_field($_POST['content']));
    }
}

add_action('edit_category', 'save_category_content_meta');
add_action('create_category', 'save_category_content_meta');
