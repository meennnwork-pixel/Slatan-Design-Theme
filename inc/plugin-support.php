<?php
/**
 * Popular Plugin Compatibility
 *
 * @package Slatan_Design
 */
if (!defined('ABSPATH')) {
    exit;
}
/**
 * ===========================================
 * YOAST SEO SUPPORT
 * ===========================================
 */
function slatan_design_yoast_support()
{
    if (!function_exists('yoast_breadcrumb')) {
        return;
    }
    
    // Add theme support for Yoast breadcrumbs
    add_theme_support('yoast-seo-breadcrumbs');
}
add_action('after_setup_theme', 'slatan_design_yoast_support');
/**
 * ===========================================
 * RANKMATH SEO SUPPORT
 * ===========================================
 */
function slatan_design_rankmath_support()
{
    if (!class_exists('RankMath')) {
        return;
    }
    
    // Add RankMath breadcrumb support
    add_theme_support('rank-math-breadcrumbs');
}
add_action('after_setup_theme', 'slatan_design_rankmath_support');
/**
 * ===========================================
 * WPML / POLYLANG SUPPORT
 * ===========================================
 */
function slatan_design_multilingual_support()
{
    // WPML Support
    if (defined('ICL_SITEPRESS_VERSION')) {
        // Make theme strings translatable
        add_filter('wpml_custom_fields_sync_option', function ($option, $context) {
            return WPML_TRANSLATE_CUSTOM_FIELD; // Allow translation
        }, 10, 2);
    }
    
    // Polylang Support
    if (function_exists('pll_register_string')) {
        // Register theme strings for translation
        pll_register_string('slatan_skip_content', 'Skip to content', 'Slatan Design');
        pll_register_string('slatan_primary_menu', 'Primary Menu', 'Slatan Design');
        pll_register_string('slatan_comments_closed', 'Comments are closed.', 'Slatan Design');
    }
}
add_action('init', 'slatan_design_multilingual_support');
/**
 * ===========================================
 * ACF (Advanced Custom Fields) SUPPORT
 * ===========================================
 */
function slatan_design_acf_support()
{
    if (!class_exists('ACF')) {
        return;
    }
    
    // Add ACF options page if Pro is active
    if (function_exists('acf_add_options_page')) {
        acf_add_options_page(array(
            'page_title' => __('Theme Settings', 'slatan-design'),
            'menu_title' => __('Theme Settings', 'slatan-design'),
            'menu_slug' => 'slatan-theme-settings',
            'capability' => 'edit_theme_options',
            'parent_slug' => 'themes.php',
            'icon_url' => 'dashicons-admin-customizer',
        ));
    }
    
    // Save ACF fields in theme_mod instead of postmeta (optional)
    add_filter('acf/settings/save_json', function ($path) {
        return get_template_directory() . '/acf-json';
    });
    
    add_filter('acf/settings/load_json', function ($paths) {
        $paths[] = get_template_directory() . '/acf-json';
        return $paths;
    });
}
add_action('acf/init', 'slatan_design_acf_support');
/**
 * ===========================================
 * CONTACT FORM 7 SUPPORT
 * ===========================================
 */
function slatan_design_cf7_support()
{
    if (!class_exists('WPCF7')) {
        return;
    }
    
    // Dequeue CF7 scripts/styles on pages without forms
    if (!is_page() && !is_single()) {
        add_filter('wpcf7_load_js', '__return_false');
        add_filter('wpcf7_load_css', '__return_false');
    }
}
add_action('wp_enqueue_scripts', 'slatan_design_cf7_support', 5);
/**
 * ===========================================
 * WPFORMS SUPPORT
 * ===========================================
 */
function slatan_design_wpforms_support()
{
    // Modern forms styling support
    add_filter('wpforms_frontend_modern_css', '__return_true');
}
add_action('init', 'slatan_design_wpforms_support');
/**
 * ===========================================
 * JETPACK SUPPORT
 * ===========================================
 */
function slatan_design_jetpack_support()
{
    if (!class_exists('Jetpack')) {
        return;
    }
    
    // Add Jetpack features
    add_theme_support('infinite-scroll', array(
        'container' => 'main',
        'render' => 'slatan_design_infinite_scroll_render',
        'footer' => 'page',
    ));
    
    // Responsive videos
    add_theme_support('jetpack-responsive-videos');
    
    // Content options
    add_theme_support('jetpack-content-options', array(
        'post-details' => array(
            'stylesheet' => 'slatan-design-style',
            'date' => '.posted-on',
            'categories' => '.cat-links',
            'tags' => '.tags-links',
            'author' => '.byline',
        ),
        'featured-images' => array(
            'archive' => true,
            'post' => true,
            'page' => true,
        ),
    ));
}
add_action('after_setup_theme', 'slatan_design_jetpack_support');
/**
 * Jetpack Infinite Scroll render callback
 */
function slatan_design_infinite_scroll_render()
{
    while (have_posts()) {
        the_post();
        get_template_part('template-parts/content', get_post_type());
    }
}
/**
 * ===========================================
 * GRAVITY FORMS SUPPORT
 * ===========================================
 */
function slatan_design_gravity_forms_support()
{
    if (!class_exists('GFForms')) {
        return;
    }
    
    // Disable default Gravity Forms CSS (use theme styles)
    add_filter('pre_option_rg_gforms_disable_css', function () {
        return get_theme_mod('slatan_gforms_custom_css', false) ? '1' : '0';
    });
}
add_action('init', 'slatan_design_gravity_forms_support');
/**
 * ===========================================
 * WOOCOMMERCE ENHANCED SUPPORT
 * ===========================================
 */
function slatan_design_woocommerce_support()
{
    if (!class_exists('WooCommerce')) {
        return;
    }
    
    // Already added basic support in main setup, adding enhanced features
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'slatan_design_woocommerce_support');