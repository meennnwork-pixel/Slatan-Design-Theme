<?php
/**
 * Template Name: Canvas (Blank)
 * Template Post Type: page
 * 
 * Blank canvas template without header and footer.
 * Perfect for landing pages built with page builders.
 *
 * @package Slatan_Design
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <div id="page" class="site canvas-template">
        <main id="primary" class="site-main">
            <?php
            while (have_posts()):
                the_post();

                the_content();

            endwhile;
            ?>
        </main>
    </div>

    <?php wp_footer(); ?>
</body>

</html>