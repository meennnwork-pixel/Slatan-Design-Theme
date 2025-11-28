<?php
/**
 * Customizer options for Custom Code
 *
 * @package Slatan_Design
 */

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly.

function slatan_design_register_custom_code_options($wp_customize)
{

    // 1. ตรวจสอบว่ามี WP_Customize_Code_Editor_Control หรือไม่ (สำหรับ WP 4.9+)
    if (!class_exists('WP_Customize_Code_Editor_Control')) {
        return;
    }

    // ===================================================================================
    // PANEL: CUSTOM CODE
    // ===================================================================================
    $wp_customize->add_panel('slatan_custom_code_panel', array(
        'priority' => 120, // ให้แสดงต่อจาก Floating Contact
        'capability' => 'edit_theme_options',
        'title' => __('Custom Code', 'slatan-design'),
        'description' => __('Add tracking codes or other snippets to your site.', 'slatan-design'),
    ));

    // --- SECTION: Head Code ---
    $wp_customize->add_section('slatan_code_head_section', array(
        'title' => __('Head Code', 'slatan-design'),
        'panel' => 'slatan_custom_code_panel',
        'priority' => 10,
        'description' => __('Code added here will be injected before the closing </head> tag.', 'slatan-design'),
    ));

    $wp_customize->add_setting('slatan_custom_code_head', array(
        'default' => '',
        'transport' => 'postMessage',
        'capability' => 'unfiltered_html',
        'sanitize_callback' => 'slatan_sanitize_raw_html',
    ));

    $wp_customize->add_control(new WP_Customize_Code_Editor_Control($wp_customize, 'slatan_custom_code_head_control', array(
        'label' => __('Code in <head>', 'slatan-design'),
        'section' => 'slatan_code_head_section',
        'settings' => 'slatan_custom_code_head',
        'code_type' => 'text/html',
        'priority' => 10,
    )));

    // Consent checkbox for head code
    $wp_customize->add_setting('slatan_custom_code_head_require_consent', array(
        'default' => false,
        'sanitize_callback' => 'slatan_sanitize_checkbox'
    ));
    $wp_customize->add_control('slatan_custom_code_head_require_consent_control', array(
        'label' => __('Require Cookie Consent', 'slatan-design'),
        'description' => __('Only load this code if user accepts cookies (useful for analytics/tracking).', 'slatan-design'),
        'section' => 'slatan_code_head_section',
        'settings' => 'slatan_custom_code_head_require_consent',
        'type' => 'checkbox',
        'priority' => 15,
    ));

    $wp_customize->add_setting('slatan_custom_code_head_priority', array('default' => '999', 'sanitize_callback' => 'absint'));
    $wp_customize->add_control('slatan_custom_code_head_priority_control', array(
        'label' => __('Head Code Priority', 'slatan-design'),
        'description' => __('Default: 999 (loads late). Use a lower number (e.g., 1) to load earlier.', 'slatan-design'),
        'section' => 'slatan_code_head_section',
        'settings' => 'slatan_custom_code_head_priority',
        'type' => 'number',
        'priority' => 20,
    ));

    // --- SECTION: Body Start Code ---
    $wp_customize->add_section('slatan_code_body_start_section', array(
        'title' => __('Body Start Code', 'slatan-design'),
        'panel' => 'slatan_custom_code_panel',
        'priority' => 20,
        'description' => __('Code added here will be injected immediately after the opening <body> tag.', 'slatan-design'),
    ));

    $wp_customize->add_setting('slatan_custom_code_body_start', array(
        'default' => '',
        'transport' => 'postMessage',
        'capability' => 'unfiltered_html',
        'sanitize_callback' => 'slatan_sanitize_raw_html',
    ));

    $wp_customize->add_control(new WP_Customize_Code_Editor_Control($wp_customize, 'slatan_custom_code_body_start_control', array(
        'label' => __('Code after <body> start', 'slatan-design'),
        'section' => 'slatan_code_body_start_section',
        'settings' => 'slatan_custom_code_body_start',
        'code_type' => 'text/html',
        'priority' => 10,
    )));

    // Consent checkbox for body start code
    $wp_customize->add_setting('slatan_custom_code_body_start_require_consent', array(
        'default' => false,
        'sanitize_callback' => 'slatan_sanitize_checkbox'
    ));
    $wp_customize->add_control('slatan_custom_code_body_start_require_consent_control', array(
        'label' => __('Require Cookie Consent', 'slatan-design'),
        'description' => __('Only load this code if user accepts cookies (useful for analytics/tracking).', 'slatan-design'),
        'section' => 'slatan_code_body_start_section',
        'settings' => 'slatan_custom_code_body_start_require_consent',
        'type' => 'checkbox',
        'priority' => 15,
    ));

    $wp_customize->add_setting('slatan_custom_code_body_start_priority', array('default' => '1', 'sanitize_callback' => 'absint'));
    $wp_customize->add_control('slatan_custom_code_body_start_priority_control', array(
        'label' => __('Body Start Priority', 'slatan-design'),
        'description' => __('Default: 1 (loads very early).', 'slatan-design'),
        'section' => 'slatan_code_body_start_section',
        'settings' => 'slatan_custom_code_body_start_priority',
        'type' => 'number',
        'priority' => 20,
    ));

    // --- SECTION: Body End Code ---
    $wp_customize->add_section('slatan_code_body_end_section', array(
        'title' => __('Body End Code', 'slatan-design'),
        'panel' => 'slatan_custom_code_panel',
        'priority' => 30,
        'description' => __('Code added here will be injected before the closing </body> tag.', 'slatan-design'),
    ));

    $wp_customize->add_setting('slatan_custom_code_body_end', array(
        'default' => '',
        'transport' => 'postMessage',
        'capability' => 'unfiltered_html',
        'sanitize_callback' => 'slatan_sanitize_raw_html',
    ));

    $wp_customize->add_control(new WP_Customize_Code_Editor_Control($wp_customize, 'slatan_custom_code_body_end_control', array(
        'label' => __('Code before </body> end', 'slatan-design'),
        'section' => 'slatan_code_body_end_section',
        'settings' => 'slatan_custom_code_body_end',
        'code_type' => 'text/html',
        'priority' => 10,
    )));

    // Consent checkbox for body end code
    $wp_customize->add_setting('slatan_custom_code_body_end_require_consent', array(
        'default' => false,
        'sanitize_callback' => 'slatan_sanitize_checkbox'
    ));
    $wp_customize->add_control('slatan_custom_code_body_end_require_consent_control', array(
        'label' => __('Require Cookie Consent', 'slatan-design'),
        'description' => __('Only load this code if user accepts cookies (useful for analytics/tracking).', 'slatan-design'),
        'section' => 'slatan_code_body_end_section',
        'settings' => 'slatan_custom_code_body_end_require_consent',
        'type' => 'checkbox',
        'priority' => 15,
    ));

    $wp_customize->add_setting('slatan_custom_code_body_end_priority', array('default' => '999', 'sanitize_callback' => 'absint'));
    $wp_customize->add_control('slatan_custom_code_body_end_priority_control', array(
        'label' => __('Body End Priority', 'slatan-design'),
        'description' => __('Default: 999 (loads late).', 'slatan-design'),
        'section' => 'slatan_code_body_end_section',
        'settings' => 'slatan_custom_code_body_end_priority',
        'type' => 'number',
        'priority' => 20,
    ));
}
add_action('customize_register', 'slatan_design_register_custom_code_options', 20);