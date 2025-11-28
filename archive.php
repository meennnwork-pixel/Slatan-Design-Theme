<?php
/**
 * The main template file
 *
 * @package Your_Theme_Name
 */

if ( ! defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

get_header();
?>

	<?php
	if ( have_posts() ) :

		/* Start the Loop */
		while ( have_posts() ) :
			the_post();

			the_content();

		endwhile;

	else :

		// If you want to show something when no content is found, you can add it here.
		// For an Elementor-first theme, it's often better to handle this with Elementor's theme builder.

	endif;
	?>

<?php
get_footer();