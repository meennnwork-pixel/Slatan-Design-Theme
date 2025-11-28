<?php
/**
 * Frontend functionality for Floating Contact
 *
 * @package Slatan_Design
 */

if (!defined('ABSPATH')) {
    exit;
}

// Enqueue Assets
function slatan_load_floating_contact_assets()
{
    if (get_theme_mod('slatan_fc_enable', false)) {
        $theme_version = defined('_S_VERSION') ? _S_VERSION : '1.0.0';
        wp_enqueue_style('slatan-floating-contact-style', get_template_directory_uri() . '/css/floating-contact.css', array(), $theme_version);
    }
}
add_action('wp_enqueue_scripts', 'slatan_load_floating_contact_assets');

// Display HTML
function slatan_display_floating_contact()
{
    if (!get_theme_mod('slatan_fc_enable', false)) {
        return;
    }

    $wrapper_id = 'slatan-fc-' . wp_unique_id();
    $position_class = get_theme_mod('slatan_fc_position', 'bottom-right');
    $animation_class = get_theme_mod('slatan_fc_animation_style', 'pop');
    $default_state = get_theme_mod('slatan_fc_default_state', 'closed');

    $open_fa_class = get_theme_mod('slatan_fc_open_fa_class', 'fas fa-comment-dots');
    $close_fa_class = get_theme_mod('slatan_fc_close_fa_class', 'fas fa-times');
    $open_icon_id = get_theme_mod('slatan_fc_open_icon', '');
    $close_icon_id = get_theme_mod('slatan_fc_close_icon', '');
    $open_icon_url = $open_icon_id ? wp_get_attachment_image_url($open_icon_id, 'full') : '';
    $close_icon_url = $close_icon_id ? wp_get_attachment_image_url($close_icon_id, 'full') : '';

    $toggle_tooltip_enable = get_theme_mod('slatan_fc_toggle_tooltip_enable', false);
    $toggle_tooltip_open = get_theme_mod('slatan_fc_toggle_tooltip_open', 'Open Menu');
    $toggle_tooltip_close = get_theme_mod('slatan_fc_toggle_tooltip_close', 'Close Menu');
    $tooltip_display_mode = get_theme_mod('slatan_fc_toggle_tooltip_display', 'hover');

    $active_channels = array();
    for ($i = 1; $i <= 9; $i++) {
        if (get_theme_mod('slatan_fc_channel_' . $i . '_enable', false)) {
            $link = get_theme_mod('slatan_fc_channel_' . $i . '_link', '');
            if (!empty($link)) {
                $active_channels[] = [
                    'slot_id' => $i,
                    'label' => get_theme_mod('slatan_fc_channel_' . $i . '_label', ''),
                    'link' => $link,
                    'svg' => get_theme_mod('slatan_fc_channel_' . $i . '_svg_icon') ? wp_get_attachment_image_url(get_theme_mod('slatan_fc_channel_' . $i . '_svg_icon'), 'full') : '',
                    'fa_class' => get_theme_mod('slatan_fc_channel_' . $i . '_fa_class', 'fas fa-link'),
                ];
            }
        }
    }
    ?>
    <div id="<?php echo esc_attr($wrapper_id); ?>"
        class="slatan-fc-wrapper position-<?php echo esc_attr($position_class); ?> animation-<?php echo esc_attr($animation_class); ?><?php echo ($tooltip_display_mode === 'always') ? ' tooltip-always' : ''; ?>">

        <?php if (!empty($active_channels)): ?>
            <ul class="slatan-fc-channels">
                <?php foreach ($active_channels as $channel): ?>
                    <li class="channel-slot-<?php echo esc_attr($channel['slot_id']); ?>">
                        <a href="<?php echo esc_url($channel['link']); ?>" target="_blank" rel="noopener noreferrer">
                            <?php if (!empty($channel['svg'])): ?>
                                <img src="<?php echo esc_url($channel['svg']); ?>" alt="<?php echo esc_attr($channel['label']); ?>"
                                    class="slatan-fc-svg-icon">
                            <?php else: ?>
                                <i class="<?php echo esc_attr($channel['fa_class']); ?>"></i>
                            <?php endif; ?>
                            <?php if (!empty($channel['label'])): ?>
                                <span class="slatan-fc-tooltip">
                                    <?php echo esc_html($channel['label']); ?>
                                    <span class="slatan-fc-tooltip-arrow"></span>
                                </span>
                            <?php endif; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <div class="slatan-fc-toggle">
            <?php if ($toggle_tooltip_enable): ?>
                <span class="slatan-fc-toggle-tooltip slatan-fc-tooltip-open">
                    <?php echo esc_html($toggle_tooltip_open); ?>
                    <span class="slatan-fc-tooltip-arrow"></span>
                </span>
                <span class="slatan-fc-toggle-tooltip slatan-fc-tooltip-close" style="display:none;">
                    <?php echo esc_html($toggle_tooltip_close); ?>
                    <span class="slatan-fc-tooltip-arrow"></span>
                </span>
            <?php endif; ?>

            <span class="slatan-fc-toggle-icon slatan-fc-toggle-icon-open">
                <?php if ($open_icon_url): ?>
                    <img src="<?php echo esc_url($open_icon_url); ?>" alt="Open">
                <?php else: ?>
                    <i class="<?php echo esc_attr($open_fa_class); ?>"></i>
                <?php endif; ?>
            </span>
            <span class="slatan-fc-toggle-icon slatan-fc-toggle-icon-close">
                <?php if ($close_icon_url): ?>
                    <img src="<?php echo esc_url($close_icon_url); ?>" alt="Close">
                <?php else: ?>
                    <i class="<?php echo esc_attr($close_fa_class); ?>"></i>
                <?php endif; ?>
            </span>
        </div>
    </div>
    <script>
        (function () {
            var wrapper = document.getElementById('<?php echo esc_js($wrapper_id); ?>');
            if (!wrapper) return;

            var toggleButton = wrapper.querySelector('.slatan-fc-toggle');
            var tooltipOpen = wrapper.querySelector('.slatan-fc-tooltip-open');
            var tooltipClose = wrapper.querySelector('.slatan-fc-tooltip-close');
            var storageKey = 'slatan_fc_user_closed';
            var defaultState = '<?php echo esc_js($default_state); ?>';

            var userClosed = localStorage.getItem(storageKey);

            if (defaultState === 'open' && userClosed !== 'true') {
                wrapper.classList.add('is-open');
                if (tooltipOpen && tooltipClose) {
                    tooltipOpen.style.display = 'none';
                    tooltipClose.style.display = 'block';
                }
            }

            if (toggleButton) {
                toggleButton.addEventListener('click', function () {
                    var wrapper = document.getElementById('<?php echo esc_js($wrapper_id); ?>');
                    var isOpen = wrapper.classList.toggle('is-open');

                    if (tooltipOpen && tooltipClose) {
                        if (isOpen) {
                            tooltipOpen.style.display = 'none';
                            tooltipClose.style.display = 'block';
                        } else {
                            tooltipOpen.style.display = 'block';
                            tooltipClose.style.display = 'none';
                        }
                    }

                    if (!isOpen && defaultState === 'open') {
                        localStorage.setItem(storageKey, 'true');
                    } else if (isOpen && defaultState === 'open') {
                        localStorage.removeItem(storageKey);
                    }
                });
            }
        })();
    </script>
    <?php
}
add_action('wp_footer', 'slatan_display_floating_contact');

// Generate Dynamic CSS
function slatan_generate_floating_contact_dynamic_css()
{
    if (!get_theme_mod('slatan_fc_enable', false)) {
        return;
    }

    $main_color = get_theme_mod('slatan_fc_main_btn_color', '#0073aa');
    $main_icon_color = get_theme_mod('slatan_fc_main_icon_color', '#ffffff');
    $padding = get_theme_mod('slatan_fc_button_padding', '15');
    $spacing = get_theme_mod('slatan_fc_button_spacing', '12');
    $radius = get_theme_mod('slatan_fc_border_radius', '50');
    $icon_size = get_theme_mod('slatan_fc_icon_size', '24');
    $tooltip_bg = get_theme_mod('slatan_fc_tooltip_bg_color', '#333333');
    $tooltip_text = get_theme_mod('slatan_fc_tooltip_text_color', '#ffffff');
    $tooltip_font_size = get_theme_mod('slatan_fc_tooltip_font_size', '12');
    $tooltip_padding_y = get_theme_mod('slatan_fc_tooltip_padding_y', '4');
    $tooltip_padding_x = get_theme_mod('slatan_fc_tooltip_padding_x', '8');
    $tooltip_radius = get_theme_mod('slatan_fc_tooltip_border_radius', '4');
    $button_size = $icon_size + ($padding * 2);

    $offset_horizontal = get_theme_mod('slatan_fc_offset_horizontal', '25');
    $offset_vertical = get_theme_mod('slatan_fc_offset_vertical', '25');
    $position = get_theme_mod('slatan_fc_position', 'bottom-right');

    $css = "";

    // Positioning - 4 corners support
    if ($position === 'top-left') {
        $css .= ".slatan-fc-wrapper.position-top-left { top: {$offset_vertical}px; left: {$offset_horizontal}px; }";
    } elseif ($position === 'top-right') {
        $css .= ".slatan-fc-wrapper.position-top-right { top: {$offset_vertical}px; right: {$offset_horizontal}px; }";
    } elseif ($position === 'bottom-left') {
        $css .= ".slatan-fc-wrapper.position-bottom-left { bottom: {$offset_vertical}px; left: {$offset_horizontal}px; }";
    } else {
        $css .= ".slatan-fc-wrapper.position-bottom-right { bottom: {$offset_vertical}px; right: {$offset_horizontal}px; }";
    }

    // Button styles
    $css .= ".slatan-fc-channels { gap: {$spacing}px; margin-bottom: {$spacing}px; }";
    $css .= ".slatan-fc-toggle, .slatan-fc-channels a { width: {$button_size}px; height: {$button_size}px; border-radius: {$radius}%; }";
    $css .= ".slatan-fc-toggle { background-color: {$main_color}; color: {$main_icon_color}; }";
    $css .= ".slatan-fc-toggle i, .slatan-fc-channels a i { font-size: {$icon_size}px; }";
    $css .= ".slatan-fc-toggle img, .slatan-fc-channels a .slatan-fc-svg-icon { width: {$icon_size}px; height: {$icon_size}px; }";

    // Tooltip styles
    $css .= ".slatan-fc-channels a .slatan-fc-tooltip, .slatan-fc-toggle-tooltip { 
        background-color: {$tooltip_bg}; 
        color: {$tooltip_text}; 
        font-size: {$tooltip_font_size}px; 
        padding: {$tooltip_padding_y}px {$tooltip_padding_x}px; 
        border-radius: {$tooltip_radius}px; 
    }";

    // Tooltip arrows for all 4 positions
    $css .= ".position-bottom-right .slatan-fc-channels a .slatan-fc-tooltip-arrow,
    .position-bottom-right .slatan-fc-toggle-tooltip .slatan-fc-tooltip-arrow {
        border-color: transparent transparent transparent {$tooltip_bg};
    }";

    $css .= ".position-bottom-left .slatan-fc-channels a .slatan-fc-tooltip-arrow,
    .position-bottom-left .slatan-fc-toggle-tooltip .slatan-fc-tooltip-arrow {
        border-color: transparent {$tooltip_bg} transparent transparent;
    }";

    $css .= ".position-top-right .slatan-fc-channels a .slatan-fc-tooltip-arrow,
    .position-top-right .slatan-fc-toggle-tooltip .slatan-fc-tooltip-arrow {
        border-color: transparent transparent transparent {$tooltip_bg};
    }";

    $css .= ".position-top-left .slatan-fc-channels a .slatan-fc-tooltip-arrow,
    .position-top-left .slatan-fc-toggle-tooltip .slatan-fc-tooltip-arrow {
        border-color: transparent {$tooltip_bg} transparent transparent;
    }";

    // Channel colors
    for ($i = 1; $i <= 9; $i++) {
        if (get_theme_mod('slatan_fc_channel_' . $i . '_enable')) {
            $bg_color = get_theme_mod('slatan_fc_channel_' . $i . '_bg_color', '#0073aa');
            $icon_color = get_theme_mod('slatan_fc_channel_' . $i . '_icon_color', '#ffffff');
            $css .= ".slatan-fc-wrapper .channel-slot-{$i} a { background-color: {$bg_color}; color: {$icon_color}; }";
        }
    }

    // Hover effect
    if (get_theme_mod('slatan_fc_hover_effect', true)) {
        $css .= ".slatan-fc-channels a:hover, .slatan-fc-toggle:hover { transform: scale(1.1); }";
    }

    // Rotation
    $rotation_style = get_theme_mod('slatan_fc_rotation_style', 'rotate-90');
    $rotation_map = array(
        'no-rotation' => '0',
        'rotate-45' => '45',
        'rotate-90' => '90',
        'rotate-180' => '180',
        'rotate-360' => '360',
    );
    $rotation_deg = isset($rotation_map[$rotation_style]) ? $rotation_map[$rotation_style] : '90';

    if ($rotation_deg === '0') {
        $css .= ".slatan-fc-toggle-icon-close { transform: scale(0); opacity: 0; }";
        $css .= ".slatan-fc-wrapper.is-open .slatan-fc-toggle-icon-open { transform: scale(0); opacity: 0; }";
        $css .= ".slatan-fc-wrapper.is-open .slatan-fc-toggle-icon-close { transform: scale(1); opacity: 1; }";
    } else {
        $neg_rotation = '-' . $rotation_deg;
        $css .= ".slatan-fc-toggle-icon-close { transform: rotate({$neg_rotation}deg) scale(0); opacity: 0; }";
        $css .= ".slatan-fc-wrapper.is-open .slatan-fc-toggle-icon-open { transform: rotate({$rotation_deg}deg) scale(0); opacity: 0; }";
        $css .= ".slatan-fc-wrapper.is-open .slatan-fc-toggle-icon-close { transform: rotate(0) scale(1); opacity: 1; }";
    }

    wp_add_inline_style('slatan-floating-contact-style', $css);
}
add_action('wp_enqueue_scripts', 'slatan_generate_floating_contact_dynamic_css', 20);