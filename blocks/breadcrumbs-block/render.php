<?php

function render_breadcrumbs_block($attributes)
{
	$items = [];

	$items[] = [
		'title' => 'Home',
		'url' => esc_url(home_url('/')),
	];

	if (is_single() || is_category()) {
		$categories = get_the_category();
		if (!empty($categories)) {

			if ($categories[0]->parent) {
				$parent_category = get_category($categories[0]->parent);
				$items[] = [
					'title' => $parent_category->name,
					'url' => esc_url(get_category_link($parent_category->term_id)),
				];
			}

			$items[] = [
				'title' => $categories[0]->name,
				'url' => esc_url(get_category_link($categories[0]->term_id)),
			];
		}
	}

	if (is_single()) {
		$items[] = [
			'title' => get_the_title(),
			'url' => esc_url(get_permalink()),
		];
	}

	$render = '<ul class="breadcrumbs" itemscope itemtype="https://schema.org/BreadcrumbList">';
	foreach ($items as $index => $item) {
		$render .= '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
		$render .= '<a itemprop="item" href="' . $item['url'] . '">';
		$render .= '<span itemprop="name">' . $item['title'] . '</span>';
		$render .= '</a>';
		$render .= '<meta itemprop="position" content="' . ($index + 1) . '" />';
		$render .= '</li>';
	}
	$render .= '</ul>';

	return $render;
}
