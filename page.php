<?php

/**
 * @author LMSEO
 * @package Generate
 * @subpackage Customizations
 */

add_filter('genesis_markup_content-sidebar-wrap', '__return_null');
remove_theme_support('genesis-structural-wraps', array('header'));
//* This file handles pages, but only exists for the sake of child theme forward compatibility.
// Remove header, navigation, breadcrumbs, footer widgets, footer
add_filter('genesis_pre_get_option_site_layout', '__genesis_return_full_width_content');
remove_action('genesis_header', 'genesis_header_markup_open', 5);
remove_action('genesis_header', 'genesis_do_header');
remove_action('genesis_header', 'genesis_header_markup_close', 15);
remove_action('genesis_after_header', 'genesis_do_nav');
remove_action('genesis_after_header', 'genesis_do_subnav', 15);
remove_action('genesis_before_content_sidebar_wrap', 'genesis_do_breadcrumbs');
remove_action('genesis_before_footer', 'genesis_footer_widget_areas');

add_action('wp_enqueue_scripts', 'lmseo_index_print_styles');
function lmseo_index_print_styles() {
    global $portArchDev;

    //  Disabling CSS styles of WooCommerce blocks
    //  https://themesharbor.com/disabling-css-styles-of-woocommerce-blocks/
    wp_dequeue_style('wc-blocks-style'); //wc-blocks-integration-css
    wp_dequeue_style('wc-blocks-integration'); //wc-blocks-integration-css
    wp_dequeue_style('woocommerce-smallscreen'); //wc-blocks-integration-css
    wp_dequeue_style('woocommerce-layout'); //wc-blocks-integration-css
    wp_dequeue_style('woocommerce-general'); //wc-blocks-integration-css
    wp_dequeue_style('woocommerce-inline'); //wc-blocks-integration-css
    wp_dequeue_style('classic-theme-styles'); //wc-blocks-integration-css
    //  Dequeue Gutenberg Block Library CSS Code Snippet
    //  https://smartwp.com/remove-gutenberg-css/
    wp_dequeue_style('wp-block-library'); // wp-block-library-css
    //  https://wordpress.org/support/topic/how-to-disable-inline-styling-style-idglobal-styles-inline-css/
    wp_dequeue_style('global-styles'); //  global-styles-inline-css
    wp_dequeue_style('lmseo'); // main css
    if (!is_super_admin() || !is_admin_bar_showing() || is_wp_login()) {
        wp_deregister_script('jquery');
        wp_dequeue_script('jquery');
        wp_dequeue_script('jquery-migrate');
    }
}

/** Add Services JS to website */
add_action('wp_enqueue_scripts', 'ServicesJS_services_definition');
function ServicesJS_services_definition() {
    wp_register_script('pages-js', get_stylesheet_directory_uri('bootstrap') . '/dist/internal/pages/js/app.js', array(), '1.0', true);
    wp_enqueue_script('pages-js');
}
/** Add Services JS to website */
add_action('wp_enqueue_scripts', 'ServicesCSS_services_definition');
function ServicesCSS_services_definition() {
    wp_register_style('pages-css', get_stylesheet_directory_uri() . '/dist/internal/pages/style.css', array(), '1.0', 'all');
    wp_enqueue_style('pages-css');
}
add_filter('genesis_attr_content', 'contentClassesFunction_services_definition');

function contentClassesFunction_services_definition($attributes) {
    $attributes['class'] = $attributes['class'] . ' ' . 'container g-0 overflow-hidden py-5';
    return $attributes;
}
add_filter('genesis_attr_entry', 'entryClassesFunctionPages');

function entryClassesFunctionPages($attributes) {
    $attributes['class'] = $attributes['class'] . ' ' . 'row';
    return $attributes;
}
/**
 * Edit the "entry-content" classe's array.
 *
 *
 * filter is applied on the echoed markup.
 *
 *
 * @return 'entry-content' classes array.
 */
add_filter('genesis_attr_entry-header', 'entryClassesFunction');
function entryClassesFunction($attributes) {
    $attributes['class'] = $attributes['class'] . ' ' . 'col-lg-12';
    return $attributes;
}

add_filter('genesis_attr_entry-content', 'entryContentClassesFunction');
function entryContentClassesFunction($attributes) {
    $attributes['class'] = $attributes['class'] . ' ' . 'col-lg-12';
    return $attributes;
}

genesis();
