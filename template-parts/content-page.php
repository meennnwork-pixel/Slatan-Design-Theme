<?php
/**
 * Template part for displaying page content in page.php
 *
 * @package Slatan_Design
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		// Check if page title should be shown
		$show_title = get_post_meta(get_the_ID(), '_slatan_show_page_title', true);
		if ($show_title === '') {
			// If not set, use Customizer default
			$show_title = get_theme_mod('slatan_show_page_title_default', true);
		}

		// Display title if enabled
		if ($show_title) {
			the_title('<h1 class="entry-title">', '</h1>');
		}
		?>
	</header><!-- .entry-header -->

	<?php slatan_design_post_thumbnail(); ?>

	<div class="entry-content">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__('Pages:', 'slatan-design'),
				'after' => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->

	<?php if (get_edit_post_link()): ?>
		<footer class="entry-footer">
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__('Edit <span class="screen-reader-text">%s</span>', 'slatan-design'),
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