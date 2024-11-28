<?php

/** Force the full width layout layout on the Portfolio page */
add_filter('genesis_markup_content-sidebar-wrap', '__return_null');

add_action('wp_enqueue_scripts', 'lmseo_index_main_styles');
function lmseo_index_main_styles() {
    global $portArchDev;
    wp_dequeue_style('lmseo'); // main css
}
/** Add Services JS to website */
add_action('wp_enqueue_scripts', 'blogIndexJs');
function blogIndexJs() {
    wp_register_script('blogIndex-js', get_stylesheet_directory_uri('bootstrap') . '/dist/internal/blog/index/js/app.js', array(), '1.0', true);
    wp_enqueue_script('blogIndex-js');
}
/** Add Services JS to website */
add_action('wp_enqueue_scripts', 'blogIndexCSS');
function blogIndexCSS() {
    wp_register_style('blogIndex-css', get_stylesheet_directory_uri() . '/dist/internal/blog/index/style.css', array(), '1.0', 'all');
    wp_enqueue_style('blogIndex-css');
}

//add_theme_support('genesis-footer-widgets');
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


$archive_layout = get_theme_mod('cenote_archive_style', 'tg-archive-style--masonry');
get_header();
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

?>

<main class="content container-fluid mt-5 overflow-hidden <?php echo ($paged == 1) ? 'first-page' : 'other-page' ?> page-<?php echo $paged ?>">

    <?php

    $array_defaults = array(
        'counter' => 0,
        'content' => array(),
        'columns' => array()
    );
    $wp_query = new WP_Query(
        array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => 11,
            'paged' => $paged,
        )
    );
    $sticky = get_option('sticky_posts');

    if ($wp_query->have_posts()) :
        if ('tg-archive-style--masonry' === $archive_layout) :
    ?>
            <div class="top-row row gx-4 mb-0">
            <?php
        endif;
        /* Start the Loop */
        while ($wp_query->have_posts()) :
            $wp_query->the_post();

            /*
                     * Include the Post-Format-specific template for the content.
                     * If you want to override this in a child theme, then include a file
                     * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                     */
            //                    get_template_part( 'template-parts/content', get_post_format(), $array_defaults );

            // display posts ...
            require('template-parts/content.php');


            $array_defaults['counter']++;
        endwhile;
        //                print_r($array_defaults);
        foreach ($array_defaults['columns'] as $key => $column) {
            echo $column;
        }

        if ('tg-archive-style--masonry' === $archive_layout) :
            ?>
            </div>
            <!-- /.cenote-content-masonry -->
    <?php
        endif;
        // show pagination.
        //                if ( !in_array( $wp_query->post->ID, $sticky ) ):
        // check IDs
        get_template_part('template-parts/pagination/pagination-blog', null, array(
            'query' => $wp_query
        ));
    //                endif;
    else :

        echo get_template_part('template-parts/content', null, $array_defaults);

    endif;
    wp_reset_postdata();

    ?>

</main><!-- #main -->

<?php
get_sidebar();
get_footer();
