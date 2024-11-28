<?php

/**
 * Template part for displaying single post
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package cenote
 */

$content_orders = get_theme_mod('cenote_single_order_layout', array(
	'title',
	'thumbnail',
	//	'categories', removing categories. It is included with footer-entry
	'meta',
	'content',
	'footer',
));
$classes = array('');
?>

<article id="post-<?php the_ID(); ?>" <?php post_class($classes); ?>>

	<?php
	foreach ($content_orders as $key => $content_order) :
		if ('thumbnail' === $content_order) :
			cenote_post_thumbnail(true, 'thumbnail');
			genesis_markup(
				[
					'close' => '</header>',
					'context' => 'entry-header',
					'echo' => true,
				]
			);
			genesis_markup(
				[
					'open' => '<section %s>',
					'content' => '<div class="row justify-content-center"><div class="col-md-8 col-lg-7">',
					'context' => 'blog-single-content',
					'atts' => genesis_parse_attr('services-definition-content', ['class' => 'blog-single-content container pb-5']),
					'echo' => true,
				]
			);
		elseif ('categories' === $content_order) :
	?>
			<div class="tg-top-cat">
				<?php cenote_post_categories(); ?>
			</div>
		<?php
		elseif ('title' === $content_order) :
		?>

			<?php
			genesis_markup(
				[
					'open' => '<header %s>',
					'context' => 'entry-header',
					'atts' => genesis_parse_attr('services-definition-content', ['class' => 'entry-header pt-5 mt-5']),
					'echo' => true,
				]
			);
			genesis_markup(
				[
					'open' => '<div %s>',
					'content' => '<div class="row justify-content-center"><div class="col-lg-5">',
					'context' => 'entry-title-wrapper',
					'atts' => genesis_parse_attr('entry-title-wrapper', ['class' => 'entry-title-wrapper container']),
					'echo' => true,
				]
			);

			genesis_markup(
				[
					'open' => '<h5 %s>',
					'close' => '</h5>',
					'content' => 'OUR BLOG:',
					'context' => 'here',
					'atts' => genesis_parse_attr('here', ['class' => 'here']),
					'echo' => true,
				]
			);
			cenote_posted_on();
			the_title('<h1 class="entry-title pb-5">', '</h1>');
			genesis_markup(
				[
					'content' => '</div></div>',
					'close' => '</div>',
					'context' => 'entry-title-wrapper',
					'echo' => true,
				]
			);
			?>

		<?php
		elseif ('meta' === $content_order && 'post' === get_post_type()) :
		?>

			<div class="entry-meta">
				<?php
				echo 'By: ';
				cenote_posted_by();
				?>
			</div><!-- .entry-meta -->
		<?php
		elseif ('content' === $content_order) :
		?>
			<div class="entry-content">
				<?php
				the_content();
				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . esc_html__('Pages:', 'cenote'),
						'after'  => '</div>',
					)
				);
				?>
			</div><!-- .entry-content -->
		<?php
			genesis_markup(
				[
					'content' => '</div></div>',
					'close' => '</section>',
					'context' => 'blog-single-content',
					'echo' => true,
				]
			);
		elseif ('footer' === $content_order) :
		?>
			<footer class="entry-footer container">
				<div class="row justify-content-center">
					<div class="col-md-8 col-lg-7">
						<?php cenote_entry_footer(); ?>
					</div>
				</div>
			</footer><!-- .entry-footer -->
		<?php
		endif;
	endforeach;

	// Show author box if enabled.
	if (true === get_theme_mod('cenote_single_enable_author_box', true)) {
		?>
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-8 col-lg-7">
					<?php
					get_template_part('template-parts/author/author', 'box'); ?>
				</div>
			</div>
		</div>
	<?php
	}
	?>

</article><!-- #post-<?php the_ID(); ?> -->