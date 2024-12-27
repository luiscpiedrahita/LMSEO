<?php

/**
 * Template part for displaying posts
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package cenote
 */

$content_orders = get_theme_mod('cenote_archive_order_layout', array(
	'thumbnail',
	'author',
	'title',
	'meta',
	'content',
	'footer',
));
$post_content   = get_theme_mod('cenote_archive_post_content', 'excerpt');
$excerpt_count  = get_theme_mod('cenote_archive_excerpt_count', '40');
?>

<?php
$columns = array();
$counter = $array_defaults['counter'];
$classes = [];
$classes[] = '';
$array_defaults['content'][$counter] = '<article id="post-' . get_the_ID() . '" class="';
foreach (get_post_class($classes) as $key => $class) {
	$array_defaults['content'][$counter] .=  $class . ' ';
}
$array_defaults['content'][$counter] .= 'px-3 pt-3 pb-5';
$array_defaults['content'][$counter] .= '" >';
foreach ($content_orders as $key => $content_order) {
	if ('thumbnail' === $content_order) {
		$array_defaults['content'][$counter] .= cenote_post_thumbnail(false);
	} elseif ('author' === $content_order) {
		$array_defaults['content'][$counter] .= '<div class="author-post__meta">
				<a class="author-post__author-title" href="';
		$array_defaults['content'][$counter] .= esc_url(get_author_posts_url(get_the_author_meta('ID')));
		$array_defaults['content'][$counter] .= '">' . get_the_author();
		$array_defaults['content'][$counter] .= '</a><em class="light-grey"> wrote</em></div>';
	} elseif ('meta' === $content_order) {
		$array_defaults['content'][$counter] .= '<div class="entry-meta">';
		$array_defaults['content'][$counter] .= cenote_posted_on(false);
		$array_defaults['content'][$counter] .= '<span> in </span>';
		$array_defaults['content'][$counter] .= cenote_post_categories(false);
		$array_defaults['content'][$counter] .= '</div><!-- .entry-meta -->';
	} elseif ('title' === $content_order) {
		$array_defaults['content'][$counter] .= '<header class="entry-header">';
		$array_defaults['content'][$counter] .= the_title('<h2 class="entry-title my-0"><a href="' . esc_url(get_permalink()) . '" rel="bookmark" class="">', '</a></h2>', false);
		$array_defaults['content'][$counter] .= '</header><!-- .entry-header -->';
	} elseif ('content' === $content_order) {
		$array_defaults['content'][$counter] .= ' <div class="entry-content">';
		if ('excerpt' === $post_content) {
			$array_defaults['content'][$counter] .= '<p class="text-wrap">' .  wp_trim_words(get_the_content(), 100, '') . ' […]</p>';
		} elseif ('content' === $post_content) {
			$array_defaults['content'][$counter] .= get_the_content(sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__('Continue reading<span class="screen-reader-text"> "%s"</span>', 'cenote'),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			));
		}
		$array_defaults['content'][$counter] .= '</div><!-- .entry-content -->';
	} elseif ('footer' === $content_order) {
		$array_defaults['content'][$counter] .= '<footer class="entry-footer p-0">
				<div>';
		$array_defaults['content'][$counter] .= '<span class="read-this-post">';
		$array_defaults['content'][$counter] .= __('READ THIS POST: ', 'cenote');
		$array_defaults['content'][$counter] .= ' </span><span  class="readmore-wrapper"><div class="underline-effect-wrapper">';
		$array_defaults['content'][$counter] .= '<a href="' . get_the_permalink();
		$array_defaults['content'][$counter] .= '" class="tg-readmore-link hvr-underline-from-left">';
		$array_defaults['content'][$counter] .= 	get_the_title('', '');
		$array_defaults['content'][$counter] .= '</a></div></span></div>
			</footer><!-- .entry-footer -->';
	};
}
$array_defaults['content'][$counter] .= '</article><!-- #post-';
$array_defaults['content'][$counter] .= get_the_ID() . '-->';
if ($paged == 1) {
	//   Layout page 1
	if ($counter == 0) {
		$array_defaults['columns'][0] = '';
		$array_defaults['columns'][1] = '<div class="col-lg-5 col-md-7 border-end p-0"><div class="top-article border-bottom pb-5">';
		$array_defaults['columns'][1] .= $array_defaults['content'][0];
		$array_defaults['columns'][1] .= '</div>';
	} elseif ($counter == 1) {
		$array_defaults['columns'][1] .= $array_defaults['content'][1];
		$array_defaults['columns'][1] .= '</div>';
	} elseif ($counter == 2) {
		$array_defaults['columns'][0] =  '<div class="col-lg-4 col-md-5 border-end  p-0"><div class="top-article border-bottom pb-5">';
		$array_defaults['columns'][0] .= $array_defaults['content'][$counter];
		$array_defaults['columns'][0] .= '</div>';
	} elseif ($counter == 3) {
		$array_defaults['columns'][0] .= $array_defaults['content'][$counter];
		$array_defaults['columns'][0] .= '</div>';
	} elseif ($counter == 4) {
		$array_defaults['columns'][2] = '<div class="col-lg-3 col-md-12  p-0"><div class="top-article border-bottom pb-5">';
		$array_defaults['columns'][2] .= $array_defaults['content'][$counter];
		$array_defaults['columns'][2] .= '</div>';
	} elseif ($counter == 5) {
		$array_defaults['columns'][2] .= $array_defaults['content'][$counter];
		$array_defaults['columns'][2] .= '</div></div><div class="middle-row row"><div class="col-lg-4 col-md-7 border-end py-5 "></div><div class="col-lg-5 col-md-7 border-end "></div><div class="col-lg-3 col-md-7 border-end "></div></div><div class="bottom-row row gx-4 py-0">';
	} elseif ($counter > 5) {
		$array_defaults['columns'][$counter - 2] =  '<div class="col-lg-4 border-top border-end p-5">';
		$array_defaults['columns'][$counter - 2] .= $array_defaults['content'][$counter];
		$array_defaults['columns'][$counter - 2] .= '</div>';
	}
} else {
	//		Layout every other page
	$array_defaults['columns'][$counter] =  '<div class="col-lg-4 border-top border-end">';
	$array_defaults['columns'][$counter] .= $array_defaults['content'][$counter];
	$array_defaults['columns'][$counter] .= '</div>';
}

//	if($counter == 0 ){
//		$array_defaults['columns'][1] = '<div class="col-lg-6">';
//		$array_defaults['columns'][1] .= $array_defaults['content'][$counter];
//		$array_defaults['columns'][1] .= '</div>';
//	}elseif($counter == 1){
//		$array_defaults['columns'][0] =  '<div class="col-lg-3">';
//		$array_defaults['columns'][0] .= $array_defaults['content'][$counter];
//	}elseif($counter == 2){
//		if(isset($array_defaults['columns'][0])) {
//			$array_defaults['columns'][0] .= $array_defaults['content'][$counter];
//			$array_defaults['columns'][0] .= '</div>';
//		}else{
//			$array_defaults['columns'][0] = '<div class="col-lg-3"></div>';
//		}
//	}elseif($counter == 3){
//		$array_defaults['columns'][2] =  '<div class="col-lg-3">';
//		$array_defaults['columns'][2] .= $array_defaults['content'][$counter];
//	}elseif($counter == 5){
//		if(isset($array_defaults['columns'][2])){
//			$array_defaults['columns'][2] .= $array_defaults['content'][$counter];
//			$array_defaults['columns'][2] .= '</div></div><div class="bottom-row row gx-5">';
//		}else{
//			$array_defaults['columns'][2] = '</div><div class="row gx-5">';
//		}
//
//	}elseif($counter > 4) {
//		if( $counter < 8){
//			$array_defaults['columns'][$counter-2] =  '<div class="col-lg-4">';
//		}else{
//			$array_defaults['columns'][$counter-2] =  '<div class="col-lg-4">';
//		}
//
//		$array_defaults['columns'][$counter-2] .= $array_defaults['content'][$counter];
//		$array_defaults['columns'][$counter-2] .= '</div>';
//	}
