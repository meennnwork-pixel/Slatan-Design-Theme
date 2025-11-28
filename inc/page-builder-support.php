<?php
/**
 * Page Builder Support
 * 
 * Add support for popular page builders like Elementor, Beaver Builder, etc.
 *
 * @package Slatan_Design
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add theme support for Elementor
 */
function slatan_design_elementor_support()
{
    // Elementor Header & Footer support
    add_theme_support('elementor-header-footer');

    // Elementor Pro support
    add_theme_support('elementor-pro');

    // Set Elementor width
    update_option('elementor_container_width', '1200');
    update_option('elementor_viewport_lg', '1025');
    update_option('elementor_viewport_md', '768');
}
add_action('after_setup_theme', 'slatan_design_elementor_support');

/**
 * Add theme support for Beaver Builder
 */
function slatan_design_beaver_builder_support()
{
    // Beaver Builder support
    add_theme_support('fl-builder-content-width', 1200);
}
add_action('after_setup_theme', 'slatan_design_beaver_builder_support');

/**
 * Register Page Builder compatible widths
 */
function slatan_design_content_width()
{
    // Default content width
    $GLOBALS['content_width'] = apply_filters('slatan_design_content_width', 1200);
}
add_action('after_setup_theme', 'slatan_design_content_width', 0);

/**
 * Add body classes for page builders
 */
function slatan_design_page_builder_body_classes($classes)
{
    // Check if Elementor is active and editing
    if (class_exists('\Elementor\Plugin')) {
        if (\Elementor\Plugin::$instance->preview->is_preview_mode()) {
            $classes[] = 'elementor-preview';
        }

        // Check if page is built with Elementor
        if (get_post_meta(get_the_ID(), '_elementor_edit_mode', true)) {
            $classes[] = 'elementor-page';
        }
    }

    // Check if Beaver Builder is active
    if (class_exists('FLBuilder')) {
        if (FLBuilderModel::is_builder_enabled()) {
            $classes[] = 'fl-builder-edit';
        }

        // Check if page is built with Beaver Builder
        if (get_post_meta(get_the_ID(), '_fl_builder_enabled', true)) {
            $classes[] = 'fl-builder-page';
        }
    }

    // Check for full-width template
    $template = get_page_template_slug();
    if ($template === 'page-templates/template-fullwidth.php') {
        $classes[] = 'page-template-fullwidth';
    }

    // Check for canvas template
    if ($template === 'page-templates/template-canvas.php') {
        $classes[] = 'page-template-canvas';
    }

    return $classes;
}
add_filter('body_class', 'slatan_design_page_builder_body_classes');

/**
 * Enqueue Page Builder specific styles
 */
function slatan_design_page_builder_styles()
{
    // Only load on frontend
    if (!is_admin()) {
        wp_enqueue_style(
            'slatan-page-builder',
            get_template_directory_uri() . '/css/page-builder.css',
            array(),
            _S_VERSION
        );
    }
}
add_action('wp_enqueue_scripts', 'slatan_design_page_builder_styles');

/**
 * Remove theme margins/padding for full-width page builders
 */
function slatan_design_page_builder_inline_css()
{
    $template = get_page_template_slug();

    // For full-width and canvas templates
    if (in_array($template, array('page-templates/template-fullwidth.php', 'page-templates/template-canvas.php'))) {
        ?>
        <style type="text/css">
            .site-main {
                padding: 0;
                margin: 0;
            }

            .page-template-fullwidth .site-main,
            .page-template-canvas .site-main {
                max-width: 100%;
                width: 100%;
            }
        </style>
        <?php
    }
}
add_action('wp_head', 'slatan_design_page_builder_inline_css');

/**
 * Add support for Gutenberg wide and full alignments
 */
function slatan_design_gutenberg_support()
{
    // Already added in main setup, but ensuring it's here
    add_theme_support('align-wide');

    // Add custom color palette for Gutenberg
    add_theme_support('editor-color-palette', array(
        array(
            'name' => __('Primary', 'slatan-design'),
            'slug' => 'primary',
            'color' => '#0073aa',
        ),
        array(
            'name' => __('Secondary', 'slatan-design'),
            'slug' => 'secondary',
            'color' => '#005177',
        ),
        array(
            'name' => __('Accent', 'slatan-design'),
            'slug' => 'accent',
            'color' => '#ffc107',
        ),
        array(
            'name' => __('Dark', 'slatan-design'),
            'slug' => 'dark',
            'color' => '#333333',
        ),
        array(
            'name' => __('Light', 'slatan-design'),
            'slug' => 'light',
            'color' => '#f8f9fa',
        ),
        array(
            'name' => __('White', 'slatan-design'),
            'slug' => 'white',
            'color' => '#ffffff',
        ),
    ));
}
add_action('after_setup_theme', 'slatan_design_gutenberg_support');
