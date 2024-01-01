<?php

/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Swingster
 */

// Get the current value of the checkbox option
$hide_banner = get_option('sw-main__banner-hide') ? 'checked' : '';
$banner_title = get_option('sw-main__banner-title');

// Check if the hide_banner is enabled and set the body class
$body_class = ($hide_banner == 'checked') ? ' sw-main__banner--hide' : '';

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header<?php echo $body_class ?>">
		<?php
		if (!empty($banner_title)) {
			echo '<h1>' . esc_html($banner_title) . '</h1>';
		} else {
			echo the_title('<h1 class="entry-title">', '</h1>');
		}
		?>
	</header><!-- .entry-header -->

	<?php swingster_post_thumbnail(); ?>

	<div class="entry-content">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__('Pages:', 'swingster'),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->

	<?php if (get_edit_post_link()) : ?>
		<footer class="entry-footer">
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__('Edit <span class="screen-reader-text">%s</span>', 'swingster'),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post(get_the_title())
				),
				'<span class="edit-link">',
				'</span>'
			);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
