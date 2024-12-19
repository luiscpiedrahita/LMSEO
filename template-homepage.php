<?php
/*------------------------------
Template Name: HomePage
------------------------------*/

/*
*Removes default CSS
*/
add_action('wp_enqueue_scripts', 'lmseo_index_print_styles');
function lmseo_index_print_styles() {
	if (!is_super_admin() || !is_admin_bar_showing() || is_wp_login()) {
		wp_deregister_script('jquery');
		wp_dequeue_script('jquery');
		wp_dequeue_script('jquery-migrate');
	}

	//  Disabling CSS styles of WooCommerce blocks
	//  https://themesharbor.com/disabling-css-styles-of-woocommerce-blocks/

	wp_dequeue_script('woocommerce');
	wp_dequeue_script('wc-add-to-cart');
	wp_dequeue_script('jquery-blockui');
	wp_dequeue_script('js-cookie');
	wp_dequeue_script('wc-order-attribution');
	wp_dequeue_script('sourcebuster-js');
	wp_dequeue_script('WCPAY_ASSETS-js-extra');

	wp_dequeue_style('wc-blocks-style'); //wc-blocks-integration-css
	wp_dequeue_style('wc-blocks-integration'); //wc-blocks-integration-css
	wp_dequeue_style('woocommerce-smallscreen'); //wc-blocks-integration-css
	wp_dequeue_style('woocommerce-layout'); //wc-blocks-integration-css
	wp_dequeue_style('woocommerce-general'); //wc-blocks-integration-css
	wp_dequeue_style('woocommerce-inline'); //wc-blocks-integration-css
	wp_dequeue_style('classic-theme-styles'); //wc-blocks-integration-css
	wp_dequeue_style('wc-order-attribution');
	wp_dequeue_style('core-block-supports');
	wp_dequeue_style('core-block-supports-duotone');
	//  Disabling CSS styles of contact-form-7 blocks
	wp_dequeue_script('swv');
	wp_dequeue_script('wp-i18n');
	wp_dequeue_script('wp-hooks');
	wp_dequeue_script('contact-form-7');

	wp_dequeue_style('contact-form-7');

	//  Dequeue Gutenberg Block Library CSS Code Snippet
	//  https://smartwp.com/remove-gutenberg-css/
	wp_dequeue_style('wp-block-library'); // wp-block-library-css
	//  https://wordpress.org/support/topic/how-to-disable-inline-styling-style-idglobal-styles-inline-css/
	wp_dequeue_style('global-styles'); //  global-styles-inline-css

}
/** Add Main JS to website */
add_action('wp_enqueue_scripts', 'MainJS');
function MainJS() {
	wp_enqueue_script('index-main');
}

//disable or remove wp-embed.js from WordPress
add_action('wp_footer', 'lmseo_deregister_scripts');
function lmseo_deregister_scripts() {
	wp_deregister_script('wp-embed');
}

/*
* Force the full width layout layout on the Portfolio page 
*/
add_filter('genesis_pre_get_option_site_layout', '__genesis_return_full_width_content');

/*
*remove wrappers for header and inner
*/
remove_theme_support('genesis-structural-wraps', array('header', 'inner'));

/*
* add body class when full width slider is disable add_filter( 'body_class', 'zp_body_class' );
*/
add_filter('body_class', 'zp_body_class');
function zp_body_class($classes) {
	global $post;

	$enable = get_post_meta($post->ID, 'zp_fullwidth_slider_value', true);

	if ($enable == 'false') {
		$classes[] = 'zp_boxed_home';
	}
	return $classes;
}

// remove_action('genesis_loop', 'genesis_do_loop');
add_filter('genesis_markup_content-sidebar-wrap', '__return_null');
remove_action('genesis_sidebar', 'genesis_do_sidebar');
remove_action('genesis_content_sidebar_wrap', 'genesis_do_sidebar');
remove_action('genesis_header', 'genesis_header_markup_open', 5);
remove_action('genesis_header', 'genesis_do_header');
remove_action('genesis_header', 'genesis_header_markup_close', 15);


add_action('genesis_before_loop', 'lmseo_homepage_content');
function lmseo_homepage_content() {
	$out = '';
	require_once(get_stylesheet_directory() . '/lib/partials/homepage/featured-banner.php');
	require_once(get_stylesheet_directory() . '/lib/partials/homepage/catalog.php');
	// require_once(get_stylesheet_directory() . '/lib/partials/homepage/tap-titles.php');
	require_once(get_stylesheet_directory() . '/lib/partials/homepage/projects.php');
	require_once(get_stylesheet_directory() . '/lib/partials/homepage/social.php');
	require_once(get_stylesheet_directory() . '/lib/partials/homepage/recent-posts.php');
	require_once(get_stylesheet_directory() . '/lib/partials/homepage/services.php');
	require_once(get_stylesheet_directory() . '/lib/partials/homepage/about.php');
	require_once(get_stylesheet_directory() . '/lib/partials/homepage/contact.php');
	echo $out;
}
remove_action('genesis_entry_header', 'genesis_do_post_title');
genesis();
