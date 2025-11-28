<?php
/**
 * Customizer options for Floating Contact
 *
 * @package Slatan_Design
 */

if (!defined('ABSPATH')) {
	exit;
}

function slatan_design_register_floating_contact_options($wp_customize)
{

	// Panel
	$wp_customize->add_panel('slatan_floating_contact_panel', array('priority' => 110, 'capability' => 'edit_theme_options', 'title' => __('Floating Contact', 'slatan-design')));

	// Section: General & Style
	$wp_customize->add_section('slatan_fc_style_section', array('title' => __('General & Style', 'slatan-design'), 'panel' => 'slatan_floating_contact_panel', 'priority' => 10));

	// Enable
	$wp_customize->add_setting('slatan_fc_enable', array('default' => false, 'sanitize_callback' => 'slatan_sanitize_checkbox'));
	$wp_customize->add_control('slatan_fc_enable_control', array('label' => __('Enable Floating Contact', 'slatan-design'), 'section' => 'slatan_fc_style_section', 'settings' => 'slatan_fc_enable', 'type' => 'checkbox'));

	// Default State
	$wp_customize->add_setting('slatan_fc_default_state', array('default' => 'closed', 'sanitize_callback' => 'sanitize_key'));
	$wp_customize->add_control('slatan_fc_default_state_control', array(
		'label' => __('Default State', 'slatan-design'),
		'description' => __('Choose whether the menu opens automatically on page load.', 'slatan-design'),
		'section' => 'slatan_fc_style_section',
		'settings' => 'slatan_fc_default_state',
		'type' => 'select',
		'choices' => array(
			'closed' => __('Closed (Default)', 'slatan-design'),
			'open' => __('Open on Page Load', 'slatan-design'),
		)
	));

	// Font Awesome Toggle
	$wp_customize->add_setting('slatan_fc_load_fontawesome', array('default' => true, 'sanitize_callback' => 'slatan_sanitize_checkbox'));
	$wp_customize->add_control('slatan_fc_load_fontawesome_control', array('label' => __('Load Font Awesome Library', 'slatan-design'), 'description' => __('Disable if using only SVG icons.', 'slatan-design'), 'section' => 'slatan_fc_style_section', 'settings' => 'slatan_fc_load_fontawesome', 'type' => 'checkbox'));

	// Position (4 corners)
	$wp_customize->add_setting('slatan_fc_position', array('default' => 'bottom-right', 'sanitize_callback' => 'sanitize_key'));
	$wp_customize->add_control('slatan_fc_position_control', array(
		'label' => __('Position', 'slatan-design'),
		'section' => 'slatan_fc_style_section',
		'settings' => 'slatan_fc_position',
		'type' => 'select',
		'choices' => array(
			'top-left' => __('Top Left', 'slatan-design'),
			'top-right' => __('Top Right', 'slatan-design'),
			'bottom-left' => __('Bottom Left', 'slatan-design'),
			'bottom-right' => __('Bottom Right', 'slatan-design')
		)
	));

	// Horizontal Offset
	$wp_customize->add_setting('slatan_fc_offset_horizontal', array('default' => '25', 'sanitize_callback' => 'absint'));
	$wp_customize->add_control('slatan_fc_offset_horizontal_control', array(
		'label' => __('Horizontal Offset (px)', 'slatan-design'),
		'description' => __('Distance from left or right edge.', 'slatan-design'),
		'section' => 'slatan_fc_style_section',
		'settings' => 'slatan_fc_offset_horizontal',
		'type' => 'number',
		'input_attrs' => array('min' => 0, 'max' => 500, 'step' => 1)
	));

	// Vertical Offset
	$wp_customize->add_setting('slatan_fc_offset_vertical', array('default' => '25', 'sanitize_callback' => 'absint'));
	$wp_customize->add_control('slatan_fc_offset_vertical_control', array(
		'label' => __('Vertical Offset (px)', 'slatan-design'),
		'description' => __('Distance from top or bottom edge.', 'slatan-design'),
		'section' => 'slatan_fc_style_section',
		'settings' => 'slatan_fc_offset_vertical',
		'type' => 'number',
		'input_attrs' => array('min' => 0, 'max' => 500, 'step' => 1)
	));

	// Animation
	$wp_customize->add_setting('slatan_fc_animation_style', array('default' => 'pop', 'sanitize_callback' => 'sanitize_key'));
	$wp_customize->add_control('slatan_fc_animation_style_control', array('label' => __('Animation', 'slatan-design'), 'section' => 'slatan_fc_style_section', 'settings' => 'slatan_fc_animation_style', 'type' => 'select', 'choices' => array('pop' => __('Pop Out', 'slatan-design'), 'slide-up' => __('Slide Up', 'slatan-design'), 'fade-in' => __('Fade In', 'slatan-design'))));

	// Colors
	$wp_customize->add_setting('slatan_fc_main_btn_color', array('default' => '#0073aa', 'sanitize_callback' => 'sanitize_hex_color'));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'slatan_fc_main_btn_color_control', array('label' => __('Main Button Color', 'slatan-design'), 'section' => 'slatan_fc_style_section', 'settings' => 'slatan_fc_main_btn_color')));

	$wp_customize->add_setting('slatan_fc_main_icon_color', array('default' => '#ffffff', 'sanitize_callback' => 'sanitize_hex_color'));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'slatan_fc_main_icon_color_control', array('label' => __('Main Icon Color', 'slatan-design'), 'section' => 'slatan_fc_style_section', 'settings' => 'slatan_fc_main_icon_color')));

	// Icon Size
	$wp_customize->add_setting('slatan_fc_icon_size', array('default' => '24', 'sanitize_callback' => 'absint'));
	$wp_customize->add_control('slatan_fc_icon_size_control', array('label' => __('Icon Size (px)', 'slatan-design'), 'section' => 'slatan_fc_style_section', 'settings' => 'slatan_fc_icon_size', 'type' => 'number'));

	// Open Icon
	$wp_customize->add_setting('slatan_fc_open_fa_class', array('default' => 'fas fa-comment-dots', 'sanitize_callback' => 'sanitize_text_field'));
	$wp_customize->add_control('slatan_fc_open_fa_class_control', array(
		'label' => __('Open Icon: FA Class', 'slatan-design'),
		'description' => __('e.g., "fas fa-comment-dots"', 'slatan-design'),
		'section' => 'slatan_fc_style_section',
		'settings' => 'slatan_fc_open_fa_class',
		'type' => 'text'
	));

	$wp_customize->add_setting('slatan_fc_open_icon', array('default' => '', 'sanitize_callback' => 'absint'));
	$wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'slatan_fc_open_icon_control', array('label' => __('Open Icon: SVG', 'slatan-design'), 'section' => 'slatan_fc_style_section', 'settings' => 'slatan_fc_open_icon', 'mime_type' => 'image/svg+xml')));

	// Close Icon
	$wp_customize->add_setting('slatan_fc_close_fa_class', array('default' => 'fas fa-times', 'sanitize_callback' => 'sanitize_text_field'));
	$wp_customize->add_control('slatan_fc_close_fa_class_control', array(
		'label' => __('Close Icon: FA Class', 'slatan-design'),
		'description' => __('e.g., "fas fa-times"', 'slatan-design'),
		'section' => 'slatan_fc_style_section',
		'settings' => 'slatan_fc_close_fa_class',
		'type' => 'text'
	));

	$wp_customize->add_setting('slatan_fc_close_icon', array('default' => '', 'sanitize_callback' => 'absint'));
	$wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'slatan_fc_close_icon_control', array('label' => __('Close Icon: SVG', 'slatan-design'), 'section' => 'slatan_fc_style_section', 'settings' => 'slatan_fc_close_icon', 'mime_type' => 'image/svg+xml')));

	// Spacing & Sizing
	$wp_customize->add_setting('slatan_fc_button_spacing', array('default' => '12', 'sanitize_callback' => 'absint'));
	$wp_customize->add_control('slatan_fc_button_spacing_control', array('label' => __('Button Spacing (px)', 'slatan-design'), 'section' => 'slatan_fc_style_section', 'settings' => 'slatan_fc_button_spacing', 'type' => 'number'));

	$wp_customize->add_setting('slatan_fc_button_padding', array('default' => '15', 'sanitize_callback' => 'absint'));
	$wp_customize->add_control('slatan_fc_button_padding_control', array('label' => __('Button Padding (px)', 'slatan-design'), 'section' => 'slatan_fc_style_section', 'settings' => 'slatan_fc_button_padding', 'type' => 'number'));

	$wp_customize->add_setting('slatan_fc_border_radius', array('default' => '50', 'sanitize_callback' => 'absint'));
	$wp_customize->add_control('slatan_fc_border_radius_control', array('label' => __('Border Radius (%)', 'slatan-design'), 'section' => 'slatan_fc_style_section', 'settings' => 'slatan_fc_border_radius', 'type' => 'number', 'input_attrs' => array('min' => 0, 'max' => 50)));

	// Hover Effect
	$wp_customize->add_setting('slatan_fc_hover_effect', array('default' => true, 'sanitize_callback' => 'slatan_sanitize_checkbox'));
	$wp_customize->add_control('slatan_fc_hover_effect_control', array('label' => __('Hover Zoom Effect', 'slatan-design'), 'section' => 'slatan_fc_style_section', 'settings' => 'slatan_fc_hover_effect', 'type' => 'checkbox'));

	// Rotation
	$wp_customize->add_setting('slatan_fc_rotation_style', array('default' => 'rotate-90', 'sanitize_callback' => 'sanitize_key'));
	$wp_customize->add_control('slatan_fc_rotation_style_control', array(
		'label' => __('Rotation Style', 'slatan-design'),
		'section' => 'slatan_fc_style_section',
		'settings' => 'slatan_fc_rotation_style',
		'type' => 'select',
		'choices' => array(
			'no-rotation' => __('No Rotation', 'slatan-design'),
			'rotate-45' => __('Rotate 45°', 'slatan-design'),
			'rotate-90' => __('Rotate 90°', 'slatan-design'),
			'rotate-180' => __('Rotate 180°', 'slatan-design'),
			'rotate-360' => __('Rotate 360°', 'slatan-design'),
		)
	));

	// Tooltip
	$wp_customize->add_setting('slatan_fc_toggle_tooltip_enable', array('default' => false, 'sanitize_callback' => 'slatan_sanitize_checkbox'));
	$wp_customize->add_control('slatan_fc_toggle_tooltip_enable_control', array('label' => __('Enable Tooltip', 'slatan-design'), 'section' => 'slatan_fc_style_section', 'settings' => 'slatan_fc_toggle_tooltip_enable', 'type' => 'checkbox'));

	$wp_customize->add_setting('slatan_fc_toggle_tooltip_open', array('default' => 'Open Menu', 'sanitize_callback' => 'sanitize_text_field'));
	$wp_customize->add_control('slatan_fc_toggle_tooltip_open_control', array('label' => __('Tooltip (Closed)', 'slatan-design'), 'section' => 'slatan_fc_style_section', 'settings' => 'slatan_fc_toggle_tooltip_open', 'type' => 'text'));

	$wp_customize->add_setting('slatan_fc_toggle_tooltip_close', array('default' => 'Close Menu', 'sanitize_callback' => 'sanitize_text_field'));
	$wp_customize->add_control('slatan_fc_toggle_tooltip_close_control', array('label' => __('Tooltip (Open)', 'slatan-design'), 'section' => 'slatan_fc_style_section', 'settings' => 'slatan_fc_toggle_tooltip_close', 'type' => 'text'));

	$wp_customize->add_setting('slatan_fc_toggle_tooltip_display', array('default' => 'hover', 'sanitize_callback' => 'sanitize_key'));
	$wp_customize->add_control('slatan_fc_toggle_tooltip_display_control', array(
		'label' => __('Tooltip Display', 'slatan-design'),
		'section' => 'slatan_fc_style_section',
		'settings' => 'slatan_fc_toggle_tooltip_display',
		'type' => 'select',
		'choices' => array(
			'hover' => __('On Hover', 'slatan-design'),
			'always' => __('Always Visible', 'slatan-design'),
		)
	));

	// Tooltip Colors
	$wp_customize->add_setting('slatan_fc_tooltip_bg_color', array('default' => '#333333', 'sanitize_callback' => 'sanitize_hex_color'));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'slatan_fc_tooltip_bg_color_control', array('label' => __('Tooltip BG', 'slatan-design'), 'section' => 'slatan_fc_style_section', 'settings' => 'slatan_fc_tooltip_bg_color')));

	$wp_customize->add_setting('slatan_fc_tooltip_text_color', array('default' => '#ffffff', 'sanitize_callback' => 'sanitize_hex_color'));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'slatan_fc_tooltip_text_color_control', array('label' => __('Tooltip Text', 'slatan-design'), 'section' => 'slatan_fc_style_section', 'settings' => 'slatan_fc_tooltip_text_color')));

	$wp_customize->add_setting('slatan_fc_tooltip_font_size', array('default' => '12', 'sanitize_callback' => 'absint'));
	$wp_customize->add_control('slatan_fc_tooltip_font_size_control', array('label' => __('Tooltip Font Size', 'slatan-design'), 'section' => 'slatan_fc_style_section', 'settings' => 'slatan_fc_tooltip_font_size', 'type' => 'number'));

	$wp_customize->add_setting('slatan_fc_tooltip_padding_y', array('default' => '4', 'sanitize_callback' => 'absint'));
	$wp_customize->add_control('slatan_fc_tooltip_padding_y_control', array('label' => __('Tooltip Padding Y', 'slatan-design'), 'section' => 'slatan_fc_style_section', 'settings' => 'slatan_fc_tooltip_padding_y', 'type' => 'number'));

	$wp_customize->add_setting('slatan_fc_tooltip_padding_x', array('default' => '8', 'sanitize_callback' => 'absint'));
	$wp_customize->add_control('slatan_fc_tooltip_padding_x_control', array('label' => __('Tooltip Padding X', 'slatan-design'), 'section' => 'slatan_fc_style_section', 'settings' => 'slatan_fc_tooltip_padding_x', 'type' => 'number'));

	$wp_customize->add_setting('slatan_fc_tooltip_border_radius', array('default' => '4', 'sanitize_callback' => 'absint'));
	$wp_customize->add_control('slatan_fc_tooltip_border_radius_control', array('label' => __('Tooltip Radius', 'slatan-design'), 'section' => 'slatan_fc_style_section', 'settings' => 'slatan_fc_tooltip_border_radius', 'type' => 'number'));

	// Section: Channels
	$wp_customize->add_section('slatan_fc_channels_section', array('title' => __('Contact Channels', 'slatan-design'), 'panel' => 'slatan_floating_contact_panel', 'priority' => 20));

	// 9 Channel Slots
	for ($i = 1; $i <= 9; $i++) {
		$wp_customize->add_setting('slatan_fc_channel_' . $i . '_enable', array('default' => false, 'sanitize_callback' => 'slatan_sanitize_checkbox'));
		$wp_customize->add_control('slatan_fc_channel_' . $i . '_enable_control', array('label' => sprintf('--- Channel %d ---', $i), 'section' => 'slatan_fc_channels_section', 'settings' => 'slatan_fc_channel_' . $i . '_enable', 'type' => 'checkbox'));

		$wp_customize->add_setting('slatan_fc_channel_' . $i . '_link', array('default' => '', 'sanitize_callback' => 'esc_url_raw'));
		$wp_customize->add_control('slatan_fc_channel_' . $i . '_link_control', array('label' => sprintf('Ch %d: Link', $i), 'section' => 'slatan_fc_channels_section', 'settings' => 'slatan_fc_channel_' . $i . '_link', 'type' => 'url'));

		$wp_customize->add_setting('slatan_fc_channel_' . $i . '_label', array('default' => '', 'sanitize_callback' => 'sanitize_text_field'));
		$wp_customize->add_control('slatan_fc_channel_' . $i . '_label_control', array('label' => sprintf('Ch %d: Label', $i), 'section' => 'slatan_fc_channels_section', 'settings' => 'slatan_fc_channel_' . $i . '_label', 'type' => 'text'));

		$wp_customize->add_setting('slatan_fc_channel_' . $i . '_bg_color', array('default' => '#0073aa', 'sanitize_callback' => 'sanitize_hex_color'));
		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'slatan_fc_channel_' . $i . '_bg_color_control', array('label' => sprintf('Ch %d: BG', $i), 'section' => 'slatan_fc_channels_section', 'settings' => 'slatan_fc_channel_' . $i . '_bg_color')));

		$wp_customize->add_setting('slatan_fc_channel_' . $i . '_icon_color', array('default' => '#ffffff', 'sanitize_callback' => 'sanitize_hex_color'));
		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'slatan_fc_channel_' . $i . '_icon_color_control', array('label' => sprintf('Ch %d: Icon', $i), 'section' => 'slatan_fc_channels_section', 'settings' => 'slatan_fc_channel_' . $i . '_icon_color')));

		$wp_customize->add_setting('slatan_fc_channel_' . $i . '_fa_class', array('default' => 'fas fa-link', 'sanitize_callback' => 'sanitize_text_field'));
		$wp_customize->add_control('slatan_fc_channel_' . $i . '_fa_class_control', array('label' => sprintf('Ch %d: FA Class', $i), 'section' => 'slatan_fc_channels_section', 'settings' => 'slatan_fc_channel_' . $i . '_fa_class', 'type' => 'text'));

		$wp_customize->add_setting('slatan_fc_channel_' . $i . '_svg_icon', array('default' => '', 'sanitize_callback' => 'absint'));
		$wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'slatan_fc_channel_' . $i . '_svg_icon_control', array('label' => sprintf('Ch %d: SVG', $i), 'section' => 'slatan_fc_channels_section', 'settings' => 'slatan_fc_channel_' . $i . '_svg_icon', 'mime_type' => 'image/svg+xml')));
	}
}
add_action('customize_register', 'slatan_design_register_floating_contact_options');