<?php
/**
 * Frontend functionality for Cookie Consent
 *
 * @package Slatan_Design
 */

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly.

// ===================================================================================
// 1. ENQUEUE ASSETS
// ===================================================================================
function slatan_load_cookie_consent_assets()
{
    if (get_theme_mod('slatan_cookie_consent_enable', false)) {
        $theme_version = defined('_S_VERSION') ? _S_VERSION : '1.0.0';
        wp_enqueue_style('slatan-cookie-consent-style', get_template_directory_uri() . '/css/cookie-consent.css', array(), $theme_version);
        wp_enqueue_script('slatan-cookie-consent-script', get_template_directory_uri() . '/js/cookie-consent.js', array('jquery'), $theme_version, true);
    }
}
add_action('wp_enqueue_scripts', 'slatan_load_cookie_consent_assets');

// ===================================================================================
// 2. DISPLAY BANNER HTML
// ===================================================================================
function slatan_display_cookie_consent_banner()
{
    if (!get_theme_mod('slatan_cookie_consent_enable', false)) {
        return;
    }

    $layout_class = get_theme_mod('slatan_cookie_consent_layout', 'side-text-left');
    $position_class = get_theme_mod('slatan_cookie_consent_position', 'full-width-bottom');
    $text_align_class = get_theme_mod('slatan_cookie_consent_text_align', 'left');
    $headline = get_theme_mod('slatan_cookie_consent_headline', '');
    $banner_text = get_theme_mod('slatan_cookie_consent_text', __('We use cookies to ensure you get the best experience on our website.', 'slatan-design'));
    $accept_text = get_theme_mod('slatan_cookie_consent_accept_text', __('Accept', 'slatan-design'));
    $show_decline_btn = get_theme_mod('slatan_cookie_consent_decline_enable', false);
    $decline_text = get_theme_mod('slatan_cookie_consent_decline_text', __('Decline', 'slatan-design'));

    // [Policy Link]
    $show_policy_link = get_theme_mod('slatan_cookie_consent_policy_link_enable', false);
    $policy_link_text = get_theme_mod('slatan_cookie_consent_policy_link_text', __('Read More', 'slatan-design'));
    $policy_link_url = get_theme_mod('slatan_cookie_consent_policy_link_url', '');

    $banner_classes = "cookie-consent-banner layout-{$layout_class} position-{$position_class}";
    $content_classes = "cookie-consent-content text-align-{$text_align_class}";
    ?>
    <div id="cookie-consent-banner" class="<?php echo esc_attr($banner_classes); ?>">
        <div class="<?php echo esc_attr($content_classes); ?>">
            <?php if (!empty($headline)): ?>
                <h4><?php echo esc_html($headline); ?></h4>
            <?php endif; ?>
            <p>
                <?php echo esc_html($banner_text); ?>
                <?php if ($show_policy_link && !empty($policy_link_url)): ?>
                    <a href="<?php echo esc_url($policy_link_url); ?>" class="cookie-consent-policy-link" target="_blank"
                        rel="noopener noreferrer">
                        <?php echo esc_html($policy_link_text); ?>
                    </a>
                <?php endif; ?>
            </p>
        </div>
        <div class="cookie-consent-buttons">
            <?php if ($show_decline_btn): ?>
                <button id="cookie-consent-decline"
                    class="cookie-consent-decline"><?php echo esc_html($decline_text); ?></button>
            <?php endif; ?>
            <button id="cookie-consent-accept"><?php echo esc_html($accept_text); ?></button>
        </div>
    </div>

    <!-- [Revoke Button] -->
    <?php
    if (get_theme_mod('slatan_revoke_button_enable', true)):
        $custom_icon = get_theme_mod('slatan_revoke_button_custom_icon', '');
        $fa_class = get_theme_mod('slatan_revoke_button_fa_class', 'fas fa-cookie-bite');
        ?>
        <button id="slatan-revoke-consent" class="slatan-revoke-consent"
            title="<?php esc_attr_e('Cookie Settings', 'slatan-design'); ?>">
            <?php if (!empty($custom_icon)): ?>
                <img src="<?php echo esc_url($custom_icon); ?>" alt="<?php esc_attr_e('Cookie Settings', 'slatan-design'); ?>">
            <?php elseif (!empty($fa_class)): ?>
                <i class="<?php echo esc_attr($fa_class); ?>"></i>
            <?php else: ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2a10 10 0 1 0 10 10 4 4 0 0 1-5-5 4 4 0 0 1-5-5 10 10 0 0 0-4 2z"></path>
                </svg>
            <?php endif; ?>
        </button>
        <?php
    endif;
}
add_action('wp_footer', 'slatan_display_cookie_consent_banner');


// ===================================================================================
// 3. GENERATE DYNAMIC CSS (CSS Variables)
// ===================================================================================
function slatan_generate_cookie_consent_dynamic_css()
{
    if (!get_theme_mod('slatan_cookie_consent_enable', false)) {
        return;
    }

    $bg_color = get_theme_mod('slatan_cookie_consent_bg_color', '#222222');
    $text_color = get_theme_mod('slatan_cookie_consent_text_color', '#ffffff');
    $accept_bg_color = get_theme_mod('slatan_cookie_consent_accept_bg_color', '#0073aa');
    $accept_text_color = get_theme_mod('slatan_cookie_consent_accept_text_color', '#ffffff');
    $accept_bg_hover = get_theme_mod('slatan_cookie_consent_accept_bg_hover_color', '#005a87');
    $accept_text_hover = get_theme_mod('slatan_cookie_consent_accept_text_hover_color', '#ffffff');
    $decline_bg_color = get_theme_mod('slatan_cookie_consent_decline_bg_color', 'transparent');
    $decline_text_color = get_theme_mod('slatan_cookie_consent_decline_text_color', '#ffffff');
    $decline_bg_hover = get_theme_mod('slatan_cookie_consent_decline_bg_hover_color', '#ffffff');
    $decline_text_hover = get_theme_mod('slatan_cookie_consent_decline_text_hover_color', '#222222');
    $banner_padding_top = get_theme_mod('slatan_cookie_banner_padding_top', '20');
    $banner_padding_right = get_theme_mod('slatan_cookie_banner_padding_right', '20');
    $banner_padding_bottom = get_theme_mod('slatan_cookie_banner_padding_bottom', '20');
    $banner_padding_left = get_theme_mod('slatan_cookie_banner_padding_left', '20');
    $button_padding_y = get_theme_mod('slatan_cookie_button_padding_y', '8');
    $button_padding_x = get_theme_mod('slatan_cookie_button_padding_x', '18');
    $banner_radius = get_theme_mod('slatan_cookie_banner_border_radius', '5');
    $button_radius = get_theme_mod('slatan_cookie_button_border_radius', '5');

    // Layout Logic for Flexbox
    $button_order = get_theme_mod('slatan_cookie_button_order', 'decline-first');
    $button_align = get_theme_mod('slatan_cookie_consent_button_align', 'right');
    $flex_direction = ($button_order === 'accept-first') ? 'row-reverse' : 'row';
    $justify_content = ($button_align === 'left') ? 'flex-start' : (($button_align === 'center') ? 'center' : 'flex-end');

    // Revoke Button
    $revoke_bg = get_theme_mod('slatan_revoke_button_bg_color', '#ffffff');
    $revoke_icon_color = get_theme_mod('slatan_revoke_button_icon_color', '#222222');
    $revoke_offset_bottom = get_theme_mod('slatan_revoke_button_offset_bottom', '20');
    $revoke_offset_side = get_theme_mod('slatan_revoke_button_offset_side', '20');
    $revoke_pos = get_theme_mod('slatan_revoke_button_position', 'bottom-left');

    // Revoke Position Logic
    $revoke_left = 'auto';
    $revoke_right = 'auto';
    if ($revoke_pos === 'bottom-right') {
        $revoke_right = $revoke_offset_side . 'px';
    } else {
        $revoke_left = $revoke_offset_side . 'px';
    }

    $css_output = "
    :root {
        --slatan-cookie-bg: {$bg_color};
        --slatan-cookie-text: {$text_color};
        --slatan-cookie-accept-bg: {$accept_bg_color};
        --slatan-cookie-accept-text: {$accept_text_color};
        --slatan-cookie-accept-bg-hover: {$accept_bg_hover};
        --slatan-cookie-accept-text-hover: {$accept_text_hover};
        --slatan-cookie-decline-bg: {$decline_bg_color};
        --slatan-cookie-decline-text: {$decline_text_color};
        --slatan-cookie-decline-bg-hover: {$decline_bg_hover};
        --slatan-cookie-decline-text-hover: {$decline_text_hover};
        
        --slatan-cookie-padding-top: {$banner_padding_top}px;
        --slatan-cookie-padding-right: {$banner_padding_right}px;
        --slatan-cookie-padding-bottom: {$banner_padding_bottom}px;
        --slatan-cookie-padding-left: {$banner_padding_left}px;
        
        --slatan-cookie-btn-padding-y: {$button_padding_y}px;
        --slatan-cookie-btn-padding-x: {$button_padding_x}px;
        
        --slatan-cookie-banner-radius: {$banner_radius}px;
        --slatan-cookie-btn-radius: {$button_radius}px;
        
        --slatan-revoke-bg: {$revoke_bg};
        --slatan-revoke-icon: {$revoke_icon_color};
        --slatan-revoke-bottom: {$revoke_offset_bottom}px;
        --slatan-revoke-side: {$revoke_offset_side}px;
    }
    
    /* Layout Overrides (Too complex for simple vars) */
    .cookie-consent-buttons { 
        flex-direction: {$flex_direction}; 
        justify-content: {$justify_content}; 
    }
    
    /* Revoke Position Override */
    .slatan-revoke-consent {
        left: {$revoke_left};
        right: {$revoke_right};
    }
    ";

    wp_add_inline_style('slatan-cookie-consent-style', $css_output);
}
add_action('wp_enqueue_scripts', 'slatan_generate_cookie_consent_dynamic_css', 20);

// ===================================================================================
// 4. CONDITIONAL SCRIPT LOADING (Analytics, Pixels, etc.)
// ===================================================================================
function slatan_load_conditional_head_scripts()
{
    if (isset($_COOKIE['slatan_cookie_consent']) && $_COOKIE['slatan_cookie_consent'] === 'accepted') {
        // Example: Google Analytics
        echo "<script async src='https://www.googletagmanager.com/gtag/js?id=YOUR-GA-ID-HERE'></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'YOUR-GA-ID-HERE');
</script>
"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
}
add_action('wp_head', 'slatan_load_conditional_head_scripts', 99);

function slatan_load_conditional_footer_scripts()
{
    if (isset($_COOKIE['slatan_cookie_consent']) && $_COOKIE['slatan_cookie_consent'] === 'accepted') {
        // Example: Chat Widget
        // echo "";
    }
}
add_action('wp_footer', 'slatan_load_conditional_footer_scripts', 99);


// ===================================================================================
// 5. [UPGRADED] ADMIN DEBUG RESET BUTTON (Customizer-Only)
// ===================================================================================
function slatan_add_cookie_reset_button()
{

    // จบการทำงานทันที ถ้าไม่ใช่ Admin หรือ ไม่ได้อยู่ใน Customizer Preview
    if (!(is_customize_preview() && current_user_can('edit_theme_options'))) {
        return;
    }

    // 1. พิมพ์ตัวปุ่ม
    printf('<a href="#" id="slatan-reset-cookie">%s</a>', esc_html__('Reset Cookie Consent', 'slatan-design'));

    // 2. Enqueue JS
    $theme_version = defined('_S_VERSION') ? _S_VERSION : '1.0.0';
    wp_enqueue_script('slatan-cookie-consent-reset', get_template_directory_uri() . '/js/cookie-consent-reset.js', array('jquery', 'customize-preview'), $theme_version, true);
}
add_action('wp_footer', 'slatan_add_cookie_reset_button', 200);