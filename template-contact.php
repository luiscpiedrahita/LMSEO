<?php
/**
 * This file adds the Landing template to the Streamline Child Theme.
 *
 * @author StudioPress
 * @package Generate
 * @subpackage Customizations
 */

/*
Template Name: Contact
*/

// Add custom body class to the head
add_filter( 'body_class', 'streamline_add_body_class' );
function streamline_add_body_class( $classes ) {
    $classes[] = 'contact';
    return $classes;
}

// Remove header, navigation, breadcrumbs, footer widgets, footer
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );
remove_action( 'genesis_after_header', 'genesis_do_nav' );
remove_action( 'genesis_after_header', 'genesis_do_subnav', 15 );
remove_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_breadcrumbs');
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );
/*
*remove wrappers for header and inner
*/
add_filter( 'genesis_markup_content-sidebar-wrap', '__return_null' );
remove_theme_support('genesis-structural-wraps',array( 'header'));
//remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
//remove_action( 'genesis_footer', 'genesis_do_footer' );
//remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );
//disable or remove wp-embed.js from WordPress
add_action( 'wp_footer', 'lmseo_deregister_scripts' );
function lmseo_deregister_scripts(){
    wp_deregister_script( 'wp-embed' );
}

add_action(  'wp_enqueue_scripts', 'lmseo_index_print_styles'   );
function lmseo_index_print_styles() {
    global $portArchDev;

//  Disabling CSS styles of WooCommerce blocks
//  https://themesharbor.com/disabling-css-styles-of-woocommerce-blocks/
    wp_dequeue_style( 'wc-blocks-style' ); //wc-blocks-integration-css
    wp_dequeue_style( 'wc-blocks-integration' ); //wc-blocks-integration-css
    wp_dequeue_style( 'woocommerce-smallscreen' ); //wc-blocks-integration-css
    wp_dequeue_style( 'woocommerce-layout' ); //wc-blocks-integration-css
    wp_dequeue_style( 'woocommerce-general' ); //wc-blocks-integration-css
    wp_dequeue_style( 'woocommerce-inline' ); //wc-blocks-integration-css
    wp_dequeue_style( 'classic-theme-styles' ); //wc-blocks-integration-css
//  Dequeue Gutenberg Block Library CSS Code Snippet
//  https://smartwp.com/remove-gutenberg-css/
    wp_dequeue_style( 'wp-block-library' ); // wp-block-library-css
//  https://wordpress.org/support/topic/how-to-disable-inline-styling-style-idglobal-styles-inline-css/
    wp_dequeue_style( 'global-styles' ); //  global-styles-inline-css
    wp_dequeue_style('lmseo'); // main css
    if( !is_super_admin() || !is_admin_bar_showing() || is_wp_login()){
        wp_deregister_script('jquery');
        wp_dequeue_script('jquery');
        wp_dequeue_script('jquery-migrate');
    }
}
/** Add Services JS to website */
add_action( 'wp_enqueue_scripts','contactJS');
function contactJS(){
    wp_register_script( 'contact',get_stylesheet_directory_uri( 'bootstrap' ) . '/dist/internal/contact/js/app.js',array(), '1.0', true );
    wp_enqueue_script('contact');

}
/** Add Services JS to website */
add_action( 'wp_enqueue_scripts','contactCSS');
function contactCSS(){
    wp_register_style( 'contact-css',get_stylesheet_directory_uri( ) . '/dist/internal/contact/style.css',array(), '1.0', 'all' );
    wp_enqueue_style('contact-css');

}


add_filter('genesis_attr_content','contentClassesFunction');

function contentClassesFunction($attributes) {
    $attributes['class'] = $attributes['class'] . ' ' . 'container-fluid g-0 overflow-hidden';
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
//add_filter('genesis_attr_entry-header','entryClassesFunction');
//function entryClassesFunction($attributes) {
//    $attributes['class'] = $attributes['class'] . ' ' . ' text-grid m-0';
//    return $attributes;
//}
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
//Remove breadcrumbs
remove_action( 'genesis_before_content', 'custom_breadcrumbs', 10);

remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
add_action( 'genesis_entry_content', 'lmseo_do_post_content' );
function lmseo_do_post_content() {
//
//    $img = genesis_get_image(
//        [
//            'format'  => 'html',
//            'size'    => 'post-image',
//            'context' => 'services-image ',
//            'attr'    => genesis_parse_attr( 'services-image', ['class'=>'services-image'] ),
//        ]
//    );
//    if ( ! empty( $img ) ) {
//        genesis_markup(
//            [
//                'open' => '<div %s>',
//                'close' => '</div>',
//                'content' => $img,
//                'context' => 'services-image-wrapper',
//                'atts' => genesis_parse_attr('services-image-wrapper', ['class' => 'services-image-wrapper']),
//            ]
//        );
//    }
    genesis_do_post_content();
}

genesis();
