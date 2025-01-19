<?php

/**
 * This file adds the Landing template to the Helios Child Theme.
 *
 * @author LMSEO
 * @package Generate
 * @subpackage Customizations
 */
/*
Template Name: Services -- Hosting
*/
remove_action('genesis_before_content', 'custom_breadcrumbs', 10);
add_action('genesis_before_content', 'custom_breadcrumbs_services', 10);
function custom_breadcrumbs_services() {
    get_template_part('template-parts/breadcrumb/breadcrumb-trail', 'trail');
}
// Add custom body class to the head
add_filter('body_class', 'streamline_add_body_class');
function streamline_add_body_class($classes) {
    $classes[] = 'services-category';
    return $classes;
}

// Remove header, navigation, breadcrumbs, footer widgets, footer
add_filter('genesis_pre_get_option_site_layout', '__genesis_return_full_width_content');

//disable or remove wp-embed.js from WordPress
add_action('wp_footer', 'lmseo_deregister_scripts');
function lmseo_deregister_scripts() {
    wp_deregister_script('wp-embed');
    wp_dequeue_style('wc-blocks-style'); //wc-blocks-integration-css

}

add_action('wp_enqueue_scripts', 'lmseo_index_print_styles');
function lmseo_index_print_styles() {
    wp_dequeue_style('contact-form-7'); //contact-form-integration-css
    wp_dequeue_style('wpdiscuz-frontend-minimal-css'); //wpdiscuz-integration-css
    wp_dequeue_style('wpdiscuz-fa'); //wpdiscuz-integration-css
    wp_dequeue_style('wpdiscuz-combo-css'); //wpdiscuz-integration-css
    wp_dequeue_style('wp-fonts-local'); //wc-blocks-integration-css

    //  Disabling CSS styles of WooCommerce blocks
    //  https://themesharbor.com/disabling-css-styles-of-woocommerce-blocks/
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
add_action('wp_enqueue_scripts', 'ServicesJS');
function ServicesJS() {
    wp_register_script('internal-services', get_stylesheet_directory_uri('bootstrap') . '/dist/internal/services/hosting/js/app.js', array(), '1.0', true);
    wp_enqueue_script('internal-services');
}
/** Add Services JS to website */
add_action('wp_enqueue_scripts', 'ServicesCSS');
function ServicesCSS() {
    wp_register_style('services-css', get_stylesheet_directory_uri() . '/dist/internal/services/hosting/style.css', array(), '1.0', 'all');
    wp_enqueue_style('services-css');
}
/*
*remove wrappers for header and inner
*/
add_filter('genesis_markup_content-sidebar-wrap', '__return_null');

add_filter('genesis_attr_content', 'contentClassesFunction');
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
add_filter('genesis_attr_entry-header', 'entryClassesFunction');
function entryClassesFunction($attributes) {
    $attributes['class'] = $attributes['class'] . ' ' . ' text-grid m-0 p-0';
    return $attributes;
}


remove_action('genesis_entry_header', 'genesis_do_post_title');
add_action('genesis_entry_header', 'lmseo_do_post_title');
function lmseo_do_post_title() {

    require_once(get_stylesheet_directory() . '/lib/partials/svg/ecommerce.php');

    $title = apply_filters('genesis_post_title_text', get_the_title());
    $wrap = 'h1';
    $wrap = apply_filters('genesis_entry_title_wrap', $wrap);
    $output .= genesis_markup(
        [
            'open'    => "<{$wrap} %s>",
            'close'   => "</{$wrap}>",
            'content' => "<strong>" . $title . "</strong>",
            'context' => 'entry-title',
            'params'  => [
                'wrap' => $wrap,
            ],
            'atts' => [
                'class' => 'entry-title col-lg-8 m-0 px-3 p-lg-0 fade-right',
            ],
            'echo'    => false,
        ]
    );
    $output .= genesis_markup(
        [
            'open'    => "<h4 %s>",
            'close'   => "</h4>",
            'content' => 'HOSTING',
            'context' => 'services-title',
            'atts' => [
                'class' => 'services-title m-0 px-3 p-lg-0 fade-right',
            ],
            'echo'    => false,
        ]
    );

    genesis_markup(
        [
            'open'    => "<h5 %s>",
            'close'   => "</h5>",
            'content' => 'LMSEO',
            'context' => 'header-brand',
            'atts' => [
                'class' => 'header-brand m-0 p-0 fade-left',
            ],
            'echo'    => true,
        ]
    );
    echo apply_filters('genesis_post_title_output', $output, $wrap, $title) . "\n";
}

add_filter(
    'wp_calculate_image_sizes',
    function ($sizes) {
        $sizes = "(max-width: 320px) 50vw, (max-width: 576px) 50vw, (max-width: 768px) 40vw, (max-width: 992px) 40vw, (max-width: 1200px) 40vw, (max-width: 1400px) 40vw, 100vw";
        return $sizes;
    }
);

add_action('genesis_before_entry_content', 'lmseo_do_post_content');
function lmseo_do_post_content() {
    genesis_markup(
        [
            'open' => '<section %s>',
            'content' => '',
            'context' => 'services-content',
            'atts' => genesis_parse_attr('services-content', ['class' => 'services-content']),
        ]
    );
}

remove_action('genesis_entry_content', 'genesis_do_post_content');
add_action('genesis_entry_content', 'lmseo_before_post_content');
function lmseo_before_post_content() {
    genesis_do_post_content();
}

remove_action('genesis_after_entry_content', 'genesis_do_post_content');
add_action('genesis_after_entry_content', 'lmseo_after_post_content');
function lmseo_after_post_content() {
    genesis_markup(
        [
            'content' => '',
            'close' => '</section>',
            'context' => 'services-content',
        ]
    );
}
genesis();
