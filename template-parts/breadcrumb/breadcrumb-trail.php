<?php
/**
 * Shows breadcrumb
 *
 * @package cenote
 */

// If we are front page or blog page, return.
if ( is_front_page() || is_home() ) {
	return;
}

// If file is not already loaded, loaded it now.
if ( ! function_exists( 'breadcrumb_trail' ) ) {
	include get_stylesheet_directory() . '/inc/compatibility/class-breadcrumb-trail.php';
}
?>
<nav class="lmseo-breadcrumb-wrap p-0 m-0 clearfix">
	<?php
	breadcrumb_trail( array(
		'container'   => 'div',
		'before'      => '',
		'after'       => '',
		'show_browse' => false,
	) );
	?>
</nav>
