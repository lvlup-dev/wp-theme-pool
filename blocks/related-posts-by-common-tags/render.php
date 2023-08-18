<?php

function render_related_posts_by_common_tags_block($attributes)
{
	global $post;

	// Obtenir l'ID du post actuel
	$current_post_id = $post->ID;
	$current_post_tags = wp_get_post_terms($current_post_id, 'post_tag', array("fields" => "ids"));
	$current_post_categories = wp_get_post_terms($current_post_id, 'category', array("fields" => "all"));

	$related_posts_ids = array();
	$related_output = "";

	if (!empty($current_post_tags)) {
		$args = array(
			'post__not_in' => array($current_post_id),
			'posts_per_page' => 8,
			'orderby' => 'rand',
			'tax_query' => array(
				array(
					'taxonomy' => 'post_tag',
					'terms' => $current_post_tags
				)
			)
		);

		$related_posts_query = new WP_Query($args);

		if ($related_posts_query->have_posts()) {
			while ($related_posts_query->have_posts()) {
				$related_posts_query->the_post();
				$related_posts_ids[] = get_the_ID();
				$thumbnail = get_the_post_thumbnail(null, 'thumbnail');
				$related_output .= "<li><a href='" . get_the_permalink() . "'>{$thumbnail}" . get_the_title() . "</a></li>";
			}
		}
		wp_reset_postdata();
	}

	// Si moins de 8 articles sont trouvés, complétez avec les articles récents de la sous-catégorie
	if (count($related_posts_ids) < 8) {
		$posts_to_fetch = 8 - count($related_posts_ids);

		$args = array(
			'post__not_in' => array_merge(array($current_post_id), $related_posts_ids),
			'posts_per_page' => $posts_to_fetch,
			'orderby' => 'date',
			'order' => 'DESC',
			'category__in' => array_map(function ($cat) {
				return $cat->term_id;
			}, $current_post_categories)
		);

		$recent_posts_query = new WP_Query($args);

		if ($recent_posts_query->have_posts()) {
			while ($recent_posts_query->have_posts()) {
				$recent_posts_query->the_post();
				$related_posts_ids[] = get_the_ID();
				$thumbnail = get_the_post_thumbnail(null, 'thumbnail');
				$related_output .= "<li><a href='" . get_the_permalink() . "'>{$thumbnail}" . get_the_title() . "</a></li>";
			}
			wp_reset_postdata();
		}
	}

	// Si toujours moins de 8 articles, complétez avec les articles de la catégorie parente
	if (count($related_posts_ids) < 8 && !empty($current_post_categories[0]->parent)) {
		$posts_to_fetch = 8 - count($related_posts_ids);

		$args = array(
			'post__not_in' => array_merge(array($current_post_id), $related_posts_ids),
			'posts_per_page' => $posts_to_fetch,
			'orderby' => 'date',
			'order' => 'DESC',
			'category__in' => array($current_post_categories[0]->parent)
		);

		$parent_category_posts_query = new WP_Query($args);

		if ($parent_category_posts_query->have_posts()) {
			while ($parent_category_posts_query->have_posts()) {
				$parent_category_posts_query->the_post();
				$related_posts_ids[] = get_the_ID();
				$thumbnail = get_the_post_thumbnail(null, 'thumbnail');
				$related_output .= "<li><a href='" . get_the_permalink() . "'>{$thumbnail}" . get_the_title() . "</a></li>";
			}
			wp_reset_postdata();
		}
	}

	// Si toujours moins de 8 articles, complétez avec les articles les plus récents
	if (count($related_posts_ids) < 8) {
		$posts_to_fetch = 8 - count($related_posts_ids);

		$args = array(
			'post__not_in' => array_merge(array($current_post_id), $related_posts_ids),
			'posts_per_page' => $posts_to_fetch,
			'orderby' => 'date',
			'order' => 'DESC',
		);

		$parent_category_posts_query = new WP_Query($args);

		if ($parent_category_posts_query->have_posts()) {
			while ($parent_category_posts_query->have_posts()) {
				$parent_category_posts_query->the_post();
				$thumbnail = get_the_post_thumbnail(null, 'thumbnail');
				$related_output .= "<li><a href='" . get_the_permalink() . "'>{$thumbnail}" . get_the_title() . "</a></li>";
			}
			wp_reset_postdata();
		}
	}

	return "<ul class='related-posts-block'>{$related_output}</ul>";
}
