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
require get_template_directory() . '/inc/customizer/header-display-options.php';

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
 * Add meta box for page title visibility
 */
function slatan_design_add_page_title_meta_box()
{
	add_meta_box(
		'slatan_page_title_visibility',
		__('Page Title Display', 'slatan-design'),
		'slatan_design_page_title_meta_box_callback',
		'page',
		'side',
		'default'
	);
}
add_action('add_meta_boxes', 'slatan_design_add_page_title_meta_box');

/**
 * Meta box callback
 */
function slatan_design_page_title_meta_box_callback($post)
{
	wp_nonce_field('slatan_page_title_meta_box', 'slatan_page_title_meta_box_nonce');
	$value = get_post_meta($post->ID, '_slatan_show_page_title', true);
	$default = get_theme_mod('slatan_show_page_title_default', true);

	// If value is empty string, it means not set yet, use default
	$checked = ($value === '') ? $default : $value;
	?>
	<label>
		<input type="checkbox" name="slatan_show_page_title" value="1" <?php checked($checked, 1); ?>>
		<?php _e('Show page title', 'slatan-design'); ?>
	</label>
	<p class="description">
		<?php _e('Uncheck to hide the page title. Useful for page builder pages.', 'slatan-design'); ?>
	</p>
	<?php
}

/**
 * Save meta box data
 */
function slatan_design_save_page_title_meta_box($post_id)
{
	if (!isset($_POST['slatan_page_title_meta_box_nonce'])) {
		return;
	}
	if (!wp_verify_nonce($_POST['slatan_page_title_meta_box_nonce'], 'slatan_page_title_meta_box')) {
		return;
	}
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}
	if (!current_user_can('edit_post', $post_id)) {
		return;
	}

	$value = isset($_POST['slatan_show_page_title']) ? 1 : 0;
	update_post_meta($post_id, '_slatan_show_page_title', $value);
}
add_action('save_post', 'slatan_design_save_page_title_meta_box');

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