<?php
/**
 * Customizer options for Cookie Consent
 *
 * @package Slatan_Design
 */

function slatan_design_register_cookie_consent_options($wp_customize)
{
    // Add a panel for Cookie Consent
    $wp_customize->add_panel('slatan_cookie_consent_panel', array(
        'title' => __('Cookie Consent', 'slatan-design'),
        'description' => __('Manage settings for the cookie consent banner.', 'slatan-design'),
        'priority' => 160,
    ));

    // ===================================================================================
    // SECTION: General & Content
    // ===================================================================================
    $wp_customize->add_section('slatan_cookie_content_section', array('title' => __('General & Content', 'slatan-design'), 'panel' => 'slatan_cookie_consent_panel', 'priority' => 10, ));

    $wp_customize->add_setting('slatan_cookie_consent_enable', array('default' => false, 'sanitize_callback' => 'slatan_sanitize_checkbox'));
    $wp_customize->add_control('slatan_cookie_consent_enable_control', array('label' => __('Enable Cookie Consent Banner', 'slatan-design'), 'section' => 'slatan_cookie_content_section', 'settings' => 'slatan_cookie_consent_enable', 'type' => 'checkbox'));

    $wp_customize->add_setting('slatan_cookie_consent_headline', array('default' => '', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('slatan_cookie_consent_headline_control', array('label' => __('Headline (Optional)', 'slatan-design'), 'section' => 'slatan_cookie_content_section', 'type' => 'text', 'settings' => 'slatan_cookie_consent_headline'));

    $wp_customize->add_setting('slatan_cookie_consent_text', array('default' => __('We use cookies to ensure you get the best experience on our website.', 'slatan-design'), 'sanitize_callback' => 'sanitize_textarea_field'));
    $wp_customize->add_control('slatan_cookie_consent_text_control', array('label' => __('Banner Message', 'slatan-design'), 'section' => 'slatan_cookie_content_section', 'type' => 'textarea', 'settings' => 'slatan_cookie_consent_text'));

    $wp_customize->add_setting('slatan_cookie_consent_accept_text', array('default' => __('Accept', 'slatan-design'), 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('slatan_cookie_consent_accept_text_control', array('label' => __('Accept Button Text', 'slatan-design'), 'section' => 'slatan_cookie_content_section', 'settings' => 'slatan_cookie_consent_accept_text', 'type' => 'text'));

    $wp_customize->add_setting('slatan_cookie_consent_decline_enable', array('default' => false, 'sanitize_callback' => 'slatan_sanitize_checkbox'));
    $wp_customize->add_control('slatan_cookie_consent_decline_enable_control', array('label' => __('Enable Decline Button', 'slatan-design'), 'section' => 'slatan_cookie_content_section', 'settings' => 'slatan_cookie_consent_decline_enable', 'type' => 'checkbox'));

    $wp_customize->add_setting('slatan_cookie_consent_decline_text', array('default' => __('Decline', 'slatan-design'), 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('slatan_cookie_consent_decline_text_control', array('label' => __('Decline Button Text', 'slatan-design'), 'section' => 'slatan_cookie_content_section', 'settings' => 'slatan_cookie_consent_decline_text', 'type' => 'text'));

    // Policy Link
    $wp_customize->add_setting('slatan_cookie_consent_policy_link_enable', array('default' => false, 'sanitize_callback' => 'slatan_sanitize_checkbox'));
    $wp_customize->add_control('slatan_cookie_consent_policy_link_enable_control', array('label' => __('Enable Policy Link', 'slatan-design'), 'section' => 'slatan_cookie_content_section', 'settings' => 'slatan_cookie_consent_policy_link_enable', 'type' => 'checkbox'));

    $wp_customize->add_setting('slatan_cookie_consent_policy_link_text', array('default' => __('Read More', 'slatan-design'), 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('slatan_cookie_consent_policy_link_text_control', array('label' => __('Policy Link Text', 'slatan-design'), 'section' => 'slatan_cookie_content_section', 'settings' => 'slatan_cookie_consent_policy_link_text', 'type' => 'text'));

    $wp_customize->add_setting('slatan_cookie_consent_policy_link_url', array('default' => '', 'sanitize_callback' => 'esc_url_raw'));
    $wp_customize->add_control('slatan_cookie_consent_policy_link_url_control', array('label' => __('Policy Link URL', 'slatan-design'), 'section' => 'slatan_cookie_content_section', 'settings' => 'slatan_cookie_consent_policy_link_url', 'type' => 'url'));

    // ===================================================================================
    // SECTION: Layout & Spacing
    // ===================================================================================
    $wp_customize->add_section('slatan_cookie_layout_section', array('title' => __('Layout & Spacing', 'slatan-design'), 'panel' => 'slatan_cookie_consent_panel', 'priority' => 20));

    $wp_customize->add_setting('slatan_cookie_consent_layout', array('default' => 'side-text-left', 'sanitize_callback' => 'sanitize_key'));
    $wp_customize->add_control('slatan_cookie_consent_layout_control', array('label' => __('Layout', 'slatan-design'), 'section' => 'slatan_cookie_layout_section', 'settings' => 'slatan_cookie_consent_layout', 'type' => 'select', 'choices' => array('side-text-left' => __('Side-by-Side (Text Left)', 'slatan-design'), 'side-buttons-left' => __('Side-by-Side (Buttons Left)', 'slatan-design'), 'stacked' => __('Stacked', 'slatan-design'))));

    $wp_customize->add_setting('slatan_cookie_consent_text_align', array('default' => 'left', 'sanitize_callback' => 'sanitize_key'));
    $wp_customize->add_control('slatan_cookie_consent_text_align_control', array('label' => __('Text Alignment', 'slatan-design'), 'section' => 'slatan_cookie_layout_section', 'settings' => 'slatan_cookie_consent_text_align', 'type' => 'select', 'choices' => array('left' => __('Left', 'slatan-design'), 'center' => __('Center', 'slatan-design'), 'right' => __('Right', 'slatan-design'))));

    $wp_customize->add_setting('slatan_cookie_consent_button_align', array('default' => 'right', 'sanitize_callback' => 'sanitize_key'));
    $wp_customize->add_control('slatan_cookie_consent_button_align_control', array('label' => __('Button Alignment', 'slatan-design'), 'section' => 'slatan_cookie_layout_section', 'settings' => 'slatan_cookie_consent_button_align', 'type' => 'select', 'choices' => array('left' => __('Left', 'slatan-design'), 'center' => __('Center', 'slatan-design'), 'right' => __('Right', 'slatan-design'))));

    $wp_customize->add_setting('slatan_cookie_button_order', array('default' => 'decline-first', 'sanitize_callback' => 'sanitize_key'));
    $wp_customize->add_control('slatan_cookie_button_order_control', array('label' => __('Button Order', 'slatan-design'), 'section' => 'slatan_cookie_layout_section', 'settings' => 'slatan_cookie_button_order', 'type' => 'select', 'choices' => array('decline-first' => __('Decline, then Accept', 'slatan-design'), 'accept-first' => __('Accept, then Decline', 'slatan-design'))));

    $wp_customize->add_setting('slatan_cookie_consent_position', array('default' => 'full-width-bottom', 'sanitize_callback' => 'sanitize_key'));
    $wp_customize->add_control('slatan_cookie_consent_position_control', array('label' => __('Banner Position', 'slatan-design'), 'section' => 'slatan_cookie_layout_section', 'settings' => 'slatan_cookie_consent_position', 'type' => 'select', 'choices' => array('full-width-bottom' => __('Full Width Bottom', 'slatan-design'), 'floating-left' => __('Floating Bottom Left', 'slatan-design'), 'floating-right' => __('Floating Bottom Right', 'slatan-design'))));

    $wp_customize->add_setting('slatan_cookie_banner_padding_top', array('default' => '20', 'sanitize_callback' => 'absint'));
    $wp_customize->add_control('slatan_cookie_banner_padding_top_control', array('label' => __('Banner Padding Top (px)', 'slatan-design'), 'section' => 'slatan_cookie_layout_section', 'type' => 'number', 'settings' => 'slatan_cookie_banner_padding_top'));

    $wp_customize->add_setting('slatan_cookie_banner_padding_right', array('default' => '20', 'sanitize_callback' => 'absint'));
    $wp_customize->add_control('slatan_cookie_banner_padding_right_control', array('label' => __('Banner Padding Right (px)', 'slatan-design'), 'section' => 'slatan_cookie_layout_section', 'type' => 'number', 'settings' => 'slatan_cookie_banner_padding_right'));

    $wp_customize->add_setting('slatan_cookie_banner_padding_bottom', array('default' => '20', 'sanitize_callback' => 'absint'));
    $wp_customize->add_control('slatan_cookie_banner_padding_bottom_control', array('label' => __('Banner Padding Bottom (px)', 'slatan-design'), 'section' => 'slatan_cookie_layout_section', 'type' => 'number', 'settings' => 'slatan_cookie_banner_padding_bottom'));

    $wp_customize->add_setting('slatan_cookie_banner_padding_left', array('default' => '20', 'sanitize_callback' => 'absint'));
    $wp_customize->add_control('slatan_cookie_banner_padding_left_control', array('label' => __('Banner Padding Left (px)', 'slatan-design'), 'section' => 'slatan_cookie_layout_section', 'type' => 'number', 'settings' => 'slatan_cookie_banner_padding_left'));

    $wp_customize->add_setting('slatan_cookie_button_padding_y', array('default' => '8', 'sanitize_callback' => 'absint'));
    $wp_customize->add_control('slatan_cookie_button_padding_y_control', array('label' => __('Button Padding Y (px)', 'slatan-design'), 'section' => 'slatan_cookie_layout_section', 'type' => 'number', 'settings' => 'slatan_cookie_button_padding_y'));

    $wp_customize->add_setting('slatan_cookie_button_padding_x', array('default' => '18', 'sanitize_callback' => 'absint'));
    $wp_customize->add_control('slatan_cookie_button_padding_x_control', array('label' => __('Button Padding X (px)', 'slatan-design'), 'section' => 'slatan_cookie_layout_section', 'type' => 'number', 'settings' => 'slatan_cookie_button_padding_x'));

    $wp_customize->add_setting('slatan_cookie_banner_border_radius', array('default' => '5', 'sanitize_callback' => 'absint'));
    $wp_customize->add_control('slatan_cookie_banner_border_radius_control', array('label' => __('Banner Border Radius (px)', 'slatan-design'), 'section' => 'slatan_cookie_layout_section', 'type' => 'number', 'settings' => 'slatan_cookie_banner_border_radius'));

    $wp_customize->add_setting('slatan_cookie_button_border_radius', array('default' => '5', 'sanitize_callback' => 'absint'));
    $wp_customize->add_control('slatan_cookie_button_border_radius_control', array('label' => __('Button Border Radius (px)', 'slatan-design'), 'section' => 'slatan_cookie_layout_section', 'type' => 'number', 'settings' => 'slatan_cookie_button_border_radius'));

    // ===================================================================================
    // SECTION: Color Settings
    // ===================================================================================
    $wp_customize->add_section('slatan_cookie_colors_section', array('title' => __('Color Settings', 'slatan-design'), 'panel' => 'slatan_cookie_consent_panel', 'priority' => 30));

    $wp_customize->add_setting('slatan_cookie_consent_bg_color', array('default' => '#222222', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'slatan_cookie_consent_bg_color_control', array('label' => __('Banner Background', 'slatan-design'), 'section' => 'slatan_cookie_colors_section', 'settings' => 'slatan_cookie_consent_bg_color')));

    $wp_customize->add_setting('slatan_cookie_consent_text_color', array('default' => '#ffffff', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'slatan_cookie_consent_text_color_control', array('label' => __('Banner Text Color', 'slatan-design'), 'section' => 'slatan_cookie_colors_section', 'settings' => 'slatan_cookie_consent_text_color')));

    $wp_customize->add_setting('slatan_cookie_consent_accept_bg_color', array('default' => '#0073aa', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'slatan_cookie_consent_accept_bg_color_control', array('label' => __('Accept Btn Background', 'slatan-design'), 'section' => 'slatan_cookie_colors_section', 'settings' => 'slatan_cookie_consent_accept_bg_color')));

    $wp_customize->add_setting('slatan_cookie_consent_accept_text_color', array('default' => '#ffffff', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'slatan_cookie_consent_accept_text_color_control', array('label' => __('Accept Btn Text', 'slatan-design'), 'section' => 'slatan_cookie_colors_section', 'settings' => 'slatan_cookie_consent_accept_text_color')));

    $wp_customize->add_setting('slatan_cookie_consent_accept_bg_hover_color', array('default' => '#005a87', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'slatan_cookie_consent_accept_bg_hover_color_control', array('label' => __('Accept Btn BG Hover', 'slatan-design'), 'section' => 'slatan_cookie_colors_section', 'settings' => 'slatan_cookie_consent_accept_bg_hover_color')));

    $wp_customize->add_setting('slatan_cookie_consent_accept_text_hover_color', array('default' => '#ffffff', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'slatan_cookie_consent_accept_text_hover_color_control', array('label' => __('Accept Btn Text Hover', 'slatan-design'), 'section' => 'slatan_cookie_colors_section', 'settings' => 'slatan_cookie_consent_accept_text_hover_color')));

    $wp_customize->add_setting('slatan_cookie_consent_decline_bg_color', array('default' => 'transparent', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'slatan_cookie_consent_decline_bg_color_control', array('label' => __('Decline Btn Background', 'slatan-design'), 'section' => 'slatan_cookie_colors_section', 'settings' => 'slatan_cookie_consent_decline_bg_color')));

    $wp_customize->add_setting('slatan_cookie_consent_decline_text_color', array('default' => '#ffffff', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'slatan_cookie_consent_decline_text_color_control', array('label' => __('Decline Btn Text', 'slatan-design'), 'section' => 'slatan_cookie_colors_section', 'settings' => 'slatan_cookie_consent_decline_text_color')));

    $wp_customize->add_setting('slatan_cookie_consent_decline_bg_hover_color', array('default' => '#ffffff', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'slatan_cookie_consent_decline_bg_hover_color_control', array('label' => __('Decline Btn BG Hover', 'slatan-design'), 'section' => 'slatan_cookie_colors_section', 'settings' => 'slatan_cookie_consent_decline_bg_hover_color')));

    $wp_customize->add_setting('slatan_cookie_consent_decline_text_hover_color', array('default' => '#222222', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'slatan_cookie_consent_decline_text_hover_color_control', array('label' => __('Decline Btn Text Hover', 'slatan-design'), 'section' => 'slatan_cookie_colors_section', 'settings' => 'slatan_cookie_consent_decline_text_hover_color')));

    // ===================================================================================
    // SECTION: Revoke Button Settings
    // ===================================================================================
    $wp_customize->add_section('slatan_cookie_revoke_section', array('title' => __('Revoke Button Settings', 'slatan-design'), 'panel' => 'slatan_cookie_consent_panel', 'priority' => 40));

    $wp_customize->add_setting('slatan_revoke_button_enable', array('default' => true, 'sanitize_callback' => 'slatan_sanitize_checkbox'));
    $wp_customize->add_control('slatan_revoke_button_enable_control', array('label' => __('Enable Revoke Button', 'slatan-design'), 'description' => __('Show a button to re-open the consent banner.', 'slatan-design'), 'section' => 'slatan_cookie_revoke_section', 'settings' => 'slatan_revoke_button_enable', 'type' => 'checkbox'));

    $wp_customize->add_setting('slatan_revoke_button_fa_class', array('default' => 'fas fa-cookie-bite', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('slatan_revoke_button_fa_class_control', array(
        'label' => __('Font Awesome Class', 'slatan-design'),
        'description' => __('e.g., "fas fa-cookie-bite" or "fas fa-cog"', 'slatan-design'),
        'section' => 'slatan_cookie_revoke_section',
        'settings' => 'slatan_revoke_button_fa_class',
        'type' => 'text'
    ));

    $wp_customize->add_setting('slatan_revoke_button_custom_icon', array('default' => '', 'sanitize_callback' => 'esc_url_raw'));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'slatan_revoke_button_custom_icon_control', array('label' => __('Custom Icon (SVG/Image)', 'slatan-design'), 'description' => __('Upload to override Font Awesome icon.', 'slatan-design'), 'section' => 'slatan_cookie_revoke_section', 'settings' => 'slatan_revoke_button_custom_icon')));

    $wp_customize->add_setting('slatan_revoke_button_position', array('default' => 'bottom-left', 'sanitize_callback' => 'sanitize_key'));
    $wp_customize->add_control('slatan_revoke_button_position_control', array('label' => __('Button Position', 'slatan-design'), 'section' => 'slatan_cookie_revoke_section', 'settings' => 'slatan_revoke_button_position', 'type' => 'select', 'choices' => array('bottom-left' => __('Bottom Left', 'slatan-design'), 'bottom-right' => __('Bottom Right', 'slatan-design'), 'top-left' => __('Top Left', 'slatan-design'), 'top-right' => __('Top Right', 'slatan-design'))));

    $wp_customize->add_setting('slatan_revoke_button_bg_color', array('default' => '#333333', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'slatan_revoke_button_bg_color_control', array('label' => __('Button Background Color', 'slatan-design'), 'section' => 'slatan_cookie_revoke_section', 'settings' => 'slatan_revoke_button_bg_color')));

    $wp_customize->add_setting('slatan_revoke_button_icon_color', array('default' => '#ffffff', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'slatan_revoke_button_icon_color_control', array('label' => __('Icon Color', 'slatan-design'), 'section' => 'slatan_cookie_revoke_section', 'settings' => 'slatan_revoke_button_icon_color')));

    $wp_customize->add_setting('slatan_revoke_button_offset_bottom', array('default' => '20', 'sanitize_callback' => 'absint'));
    $wp_customize->add_control('slatan_revoke_button_offset_bottom_control', array('label' => __('Bottom Offset (px)', 'slatan-design'), 'section' => 'slatan_cookie_revoke_section', 'type' => 'number', 'settings' => 'slatan_revoke_button_offset_bottom'));

    $wp_customize->add_setting('slatan_revoke_button_offset_side', array('default' => '20', 'sanitize_callback' => 'absint'));
    $wp_customize->add_control('slatan_revoke_button_offset_side_control', array('label' => __('Side Offset (px)', 'slatan-design'), 'description' => __('Distance from Left or Right edge.', 'slatan-design'), 'section' => 'slatan_cookie_revoke_section', 'type' => 'number', 'settings' => 'slatan_revoke_button_offset_side'));
}
add_action('customize_register', 'slatan_design_register_cookie_consent_options');