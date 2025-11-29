<?php
/**
 * Additional Theme Support Features
 * 
 * This file adds recommended WordPress features to improve theme compatibility
 * and user experience without affecting existing functionality.
 *
 * @package Slatan_Design
 */

if (!defined('ABSPATH')) {
    exit;
}





/**
 * Add Editor Styles
 */
function slatan_design_add_editor_styles()
{
    // Add editor stylesheet
    add_editor_style('css/editor-style.css');
}
add_action('after_setup_theme', 'slatan_design_add_editor_styles');

/**
 * Register Block Styles
 * Add custom styling variations for core blocks
 */
function slatan_design_register_block_styles()
{
    // Check if function exists (WordPress 5.3+)
    if (!function_exists('register_block_style')) {
        return;
    }

    // Register a custom style for the paragraph block
    register_block_style(
        'core/paragraph',
        array(
            'name' => 'slatan-highlight',
            'label' => __('Highlight', 'slatan-design'),
        )
    );

    // Register a custom style for the button block
    register_block_style(
        'core/button',
        array(
            'name' => 'slatan-outline',
            'label' => __('Outline', 'slatan-design'),
        )
    );

    // Register a custom style for the quote block
    register_block_style(
        'core/quote',
        array(
            'name' => 'slatan-modern',
            'label' => __('Modern', 'slatan-design'),
        )
    );

    // Register a custom style for the group block
    register_block_style(
        'core/group',
        array(
            'name' => 'slatan-card',
            'label' => __('Card', 'slatan-design'),
        )
    );
}
add_action('init', 'slatan_design_register_block_styles');

/**
 * Register Block Patterns
 * Add custom block patterns for common layouts
 */
function slatan_design_register_block_patterns()
{
    // Check if functions exist (WordPress 5.5+)
    if (!function_exists('register_block_pattern_category') || !function_exists('register_block_pattern')) {
        return;
    }

    // Register a pattern category
    register_block_pattern_category(
        'slatan-design',
        array('label' => __('Slatan Design', 'slatan-design'))
    );

    // Register a simple call-to-action pattern
    register_block_pattern(
        'slatan-design/cta-box',
        array(
            'title' => __('Call to Action Box', 'slatan-design'),
            'description' => __('A simple call-to-action box with heading, text and button', 'slatan-design'),
            'categories' => array('slatan-design'),
            'content' => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|50","right":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50"}}},"backgroundColor":"light-gray","className":"slatan-cta-box"} -->
<div class="wp-block-group slatan-cta-box has-light-gray-background-color has-background" style="padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50)"><!-- wp:heading {"textAlign":"center"} -->
<h2 class="has-text-align-center">' . __('Ready to Get Started?', 'slatan-design') . '</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">' . __('Join thousands of satisfied customers today.', 'slatan-design') . '</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button">' . __('Get Started', 'slatan-design') . '</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->',
        )
    );

    // Register a two-column feature pattern
    register_block_pattern(
        'slatan-design/two-columns-features',
        array(
            'title' => __('Two Columns Features', 'slatan-design'),
            'description' => __('Two columns layout for displaying features', 'slatan-design'),
            'categories' => array('slatan-design'),
            'content' => '<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3>' . __('Feature One', 'slatan-design') . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>' . __('Describe your amazing feature here.', 'slatan-design') . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3>' . __('Feature Two', 'slatan-design') . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>' . __('Describe your amazing feature here.', 'slatan-design') . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->',
        )
    );
}
add_action('init', 'slatan_design_register_block_patterns');
