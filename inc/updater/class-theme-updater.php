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

        private function get_github_data()
        {
            $url = "https://api.github.com/repos/{$this->username}/{$this->repository}/releases/latest"; // phpcs:ignore

            $args = array();
            if (!empty($this->github_auth)) {
                $args['headers'] = array(
                    'Authorization' => 'token ' . $this->github_auth,
                );
            }

            $request = wp_safe_remote_get($url, $args);

            if (is_wp_error($request)) {
                return false;
            }

            $body = wp_remote_retrieve_body($request);
            $data = json_decode($body);

            if (!empty($data)) {
                return $data;
            }

            return false;
        }
    }
}
