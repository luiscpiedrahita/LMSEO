<?php
/**
 * This file adds the Landing template to the Helios Child Theme.
 *
 * @author LMSEO
 * @package Generate
 * @subpackage Customizations
 */

/*
Template Name: Services - Definitions
*/
/** Add page image above breadcrumbs */
//add_action( 'genesis_before_content', 'streamline_post_image_services_definition', 1);
//function streamline_post_image_services_definition() {
//
////	if ( is_page() ) return;
//
////    if ( $image = genesis_get_image( 'format=url&size=post-image' ) ) {
//    if ( $image = genesis_get_image( array('size'=>'post-image') ) ) {
//        echo($image);
////        printf( '<a href="%s" rel="bookmark"><img class="post-photo" src="%s" alt="%s" height="%s" width="%s"/></a>', get_permalink(), $image, the_title_attribute( 'echo=0' ) );
//
//    }
//
//}


// Add custom body class to the head
add_filter( 'body_class', 'streamline_add_body_class_services_definition' );
function streamline_add_body_class_services_definition( $classes ) {
    $classes[] = 'services-definition';
    return $classes;
}

add_action( 'wp_footer', 'lmseo_deregister_scripts_services_definition' );
function lmseo_deregister_scripts_services_definition(){
    wp_deregister_script( 'wp-embed' );
}

add_action(  'wp_enqueue_scripts', 'lmseo_index_print_styles_services_definition'   );
function lmseo_index_print_styles_services_definition() {
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
add_action( 'wp_enqueue_scripts','ServicesJS_services_definition');
function ServicesJS_services_definition(){
    wp_register_script( 'internal-services',get_stylesheet_directory_uri( 'bootstrap' ) . '/dist/internal/services/definitions/js/app.js',array(), '1.0', true );
    wp_enqueue_script('internal-services');

}
/** Add Services JS to website */
add_action( 'wp_enqueue_scripts','ServicesCSS_services_definition');
function ServicesCSS_services_definition(){
    wp_register_style( 'services-css',get_stylesheet_directory_uri( ) . '/dist/internal/services/definitions/style.css',array(), '1.0', 'all' );
    wp_enqueue_style('services-css');

}
/*
*remove wrappers for header and inner
*/
add_filter( 'genesis_markup_content-sidebar-wrap', '__return_null' );
remove_theme_support('genesis-structural-wraps',array( 'header'));

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
remove_action( 'genesis_before_content', 'custom_breadcrumbs', 10);
add_action( 'genesis_before_content', 'custom_breadcrumbs_services', 10);
function custom_breadcrumbs_services(){
    get_template_part( 'template-parts/breadcrumb/breadcrumb-trail', 'trail' );
}

add_filter('genesis_attr_content','contentClassesFunction_services_definition');
function contentClassesFunction_services_definition($attributes) {
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
add_filter('genesis_attr_entry-header','entryClassesFunction');
function entryClassesFunction($attributes) {
    $attributes['class'] = $attributes['class'] . ' ' . '';
    return $attributes;
}


remove_action(  'genesis_entry_header', 'genesis_do_post_title' );
add_action( 'genesis_entry_header', 'lmseo_do_post_title' );
function lmseo_do_post_title(){
//   require_once ( get_stylesheet_directory() . '/lib/partials/svg/ecommerce.php');

    $title = apply_filters( 'genesis_post_title_text', get_the_title() );
    $wrap = 'h1';
    $wrap = apply_filters( 'genesis_entry_title_wrap', $wrap );
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
                'class' => 'entry-title col-lg-8 m-0 px-3 p-lg-0 text-center',
                'data-aos' => "fade-right",
            ],
            'echo'    => true,
        ]
    );
    genesis_markup(
        [
            'open'    => "<div %s>",
            'close'   => "</div>",
            'content' => get_the_excerpt(),
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
            'open'    => "<div %s>",
            'close'   => "</div>",
            'content' => '',
            'context' => 'magicbox-def-div-2',
            'atts' => [
                'class' => 'magicbox-def-div-2 m-0 p-0 p-lg-0',
                'data-aos' => "fade-down",
                'data-aos-delay' => "0",
            ],
            'echo'    => true,
        ]
    );
    genesis_markup(
        [
            'open'    => "<div %s>",
            'close'   => "</div>",
            'content' => '',
            'context' => 'magicbox-def-div-5',
            'atts' => [
                'class' => 'magicbox-def-div-5 m-0 p-0 p-lg-0',
                'data-aos' => "fade-up",
                'data-aos-offset' => "100",
            ],
            'echo'    => true,
        ]
    );
    genesis_markup(
        [
            'open'    => "<div %s>",
            'close'   => "</div>",
            'content' => '',
            'context' => 'magicbox-def-div-3',
            'atts' => [
                'class' => 'magicbox-def-div-3 m-0 p-0 p-lg-0',
                'data-aos' => "fade-up",
                'data-aos-delay' => "0",
            ],
            'echo'    => true,
        ]
    );
    genesis_markup(
        [
            'open'    => "<div %s>",
            'close'   => "</div>",
            'content' => '',
            'context' => 'magicbox-definition-divider',
            'atts' => [
                'class' => 'magicbox-definition-divider m-0 p-0 p-lg-0',
                'data-aos' => "fade-right",
                'data-aos-delay' => "0",
            ],
            'echo'    => true,
        ]
    );
    $img = genesis_get_image(
        [
            'format'  => 'html',
            'size'    => 'full',
            'context' => 'services-definition-image',
            'attr'    => genesis_parse_attr( 'services-definition-image', ['class'=>'services-definition-image'] ),
        ]
    );
    if ( ! empty( $img ) ) {
        genesis_markup(
            [
                'open' => '<div %s>',
                'close' => '</div>',
                'content' => $img,
                'context' => 'services-definition-image-wrapper',
                'atts' => genesis_parse_attr('services-definition-image-wrapper', ['class' => 'services-definition-image-wrapper', 'data-aos' => "fade-left", ]),
            ]
        );
    }
    genesis_markup(
        [
            'open'    => "<div %s>",
            'close'   => "</div>",
            'content' => '',
            'context' => 'magicbox-def-div-4',
            'atts' => [
                'class' => 'magicbox-def-div-4 m-0 p-0 p-lg-0',
                'data-aos' => "fade-down",
                'data-aos-delay' => "0",
            ],
            'echo'    => true,
        ]
    );
//    genesis_markup(
//        [
//            'open'    => "<h5 %s>",
//            'close'   => "</h5>",
//            'content' => 'LMSEO',
//            'context' => 'header-brand',
//            'atts' => [
//                'class' => 'header-brand m-0 p-0 pe-5',
//                'data-aos' => "fade-left",
//                'data-aos-delay' => "0",
//            ],
//            'echo'    => true,
//        ]
//    );
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
    echo apply_filters( 'genesis_post_title_output', $output, $wrap, $title ) . "\n";
}

//remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
//add_action( 'genesis_entry_content', 'lmseo_do_post_content' );
//function lmseo_do_post_content() {
//
//    $img = genesis_get_image(
//        [
//            'format'  => 'html',
//            'size'    => 'post-image',
//            'context' => 'services-definition-image',
//            'attr'    => genesis_parse_attr( 'services-definition-image', ['class'=>'services-definition-image'] ),
//        ]
//    );
//    if ( ! empty( $img ) ) {
//        genesis_markup(
//            [
//                'open' => '<div %s>',
//                'close' => '</div>',
//                'content' => $img,
//                'context' => 'services-definition-image-wrapper',
//                'atts' => genesis_parse_attr('services-definition-image-wrapper', ['class' => 'services-definition-image-wrapper']),
//            ]
//        );
//    }
//    genesis_do_post_content();
//}

genesis();
