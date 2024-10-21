<?php

/**
 *  ENQUEUE MODERNIZR (http://modernizr.com/) TO HELP WITH OLDER BROWSER SUPPORT.
 */
//add_action( 'wp_enqueue_scripts', 'load_modernizr' );
//  function load_modernizr() {
//		wp_register_script( 'modernizr', 'http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js', array(), '2.6.2', false );
//		wp_enqueue_script( 'modernizr' );
//}

/**
 * HTML5 DOCTYPE
 */
remove_action('genesis_doctype', 'genesis_do_doctype');
add_action('genesis_doctype', 'html5_do_doctype');
function html5_do_doctype()
{
?>
	<!DOCTYPE html>
	<html <?php language_attributes(); ?>>

	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
	<?php
}



/**
 * HTML5 SUB NAVIGATION
 */
function html5_sub_nav($sub_nav_out, $sub_nav)
{
	$sub_nav_out = sprintf('<nav id="subnav">%2$s%1$s%3$s</nav>', $sub_nav, genesis_structural_wrap('subnav', 'open', 0), genesis_structural_wrap('subnav', 'close', 0));
	return $sub_nav_out;
}
add_filter('genesis_do_subnav', 'html5_sub_nav', 10, 2);
/**
 * Content
 */


/**
 * HTML5 OPEN FOOTER
 */

//remove_action( 'genesis_footer', 'genesis_do_footer' );
//add_action( 'genesis_footer', 'html5_footer' );
/*function html5_footer() {
		//echo '<footer id="footer">';
		require_once ( get_stylesheet_directory() . '/lib/partials/footer.php' );
		echo $footer;
		//genesis_structural_wrap( 'footer', 'open' );

		//genesis_structural_wrap( 'footer', 'close' );
		//echo '</footer><!-- end #footer -->';
}*/
remove_action('genesis_footer', 'genesis_footer_markup_open', 5);
add_action('genesis_footer', 'html5_open_footer', 5);
function html5_open_footer()
{
	echo '<footer id="footer" class="footer dark-bg">';
	require_once(get_stylesheet_directory() . '/lib/partials/homepage/footer.php');
	echo $footer;
	echo '<div class="container-fluid">';
	//genesis_structural_wrap( 'footer', 'open' );
}
add_theme_support('genesis-footer-widgets', 3);
remove_action('genesis_before_footer', 'genesis_footer_widget_areas');
add_action('genesis_footer', 'genesis_footer_widget_areas');
//* Customize the credits
add_filter('genesis_pre_get_option_footer_text', 'sp_footer_creds_text');
function sp_footer_creds_text()
{
	echo '';
}
// add_filter('genesis_footer_backtotop_text', 'sp_footer_backtotop_text');
// function sp_footer_backtotop_text($backtotop)
// {
// 	$backtotop = '[footer_backtotop text="Return to Top"]';
// 	return $backtotop;
// }
/**
 * HTML5 CLOSE FOOTER
 */
remove_action('genesis_footer', 'genesis_footer_markup_close', 15);
add_action('genesis_footer', 'html5_close_footer', 15);
function html5_close_footer()
{
	echo '</div>';
	//genesis_structural_wrap( 'footer', 'close' );
	echo '</footer><!-- end #footer -->' . "\n";
}

/*add_theme_support( 'genesis-footer-widgets', 3 );
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );
add_action( 'genesis_after_footer', 'genesis_footer_widget_areas' );
add_action( 'genesis_after_footer', 'foundation_js_files' );*/
//add_action( 'genesis_after_footer', 'foundation_js_files' );
function foundation_js_files()
{
	echo '<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>';
}
add_filter('genesis_attr_footer-widget-area', 'lmseo_modify_widget_area_attr');
function lmseo_modify_widget_area_attr($attributes)
{
	// $attributes['itemtype'] = 'http://schema.org/CreativeWork';
	$attributes['class'] .= ' col-lg-4 px-5 d-lg-flex align-items-lg-center';
	return $attributes;
}
add_filter('genesis_attr_footer-widgets', 'lmseo_modify_attr_footer_widgets');
function lmseo_modify_attr_footer_widgets($attributes)
{
	// $attributes['itemtype'] = 'http://schema.org/CreativeWork';
	$attributes['class'] .= ' row';
	return $attributes;
}
add_filter('genesis_attr_footer-footer-widgets-3', 'lmseo_modify_widget_area_search_attr');
function lmseo_modify_widget_area_search_attr($attributes)
{
	// $attributes['itemtype'] = 'http://schema.org/CreativeWork';
	$attributes['class'] .= ' col-lg-4 d-lg-flex justify-content-lg-center align-items-lg-center';
	return $attributes;
}
	?>