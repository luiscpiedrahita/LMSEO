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
    // wp_dequeue_style('wc-blocks-style'); //wc-blocks-integration-css
    // wp_dequeue_style('wc-blocks-integration'); //wc-blocks-integration-css
    wp_dequeue_style('woocommerce-smallscreen'); //wc-blocks-integration-css
    wp_dequeue_style('woocommerce-layout'); //wc-blocks-integration-css
    wp_dequeue_style('woocommerce-general'); //wc-blocks-integration-css
    wp_dequeue_style('woocommerce-inline'); //wc-blocks-integration-css
    wp_dequeue_style('classic-theme-styles'); //wc-blocks-integration-css
    //  Dequeue Gutenberg Block Library CSS Code Snippet
    //  https://smartwp.com/remove-gutenberg-css/
    // wp_dequeue_style('wp-block-library'); // wp-block-library-css
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
    wp_register_script('pages-js', get_stylesheet_directory_uri('bootstrap') . '/dist/internal/blog/js/app.js', array(), '1.0', true);
    wp_enqueue_script('pages-js');
}
/** Add Services JS to website */
add_action('wp_enqueue_scripts', 'ServicesCSS_services_definition');
function ServicesCSS_services_definition() {
    wp_register_style('pages-css', get_stylesheet_directory_uri() . '/dist/internal/blog/style.css', array(), '1.0', 'all');
    wp_enqueue_style('pages-css');
}
add_filter('genesis_attr_content', 'contentClassesFunction_services_definition');

remove_action('genesis_before_content', 'custom_breadcrumbs', 10);
add_action('genesis_after_header', 'custom_breadcrumbs_services', 10);

function custom_breadcrumbs_services() {
    get_template_part('template-parts/breadcrumb/breadcrumb-trail', 'trail');
}

function contentClassesFunction_services_definition($attributes) {
    $attributes['class'] = $attributes['class'] . ' ' . 'container g-0 overflow-hidden py-5';
    return $attributes;
}
add_filter('genesis_attr_entry', 'entryClassesFunctionPages');

function entryClassesFunctionPages($attributes) {
    $attributes['class'] = $attributes['class'] . ' ' . 'row';
    return $attributes;
}

add_filter('genesis_attr_entry-footer', 'entryFooterFunctionBlogs');

function entryFooterFunctionBlogs($attributes) {
    $attributes['class'] = $attributes['class'] . ' ' . 'container py-5';
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
    $attributes['class'] = $attributes['class'] . ' ' . '';
    return $attributes;
}

add_filter('genesis_attr_entry-content', 'entryContentClassesFunction');
function entryContentClassesFunction($attributes) {
    $attributes['class'] = $attributes['class'] . ' ' . 'col-lg-12';
    return $attributes;
}
//    genesis();
get_header();
// echo '<nav class="lmseo-breadcrumb-wrap px-5"><div class="container-fluid g-0 clearfix"><div class="">';
// if (function_exists('yoast_breadcrumb')) {
//     yoast_breadcrumb('<ul class="lmseo-breadcrumb float-end m-0 p-0" itemscope itemtype="https://schema.org/BreadcrumbList">', '</ul>');
// }
// echo '</div></div></nav>';
?>


<main id="main" class="main" role="main">

    <?php
    // Start the loop.
    while (have_posts()) : the_post();

        /*
                 * Include the post format-specific template for the content. If you want to
                 * use this in a child theme, then include a file called called content-___.php
                 * (where ___ is the post format) and that will be used instead.
                 */
        get_template_part('template-parts/content-single-blog', get_post_format());

        $postNavArray = array();
        $postNavArray['next_text'] =  '<span class="post-title">%title</span>';
        $postNavArray['next_text'] .= '<span class="meta-nav" aria-hidden="true">';
        $postNavArray['next_text'] .= __('Next →', 'twentyfifteen');
        $postNavArray['next_text'] .= '</span> ';



        $postNavArray['prev_text'] =  '<span class="meta-nav" aria-hidden="true">';
        $postNavArray['prev_text'] .=  __('← Previous', 'twentyfifteen');
        $postNavArray['prev_text'] .=  '</span> ';
        $postNavArray['prev_text'] .=  '<span class="post-title">%title </span>';

        $postNavArray['class'] = 'row';
    ?>
        <section class="post-navigation container py-5">
            <div class="row">
                <?php
                $prev_post = get_previous_post();
                $next_post = get_next_post();
                if (! empty($prev_post)):
                ?>
                    <a href="<?php echo get_permalink($prev_post->ID); ?>" class="prev-post offset-lg-1 col-lg-4 my-5 text-middle">
                        <span class="prev-post-arrow">
                            <svg width="60" height="60" class="arrow arrow-left">
                                <path d="M 20 10 L 30 0 L 60 30 L 30 60 L 20 50 L 40 30 L 20 10"></path>
                            </svg>
                        </span>
                        <span class="prev-post-image">
                            <?php
                            echo get_the_post_thumbnail($prev_post, [400, 400]);
                            ?>
                        </span>
                        <span class="prev-post-title hvr-underline-from-right pb-1">
                            <span class="next-post-title-item">
                                <?php echo apply_filters('the_title', $prev_post->post_title); ?>
                            </span>
                        </span>
                    </a>
                <?php endif;
                if (! empty($next_post)):
                ?>
                    <a href="<?php echo get_permalink($next_post->ID); ?>" class="next-post offset-lg-2 col-lg-4 my-5 text-middle clipped">

                        <span class="next-post-image">
                            <?php
                            echo get_the_post_thumbnail($next_post, [400, 400]);
                            ?>
                        </span>
                        <span class="next-post-arrow">
                            <svg width="60" height="60" class="arrow arrow-right">
                                <path d="M 20 10 L 30 0 L 60 30 L 30 60 L 20 50 L 40 30 L 20 10"></path>
                            </svg>
                        </span>
                        <span class="next-post-title  hvr-underline-from-left pb-1">
                            <span class="next-post-title-item">
                                <?php
                                echo apply_filters('the_title', $next_post->post_title); ?>
                            </span>
                        </span>
                    </a>
                <?php endif;
                // Previous/next post navigation.
                //                    the_post_navigation( $postNavArray );
                // If comments are open or we have at least one comment, load up the comment template.
                ?>
            </div>
        </section>
        <?php
        if (comments_open() || get_comments_number()) : ?>
            <div class="dark-bg py-5">
                <div class="container">
                    <div class="row">
                        <?php comments_template(); ?>
                    </div>
                </div>
            </div>
    <?php
        endif;
    // End the loop.
    endwhile;
    ?>

</main><!-- .site-main -->

<?php
get_footer(); ?>