<?php
/**
 * Slatan Design functions and definitions
 *
 * @package Slatan_Design
 */

if (!defined('ABSPATH')) {
	exit;
} // Exit if accessed directly.

if (!defined('_S_VERSION')) {
	define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function slatan_design_setup()
{
	load_theme_textdomain('slatan-design', get_template_directory() . '/languages');
	add_theme_support('automatic-feed-links');
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');

	// Menus
	register_nav_menus(
		array(
			'menu-1' => esc_html__('Primary', 'slatan-design'),
		)
	);

	// HTML5 Support
	add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'));

	// Gutenberg Support
	add_theme_support('align-wide');
	add_theme_support('responsive-embeds');
	add_theme_support('wp-block-styles');

	// Custom Logo
	add_theme_support('custom-logo', array(
		'height' => 250,
		'width' => 250,
		'flex-width' => true,
		'flex-height' => true,
	));

	add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'slatan_design_setup');

/**
 * Register widget area.
 */
function slatan_design_widgets_init()
{
	register_sidebar(
		array(
			'name' => esc_html__('Sidebar', 'slatan-design'),
			'id' => 'sidebar-1',
			'description' => esc_html__('Add widgets here.', 'slatan-design'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		)
	);
}
add_action('widgets_init', 'slatan_design_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function slatan_design_scripts()
{
	wp_enqueue_style('slatan-design-style', get_stylesheet_uri(), array(), _S_VERSION);

	// Enqueue Font Awesome CDN (if enabled in Floating Contact settings)
	if (get_theme_mod('slatan_fc_load_fontawesome', true)) {
		wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css', array(), '6.5.1');
	}

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'slatan_design_scripts');

/**
 * Include Customizer options.
 */
require get_template_directory() . '/inc/customizer/cookie-consent-options.php';
require get_template_directory() . '/inc/customizer/floating-contact-options.php';
require get_template_directory() . '/inc/customizer/custom-code-options.php';

/**
 * Include Theme Support features.
 */
require get_template_directory() . '/inc/theme-support.php';

/**
 * Include Page Builder Support.
 */
require get_template_directory() . '/inc/page-builder-support.php';

/**
 * Include Frontend features.
 */
require get_template_directory() . '/inc/frontend/cookie-consent-frontend.php';
require get_template_directory() . '/inc/frontend/floating-contact-frontend.php';
require get_template_directory() . '/inc/frontend/custom-code-frontend.php';

/**
 * Allow SVG uploads for admins.
 */
function slatan_design_allow_svg_upload($mimes)
{
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'slatan_design_allow_svg_upload');

/**
 * Centralized Sanitization callback for checkbox.
 */
function slatan_sanitize_checkbox($checked)
{
	return ((isset($checked) && true === $checked) ? true : false);
}

/**
 * Sanitization callback for raw HTML/JS/CSS.
 * Used for Custom Code options where users need to input scripts.
 */
function slatan_sanitize_raw_html($input)
{
	return $input; // Allow everything, including <script> tags.
}

/**
 * Enqueue scripts and styles for the Customizer.
 * (This function is ESSENTIAL for loading admin-customizer.css)
 */
function slatan_design_customizer_scripts()
{
	wp_enqueue_style(
		'slatan-admin-customizer-css',
		get_template_directory_uri() . '/css/admin-customizer.css',
		array(),
		_S_VERSION
	);
}
add_action('customize_controls_enqueue_scripts', 'slatan_design_customizer_scripts');

/**
 * GitHub Theme Updater
 */
require get_template_directory() . '/inc/updater/class-theme-updater.php';

function slatan_design_updater_init()
{
	// EDIT HERE: Replace with your GitHub username and repository name
	$updater = new Slatan_Theme_Updater(
		'meennnwork-pixel', // GitHub Username
		'Slatan-Design-Theme',       // Repository Name
		'slatan-design'         // Theme Slug (must match folder name)
	);
}
add_action('after_setup_theme', 'slatan_design_updater_init');