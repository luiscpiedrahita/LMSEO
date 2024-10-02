<?php

/**
 * This file adds the Landing template to the Streamline Child Theme.
 *
 * @author StudioPress
 * @package Generate
 * @subpackage Customizations
 */
/*
Template Name: Services
*/
remove_action('genesis_before_content', 'custom_breadcrumbs', 10);
add_action('genesis_before_content', 'custom_breadcrumbs_services', 10);
function custom_breadcrumbs_services()
{
    get_template_part('template-parts/breadcrumb/breadcrumb-trail', 'trail');

    //     if(is_home() or is_front_page()){
    //     }else {
    //         echo '<nav class="lmseo-breadcrumb-wrap px-5"><div class="container-fluid g-0">';
    // //        if(function_exists('bcn_display_list')){
    // //            bcn_display_list();
    // //        }
    // //        if (function_exists('yoast_breadcrumb')) {
    // //            yoast_breadcrumb('<ul class="lmseo-breadcrumb float-end m-0" itemscope itemtype="https://schema.org/BreadcrumbList">', '</ul><div class="breadcrumbs-bg-shape-wrap float-end"><span class="bc-shape1"></span><span class="bc-shape2"></span><span class="bc-shape3"></span><span class="bc-shape4"></span></div>');
    // //        }
    //         if (function_exists('yoast_breadcrumb')) {
    //             yoast_breadcrumb('<ul class="lmseo-breadcrumb float-end m-0 p-0" itemscope itemtype="https://schema.org/BreadcrumbList">', '</ul>');
    //         }
    //         echo '</div></nav>';
    //     }
}

/** Add page image above breadcrumbs */
//add_action( 'genesis_before_content', 'streamline_post_image', 1);
function streamline_post_image()
{

    //	if ( is_page() ) return;

    //    if ( $image = genesis_get_image( 'format=url&size=post-image' ) ) {
    if ($image = genesis_get_image(array('size' => 'post-image'))) {
        echo ($image);
        //        printf( '<a href="%s" rel="bookmark"><img class="post-photo" src="%s" alt="%s" height="%s" width="%s"/></a>', get_permalink(), $image, the_title_attribute( 'echo=0' ) );

    }
}
// Add custom body class to the head
add_filter('body_class', 'streamline_add_body_class');
function streamline_add_body_class($classes)
{
    $classes[] = 'services-category';
    return $classes;
}

// Remove header, navigation, breadcrumbs, footer widgets, footer
//add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
//remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
//remove_action( 'genesis_header', 'genesis_do_header' );
//remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );
//remove_action( 'genesis_after_header', 'genesis_do_nav' );
//remove_action( 'genesis_after_header', 'genesis_do_subnav', 15 );
//remove_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_breadcrumbs');
//remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );
//remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
//remove_action( 'genesis_footer', 'genesis_do_footer' );
//remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );
//disable or remove wp-embed.js from WordPress
add_action('wp_footer', 'lmseo_deregister_scripts');
function lmseo_deregister_scripts()
{
    wp_deregister_script('wp-embed');
}

add_action('wp_enqueue_scripts', 'lmseo_index_print_styles');
function lmseo_index_print_styles()
{
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
add_action('wp_enqueue_scripts', 'ServicesJS');
function ServicesJS()
{
    wp_register_script('internal-services', get_stylesheet_directory_uri('bootstrap') . '/dist/internal/services/js/app.js', array(), '1.0', true);
    wp_enqueue_script('internal-services');
}
/** Add Services JS to website */
add_action('wp_enqueue_scripts', 'ServicesCSS');
function ServicesCSS()
{
    wp_register_style('services-css', get_stylesheet_directory_uri() . '/dist/internal/services/style.css', array(), '1.0', 'all');
    wp_enqueue_style('services-css');
}
/*
*remove wrappers for header and inner
*/
add_filter('genesis_markup_content-sidebar-wrap', '__return_null');

//add_filter( 'genesis_markup_content', '__return_null' );
//add_action( 'genesis_before_content', 'lmseoMainContentWrapper' );
//function lmseoMainContentWrapper(){
//    genesis_markup(
//        [
//            'open'    => '<main %s>',
//            'context' => 'container',
//        ]
//    );
//}
//add_action( 'genesis_after_content', 'lmseoAfterMainContentWrapper' );
//function lmseoAfterMainContentWrapper(){
//    genesis_markup(
//        [
//            'close'   => '</main>', // End .content.
//            'context' => 'container',
//        ]
//    );
//}
add_filter('genesis_attr_content', 'contentClassesFunction');

function contentClassesFunction($attributes)
{
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
function entryClassesFunction($attributes)
{
    $attributes['class'] = $attributes['class'] . ' ' . ' text-grid m-0';
    return $attributes;
}


remove_action('genesis_entry_header', 'genesis_do_post_title');
add_action('genesis_entry_header', 'lmseo_do_post_title');
function lmseo_do_post_title()
{
    require_once(get_stylesheet_directory() . '/lib/partials/svg/ecommerce.php');

    $title = apply_filters('genesis_post_title_text', get_the_title());
    $wrap = 'h1';
    $wrap = apply_filters('genesis_entry_title_wrap', $wrap);
    $output = genesis_markup(
        [
            'open'    => "<{$wrap} %s>",
            'close'   => "</{$wrap}>",
            'content' => $title,
            'context' => 'entry-title',
            'params'  => [
                'wrap' => $wrap,
            ],
            'atts' => [
                'class' => 'entry-title col-lg-8 m-0 px-3 p-lg-0',
                'data-aos' => "fade-right",
                'data-aos-delay' => "300",
            ],
            'echo'    => false,
        ]
    );
    genesis_markup(
        [
            'open'    => "<h4 %s>",
            'close'   => "</h4>",
            'content' => 'SERVICES',
            'context' => 'services-title',
            'atts' => [
                'class' => 'services-title m-0 px-3 p-lg-0',
                'data-aos' => "fade-right",
                'data-aos-delay' => "0",
            ],
            'echo'    => true,
        ]
    );
    genesis_markup(
        [
            'open'    => "<h5 %s>",
            'close'   => "</h5>",
            'content' => 'LMSEO',
            'context' => 'header-brand',
            'atts' => [
                'class' => 'header-brand m-0 p-0',
                'data-aos' => "fade-left",
                'data-aos-delay' => "0",
            ],
            'echo'    => true,
        ]
    );
    //    genesis_markup(
    //        [
    //            'open'    => "<div %s>",
    //            'close'   => "</div>",
    //            'content' => $ecommerce,
    //            'context' => 'ecommerce-icon',
    //            'atts' => [
    //                'class' => 'ecommerce-icon m-0 p-0',
    //                'data-aos' => "fade-right",
    //                'data-aos-delay' => "0",
    //            ],
    //            'echo'    => true,
    //        ]
    //    );
    //    p-0 p-sm-5 p-lg-0
    //    echo '<h4 class="services-title m-0 p-0">SERVICES</h4>';
    echo apply_filters('genesis_post_title_output', $output, $wrap, $title) . "\n";
}

add_filter(
    'wp_calculate_image_sizes',
    function ($sizes) {
        // $sizes = '(max-width: 960px) 50vw, 430px'; // Also just an example.
        // $sizes = '(max-width: 960px) 50vw, 430px'; // Also just an example.
        $sizes = "(max-width: 320px) 50vw, (max-width: 576px) 50vw, (max-width: 768px) 40vw, (max-width: 992px) 40vw, (max-width: 1200px) 40vw, (max-width: 1400px) 40vw, 100vw";
        // $sizes = "(min-width: 1200px) 740px, (min-width: 768px) 700px, calc(100vw - 36px)";

        return $sizes;
    }
);


remove_action('genesis_entry_content', 'genesis_do_post_content');
add_action('genesis_entry_content', 'lmseo_do_post_content');
function lmseo_do_post_content()
{
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
