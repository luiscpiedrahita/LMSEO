<?php
/** Start the engine */
require_once(TEMPLATEPATH.'/lib/init.php');
require_once ( get_stylesheet_directory() . '/lib/functions/html5.php' );
/**
 * Custom template tags for this theme.
 */
require_once ( get_stylesheet_directory() .'/inc/template-tags.php');
/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require_once ( get_stylesheet_directory() . '/inc/template-functions.php');


//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );
add_post_type_support( 'page', 'excerpt' );
/*add_filter('language_attributes', 'modernizr_no_js');
function modernizr_no_js($output) {
    return $output . ' class="no-js"';
}*/

/** Branding **/
add_action('wp_head','lmseo_branding', 1);
function lmseo_branding(){
	if ( ( is_home() || is_front_page() ) && is_page() ) {
		echo '
<!--
Design + Development by                                   
LMSEO © '. date("Y")  .'                     
All Rights Reserved.               
www.lmseo.com

-->';
	}
}
/*add_action( 'genesis_meta', 'sp_viewport_meta_tag' );
function sp_viewport_meta_tag() {
	echo '<meta name="viewport" content="width=device-width, initial-scale=1"/>';
}*/
/** Child theme (do not remove) */
define( 'CHILD_THEME_NAME', 'LMSEO' );
define( 'CHILD_THEME_URL', 'http://www.lmseo.co/' );

/** Custom Post Types */
require_once(  get_stylesheet_directory(  ) . '/include/cpt/super-cpt.php'   );
require_once(  get_stylesheet_directory(  ) . '/include/cpt/zp_cpt.php'   );

/** Theme Option/Functions */
require_once (  get_stylesheet_directory(  ) . '/include/theme_settings.php'   );
require_once (  get_stylesheet_directory(  ) . '/include/theme_functions.php'   );

/**performance support*/
require_once (  get_stylesheet_directory(  ) . '/include/performance/performance.php');

/* Include Update Notice File  */
require_once(  get_stylesheet_directory(  )  .'/include/updater/theme_updater.php'   );

/** Theme Widgets */
require_once(  get_stylesheet_directory(  )  .'/include/widgets/widget-flickr.php'   );
require_once(  get_stylesheet_directory(  )  .'/include/widgets/widget-address.php'   );
//require_once(  get_stylesheet_directory(  )  .'/include/widgets/widget-social_icons.php'   );
require_once(  get_stylesheet_directory(  )  .'/include/widgets/widget-latest_portfolio.php'   );
require_once(  get_stylesheet_directory(  )  .'/include/widgets/widget-cta-after-content.php'   );
require_once(  get_stylesheet_directory(  )  .'/include/widgets/widget-lmseo-recent-comments.php'   );

/** Theme Shortcode */
require_once(  get_stylesheet_directory(  ) . '/include/shortcodes/shortcode.php'   );

/** Unregister Layout */
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-content' );
genesis_unregister_layout( 'content-sidebar' );


/** Unregister Sidebar */
unregister_sidebar(  'header-right'  );
unregister_sidebar( 'sidebar-alt' );

remove_filter( 'the_content', 'wpautop' ); //https://stackoverflow.com/questions/6625458/removing-p-and-br-tags-in-wordpress-posts
/*Disable emoticons
add_action( 'wp_head',             'print_emoji_detection_script',     7    );
*/
function disable_wp_emojicons() {

  // all actions related to emojis
  remove_action( 'admin_print_styles', 'print_emoji_styles' );
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

  // filter to remove TinyMCE emojis
  //add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
}
add_action( 'init', 'disable_wp_emojicons' );


global $wpseo_json_ld;
remove_action( 'wpseo_head', array( $wpseo_json_ld, 'json_ld' ), 90 );


/** Add Viewport meta tag for mobile browsers */
add_action( 'genesis_meta', 'streamline_add_viewport_meta_tag' );
function streamline_add_viewport_meta_tag() {
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>';
}

add_action(  'wp_enqueue_scripts', 'lmseo_theme_js'  );
function lmseo_theme_js(   ) {
	wp_deregister_script('jquery');
	// Register
	wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js', false, '2.1.4',false);
	// jQuery Migrate
	// Deregister core jQuery Migrate
	wp_deregister_script('jquery-migrate');
	// Register
	wp_register_script('jquery-migrate', 'https://code.jquery.com/jquery-migrate-1.2.1.min.js', array('jquery'), '1.2.1',false); // require jquery, as loaded above
//	wp_register_script( 'bootstrap','https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js',array(), '5.2.3', true );
	wp_register_script( 'index-main',get_stylesheet_directory_uri( 'bootstrap' ) . '/dist/homepage/js/app.js',array(), '1.0', true );
    wp_register_script( 'loadcss',get_stylesheet_directory_uri(  ) . '/bower_components/loadcss/src/loadCSS.min.js',array(), '1.0', true );
    wp_register_script( 'onloadcss',get_stylesheet_directory_uri(  ) . '/bower_components/loadcss/src/onloadCSS.min.js',array(), '1.0', true );
}

add_action(  'wp_enqueue_scripts', 'lmseo_enque_scripts'  );
function lmseo_enque_scripts(   ) {
	wp_enqueue_script(  'jquery');
	wp_enqueue_script(  'jquery-migrate');
}

//* Remove the site title
//remove_action( 'genesis_site_title', 'genesis_seo_site_title' );
//* Remove the site description
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );

/** Create additional color style options */
//add_theme_support( 'genesis-style-selector', array( 'streamline-blue' => 'Blue', 'streamline-green' => 'Green' ) );

/** Remove favicon */
remove_action('wp_head', 'genesis_load_favicon');

/*add new favicons */
add_action('wp_head','lmseo_favicon');
function lmseo_favicon(){ ?>
<link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="/apple-touch-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon-180x180.png">
<link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="/android-chrome-192x192.png" sizes="192x192">
<link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96">
<link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
<link rel="manifest" href="/manifest.json">
<meta name="msapplication-TileColor" content="#008cc0">
<meta name="msapplication-TileImage" content="/mstile-144x144.png">
<meta name="theme-color" content="#ffffff"><?php
}

/*customize breadcrummbs */
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
/*add_action( 'genesis_after_header', 'genesis_do_breadcrumbs' );
add_filter( 'genesis_breadcrumb_args', 'sp_breadcrumb_args' );
function sp_breadcrumb_args( $args ) {
	$args['home'] = 'Home';
	$args['sep'] = '</li><li>';
	$args['list_sep'] = ', '; // Genesis 1.5 and later
	$args['prefix'] = '<nav class="breadcrumb"><div class="row">';
	$args['suffix'] = '</div></nav>';
	$args['heirarchial_attachments'] = true; // Genesis 1.5 and later
	$args['heirarchial_categories'] = true; // Genesis 1.5 and later
	$args['display'] = true;
	$args['labels']['prefix'] = '<li><span class="home"></span></li>';
	$args['labels']['author'] = 'Archives for ';
	$args['labels']['category'] = 'Archives for '; // Genesis 1.6 and later
	$args['labels']['tag'] = 'Archives for ';
	$args['labels']['date'] = 'Archives for ';
	$args['labels']['search'] = 'Search for ';
	$args['labels']['tax'] = 'Archives for ';
	$args['labels']['post_type'] = 'Archives for ';
	$args['labels']['404'] = 'Not found: '; // Genesis 1.5 and later
return $args;
}*/



/** Add support for structural wraps */
add_theme_support( 'genesis-structural-wraps', array(  'nav', 'subnav', 'footer-widgets', 'footer' ) );

/* row class as structural wrap*/

add_action( 'genesis_before_content', 'opening_main_divs', 9 );
function opening_main_divs() {
	if ( is_front_page() or is_home()) {

	} else {
//		echo '<div class="row"><div class="large-12 columns">';
	  //everything else
	}
}

add_action( 'genesis_after_content', 'closing_main_divs' );
function closing_main_divs() {
	if(is_home() or is_front_page()){

	}else {
//		echo '</div>';
	  //everything else
	}
}


add_action( 'genesis_before_sidebar_widget_area', 'opening_aside_divs', 9 );
function opening_aside_divs() {
	if ( is_front_page() or is_home()) {

	} else {
		echo '</div>';
	  //everything else
	}
}

add_action( 'genesis_after_sidebar_widget_area', 'closing_aside_divs' );
function closing_aside_divs() {
	if(is_home() or is_front_page()){

	}else {
		echo '';
	  //everything else
	}
}
/** Add new image sizes */
add_image_size( 'home-featured', 255, 80, TRUE );
add_image_size( 'post-image', 1890, 400, TRUE );

/** Unregister layout settings */
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

/** Unregister secondary sidebar */
unregister_sidebar( 'sidebar-alt' );

/** Add support for custom background */
//add_custom_background();
add_theme_support('custom-background');

/** Add support for custom header */
//add_theme_support( 'genesis-custom-header', array( 'width' => 960, 'height' => 120 ) );

/** Add newsletter section after header */
//add_action( 'genesis_before_content_sidebar_wrap', 'streamline_newsletter' );
//function streamline_newsletter() {
  /* if ( ! is_home() )
       return;

   genesis_widget_area( 'newsletter', array(
       'before' => '<div class="newsletter widget-area">',
   ) );*/
//}

/** Reposition the breadcrumbs */
/*remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'child_do_custom_loop' );


function child_do_custom_loop() {

    global $paged; // current paginated page
    global $query_args; // grab the current wp_query() args
    $args = array(
        'category__not_in' => 42, // exclude posts from this category
        'paged'            => $paged, // respect pagination
    );

    genesis_custom_loop( wp_parse_args($query_args, $args) );

}*/

/** Customize breadcrumbs display */
/*
add_filter( 'genesis_breadcrumb_args', 'streamline_breadcrumb_args' );
function streamline_breadcrumb_args( $args ) {
	$args['home'] = 'Home';
	$args['sep'] = ' ';
	$args['list_sep'] = ', '; // Genesis 1.5 and later
	$args['prefix'] = '<div class="breadcrumb"><div class="inner">';
	$args['suffix'] = '</div></div>';
	$args['labels']['prefix'] = '<span class="home"></span>';
	return $args;
}*/
/*<nav>
   <h2>You are here:</h2>
   <ul id="navlist">
   <li><a href="/">Main</a> →</li>
   <li><a href="/products/">Products</a> →</li>
   <li><a href="/products/dishwashers/">Dishwashers</a> →</li>
   <li><a>Second hand</a></li>
   </ul>
   </nav>


   <nav class="appbar-nav">
   <ul class="breadcrumbs" data-tracking-cat="breadcrumbs">
   <li itemscope="itemscope" itemtype="http://data-vocabulary.org/Breadcrumb"><a class="product-icon" href="//www.google.com/webmasters/">
   <img alt="Webmaster Tools" src="https://www.google.com/images/icons/product/webmaster_tools-16.png"></a>
   <a class="crumb product-name" href="//www.google.com/webmasters/" itemprop="url"><span itemprop="title">Webmaster Tools</span></a></li>
   <li class="crumb-container" itemscope="itemscope" itemtype="http://data-vocabulary.org/Breadcrumb" style="z-index:3"><a class="crumb crumb--first" href="/webmasters/?hl=en#topic=3309300" itemprop="url"><span class="breadcrumb-text" title="Help" itemprop="title">Help</span></a></li>
   <li class="crumb-container" itemscope="itemscope" itemtype="http://data-vocabulary.org/Breadcrumb" style="z-index:2"><a class="crumb" href="/webmasters/topic/4598337?hl=en&amp;ref_topic=3309300" itemprop="url"><span class="breadcrumb-text" title="Use structured data for rich search results" itemprop="title">Use structured data for rich search results</span></a></li>
   <li class="crumb-container" itemscope="itemscope" itemtype="http://data-vocabulary.org/Breadcrumb" style="z-index:1"><a class="crumb crumb--last" href="/webmasters/topic/4599102?hl=en&amp;ref_topic=4598337" itemprop="url"><span class="breadcrumb-text" title="Structured data types" itemprop="title">Structured data types</span></a></li>
   </ul>
   </nav>*/

/** Relocate the post info function */
remove_action( 'genesis_before_post_content', 'genesis_post_info' );
add_action( 'genesis_before_post', 'genesis_post_info' );

/** Customize the post info function */
add_filter( 'genesis_post_info', 'post_info_filter' );
function post_info_filter($post_info) {
if ( !is_page() ) {
    $post_info = '[post_author_posts_link] [post_date] [post_comments] [post_edit]';
    return $post_info;
}}

/** Add markup around post class */
add_action( 'genesis_before_post', 'streamline_post_markup' );
	function streamline_post_markup() { ?>
	<div class="post-wrap row">
	<?php
}
add_action( 'genesis_after_post', 'streamline_post_markup_close' );
	function streamline_post_markup_close() { ?>
	</div>
	<?php
}

/** Modify the size of the Gravatar in the author box */
add_filter( 'genesis_author_box_gravatar_size', 'streamline_author_box_gravatar_size' );
function streamline_author_box_gravatar_size($size) {
    return '80';
}

/** Customize the post meta function */
add_filter( 'genesis_post_meta', 'post_meta_filter' );
function post_meta_filter($post_meta) {
if ( !is_page() ) {
    $post_meta = '[post_categories before="Filed Under: "] [post_tags before="Tagged: "]';
    return $post_meta;
}}

/** Add the after post section */
add_action( 'genesis_after_post_content', 'streamline_after_post' );
function streamline_after_post() {
	if ( ! is_singular( 'post' ) )
	return;
	genesis_widget_area( 'after-post', array(
		'before' => '<div class="after-post widget-area">',
   ) );
}

/** Add Olark to website */
add_action( 'wp_footer','lmseo_olark', 1);
function lmseo_olark(){
	?>
	<!-- begin olark code -->
	<!-- begin olark code -->
	<script data-cfasync="false" type='text/javascript'>/*<![CDATA[*/window.olark||(function(c){var f=window,d=document,l=f.location.protocol=="https:"?"https:":"http:",z=c.name,r="load";var nt=function(){
	f[z]=function(){
	(a.s=a.s||[]).push(arguments)};var a=f[z]._={
	},q=c.methods.length;while(q--){(function(n){f[z][n]=function(){
	f[z]("call",n,arguments)}})(c.methods[q])}a.l=c.loader;a.i=nt;a.p={
	0:+new Date};a.P=function(u){
	a.p[u]=new Date-a.p[0]};function s(){
	a.P(r);f[z](r)}f.addEventListener?f.addEventListener(r,s,false):f.attachEvent("on"+r,s);var ld=function(){function p(hd){
	hd="head";return["<",hd,"></",hd,"><",i,' onl' + 'oad="var d=',g,";d.getElementsByTagName('head')[0].",j,"(d.",h,"('script')).",k,"='",l,"//",a.l,"'",'"',"></",i,">"].join("")}var i="body",m=d[i];if(!m){
	return setTimeout(ld,100)}a.P(1);var j="appendChild",h="createElement",k="src",n=d[h]("div"),v=n[j](d[h](z)),b=d[h]("iframe"),g="document",e="domain",o;n.style.display="none";m.insertBefore(n,m.firstChild).id=z;b.frameBorder="0";b.id=z+"-loader";if(/MSIE[ ]+6/.test(navigator.userAgent)){
	b.src="javascript:false"}b.allowTransparency="true";v[j](b);try{
	b.contentWindow[g].open()}catch(w){
	c[e]=d[e];o="javascript:var d="+g+".open();d.domain='"+d.domain+"';";b[k]=o+"void(0);"}try{
	var t=b.contentWindow[g];t.write(p());t.close()}catch(x){
	b[k]=o+'d.write("'+p().replace(/"/g,String.fromCharCode(92)+'"')+'");d.close();'}a.P(2)};ld()};nt()})({
	loader: "static.olark.com/jsclient/loader0.js",name:"olark",methods:["configure","extend","declare","identify"]});
	/* custom configuration goes here (www.olark.com/documentation) */
	olark.identify('7020-153-10-7829');/*]]>*/</script><noscript><a href="https://www.olark.com/site/7020-153-10-7829/contact" title="Contact us" target="_blank">Questions? Feedback?</a> powered by <a href="http://www.olark.com?welcome" title="Olark live chat software">Olark live chat software</a></noscript>
	<!-- end olark code -->
<?php
}
remove_filter( 'comment_form_defaults', 'genesis_comment_form_args' );


/** Register widget areas */
genesis_register_sidebar( array(
	'id'				=> 'newsletter',
	'name'			=> __( 'Newsletter', 'streamline' ),
	'description'	=> __( 'This is the newsletter section below the navigation.', 'streamline' ),
) );
genesis_register_sidebar( array(
	'id'				=> 'home-featured-1',
	'name'			=> __( 'Home Featured #1', 'streamline' ),
	'description'	=> __( 'This is the featured #1 column on the homepage.', 'streamline' ),
) );
genesis_register_sidebar( array(
	'id'				=> 'home-featured-2',
	'name'			=> __( 'Home Featured #2', 'streamline' ),
	'description'	=> __( 'This is the featured #2 column on the homepage.', 'streamline' ),
) );
genesis_register_sidebar( array(
	'id'				=> 'home-featured-3',
	'name'			=> __( 'Home Featured #3', 'streamline' ),
	'description'	=> __( 'This is the featured #3 column on the homepage.', 'streamline' ),
) );
genesis_register_sidebar( array(
	'id'				=> 'after-post',
	'name'			=> __( 'After Post', 'streamline' ),
	'description'	=> __( 'This is the after post section.', 'streamline' ),
) );
add_theme_support( 'genesis-connect-woocommerce' );


/*
 * Add custom primary nav
 */
function register_my_menu() {
  register_nav_menu('top-bar',__( 'Top Bar' ));
}
add_action( 'init', 'register_my_menu' );

remove_action( 'genesis_after_header', 'genesis_do_nav' );
//add_action( 'genesis_header', 'genesis_do_nav' );
//remove_action( 'genesis_header', 'genesis_do_nav' );
//add_action( 'genesis_header', 'lmseo_primary_nav' );
function lmseo_primary_nav(){
	$defaults = array(
		'theme_location'  => 'primary',
		'menu'            => 'main',
		'container'       => '',
		'container_class' => '',
		'container_id'    => '',
		'menu_class'      => 'primary-links',
		'menu_id'         => 'primary-links',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '',
		'depth'           => 0,
		'walker'          => ''
	);

	wp_nav_menu( $defaults );
}

/**
 * HTML5 OPEN HEADER
*/
/*remove_action('genesis_header','genesis_header_markup_open', 5);
add_action('genesis_header','html5_open_header', 5);
	function html5_open_header() {
		echo '<header class="sticky"><nav class="top-bar" data-topbar role="navigation" data-options="sticky_on: large"><div class="name"></div><section class="top-bar-section">
  ';
		//require_once ( get_stylesheet_directory() . '/lib/partials/top-bar.php' );
		//echo $out;
		///genesis_structural_wrap( 'header', 'open' );
}*/

/**
 * HTML5 CLOSE HEADER
*/
/*remove_action('genesis_header','genesis_header_markup_close', 15);
add_action('genesis_header','html5_close_header', 15);
	function html5_close_header() {
		//genesis_structural_wrap( 'header', 'close' );
		echo '</section><div class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></div>';
    	echo'</nav></header><!--end #header-->';
 }*/
/**
 * HTML5 NAVIGATION
*/
/*function html5_nav($nav_out, $nav){
		$nav_out = sprintf( '<nav id="nav" data-role="navbar">%2$s%1$s%3$s</nav>', $nav, genesis_structural_wrap( 'nav', 'open', 0 ),genesis_structural_wrap( 'nav', 'close', 0 ) );
		return $nav_out;
}
add_filter( 'genesis_do_nav', 'html5_nav', 10, 2 );*/
remove_action('genesis_site_title', 'genesis_seo_site_title');
//add_action( 'genesis_site_title', 'lmseo_seo_site_title' );

/**
 * Echo the site title into the header.
 *
 * Depending on the SEO option set by the user, this will either be wrapped in an `h1` or `p` element.
 *
 * Applies the `genesis_seo_title` filter before echoing.
 *
 * @since 1.1.0
 *
 * @uses genesis_get_seo_option() Get SEO setting value.
 * @uses genesis_html5()          Check or HTML5 support.
 */
function lmseo_seo_site_title(){

	//* Set what goes inside the wrapping tags
	$inside = sprintf( '<a href="%s" class="logo">%s</a>', trailingslashit( home_url() ), get_bloginfo( 'name' ) );



	//* Determine which wrapping tags to use
	$wrap = genesis_is_root_page() && 'title' === genesis_get_seo_option( 'home_h1_on' ) ? 'h1' : 'p';

	//* A little fallback, in case an SEO plugin is active
	$wrap = genesis_is_root_page() && ! genesis_get_seo_option( 'home_h1_on' ) ? 'h1' : $wrap;

	//* Wrap homepage site title in p tags if static front page
	$wrap = is_front_page() && ! is_home() ? 'h1' : $wrap;

	//* And finally, $wrap in h1 if HTML5 & semantic headings enabled
	$wrap = genesis_html5() && genesis_get_seo_option( 'semantic_headings' ) ? 'h1' : $wrap;

	/**
	 * Site title wrapping element
	 *
	 * The wrapping element for the site title.
	 *
	 * @since 2.2.3
	 *
	 * @param string $wrap The wrapping element (h1, h2, p, etc.).
	 */
	$wrap = apply_filters( 'genesis_site_title_wrap', $wrap );

	//* Build the title
	$title  = genesis_html5() ? sprintf( "<{$wrap} %s>", genesis_attr( 'site-title' ) ) : sprintf( '<%s id="title">%s</%s>', $wrap, $inside, $wrap );
	$title .= genesis_html5() ? "{$inside}</{$wrap}>" : '';

	//* Echo (filtered)
	echo apply_filters( 'genesis_seo_title', $title, $inside, $wrap );
}

//remove initial header functions
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );
remove_action( 'genesis_header', 'genesis_do_header' );

//add in the new header markup - prefix the function name - here sm_ is used
add_action( 'genesis_header', 'lmseo_genesis_header_markup_open', 5 );
add_action( 'genesis_header', 'lmseo_genesis_header_markup_close', 15 );

//New Header functions
function lmseo_genesis_header_markup_open() {
    genesis_markup( array(
        'html5'   => '
    <header %s><nav class="navbar navbar-nav-scroll fixed-top navbar-expand-lg navbar-light mask-custom shadow-0 p-0">
        <div class="top-bar-section container-fluid gx-0 p-0">',
        'open' => '',
        'params'  => array(
            'id'  => 'site-header',
        ),
        'close'=> '</header>',
        'context' => 'site-header',
    ) );
    //echo '<div class="header-ghost"></div>';
    genesis_structural_wrap( 'header' );
}
function lmseo_genesis_header_markup_close() {
    genesis_structural_wrap( 'header', 'close' );
    genesis_markup( array(
        'html5' => '</div></nav></header>',
    ) );
}
add_action( 'genesis_header', 'lmseo_genesis_do_header' );
function lmseo_genesis_do_header() {
	global $wp_registered_sidebars;
    require_once ( get_stylesheet_directory() . '/lib/partials/svg/logo.php');
	genesis_markup( array(
//		'html5'   => '<ul %s><li class="name">',
		'html5'   => '<div class="title-area">
<h1 class="navbar-brand site-title" itemprop="headline">
<a href="/" class="logo">
'. $logo .'
</a>
</h1>
<div class="navbar-toggler-wrapper">
 <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <div class="hamburger-toggle">
          <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
          </div>
      </div>
    </button>
</div>
   </div>',
		'context' => 'title-area',
	) );
	do_action( 'genesis_site_title' );
//	do_action( 'genesis_site_description' );
//	genesis_markup( array(
//			'html5' => '<li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li></li></ul>',
//			'xhtml' => '<li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li></li></ul>',
//		) );

	//wp_nav_menu( $defaults );
	genesis_markup( array(
		'html5'   => '<div class="collapse navbar-collapse" id="navbarSupportedContent" >',
		'context' => 'navbar-collapse',
	) );

	wp_nav_menu(
		array(
		'theme_location'  => 'top-bar',
		'menu'            => 'main',
		'container'       => '',
		'container_class' => 'top-bar-section',
		'container_id'    => '',
		'menu_class'      => 'navbar-nav',
		'menu_id'         => 'primary-links',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'depth'           => 0,
		'walker'          => new LMSEO_Walker_Nav_Menu()
		)
	);
    genesis_markup( array(
        'html5' => '</div>',
        'xhtml' => '</div>',
    ) );
    genesis_markup( array(
        'html5'   => '
<div class="d-none d-lg-block d-lg-flex justify-content-end pe-lg-5">
    <div class="container g-3">
        <form role="search">
            <div class="row">
                <span class="col-xl-4">
                    <a class="d-lg-none d-xl-block nav-link hvr-underline-from-left  float-start phone-link" href="tel:+16262325218">626.232.5218</a>
                </span>
                <div class="col-lg-8 col-xl-6 g-lg-0 top-search-input-wrapper">
                    <input type="text" placeholder="Search" class="float-end top-search-input" >
                    <button class="btn-search">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                          <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </form>
    </div>  
</div>',
        'xhtml'   => '</div>',
    ) );
//<div class="col-lg-4 col-xl-2 g-lg-0 top-search-end-wrapper">
//                    <a href="/search" class="top-button rounded-end top-search-end">
//                </div>
//
//                        Search
//                    </a>
	if ( ( isset( $wp_registered_sidebars['header-right'] ) && is_active_sidebar( 'header-right' ) ) || has_action( 'genesis_header_right' ) ) {
		genesis_markup( array(
			'html5'   => '<aside %s>',
			'xhtml'   => '<div class="widget-area header-widget-area">',
			'context' => 'header-widget-area',
		) );
			do_action( 'genesis_header_right' );
			add_filter( 'wp_nav_menu_args', 'genesis_header_menu_args' );
			add_filter( 'wp_nav_menu', 'genesis_header_menu_wrap' );
			dynamic_sidebar( 'header-right' );
			remove_filter( 'wp_nav_menu_args', 'genesis_header_menu_args' );
			remove_filter( 'wp_nav_menu', 'genesis_header_menu_wrap' );
		genesis_markup( array(
			'html5' => '</aside>',
			'xhtml' => '</div>',
		) );
	}
}
/**
 * Add a parent CSS class for nav menu items.
 *
 * @param array  $items The menu items, sorted by each menu item's menu order.
 * @return array (maybe) modified parent CSS class.
 */
function wpdocs_add_menu_parent_class( $items ) {
    $parents = array();

    // Collect menu items with parents.
    foreach ( $items as $item ) {
        if ( $item->menu_item_parent && $item->menu_item_parent > 0 ) {
            $parents[] = $item->menu_item_parent;
            $item->classes[]='hvr-buzz-out';
        }
    }

    // Add class.
    foreach ( $items as $item ) {
        if ( in_array( $item->ID, $parents ) ) {
            $item->classes[] = 'has-dropdown not-click';
        }
    }
    return $items;
}
add_filter( 'wp_nav_menu_objects', 'wpdocs_add_menu_parent_class' );

class My_Walker_Nav_Menu extends Walker_Nav_Menu {
  function start_lvl(&$output, $depth = 0, $args = Array()) {
    $indent = str_repeat("\t", $depth);
    $output .= "\n$indent<ul class=\"dropdown\">\n";
  }
}

/**
 * Custom walker class.
 */
class LMSEO_Walker_Nav_Menu extends Walker_Nav_Menu {

    /**
     * Starts the list before the elements are added.
     *
     * Adds classes to the unordered list sub-menus.
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        // Depth-dependent classes.
        $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
        $display_depth = ( $depth + 1); // because it counts the first submenu as 0
        $classes = array(
            'dropdown-menu',
            ( $display_depth % 2  ? 'dropdown-odd' : 'dropdown-even' ),
            ( $display_depth >=2 ? 'submenu' : '' ),
            'dropdown-depth-' . $display_depth
        );
        $class_names = implode( ' ', $classes );

        // Build HTML for output.
        $output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
    }

    /**
     * Start the element output.
     *
     * Allows to create a custom navbar with the structure of Bootstrap.
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Menu item data object.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     * @param int    $id     Current item ID.
     */
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        global $wp_query;
        $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent
//        print_r(($item));
        // Depth-dependent classes.
        $depth_classes = array(
            ( $depth == 0 ? 'nav-item' : '' ),
            ( $depth == 0 && $args->walker->has_children ? 'dropdown' : '' ),
            ( $depth > 0 && $args->walker->has_children ? 'nav-item dropdown' : '' ),
            ( $depth % 2 ? 'nav-item-odd' : 'nav-item-even' ),
            'nav-item-depth-' . $depth
        );
        $depth_class_names = esc_attr( implode( ' ', $depth_classes ) );

        // Passed classes.
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

        // Build HTML.
        $output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';

        // Link attributes.
        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
        $linkClasses = 'hvr-underline-from-left ';
        if ($args->walker->has_children) {
            $linkClasses .= 'nav-link dropdown-toggle';
//            $attributes .= !empty( $item->url )        ? ' data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside" data-bs-boundary="clippingParents"' : '';
            $attributes .= !empty( $item->url )        ? ' data-bs-toggle="" aria-expanded="false" data-bs-auto-close="outside" data-bs-boundary="clippingParents"' : '';

        }else{
            if( $depth>0 ) {
                $linkClasses .= 'dropdown-item';
            }else{
                $linkClasses .= 'nav-link';
            }
        }
        $attributes .= ' class="' . ( $linkClasses ) . '"';

        // Build HTML output and pass through the proper filter.
        $item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
            $args->before,
            $attributes,
            $args->link_before,
            apply_filters( 'the_title', $item->title, $item->ID ),
            $args->link_after,
            $args->after
        );
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}

/**
 * Filter the output of Yoast breadcrumbs so each item is an <li> with schema markup
 * @param $link_output
 * @param $link
 *
 * @return string
 */
function lmseo_filter_yoast_breadcrumb_items( $link_output, $link ) {
	$new_link_output ='';
	$pos = strpos($link_output, 'breadcrumb_last');
	if($pos===false){
		$new_link_output = '<li itemprop="itemListElement" itemscope
      itemtype="https://schema.org/ListItem">';
		$new_link_output .= '<a href="' . $link['url'] . '" itemprop="item" class="hvr-underline-from-left"><span itemprop="name">' . $link['text'] . '</span></a>';
		$new_link_output .= '</li>';
	}else{
		$new_link_output .= '<li class="current-item" itemprop="itemListElement" itemscope
      itemtype="https://schema.org/ListItem">'. $link['text'];
		$new_link_output .= '</li>';
	}


    return $new_link_output;
}
add_filter( 'wpseo_breadcrumb_single_link', 'lmseo_filter_yoast_breadcrumb_items', 10, 2 );


/**
 * Filter the output of Yoast breadcrumbs to remove <span> tags added by the plugin
 * @param $output
 *
 * @return mixed
 */
function lmseo_filter_yoast_breadcrumb_output( $output ){

    $from = '<span>';
    $to = '</span>';
    $output = str_replace( $from, $to, $output );

    return $output;
}
add_filter( 'wpseo_breadcrumb_output', 'lmseo_filter_yoast_breadcrumb_output' );

// add_action( 'genesis_before_content', 'custom_breadcrumbs_services_definition', 10);
// function custom_breadcrumbs_services_definition(){
//     if(is_home() or is_front_page()){
//     }else {
//         echo '<nav class="lmseo-breadcrumb-wrap px-5"><div class="container-fluid g-0 clearfix"><div class="">';
// //        if(function_exists('bcn_display_list')){
// //            bcn_display_list();
// //        }

//         if (function_exists('yoast_breadcrumb')) {
//             yoast_breadcrumb('<ul class="lmseo-breadcrumb float-end m-0 p-0" itemscope itemtype="https://schema.org/BreadcrumbList">', '</ul>');
//         }

//         echo '</div></div></nav>';
//     }
// }
add_action( 'genesis_before_content', 'custom_breadcrumbs', 10);
function custom_breadcrumbs(){
    get_template_part( 'template-parts/breadcrumb/breadcrumb-trail', 'trail' );
}

add_action(  'wp_enqueue_scripts', 'lmseo_general_styles'   );
function lmseo_general_styles() {
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
}