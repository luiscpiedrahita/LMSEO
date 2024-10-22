<?php

/**
 * Genesis Framework.
 *
 * WARNING: This file is part of the core Genesis Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package Genesis\Templates
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/genesis/
 */

//* Template Name: Blog Index

//* The blog page loop logic is located in lib/structure/loops.php
/** Start the engine */


/** Add support for structural wraps */
add_theme_support('genesis-structural-wraps', array('subnav', 'inner', 'footer'));

/** Add new image sizes */
add_image_size('grid', 295, 100, TRUE);
add_image_size('portfolio', 300, 200, TRUE);

add_filter('body_class', 'sp_body_class');
function sp_body_class($classes) {

	$classes[] = 'blog-index-class';
	return $classes;
}

/** Reposition post info */
remove_action('genesis_before_post_content', 'genesis_post_info');
add_action('genesis_before_post_title', 'genesis_post_info');

/** Customize the post info function */
/**add_filter( 'genesis_post_info', 'post_info_filter' );
function post_info_filter2($post_info) {
	if (!is_page()) {
		$post_info = '[post_author_posts_link] [post_date]';
		return $post_info;
	}
}**/

/** Customize the post meta function */
/**add_filter( 'genesis_post_meta', 'post_meta_filter' );
function post_meta_filter2($post_meta) {
	if (!is_page()) {
		$post_meta = '[post_categories] [post_edit] [post_tags] [post_comments]';
		return $post_meta;
	}
}**/

/** Customize 'Read More' text */
/**add_filter( 'get_the_content_more_link', 'balance_read_more_link' );
add_filter( 'the_content_more_link', 'balance_read_more_link' );
function balance_read_more_link() {
	return '<a class="more-link" href="' . get_permalink() . '" rel="nofollow">' . __( 'Continue Reading' ) . '</a>';
}**/

/** Customize search button text */
add_filter('genesis_search_button_text', 'custom_search_button_text');
function custom_search_button_text($text) {
	return esc_attr('Search');
}



/** Customize breadcrumbs display */
/**add_filter( 'genesis_breadcrumb_args', 'balance_breadcrumb_args' );
function balance_breadcrumb_args( $args ) {
	$args['home'] = 'Home';
	$args['sep'] = ' ';
	$args['list_sep'] = ', '; // Genesis 1.5 and later
	$args['prefix'] = '<div class="breadcrumb"><div class="wrap">';
	$args['suffix'] = '</div></div>';
	$args['labels']['prefix'] = '<span class="home">You are here:</span>';
	return $args;
}**/

/** Add support for 3-column footer widgets */
//add_theme_support( 'genesis-footer-widgets', 3 );
//remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );
//add_action( 'genesis_after_footer', 'genesis_footer_widget_areas' );

/** Register widget areas */
genesis_register_sidebar(array(
	'id'				=> 'home-featured-left',
	'name'			=> __('Home Featured Left', 'balance'),
	'description'	=> __('This is the featured left area on the homepage.', 'balance'),
));

genesis_register_sidebar(array(
	'id'				=> 'home-featured-right',
	'name'			=> __('Home Featured Right', 'balance'),
	'description'	=> __('This is the featured right area on the homepage.', 'balance'),
));

genesis_register_sidebar(array(
	'id'				=> 'portfolio',
	'name'			=> __('Portfolio', 'balance'),
	'description'	=> __('This is the portfolio page.', 'balance'),
));

//remove_action( 'genesis_loop', 'genesis_do_loop' );
//add_action( 'genesis_loop', 'child_grid_loop_helper' );
/** Add support for Genesis Grid Loop **/
/**function child_grid_loop_helper() {

	genesis_grid_loop( array(
		'features' => 2,
		'feature_image_size' => 'child_full',
		'feature_image_class' => 'aligncenter post-image',
		'feature_content_limit' => 0,
		'grid_image_size' => 0,
		'grid_content_limit' => 0,
		'more' => __( '[Continue reading...]', 'genesis' ),
		'posts_per_page' => 10,
	) );

}*/
genesis();
