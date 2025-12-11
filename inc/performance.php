<?php
/**
 * Performance Optimizations
 *
 * @package Slatan_Design
 */
if (!defined('ABSPATH')) {
    exit;
}
/**
 * Add resource hints for faster loading
 */
function slatan_design_resource_hints($hints, $relation_type)
{
    if ('preconnect' === $relation_type) {
        // Google Fonts (if used)
        $hints[] = array(
            'href' => 'https://fonts.googleapis.com',
            'crossorigin' => 'anonymous',
        );
        $hints[] = array(
            'href' => 'https://fonts.gstatic.com',
            'crossorigin' => 'anonymous',
        );
        
        // Font Awesome CDN (if used)
        if (get_theme_mod('slatan_fc_load_fontawesome', true)) {
            $hints[] = array(
                'href' => 'https://cdnjs.cloudflare.com',
                'crossorigin' => 'anonymous',
            );
        }
    }
    
    return $hints;
}
add_filter('wp_resource_hints', 'slatan_design_resource_hints', 10, 2);
/**
 * Defer non-critical JavaScript
 */
function slatan_design_defer_scripts($tag, $handle, $src)
{
    // Scripts to defer
    $defer_scripts = array(
        'comment-reply',
    );
    
    // Scripts to async
    $async_scripts = array(
        'font-awesome',
    );
    
    if (in_array($handle, $defer_scripts)) {
        return str_replace(' src=', ' defer src=', $tag);
    }
    
    if (in_array($handle, $async_scripts)) {
        return str_replace(' src=', ' async src=', $tag);
    }
    
    return $tag;
}
add_filter('script_loader_tag', 'slatan_design_defer_scripts', 10, 3);
/**
 * Preload critical assets
 */
function slatan_design_preload_assets()
{
    // Preload main stylesheet
    echo '<link rel="preload" href="' . esc_url(get_stylesheet_uri()) . '" as="style">' . "\n";
    
    // Preload Font Awesome if enabled - but only the CSS file
    if (get_theme_mod('slatan_fc_load_fontawesome', true) && get_theme_mod('slatan_fc_enable', false)) {
        echo '<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" as="style" crossorigin="anonymous">' . "\n";
    }
}
add_action('wp_head', 'slatan_design_preload_assets', 1);
/**
 * Remove unnecessary resources
 */
function slatan_design_cleanup_head()
{
    // Remove emoji scripts if not needed
    if (get_theme_mod('slatan_disable_emoji', true)) {
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_styles', 'print_emoji_styles');
        remove_filter('the_content_feed', 'wp_staticize_emoji');
        remove_filter('comment_text_rss', 'wp_staticize_emoji');
        remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
        
        // Remove TinyMCE emojis
        add_filter('tiny_mce_plugins', function ($plugins) {
            return is_array($plugins) ? array_diff($plugins, array('wpemoji')) : array();
        });
        
        // Remove emoji CDN hostname from DNS prefetching hints
        add_filter('wp_resource_hints', function ($urls, $relation_type) {
            if ('dns-prefetch' === $relation_type) {
                $urls = array_filter($urls, function ($url) {
                    return strpos($url, 'https://s.w.org/images/core/emoji/') === false;
                });
            }
            return $urls;
        }, 10, 2);
    }
    
    // Remove query strings from static resources
    if (get_theme_mod('slatan_remove_query_strings', true)) {
        add_filter('script_loader_src', 'slatan_design_remove_query_strings', 15, 1);
        add_filter('style_loader_src', 'slatan_design_remove_query_strings', 15, 1);
    }
    
    // Remove unnecessary meta tags
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
}
add_action('init', 'slatan_design_cleanup_head');
/**
 * Remove query strings from static resources
 */
function slatan_design_remove_query_strings($src)
{
    if (strpos($src, '?ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
/**
 * Add loading="lazy" to content images automatically
 * (WordPress 5.5+ has native support, but we ensure it for older images)
 */
function slatan_design_lazy_load_images($content)
{
    // Skip if already has loading attribute
    if (strpos($content, 'loading=') !== false) {
        return $content;
    }
    
    // Add loading="lazy" to img tags that don't have it
    $content = preg_replace(
        '/<img((?!loading)[^>]*?)(\s?)(\/?)\s*>/i',
        '<img$1 loading="lazy"$2$3>',
        $content
    );
    
    return $content;
}
add_filter('the_content', 'slatan_design_lazy_load_images');
add_filter('post_thumbnail_html', 'slatan_design_lazy_load_images');
/**
 * Optimize WooCommerce if active
 */
function slatan_design_optimize_woocommerce()
{
    if (!class_exists('WooCommerce')) {
        return;
    }
    
    // Disable WooCommerce scripts on non-WooCommerce pages
    if (!is_woocommerce() && !is_cart() && !is_checkout() && !is_account_page()) {
        wp_dequeue_style('woocommerce-layout');
        wp_dequeue_style('woocommerce-smallscreen');
        wp_dequeue_style('woocommerce-general');
        wp_dequeue_script('wc-cart-fragments');
    }
}
add_action('wp_enqueue_scripts', 'slatan_design_optimize_woocommerce', 99);
/**
 * Add fetchpriority="high" to LCP image (hero/featured image)
 */
function slatan_design_lcp_image_priority($attr, $attachment, $size)
{
    // Add fetchpriority to featured images on single posts/pages
    if (is_singular() && has_post_thumbnail() && get_post_thumbnail_id() === $attachment->ID) {
        $attr['fetchpriority'] = 'high';
        $attr['loading'] = 'eager'; // Don't lazy load LCP image
    }
    
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'slatan_design_lcp_image_priority', 10, 3);