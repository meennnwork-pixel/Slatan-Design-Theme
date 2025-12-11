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

/**
 * ===========================================
 * ELEMENTOR PRO THEME BUILDER SUPPORT
 * ===========================================
 */

/**
 * Register Elementor Theme Locations for Theme Builder Pro
 * This enables dynamic header/footer/single templates in Elementor Pro
 */
function slatan_design_register_elementor_locations($location_manager)
{
    // Register all core locations (header, footer, single, archive, etc.)
    $location_manager->register_all_core_location();
}
add_action('elementor/theme/register_locations', 'slatan_design_register_elementor_locations');

/**
 * Add Elementor Theme Builder compatibility
 */
function slatan_design_elementor_theme_builder_support()
{
    if (!class_exists('\Elementor\Plugin')) {
        return;
    }

    // Add Elementor default kit support
    add_theme_support('elementor-default-kit');
}
add_action('after_setup_theme', 'slatan_design_elementor_theme_builder_support');

/**
 * Disable theme header/footer when Elementor Pro Theme Builder is active
 */
function slatan_design_elementor_theme_builder_override()
{
    if (!class_exists('\ElementorPro\Plugin')) {
        return;
    }

    // Check if Elementor Pro Theme Builder has custom header
    $header_location = \ElementorPro\Modules\ThemeBuilder\Module::instance()->get_locations_manager()->get_location('header');
    $footer_location = \ElementorPro\Modules\ThemeBuilder\Module::instance()->get_locations_manager()->get_location('footer');

    // If Elementor has custom header, add filter to skip theme header
    if (!empty($header_location)) {
        add_filter('slatan_skip_theme_header', '__return_true');
    }

    // If Elementor has custom footer, add filter to skip theme footer
    if (!empty($footer_location)) {
        add_filter('slatan_skip_theme_footer', '__return_true');
    }
}
add_action('wp', 'slatan_design_elementor_theme_builder_override');

/**
 * ===========================================
 * PERFORMANCE OPTIMIZATIONS FOR PAGE BUILDERS
 * ===========================================
 */

/**
 * Conditional Page Builder CSS loading
 * Only load page-builder.css on pages that actually use page builders
 */
function slatan_design_conditional_builder_assets()
{
    if (!is_singular()) {
        return;
    }

    $post_id = get_the_ID();
    if (!$post_id) {
        return;
    }

    // Check if page uses any page builder
    $uses_elementor = get_post_meta($post_id, '_elementor_edit_mode', true);
    $uses_beaver = get_post_meta($post_id, '_fl_builder_enabled', true);

    // If page doesn't use any builder and isn't using a builder template
    $template = get_page_template_slug($post_id);
    $is_builder_template = in_array($template, array(
        'page-templates/template-fullwidth.php',
        'page-templates/template-canvas.php'
    ));

    if (!$uses_elementor && !$uses_beaver && !$is_builder_template) {
        // Dequeue page builder specific styles on non-builder pages
        wp_dequeue_style('slatan-page-builder');
    }
}
add_action('wp_enqueue_scripts', 'slatan_design_conditional_builder_assets', 100);

/**
 * Defer non-critical page builder scripts
 */
function slatan_design_optimize_builder_scripts($tag, $handle, $src)
{
    // Skip in admin and editor mode
    if (is_admin()) {
        return $tag;
    }

    // Skip if in Elementor preview or editor
    if (class_exists('\Elementor\Plugin')) {
        if (
            \Elementor\Plugin::$instance->preview->is_preview_mode() ||
            \Elementor\Plugin::$instance->editor->is_edit_mode()
        ) {
            return $tag;
        }
    }

    // Scripts safe to defer on frontend
    $defer_scripts = array(
        'elementor-waypoints',
        'elementor-frontend-modules',
        'jquery-numerator',
        'swiper',
    );

    if (in_array($handle, $defer_scripts) && strpos($tag, 'defer') === false) {
        return str_replace(' src=', ' defer src=', $tag);
    }

    return $tag;
}
add_filter('script_loader_tag', 'slatan_design_optimize_builder_scripts', 10, 3);

/**
 * Add dns-prefetch for page builder resources
 */
function slatan_design_builder_resource_hints($urls, $relation_type)
{
    if ('dns-prefetch' === $relation_type) {
        // Elementor assets
        if (class_exists('\Elementor\Plugin')) {
            $urls[] = '//i.ytimg.com'; // YouTube thumbnails
            $urls[] = '//www.google.com'; // Google Maps
        }
    }

    return $urls;
}
add_filter('wp_resource_hints', 'slatan_design_builder_resource_hints', 10, 2);

