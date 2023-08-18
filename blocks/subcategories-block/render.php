<?php

function render_subcategories_block($attributes)
{
	// Obtenir l'objet actuellement consulté
	$current_obj = get_queried_object();

	// Initialiser la variable $parent_id
	$parent_id = 0;
	$term_id = 0;

	if ('category' === $current_obj->taxonomy) {
		// Si nous sommes sur une page de catégorie, utilisez l'ID de la catégorie
		$term_id = $current_obj->term_id;
		$parent_id = $current_obj->parent;
	} elseif ('post' === $current_obj->post_type) {
		// Si nous sommes sur une page de post, obtenez la première catégorie
		$categories = get_the_category($current_obj->ID);
		if (!empty($categories)) {
			$term_id = $categories[0]->term_id;
			$parent_id = $categories[0]->parent;
		}
	} else {
		// Si nous ne sommes ni sur une page de catégorie, ni sur un post, retournez une chaîne vide
		return '';
	}

	// Essayez d'abord de récupérer les sous-catégories
	$child_categories = get_terms(array(
		'taxonomy' => 'category',
		'parent' => $term_id,
		'hide_empty' => false,
	));

	// Si la catégorie actuelle a des sous-catégories, affichez-les
	if (!empty($child_categories)) {
		$sibling_categories = $child_categories;
	} else {
		// Sinon, récupérez les catégories "soeurs"
		$sibling_categories = get_terms(array(
			'taxonomy' => 'category',
			'parent' => $parent_id,
			'hide_empty' => false,
		));
	}

	// Si aucune catégorie n'est trouvée, retournez une chaîne vide
	if (empty($sibling_categories)) {
		return '';
	}

	// Construire le rendu
	$render = '<ul class="subcategories-block">';
	foreach ($sibling_categories as $category) {
		$image_id = get_term_meta($category->term_id, 'category_image_id', true);
		$image_url = $image_id ? wp_get_attachment_image_url($image_id, 'medium') : '';
		$render .= '<li>';
		if ($image_url) {
			$render .= '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($category->name) . '">';
		}
		$render .= '<a href="' . esc_url(get_term_link($category)) . '">' . esc_html($category->name) . '</a>';
		$render .= '</li>';
	}
	$render .= '</ul>';

	return $render;
}
