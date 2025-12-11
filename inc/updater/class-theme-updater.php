<?php
/**
 * GitHub Theme Updater
 *
 * @package Slatan_Design
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Slatan_Theme_Updater')) {
    class Slatan_Theme_Updater
    {

        private $username;
        private $repository;
        private $theme_slug;
        private $github_auth;

        public function __construct($username, $repository, $theme_slug, $github_auth = '')
        {
            $this->username = $username;
            $this->repository = $repository;
            $this->theme_slug = $theme_slug;
            $this->github_auth = $github_auth;

            add_filter('pre_set_site_transient_update_themes', array($this, 'check_update'));
            add_filter('upgrader_post_install', array($this, 'upgrader_post_install'), 10, 3);
        }

        /**
         * Rename the theme folder after installation
         * GitHub downloads create folders like "username-repo-commithash"
         * We need to rename it to match the theme slug
         */
        public function upgrader_post_install($response, $hook_extra, $result)
        {
            global $wp_filesystem;

            // Only process theme updates
            if (!isset($hook_extra['theme'])) {
                return $response;
            }

            // Only process our theme
            if ($hook_extra['theme'] !== $this->theme_slug) {
                return $response;
            }

            // Get the destination folder
            $theme_dir = trailingslashit(get_theme_root());
            $proper_destination = $theme_dir . $this->theme_slug;

            // If the folder is already correct, do nothing
            if ($result['destination'] === $proper_destination) {
                return $response;
            }

            // Remove old theme folder if it exists
            if ($wp_filesystem->exists($proper_destination)) {
                $wp_filesystem->delete($proper_destination, true);
            }

            // Rename the downloaded folder to the correct slug
            $wp_filesystem->move($result['destination'], $proper_destination);
            $result['destination'] = $proper_destination;

            // Update the destination name
            $result['destination_name'] = $this->theme_slug;

            return $response;
        }

        public function check_update($transient)
        {
            if (empty($transient->checked)) {
                return $transient;
            }

            // Get the remote version
            $remote_version = $this->get_remote_version();

            if ($remote_version && version_compare($this->get_theme_version(), $remote_version, '<')) {
                // WordPress expects an array, not an object
                $res = array(
                    'theme' => $this->theme_slug,
                    'new_version' => $remote_version,
                    'url' => $this->get_repo_url(),
                    'package' => $this->get_download_url(),
                );

                $transient->response[$this->theme_slug] = $res;
            }

            return $transient;
        }

        private function get_theme_version()
        {
            $theme = wp_get_theme($this->theme_slug);
            return $theme->get('Version');
        }

        private function get_remote_version()
        {
            $request = $this->get_github_data();
            if (!empty($request) && !empty($request->tag_name)) {
                return str_replace('v', '', $request->tag_name);
            }
            return false;
        }

        private function get_download_url()
        {
            $request = $this->get_github_data();
            if (!empty($request) && !empty($request->zipball_url)) {
                return $request->zipball_url;
            }
            return false;
        }

        private function get_repo_url()
        {
            return "https://github.com/{$this->username}/{$this->repository}"; // phpcs:ignore
        }

        /**
         * Get GitHub data with caching
         */
        private function get_github_data()
        {
            // Check cache first
            $cache_key = 'slatan_github_update_' . md5($this->username . $this->repository);
            $cached_data = get_transient($cache_key);
            
            if ($cached_data !== false) {
                return $cached_data;
            }
            
            $url = "https://api.github.com/repos/{$this->username}/{$this->repository}/releases/latest";
            $args = array(
                'timeout' => 10,
                'headers' => array(
                    'Accept' => 'application/vnd.github.v3+json',
                ),
            );
            
            if (!empty($this->github_auth)) {
                $args['headers']['Authorization'] = 'token ' . $this->github_auth;
            }
            $request = wp_safe_remote_get($url, $args);
            if (is_wp_error($request)) {
                // Log error for debugging (optional)
                if (defined('WP_DEBUG') && WP_DEBUG) {
                    error_log('Slatan Theme Updater Error: ' . $request->get_error_message());
                }
                return false;
            }
            $response_code = wp_remote_retrieve_response_code($request);
            if ($response_code !== 200) {
                return false;
            }
            $body = wp_remote_retrieve_body($request);
            $data = json_decode($body);
            if (!empty($data) && isset($data->tag_name)) {
                // Cache for 6 hours
                set_transient($cache_key, $data, 6 * HOUR_IN_SECONDS);
                return $data;
            }
            return false;
        }
    }
}
