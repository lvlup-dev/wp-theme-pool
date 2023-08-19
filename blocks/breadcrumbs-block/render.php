<?php
function render_breadcrumbs_block($attributes)
{
	$items = [];

	$items[] = [
		'title' => 'Home',
		'url' => esc_url(home_url('/')),
	];

	if (is_category()) {
		$current_category = get_queried_object();

		if ($current_category->parent) {
			$parent_category = get_category($current_category->parent);
			$items[] = [
				'title' => $parent_category->name,
				'url' => esc_url(get_category_link($parent_category->term_id)),
			];
		}

		$items[] = [
			'title' => $current_category->name,
			'url' => esc_url(get_category_link($current_category->term_id)),
		];

	} elseif (is_single()) {
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

		$items[] = [
			'title' => get_the_title(),
			'url' => esc_url(get_permalink()),
		];
	}

	$render = '<ul id="breadcrumbs" itemscope itemtype="https://schema.org/BreadcrumbList">';
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
