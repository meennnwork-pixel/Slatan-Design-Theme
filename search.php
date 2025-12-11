<?php
if (!defined('ABSPATH')) {
	exit;
} // Exit if accessed directly.
/**
 * The main template file
 *
 * @package Slatan_Design
 */

get_header();
?>

<?php
if (have_posts()):

	/* Start the Loop */
	while (have_posts()):
		the_post();

		the_content();

	endwhile;

else:

	// If you want to show something when no content is found, you can add it here.
	// For an Elementor-first theme, it's often better to handle this with Elementor's theme builder.

endif;
?>

<?php
get_footer();