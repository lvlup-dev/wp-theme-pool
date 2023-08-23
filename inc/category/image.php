<?php

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

add_action('category_add_form_fields', 'category_image_meta', 20);

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

add_action('category_edit_form_fields', 'edit_category_image_meta', 20);

function category_image_scripts($hook)
{
    if ($hook == 'edit-tags.php' || $hook == 'term.php') {
        wp_enqueue_media();
        wp_enqueue_script('category-image-script', get_template_directory_uri() . '/js/category-image.js', array('jquery'));
    }
}

add_action('admin_enqueue_scripts', 'category_image_scripts');

// save
function save_category_image($term_id)
{
    if (isset($_POST['category_image'])) {
        $image_id = $_POST['category_image'];
        update_term_meta($term_id, 'category_image_id', $image_id);
    }
}

add_action('create_category', 'save_category_image');
add_action('edit_category', 'save_category_image');

function register_category_image()
{
    register_meta('term', 'category_image_id', array(
        'show_in_rest' => true,
        'type' => 'integer',
        'single' => true,
        'sanitize_callback' => 'absint',
    ));
}

add_action('init', 'register_category_image');
