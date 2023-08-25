<?php

function render_footer_categories_block()
{
	$categories = get_categories(array(
		'parent' => 0,
		'hide_empty' => true,
	));

	$output = '<div class="footer-categories-container">';

	foreach ($categories as $category) {
		$output .= '<div class="footer-category">';
		$output .= '<a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a>';

		$subcategories = get_categories(array(
			'parent' => $category->term_id,
			'hide_empty' => true,
		));

		if ($subcategories) {
			$output .= '<ul>';
			foreach ($subcategories as $subcategory) {
				$output .= '<li><a href="' . esc_url(get_category_link($subcategory->term_id)) . '">' . esc_html($subcategory->name) . '</a></li>';
			}
			$output .= '</ul>';
		}

		$output .= '</div>'; // .footer-category
	}

	$output .= '</div>'; // .footer-categories-container
	return $output;
}
