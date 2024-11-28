<?php 
/*------------------------------
Template Name: HomePage
------------------------------*/ 

//during dev set to false. during Dist = true
$portArchDev = false;
//Set to true if critical local not recommended for dist
$criticalLocal = true;
//$isAsync uses loadcss asyn scritp true/false
$isAsync = false;
/*
*Inline crital CSS for first browser paint
*/
//add_action('wp_head','lmseo_index_critical_css',1);
//function lmseo_index_critical_css(){
//	$path= 'bin/css/homepage/critical/styles.min.css.php';
//	global $portArchDev;
//	if($portArchDev){
//		echo '<style>';
//		include $path;
//		echo '</style>';
//	}
//}
/*
* Loads optimized CSS at the bottom of the page Asynch priority 20 is where 
add_action( 'wp_head',             'wp_enqueue_scripts',              1     );
add_action( 'wp_footer',           'wp_print_footer_scripts',         20    );
add_action( 'wp_head',             'wp_print_styles',                  8    );
add_action( 'wp_head',             'wp_print_head_scripts',            9    );

*/
//add_action( 'wp_enqueue_scripts','lmseo_loadcss');
//function lmseo_loadcss(){
//    wp_enqueue_script('loadcss');
//    wp_enqueue_script('onloadcss');
//}
//add_action('wp_footer','lmseo_index_load_css_asynchronously',20);

/*Enque <noscript> in the header*/
/*add_action(  'wp_head', 'lmseo_index_print_styles_nojavascript'   );
function lmseo_index_print_styles_nojavascript() {
	?>
	
	<?php
}*/
/**/



//remove_action('enqueue_scripts');
/*
*Removes default CSS
*/
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
    if( !is_super_admin() || !is_admin_bar_showing() || is_wp_login()){
        wp_deregister_script('jquery');
        wp_dequeue_script('jquery');
        wp_dequeue_script('jquery-migrate');
    }
	if($portArchDev){
		/*Not in use*/
		wp_dequeue_style('lmseo');
		wp_deregister_style('lmseo');

//		wp_dequeue_style('crayon');
//		wp_dequeue_style('woocommerce-layout');
//		wp_dequeue_style('woocommerce-general');
//		wp_dequeue_style('woocommerce-smallscreen');
//		wp_deregister_style('jetpack_css');
//		wp_dequeue_style('jetpack_css');
//		wp_dequeue_script('crayon_js');
		/*Bundled*/
		if( !is_super_admin() || !is_admin_bar_showing() || is_wp_login()){
			wp_deregister_script('jquery');
			wp_dequeue_script('jquery');
			wp_dequeue_script('jquery-migrate');
		}
//		wp_dequeue_script('wc-add-to-cart');
//		wp_dequeue_script('contact-form-7');
//		wp_dequeue_style('contact-form-7');
//		wp_dequeue_script('html5shiv');
//		wp_dequeue_script('modernizr');
//		wp_deregister_script('jquery-blockui');
//		wp_dequeue_script('jquery-blockui');
//		wp_dequeue_script('wc-cart-fragments');
//		wp_dequeue_script('blueimp_helper');
//		wp_dequeue_script('blueimp');
//		wp_dequeue_script('transit');
//		wp_dequeue_script('scrollto');
//		wp_dequeue_script('foundation');
//		wp_dequeue_script('foundation_app');
//		wp_register_script( 'custom-waypoint',get_stylesheet_directory_uri(  ) . '/helios/js/custom/custom.waypoints.js',array( ), '1', true );
		//wp_deregister_script('insert_footer_js');
		//wp_dequeue_script('insert_footer_js');
		//wp_deregister_script('enqueue_scripts');
		//wp_dequeue_script('enqueue_scripts');
		
		//foreach( array( 'wp_enqueue_scripts', 'login_enqueue_scripts' ) as $a ) { add_action( $a, array($this,'enqueue_scripts'), 100 ); }


		
		//wp_enqueue_script('jquery-easing');
		//wp_enqueue_script('jquery-circularcontentcarousel');
		//wp_enqueue_script('jquery-mousewheel');
		//wp_register_style(  'home-template', get_stylesheet_directory_uri(   ).'/bin/css/homepage/style.css' , '', '1' );
		//wp_enqueue_style( 'home-template');

	}
//    wp_enqueue_script( 'bootstrap');
}
/** Add Main JS to website */
    add_action( 'wp_enqueue_scripts','MainJS');
    function MainJS(){
        /*In Use*/
        global $portArchDev;
    //    wp_enqueue_script('bootstrap');
        wp_enqueue_script('index-main');

    }
//disable or remove wp-embed.js from WordPress
    add_action( 'wp_footer', 'lmseo_deregister_scripts' );
    function lmseo_deregister_scripts(){
        wp_deregister_script( 'wp-embed' );
    }


/*
* Force the full width layout layout on the Portfolio page 
*/
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

/*
*remove wrappers for header and inner
*/
remove_theme_support('genesis-structural-wraps',array( 'header','inner'));

/*
* add body class when full width slider is disable add_filter( 'body_class', 'zp_body_class' );
*/
add_filter( 'body_class', 'zp_body_class' );
function zp_body_class( $classes ) {
global $post;
	
$enable = get_post_meta( $post->ID, 'zp_fullwidth_slider_value', true);

if( $enable == 'false' ){
	$classes[] = 'zp_boxed_home';
}
	return $classes;
}

remove_action(	'genesis_loop', 'genesis_do_loop' );
add_filter( 'genesis_markup_content-sidebar-wrap', '__return_null' );
remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
remove_action( 'genesis_loop', 'genesis_do_loop' );
remove_action( 'genesis_content_sidebar_wrap' ,'genesis_do_sidebar');

add_action( 'genesis_before_content_sidebar_wrap', 'lmseo_homepage_content' );
function lmseo_homepage_content() {
	$out ='';
	require_once ( get_stylesheet_directory() . '/lib/partials/homepage/featured-banner.php' );
	require_once ( get_stylesheet_directory() . '/lib/partials/homepage/catalog.php' );
//    require_once ( get_stylesheet_directory() . '/lib/partials/homepage/tap-titles.php' );
	require_once ( get_stylesheet_directory() . '/lib/partials/homepage/projects.php' );
	require_once ( get_stylesheet_directory() . '/lib/partials/homepage/social.php' );
	require_once ( get_stylesheet_directory() . '/lib/partials/homepage/recent-posts.php' );
	require_once ( get_stylesheet_directory() . '/lib/partials/homepage/services.php' );
	require_once ( get_stylesheet_directory() . '/lib/partials/homepage/contact.php' );
	require_once ( get_stylesheet_directory() . '/lib/partials/homepage/about.php' );
	
	//require_once ( get_stylesheet_directory() . '/lib/partials/homepage/header.php' );
	//require_once ( get_stylesheet_directory() . '/lib/partials/homepage/featured-banner.php' );
	//require_once ( get_stylesheet_directory() . '/lib/partials/homepage/tap-titles.php' );
	//require_once ( get_stylesheet_directory() . '/lib/partials/homepage/projects.php' );
	//require_once ( get_stylesheet_directory() . '/lib/partials/homepage/social.php' );
	//require_once ( get_stylesheet_directory() . '/lib/partials/homepage/recent-posts.php' );
	//require_once ( get_stylesheet_directory() . '/lib/partials/homepage/contact.php' );
	//require_once ( get_stylesheet_directory() . '/lib/partials/homepage/about.php' );
	//require_once ( get_stylesheet_directory() . '/lib/partials/homepage/footer.php' );
	echo $out;
}
genesis();
