<?php
/**
 * Security Enhancements
 *
 * @package Slatan_Design
 */
if (!defined('ABSPATH')) {
    exit;
}
/**
 * Add security headers
 */
function slatan_design_security_headers()
{
    // Only add on frontend
    if (is_admin()) {
        return;
    }
    // X-Content-Type-Options
    header('X-Content-Type-Options: nosniff');
    
    // X-Frame-Options (prevent clickjacking)
    header('X-Frame-Options: SAMEORIGIN');
    
    // X-XSS-Protection
    header('X-XSS-Protection: 1; mode=block');
    
    // Referrer Policy
    header('Referrer-Policy: strict-origin-when-cross-origin');
    
    // Permissions Policy (Feature Policy)
    header('Permissions-Policy: geolocation=(), microphone=(), camera=()');
}
add_action('send_headers', 'slatan_design_security_headers');
/**
 * Disable XML-RPC if not needed
 */
function slatan_design_disable_xmlrpc()
{
    // Check if theme mod allows XML-RPC (default: disabled)
    if (!get_theme_mod('slatan_enable_xmlrpc', false)) {
        add_filter('xmlrpc_enabled', '__return_false');
        
        // Remove XML-RPC link from header
        remove_action('wp_head', 'rsd_link');
        remove_action('wp_head', 'wlwmanifest_link');
    }
}
add_action('init', 'slatan_design_disable_xmlrpc');
/**
 * Limit login attempts (basic protection)
 */
function slatan_design_limit_login_attempts($user, $username, $password)
{
    if (empty($username) || empty($password)) {
        return $user;
    }
    $ip = slatan_get_client_ip();
    $transient_key = 'slatan_login_attempts_' . md5($ip);
    $attempts = get_transient($transient_key);
    
    $max_attempts = apply_filters('slatan_max_login_attempts', 5);
    $lockout_duration = apply_filters('slatan_lockout_duration', 15 * MINUTE_IN_SECONDS);
    if ($attempts !== false && $attempts >= $max_attempts) {
        return new WP_Error(
            'too_many_attempts',
            sprintf(
                __('Too many failed login attempts. Please try again in %d minutes.', 'slatan-design'),
                ceil($lockout_duration / 60)
            )
        );
    }
    return $user;
}
add_filter('authenticate', 'slatan_design_limit_login_attempts', 30, 3);
/**
 * Track failed login attempts
 */
function slatan_design_track_failed_login($username)
{
    $ip = slatan_get_client_ip();
    $transient_key = 'slatan_login_attempts_' . md5($ip);
    $attempts = get_transient($transient_key);
    
    $max_attempts = apply_filters('slatan_max_login_attempts', 5);
    $lockout_duration = apply_filters('slatan_lockout_duration', 15 * MINUTE_IN_SECONDS);
    if ($attempts === false) {
        set_transient($transient_key, 1, $lockout_duration);
    } else {
        set_transient($transient_key, $attempts + 1, $lockout_duration);
    }
}
add_action('wp_login_failed', 'slatan_design_track_failed_login');
/**
 * Clear login attempts on successful login
 */
function slatan_design_clear_login_attempts($username)
{
    $ip = slatan_get_client_ip();
    $transient_key = 'slatan_login_attempts_' . md5($ip);
    delete_transient($transient_key);
}
add_action('wp_login', 'slatan_design_clear_login_attempts');
/**
 * Get client IP address
 */
function slatan_get_client_ip()
{
    $ip_keys = array(
        'HTTP_CF_CONNECTING_IP', // Cloudflare
        'HTTP_X_REAL_IP',
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'REMOTE_ADDR'
    );
    foreach ($ip_keys as $key) {
        if (!empty($_SERVER[$key])) {
            $ip = sanitize_text_field(wp_unslash($_SERVER[$key]));
            // Handle comma-separated IPs
            if (strpos($ip, ',') !== false) {
                $ip = trim(explode(',', $ip)[0]);
            }
            if (filter_var($ip, FILTER_VALIDATE_IP)) {
                return $ip;
            }
        }
    }
    return '127.0.0.1';
}
/**
 * Hide WordPress version
 */
function slatan_design_remove_version()
{
    return '';
}
add_filter('the_generator', 'slatan_design_remove_version');
/**
 * Disable file editing in admin
 */
if (!defined('DISALLOW_FILE_EDIT')) {
    define('DISALLOW_FILE_EDIT', true);
}