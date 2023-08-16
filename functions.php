<?php

// styles
function enqueue_theme_styles()
{
    wp_enqueue_style('theme-styles', get_template_directory_uri() . '/style.css', [], '1.0.0');
}

add_action('wp_enqueue_scripts', 'enqueue_theme_styles');


// blocks
require get_template_directory() . '/blocks/subcategories-block/render.php';
require get_template_directory() . '/blocks/breadcrumbs-block/render.php';
require get_template_directory() . '/blocks/categories-long-desc-block/render.php';

function register_custom_blocks()
{
    $blocks = [
        'subcategories-block' => 'render_subcategories_block',
        'breadcrumbs-block' => 'render_breadcrumbs_block',
        'categories-long-desc-block' => 'render_categories_long_desc_block',
    ];

    foreach ($blocks as $block_name => $block_render_callback) {
        register_block_type_from_metadata(__DIR__ . '/blocks/' . $block_name . '/build', [
            'render_callback' => $block_render_callback
        ]);
    }
}

add_action('init', 'register_custom_blocks');


// descriptions des catégories
function add_category_content_field()
{
    echo '<div class="form-field term-content-wrap">';
    echo '<label for="term_content">Description longue</label>';
    wp_editor('', 'term_content', array('media_buttons' => true));
    echo '</div>';
}

add_action('category_add_form_fields', 'add_category_content_field', 10, 2);

// Ajouter l'éditeur WYSIWYG à la page d'édition de catégorie
function edit_category_content_field($term)
{
    $content = get_term_meta($term->term_id, 'term_content', true);
    wp_editor($content, 'term_content', array('media_buttons' => true));
}

add_action('category_edit_form_fields', 'edit_category_content_field', 10, 2);

// Sauvegarder le contenu lors de l'ajout ou de la mise à jour d'une catégorie
function save_category_content($term_id)
{
    if (isset($_POST['term_content'])) {
        update_term_meta($term_id, 'term_content', $_POST['term_content']);
    }
}

add_action('create_category', 'save_category_content');
add_action('edit_category', 'save_category_content');

function category_image_meta()
{
    ?>
    <div class="form-field">
        <label for="category_image"><?php _e('Image à la une', 'text-domain'); ?></label>
        <input type="hidden" id="category_image" name="category_image" class="custom_media_url" value="">
        <div id="category_image_wrapper"></div>
        <p>
            <input type="button" class="button button-secondary custom_media_button" id="custom_media_button"
                   name="custom_media_button" value="<?php _e('Ajouter une image', 'text-domain'); ?>"/>
            <input type="button" class="button button-secondary custom_media_remove" id="custom_media_remove"
                   name="custom_media_remove" value="<?php _e('Supprimer l\'image', 'text-domain'); ?>"/>
        </p>
    </div>
    <?php
}

add_action('category_add_form_fields', 'category_image_meta');

function edit_category_image_meta($term)
{
    $image_id = get_term_meta($term->term_id, 'category_image_id', true);
    $image_url = wp_get_attachment_url($image_id);
    ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="category_image"><?php _e('Image à la une', 'text-domain'); ?></label>
        </th>
        <td>
            <input type="hidden" id="category_image" name="category_image" value="<?php echo $image_id; ?>">
            <div id="category_image_wrapper">
                <?php if ($image_url) { ?>
                    <img src="<?php echo $image_url; ?>" style="max-width:100%;"/>
                <?php } ?>
            </div>
            <p>
                <input type="button" class="button button-secondary custom_media_button" id="custom_media_button"
                       name="custom_media_button" value="<?php _e('Ajouter une image', 'text-domain'); ?>"/>
                <input type="button" class="button button-secondary custom_media_remove" id="custom_media_remove"
                       name="custom_media_remove" value="<?php _e('Supprimer l\'image', 'text-domain'); ?>"/>
            </p>
        </td>
    </tr>
    <?php
}

add_action('category_edit_form_fields', 'edit_category_image_meta');

function category_image_scripts($hook)
{
    if ($hook == 'edit-tags.php' || $hook == 'term.php') {
        wp_enqueue_media();
        wp_enqueue_script('category-image-script', get_template_directory_uri() . '/js/category-image.js', array('jquery'));
    }
}

add_action('admin_enqueue_scripts', 'category_image_scripts');


/***********************************
 * categories - description longue *
 ***********************************/

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
        $long_desc = get_term_meta($term_id, 'term_content', true);
        return wp_trim_words($long_desc, 20, '...');
    }
    return $out;
}

add_filter('manage_category_custom_column', 'custom_category_columns_content', 10, 3);
