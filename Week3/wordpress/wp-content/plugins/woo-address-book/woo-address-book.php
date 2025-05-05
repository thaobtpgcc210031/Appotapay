<?php
/**
 * Plugin Name: Woo Address Book
 * Description: Quản lý sổ địa chỉ giao hàng cho WooCommerce như Shopee.
 * Version: 1.0
 * Author: ChatGPT Dev
 */

if (!defined('ABSPATH')) exit;

define('WAB_PATH', plugin_dir_path(__FILE__));

add_action('init', function() {
    if (is_user_logged_in()) {
        add_shortcode('woo_address_book', 'wab_render_form');
    }
});

function wab_render_form() {
    ob_start();
    include WAB_PATH . 'templates/address-form.php';
    return ob_get_clean();
}

add_action('wp_enqueue_scripts', function() {
    wp_enqueue_script('woo-address-book-js', plugin_dir_url(__FILE__) . 'assets/script.js', ['jquery'], null, true);
    wp_localize_script('woo-address-book-js', 'WAB', [
        'ajax_url' => admin_url('admin-ajax.php')
    ]);
});

require_once WAB_PATH . 'includes/ajax-handler.php';
