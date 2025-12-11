<?php
/**
 * Customizer options for Performance Settings
 *
 * @package Slatan_Design
 */
if (!defined('ABSPATH')) {
    exit;
}
function slatan_design_register_performance_options($wp_customize)
{
    // Panel
    $wp_customize->add_panel('slatan_performance_panel', array(
        'priority' => 130,
        'capability' => 'edit_theme_options',
        'title' => __('Performance', 'slatan-design'),
        'description' => __('Optimize your theme for better performance.', 'slatan-design'),
    ));
    // Section: General Optimization
    $wp_customize->add_section('slatan_performance_general_section', array(
        'title' => __('General Optimization', 'slatan-design'),
        'panel' => 'slatan_performance_panel',
        'priority' => 10,
    ));
    // Disable Emoji
    $wp_customize->add_setting('slatan_disable_emoji', array(
        'default' => true,
        'sanitize_callback' => 'slatan_sanitize_checkbox',
    ));
    $wp_customize->add_control('slatan_disable_emoji_control', array(
        'label' => __('Disable WordPress Emoji', 'slatan-design'),
        'description' => __('Remove emoji scripts for faster loading (emojis will still work in modern browsers).', 'slatan-design'),
        'section' => 'slatan_performance_general_section',
        'settings' => 'slatan_disable_emoji',
        'type' => 'checkbox',
    ));
    // Remove Query Strings
    $wp_customize->add_setting('slatan_remove_query_strings', array(
        'default' => true,
        'sanitize_callback' => 'slatan_sanitize_checkbox',
    ));
    $wp_customize->add_control('slatan_remove_query_strings_control', array(
        'label' => __('Remove Query Strings', 'slatan-design'),
        'description' => __('Remove version query strings from CSS/JS files for better caching.', 'slatan-design'),
        'section' => 'slatan_performance_general_section',
        'settings' => 'slatan_remove_query_strings',
        'type' => 'checkbox',
    ));
    // Section: Security
    $wp_customize->add_section('slatan_performance_security_section', array(
        'title' => __('Security Settings', 'slatan-design'),
        'panel' => 'slatan_performance_panel',
        'priority' => 20,
    ));
    // Enable XML-RPC
    $wp_customize->add_setting('slatan_enable_xmlrpc', array(
        'default' => false,
        'sanitize_callback' => 'slatan_sanitize_checkbox',
    ));
    $wp_customize->add_control('slatan_enable_xmlrpc_control', array(
        'label' => __('Enable XML-RPC', 'slatan-design'),
        'description' => __('Enable XML-RPC for remote publishing. Disable if not needed for security.', 'slatan-design'),
        'section' => 'slatan_performance_security_section',
        'settings' => 'slatan_enable_xmlrpc',
        'type' => 'checkbox',
    ));
}
add_action('customize_register', 'slatan_design_register_performance_options');