<?php
/**
 * Customizer options for Header Display Controls
 *
 * @package Slatan_Design
 */

if (!defined('ABSPATH')) {
    exit;
}

function slatan_design_register_header_display_options($wp_customize)
{
    // Panel
    $wp_customize->add_panel('slatan_header_display_panel', array(
        'priority' => 105,
        'capability' => 'edit_theme_options',
        'title' => __('Header Display', 'slatan-design'),
        'description' => __('Control visibility of header elements. Perfect for page builder pages.', 'slatan-design'),
    ));

    // Section: Header Elements
    $wp_customize->add_section('slatan_header_elements_section', array(
        'title' => __('Header Elements', 'slatan-design'),
        'panel' => 'slatan_header_display_panel',
        'priority' => 10,
    ));

    // Show Site Title
    $wp_customize->add_setting('slatan_show_site_title', array(
        'default' => true,
        'sanitize_callback' => 'slatan_sanitize_checkbox',
    ));
    $wp_customize->add_control('slatan_show_site_title_control', array(
        'label' => __('Show Site Title', 'slatan-design'),
        'description' => __('Display the site title in the header.', 'slatan-design'),
        'section' => 'slatan_header_elements_section',
        'settings' => 'slatan_show_site_title',
        'type' => 'checkbox',
    ));

    // Show Site Description
    $wp_customize->add_setting('slatan_show_site_description', array(
        'default' => true,
        'sanitize_callback' => 'slatan_sanitize_checkbox',
    ));
    $wp_customize->add_control('slatan_show_site_description_control', array(
        'label' => __('Show Site Description', 'slatan-design'),
        'description' => __('Display the site tagline/description in the header.', 'slatan-design'),
        'section' => 'slatan_header_elements_section',
        'settings' => 'slatan_show_site_description',
        'type' => 'checkbox',
    ));

    // Show Navigation Menu
    $wp_customize->add_setting('slatan_show_navigation', array(
        'default' => true,
        'sanitize_callback' => 'slatan_sanitize_checkbox',
    ));
    $wp_customize->add_control('slatan_show_navigation_control', array(
        'label' => __('Show Navigation Menu', 'slatan-design'),
        'description' => __('Display the primary navigation menu in the header.', 'slatan-design'),
        'section' => 'slatan_header_elements_section',
        'settings' => 'slatan_show_navigation',
        'type' => 'checkbox',
    ));

    // Default Page Title Visibility
    $wp_customize->add_setting('slatan_show_page_title_default', array(
        'default' => true,
        'sanitize_callback' => 'slatan_sanitize_checkbox',
    ));
    $wp_customize->add_control('slatan_show_page_title_default_control', array(
        'label' => __('Show Page Titles by Default', 'slatan-design'),
        'description' => __('Default visibility for page titles. Can be overridden per-page in the page editor.', 'slatan-design'),
        'section' => 'slatan_header_elements_section',
        'settings' => 'slatan_show_page_title_default',
        'type' => 'checkbox',
    ));
}
add_action('customize_register', 'slatan_design_register_header_display_options');
