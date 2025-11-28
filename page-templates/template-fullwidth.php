<?php
/**
 * Template Name: Full Width
 * Template Post Type: page
 * 
 * Full width page template without sidebar.
 * Perfect for page builders like Elementor, Beaver Builder, etc.
 *
 * @package Slatan_Design
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="full-width-content">
    <?php
    while (have_posts()):
        the_post();

        the_content();

        // If comments are open or we have at least one comment, load up the comment template.
        if (comments_open() || get_comments_number()):
            comments_template();
        endif;

    endwhile;
    ?>
</div>

<?php
get_footer();
