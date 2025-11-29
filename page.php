<?php
/**
 * The main template file
 *
 * @package Slatan_Design
 */

if (!defined('ABSPATH')) {
	exit;
} // Exit if accessed directly.

get_header();
?>

<?php
if (have_posts()):

	/* Start the Loop */
	while (have_posts()):
		the_post();

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

		the_content();

	endwhile;

else:

	// If you want to show something when no content is found, you can add it here.
	// For an Elementor-first theme, it's often better to handle this with Elementor's theme builder.

endif;
?>

<?php
get_footer();