<?php

/**
 * Script to show pagination.
 *
 * @package LMSEO
 */

global $wp_query;
$big = PHP_INT_MAX;

// if only have one page don't show pagination.
if ($wp_query->max_num_pages <= 1) {
	return;
}
// 	Copy of paginate_links core fucntion
//  @return string|string[]|void String of page links or array of page links, depending on 'type' argument.
//  Void if total number of pages is less than 2.
function paginate($args = '') {
	global $wp_query, $wp_rewrite;

	// Setting up default values based on the current URL.
	$pagenum_link = html_entity_decode(get_pagenum_link());
	$url_parts    = explode('?', $pagenum_link);

	// Get max pages and current page out of the current query, if available.
	$total   = isset($wp_query->max_num_pages) ? $wp_query->max_num_pages : 1;
	$current = get_query_var('paged') ? (int) get_query_var('paged') : 1;

	// Append the format placeholder to the base URL.
	$pagenum_link = trailingslashit($url_parts[0]) . '%_%';

	// URL base depends on permalink settings.
	$format  = $wp_rewrite->using_index_permalinks() && ! strpos($pagenum_link, 'index.php') ? 'index.php/' : '';
	$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit($wp_rewrite->pagination_base . '/%#%', 'paged') : '?paged=%#%';

	$defaults = array(
		'base'               => $pagenum_link, // http://example.com/all_posts.php%_% : %_% is replaced by format (below).
		'format'             => $format, // ?page=%#% : %#% is replaced by the page number.
		'total'              => $total,
		'current'            => $current,
		'aria_current'       => 'page',
		'show_all'           => false,
		'prev_next'          => true,
		'prev_text'          => __('&laquo; Previous'),
		'next_text'          => __('Next &raquo;'),
		'end_size'           => 1,
		'mid_size'           => 2,
		'type'               => 'plain',
		'add_args'           => array(), // Array of query args to add.
		'add_fragment'       => '',
		'before_page_number' => '',
		'after_page_number'  => '',
	);

	$args = wp_parse_args($args, $defaults);

	if (! is_array($args['add_args'])) {
		$args['add_args'] = array();
	}

	// Merge additional query vars found in the original URL into 'add_args' array.
	if (isset($url_parts[1])) {
		// Find the format argument.
		$format       = explode('?', str_replace('%_%', $args['format'], $args['base']));
		$format_query = isset($format[1]) ? $format[1] : '';
		wp_parse_str($format_query, $format_args);

		// Find the query args of the requested URL.
		wp_parse_str($url_parts[1], $url_query_args);

		// Remove the format argument from the array of query arguments, to avoid overwriting custom format.
		foreach ($format_args as $format_arg => $format_arg_value) {
			unset($url_query_args[$format_arg]);
		}

		$args['add_args'] = array_merge($args['add_args'], urlencode_deep($url_query_args));
	}

	// Who knows what else people pass in $args.
	$total = (int) $args['total'];
	if ($total < 2) {
		return;
	}
	$current  = (int) $args['current'];
	$end_size = (int) $args['end_size']; // Out of bounds? Make it the default.
	if ($end_size < 1) {
		$end_size = 1;
	}
	$mid_size = (int) $args['mid_size'];
	if ($mid_size < 0) {
		$mid_size = 2;
	}

	$add_args   = $args['add_args'];
	$r          = '';
	$page_links = array();
	$dots       = false;

	if ($args['prev_next']) :
		$link = str_replace('%_%', 2 == $current ? '' : $args['format'], $args['base']);
		$link = str_replace('%#%', $current - 1, $link);
		if ($add_args) {
			$link = add_query_arg($add_args, $link);
		}
		$link .= $args['add_fragment'];
		if ($current && 1 < $current):
			$page_links[] = sprintf(
				'<a class="prev page-numbers page-link" href="%s">%s</a>',
				/** This filter is documented in wp-includes/general-template.php */
				esc_url(apply_filters('paginate_links', $link)),
				$args['prev_text']
			);
		else:
			$page_links[] = sprintf(
				'<a class="prev page-numbers page-link disabled">%s</a>',
				/** This filter is documented in wp-includes/general-template.php */
				$args['prev_text']
			);
		endif;
	endif;

	for ($n = 1; $n <= $total; $n++) :
		if ($n == $current) :
			$page_links[] = sprintf(
				'<a class="page-link active disabled"><span aria-current="%s" class="page-numbers active current">%s</span></a>',
				esc_attr($args['aria_current']),
				$args['before_page_number'] . number_format_i18n($n) . $args['after_page_number']
			);

			$dots = true;
		else :
			if ($args['show_all'] || ($n <= $end_size || ($current && $n >= $current - $mid_size && $n <= $current + $mid_size) || $n > $total - $end_size)) :
				$link = str_replace('%_%', 1 == $n ? '' : $args['format'], $args['base']);
				$link = str_replace('%#%', $n, $link);
				if ($add_args) {
					$link = add_query_arg($add_args, $link);
				}
				$link .= $args['add_fragment'];

				$page_links[] = sprintf(
					'<a class="page-numbers page-link" href="%s">%s</a>',
					/** This filter is documented in wp-includes/general-template.php */
					esc_url(apply_filters('paginate_links', $link)),
					$args['before_page_number'] . number_format_i18n($n) . $args['after_page_number']
				);

				$dots = true;
			elseif ($dots && ! $args['show_all']) :
				$page_links[] = '<span class="page-numbers dots">' . __('&hellip;') . '</span>';

				$dots = false;
			endif;
		endif;
	endfor;

	if ($args['prev_next']) :
		$link = str_replace('%_%', $args['format'], $args['base']);
		$link = str_replace('%#%', $current + 1, $link);
		if ($add_args) {
			$link = add_query_arg($add_args, $link);
		}
		$link .= $args['add_fragment'];
		if ($current && $current < $total):
			$page_links[] = sprintf(
				'<a class="next page-numbers page-link" href="%s">%s</a>',
				/** This filter is documented in wp-includes/general-template.php */
				esc_url(apply_filters('paginate_links', $link)),
				$args['next_text']
			);
		else:
			$page_links[] = sprintf(
				'<a class="next page-numbers page-link disabled">%s</a>',
				/** This filter is documented in wp-includes/general-template.php */
				$args['next_text']
			);
		endif;
	endif;

	switch ($args['type']) {
		case 'array':
			return $page_links;

		case 'list':
			$r .= "<ul class='page-numbers pagination justify-content-center'>\n\t<li class='page-item'>";
			$r .= implode("</li>\n\t<li class='page-item'>", $page_links);
			$r .= "</li>\n</ul>\n";
			break;

		default:
			$r = implode("\n", $page_links);
			break;
	}

	/**
	 * Filters the HTML output of paginated links for archives.
	 *
	 * @since 5.7.0
	 *
	 * @param string $r    HTML output.
	 * @param array  $args An array of arguments. See paginate_links()
	 *                     for information on accepted arguments.
	 */
	$r = apply_filters('paginate_links_output', $r, $args);

	return $r;
}
function lmseo_get_paginated_noNextPrev($query) {
	// When we're on page 1, 'paged' is 0, but we're counting from 1,
	// so we're using max() to get 1 instead of 0
	$currentPage = max(1, get_query_var('paged', 1));

	// This creates an array with all available page numbers, if there
	// is only *one* page, max_num_pages will return 0, so here we also
	// use the max() function to make sure we'll always get 1
	$pages = range(1, max(1, $query->max_num_pages));

	// Now, map over $pages and return the page number, the url to that
	// page and a boolean indicating whether that number is the current page
	return array_map(function ($page) use ($currentPage) {
		return array(
			"isCurrent" => $page == $currentPage,
			"page" => $page,
			"url" => get_pagenum_link($page)
		);
	}, $pages);
}
?>
<div class="row pagination-wrapper smoky-bg">
	<nav class="navigation pt-5 pb-4">
		<span class="screen-reader-text"><?php esc_html_e('Posts Navigation', 'LMSEO'); ?></span>

		<!-- /.screen-reader-text -->
		<div class="nav-links">
			<?php
			echo paginate(
				array(
					'base'               => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
					'format'             => '?paged=%#%',
					'current'            => max(1, get_query_var('paged')),
					'total'              => $wp_query->max_num_pages,
					'before_page_number' => '<span class="screen-reader-text">' . esc_html__('Page ', 'LMSEO') . '</span>',
					'next_text'          => esc_html__('Next', 'LMSEO'),
					'prev_text'          => esc_html__('Previous', 'LMSEO'),
					'mid_size'           => 4,
					'type' 				 => 'list'
				)
			); // WPCS xss ok.
			?>
		</div>
		<!-- /.nav-links -->
	</nav>
	<!-- /.navigation pagination -->
</div>