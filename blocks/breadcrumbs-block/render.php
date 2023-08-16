<?php

function render_breadcrumbs_block($attributes)
{
	// Début des "breadcrumbs"
	$breadcrumbs = '<div class="breadcrumbs">Breadcrumbs :';

	// Home
	$breadcrumbs .= '<a href="' . esc_url(home_url('/')) . '">Home</a>';

	// Catégorie & Sous-catégorie
	if (is_single() || is_category()) {
		$categories = get_the_category();
		if (!empty($categories)) {
			$breadcrumbs .= ' &raquo; <a href="' . esc_url(get_category_link($categories[0]->term_id)) . '">' . esc_html($categories[0]->name) . '</a>';

			if ($categories[0]->parent) {
				$parent_category = get_category($categories[0]->parent);
				$breadcrumbs .= ' &raquo; <a href="' . esc_url(get_category_link($parent_category->term_id)) . '">' . esc_html($parent_category->name) . '</a>';
			}
		}
	}

	// Titre de l'article si on est sur un post
	if (is_single()) {
		$breadcrumbs .= ' &raquo; ' . esc_html(get_the_title());
	}

	// Fermeture des "breadcrumbs"
	$breadcrumbs .= '</div>';

	return $breadcrumbs;
}
