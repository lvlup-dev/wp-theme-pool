<?php

function render_home_posts_by_categories_block($attributes, $content) {
	$output = '<div class="container">';

	// Récupérer toutes les catégories parentes
	$parent_categories = get_categories(array(
		'parent' => 0,
		'hide_empty' => true,
	));

	foreach ($parent_categories as $category) {
		$output .= '<div class="category-container">';

		$category_link = get_category_link($category->term_id);

		$output .= '<a href="' . esc_url($category_link) . '" class="category-header">';

		$image_id = get_term_meta($category->term_id, 'category_image_id', true);
//		if ($image_id) {
//			$image_url = wp_get_attachment_url($image_id);
//			$output .= '<div class="category-image inline-block">';
//			$output .= '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($category->name) . '">';
//			$output .= '</div>';
//		}

		$image_src_array = wp_get_attachment_image_src($image_id, 'custom-category');
		if ($image_src_array) {
			$image_url = $image_src_array[0];
			$output .= '<div class="category-image inline-block">';
			$output .= '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($category->name) . '">';
			$output .= '</div>';
		}


		// Le titre de la catégorie
		$output .= '<span class="category-title inline-block">' . esc_html($category->name) . '</span>';

		$output .= '</a>';  // Fin du lien

		$output .= '<div class="category-content">';



		// Récupérer les sous-catégories
		$subcategories = get_categories(array(
			'parent' => $category->term_id,
			'hide_empty' => true,
		));

		if ($subcategories) {
			$output .= '<ul class="posts-list">';
			foreach ($subcategories as $subcategory) {
				// Récupérer un seul post pour chaque sous-catégorie
				$posts = get_posts(array(
					'posts_per_page' => 1,
					'category' => $subcategory->term_id,
				));

				if ($posts) {
					$output .= '<li class="post-item">';
					$post = $posts[0];
					$post_thumbnail = get_the_post_thumbnail($post);
					if ($post_thumbnail) {
						$output .= $post_thumbnail;
					}

					$output .= '<a href="' . esc_url(get_permalink($post)) . '">' . esc_html($post->post_title) . '</a>';
					$output .= '</li>';
				}
			}
			$output .= '</ul>';
		}
		$output .= '</div>';  // Fin de .category-content
		$output .= '</div>';  // Fin de .category-container
	}

	$output .= '</div>';

	return $output;
}
