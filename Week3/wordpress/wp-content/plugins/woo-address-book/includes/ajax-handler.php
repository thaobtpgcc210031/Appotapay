<?php
add_action('wp_ajax_save_address', 'wab_save_address');
add_action('wp_ajax_delete_address', 'wab_delete_address');

function wab_save_address() {
    $user_id = get_current_user_id();
    $addresses = get_user_meta($user_id, 'woo_address_book', true) ?: [];
    $address_id = $_POST['address_id'] ?: uniqid();

    $new_address = [
        'id' => $address_id,
        'full_name' => sanitize_text_field($_POST['full_name']),
        'phone' => sanitize_text_field($_POST['phone']),
        'address' => sanitize_textarea_field($_POST['address']),
        'is_default' => !empty($_POST['is_default']),
    ];

    if ($new_address['is_default']) {
        foreach ($addresses as &$addr) $addr['is_default'] = false;
    }

    $addresses[$address_id] = $new_address;
    update_user_meta($user_id, 'woo_address_book', $addresses);
    wp_send_json_success();
}

function wab_delete_address() {
    $user_id = get_current_user_id();
    $addresses = get_user_meta($user_id, 'woo_address_book', true) ?: [];
    $id = $_POST['address_id'];

    if (isset($addresses[$id])) {
        unset($addresses[$id]);
        update_user_meta($user_id, 'woo_address_book', $addresses);
        wp_send_json_success();
    }

    wp_send_json_error();
}
