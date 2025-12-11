<?php
/**
 * Frontend functionality for Custom Code
 *
 * @package Slatan_Design
 */

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly.

/**
 * This is our new "loader" function.
 * It waits until WordPress is fully loaded, gets the priorities from the Customizer,
 * and *then* adds the actions with the correct dynamic priority.
 */
function slatan_design_hook_custom_code()
{

    // 1. Get Head Code
    $head_code = get_theme_mod('slatan_custom_code_head');
    if (!empty($head_code)) {
        $priority = get_theme_mod('slatan_custom_code_head_priority', 999);
        add_action('wp_head', 'slatan_design_output_custom_code_head', intval($priority));
    }

    // 2. Get Body Start Code
    $body_start_code = get_theme_mod('slatan_custom_code_body_start');
    if (!empty($body_start_code)) {
        $priority = get_theme_mod('slatan_custom_code_body_start_priority', 1);
        add_action('wp_body_open', 'slatan_design_output_custom_code_body_start', intval($priority));
    }
    // 3. Get Body End Code
    $body_end_code = get_theme_mod('slatan_custom_code_body_end');
    if (!empty($body_end_code)) {
        $priority = get_theme_mod('slatan_custom_code_body_end_priority', 999);
        add_action('wp_footer', 'slatan_design_output_custom_code_body_end', intval($priority));
    }
}
// We hook this function to 'wp' to ensure get_theme_mod() has the correct values.
add_action('wp', 'slatan_design_hook_custom_code');


/**
 * Check if custom code should render based on consent requirement
 * 
 * @param string $section The section to check ('head', 'body_start', or 'body_end')
 * @return bool Whether the code should render
 */
function slatan_should_render_custom_code($section = '')
{
    // Check if this specific section requires consent
    $require_consent = get_theme_mod('slatan_custom_code_' . $section . '_require_consent', false);

    // If consent is not required for this section, always render
    if (!$require_consent) {
        return true;
    }

    // If consent is required, check if cookie consent is accepted
    if (isset($_COOKIE['slatan_cookie_consent']) && 'accepted' === $_COOKIE['slatan_cookie_consent']) {
        return true;
    }

    return false;
}

/**
 * Get allowed HTML tags for custom code sections
 * 
 * @return array Allowed HTML tags and attributes
 */
function slatan_get_custom_code_allowed_tags()
{
    $allowed_tags = wp_kses_allowed_html('post');

    // Add script tags for tracking codes, analytics, etc.
    $allowed_tags['script'] = array(
        'type' => true,
        'src' => true,
        'async' => true,
        'defer' => true,
        'charset' => true,
        'crossorigin' => true,
        'integrity' => true,
    );

    // Add style tags for custom CSS
    $allowed_tags['style'] = array(
        'type' => true,
        'media' => true,
    );

    // Add link tags for external stylesheets
    $allowed_tags['link'] = array(
        'rel' => true,
        'type' => true,
        'href' => true,
        'media' => true,
        'crossorigin' => true,
        'integrity' => true,
    );

    // Add meta tags for SEO and social media
    $allowed_tags['meta'] = array(
        'name' => true,
        'content' => true,
        'property' => true,
        'charset' => true,
        'http-equiv' => true,
    );

    // Add iframe for embeds (YouTube, Google Maps, etc.)
    $allowed_tags['iframe'] = array(
        'src' => true,
        'width' => true,
        'height' => true,
        'frameborder' => true,
        'allowfullscreen' => true,
        'allow' => true,
        'loading' => true,
        'title' => true,
        'class' => true,
        'id' => true,
        'style' => true,
    );

    // Add noscript tag
    $allowed_tags['noscript'] = array();

    return $allowed_tags;
}

/**
 * Output function for <head> code
 * This function outputs custom code with proper escaping while allowing necessary HTML tags.
 */
function slatan_design_output_custom_code_head()
{
    if (slatan_should_render_custom_code('head')) {
        $custom_code = get_theme_mod('slatan_custom_code_head');
        if (!empty($custom_code)) {
            echo wp_kses($custom_code, slatan_get_custom_code_allowed_tags());
        }
    }
}

/**
 * Output function for <body> start code
 */
function slatan_design_output_custom_code_body_start()
{
    if (slatan_should_render_custom_code('body_start')) {
        $custom_code = get_theme_mod('slatan_custom_code_body_start');
        if (!empty($custom_code)) {
            echo wp_kses($custom_code, slatan_get_custom_code_allowed_tags());
        }
    }
}

/**
 * Output function for <body> end code
 */
function slatan_design_output_custom_code_body_end()
{
    if (slatan_should_render_custom_code('body_end')) {
        $custom_code = get_theme_mod('slatan_custom_code_body_end');
        if (!empty($custom_code)) {
            echo wp_kses($custom_code, slatan_get_custom_code_allowed_tags());
        }
    }
}

/**
 * Output Custom CSS
 */
function slatan_design_output_custom_css()
{
    $custom_css = get_theme_mod('slatan_custom_css', '');

    if (empty($custom_css)) {
        return;
    }

    // Minify if enabled
    if (get_theme_mod('slatan_custom_css_minify', true)) {
        $custom_css = slatan_minify_css($custom_css);
    }

    // Security: Escape closing style tags to prevent injection
    $safe_css = str_replace('</style', '<\/style', $custom_css);
    echo '<style id="slatan-custom-css">' . $safe_css . '</style>' . "\n";
}
add_action('wp_head', 'slatan_design_output_custom_css', 100);
/**
 * Simple CSS Minifier
 */
function slatan_minify_css($css)
{
    // Remove comments
    $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);

    // Remove whitespace
    $css = preg_replace('/\s+/', ' ', $css);

    // Remove spaces around selectors and properties
    $css = preg_replace('/\s*([{}:;,>+~])\s*/', '$1', $css);

    // Remove trailing semicolon before closing brace
    $css = str_replace(';}', '}', $css);

    return trim($css);
}
/**
 * Output Custom JavaScript
 */
function slatan_design_output_custom_js()
{
    // Check consent if required
    if (get_theme_mod('slatan_custom_js_require_consent', false)) {
        // Check if cookie consent is required and if user has consented
        $consent_enabled = get_theme_mod('slatan_cookie_consent_enable', false);
        if ($consent_enabled) {
            // If consent is required but not given, skip
            if (!isset($_COOKIE['slatan_cookie_consent']) || $_COOKIE['slatan_cookie_consent'] !== 'accepted') {
                return;
            }
        }
    }

    $custom_js = get_theme_mod('slatan_custom_js', '');

    if (empty($custom_js)) {
        return;
    }

    $defer = get_theme_mod('slatan_custom_js_defer', true);

    // Security: Escape closing script tags to prevent injection
    $safe_js = str_replace('</script', '<\/script', $custom_js);

    // Output inline script - use DOMContentLoaded for defer (defer doesn't work on inline scripts)
    echo '<script id="slatan-custom-js">' . "\n";
    if ($defer) {
        echo 'document.addEventListener("DOMContentLoaded", function() {' . "\n";
    }
    echo $safe_js;
    if ($defer) {
        echo "\n});";
    }
    echo "\n</script>\n";
}
// Hook based on location setting
function slatan_design_hook_custom_js()
{
    $location = get_theme_mod('slatan_custom_js_location', 'footer');

    if ($location === 'header') {
        add_action('wp_head', 'slatan_design_output_custom_js', 999);
    } else {
        add_action('wp_footer', 'slatan_design_output_custom_js', 999);
    }
}
add_action('init', 'slatan_design_hook_custom_js');
/**
 * Live preview for Custom CSS in Customizer
 */
function slatan_customizer_custom_css_preview()
{
    ?>
    <script>
        (function ($) {
            wp.customize('slatan_custom_css', function (value) {
                value.bind(function (newval) {
                    var $style = $('#slatan-custom-css');
                    if ($style.length === 0) {
                        $('head').append('<style id="slatan-custom-css"></style>');
                        $style = $('#slatan-custom-css');
                    }
                    $style.html(newval);
                });
            });
        })(jQuery);
    </script>
    <?php
}
add_action('customize_preview_init', function () {
    add_action('wp_footer', 'slatan_customizer_custom_css_preview', 999);
});