<?php

function render_subcategories_block($attributes)
{
	// Obtenir la catégorie actuelle
	$current_cat = get_queried_object();

	// Vérifier si c'est bien une catégorie
	if (!$current_cat || 'category' !== $current_cat->taxonomy) {
		return '';
	}

	// Récupérer les sous-catégories
	$subcategories = get_terms(array(
		'taxonomy' => 'category',
		'parent' => $current_cat->term_id,
		'hide_empty' => false,
	));

	// Construire le rendu
	$output = '<div class="subcategories-block"><div>Sous-catégories :</div><ul>';
	foreach ($subcategories as $subcategory) {
		$output .= '<li><a href="' . esc_url(get_term_link($subcategory)) . '">' . esc_html($subcategory->name) . '</a></li>';
	}
	$output .= '</ul></div>';

	return $output;
}

// Enregistrer la fonction de rendu pour votre bloc
register_block_type('lvlup-dev/subcategories-block', array(
	'render_callback' => 'render_subcategories_block',
));
