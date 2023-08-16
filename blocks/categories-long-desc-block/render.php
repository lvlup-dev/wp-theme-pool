<?php
function render_categories_long_desc_block($attributes) {
	// Obtenir l'objet de la catégorie actuellement interrogée
	$current_cat = get_queried_object();

	// Vérifiez que vous êtes sur une page de catégorie
	if (!$current_cat || 'category' !== $current_cat->taxonomy) {
		return ''; // Si ce n'est pas une catégorie, renvoyez une chaîne vide
	}

	// Récupérez la description longue à partir des métadonnées du terme
	$long_desc = get_term_meta($current_cat->term_id, 'term_content', true);

	// Si la description longue est vide, retournez une chaîne vide
	if (!$long_desc) {
		return '';
	}

	// Retournez la description longue enveloppée dans un div (ou un autre élément de votre choix)
	return '<div class="category-long-description">' . wp_kses_post($long_desc) . '</div>';
}
