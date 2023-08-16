<?php

// register custom blocks
function enqueue_custom_block_assets() {
    register_block_type_from_metadata( __DIR__ . '/blocks/subcategories-block/build' );
//    register_block_type_from_metadata( __DIR__ . '/blocks/breadcrumbs-block/build' );
}
add_action( 'init', 'enqueue_custom_block_assets' );

//require get_template_directory() . '/blocks/subcategories-block/render.php';
//require get_template_directory() . '/blocks/breadcrumbs-block/render.php';
