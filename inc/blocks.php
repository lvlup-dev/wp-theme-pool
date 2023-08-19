<?php

require get_template_directory() . '/blocks/subcategories-block/render.php';
require get_template_directory() . '/blocks/breadcrumbs-block/render.php';
require get_template_directory() . '/blocks/categories-long-desc-block/render.php';
require get_template_directory() . '/blocks/related-posts-by-common-tags/render.php';
require get_template_directory() . '/blocks/category-image/render.php';

function register_custom_blocks()
{
    $blocks = [
        'subcategories-block' => 'render_subcategories_block',
        'breadcrumbs-block' => 'render_breadcrumbs_block',
        'categories-long-desc-block' => 'render_categories_long_desc_block',
        'related-posts-by-common-tags' => 'render_related_posts_by_common_tags_block',
        'category-image' => 'render_category_image_block',
    ];

    foreach ($blocks as $block_name => $block_render_callback) {
        register_block_type_from_metadata(__DIR__ . '/../blocks/' . $block_name . '/build', [
            'render_callback' => $block_render_callback
        ]);
    }
}

add_action('init', 'register_custom_blocks');
