<?php

defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Custom URI Core Extension untuk OpenSID
 *
 * Mengabaikan pemeriksaan filter_uri pada CLI / Artisan Console Runner
 * agar password kompleks (seperti tanda seru '!', '@', '#') dan flag opsi CLI
 * tidak dianggap sebagai karakter URL ilegal.
 */
class MY_URI extends CI_URI
{
    public function __construct()
    {
        parent::__construct();

        if ((function_exists('is_cli') && is_cli()) || PHP_SAPI === 'cli' || defined('ARTISAN_CLI') || defined('STDIN')) {
            $this->_permitted_uri_chars = '';
        }
    }

    public function filter_uri(&$str)
    {
        // Jika dieksekusi dari terminal CLI (artisan, cron, dll), lewati filter URL
        if ((function_exists('is_cli') && is_cli()) || PHP_SAPI === 'cli' || defined('ARTISAN_CLI') || defined('STDIN')) {
            return;
        }

        parent::filter_uri($str);
    }
}
