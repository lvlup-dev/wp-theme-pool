<?php

function render_subcategories_block($attributes)
{
	// Obtenir l'objet actuellement consulté
	$current_obj = get_queried_object();

	// Initialiser la variable $parent_id
	$parent_id = 0;

	if ('category' === $current_obj->taxonomy) {
		// Si nous sommes sur une page de catégorie, utilisez le parent comme $parent_id
		$parent_id = $current_obj->parent;
	} elseif ('post' === $current_obj->post_type) {
		// Si nous sommes sur une page de post, obtenez la première catégorie et utilisez son parent comme $parent_id
		$categories = get_the_category($current_obj->ID);
		if (!empty($categories)) {
			$parent_id = $categories[0]->parent;
		}
	} else {
		// Si nous ne sommes ni sur une page de catégorie, ni sur un post, retournez une chaîne vide
		return '';
	}

	// Récupérer les sous-catégories ou les catégories "soeurs"
	$sibling_categories = get_terms(array(
		'taxonomy' => 'category',
		'parent' => $parent_id,
		'hide_empty' => false,
	));

	// Si aucune sous-catégorie ou catégorie "soeur" n'est trouvée, retournez une chaîne vide
	if (empty($sibling_categories)) {
		return '';
	}

	// Construire le rendu
	$output = '<div class="subcategories-block"><div>';
	$output .= $parent_id ? 'Catégories soeurs :' : 'Sous-catégories :';  // Titre conditionnel
	$output .= '</div><ul>';
	foreach ($sibling_categories as $category) {
		$output .= '<li><a href="' . esc_url(get_term_link($category)) . '">' . esc_html($category->name) . '</a></li>';
	}
	$output .= '</ul></div>';

	return $output;
}
