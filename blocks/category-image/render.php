<?php
function render_category_image_block() {
	// Obtenez l'ID de la catégorie en cours.
	$category_id = get_queried_object_id();

	if (!$category_id) {
		return ''; // Renvoie une chaîne vide si nous ne sommes pas sur une page de catégorie.
	}

	// Obtenez l'ID de l'image en utilisant l'ID de la catégorie.
	$image_id = get_term_meta($category_id, 'category_image_id', true);

	if (!$image_id) {
		return ''; // Renvoie une chaîne vide s'il n'y a pas d'image associée.
	}

	// Obtenez l'URL de l'image.
	$image_url = wp_get_attachment_url($image_id);

	// Obtenez l'attribut "alt" de l'image.
	$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);

	if (!$image_url) {
		return ''; // Renvoie une chaîne vide s'il n'y a pas d'URL d'image valide.
	}

	// Renvoie le HTML de l'image.
	return sprintf('<div class="category-image-block"><img src="%s" alt="%s" /></div>', esc_url($image_url), esc_attr($image_alt));
}
