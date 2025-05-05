<?php
$user_id = get_current_user_id();
$addresses = get_user_meta($user_id, 'woo_address_book', true) ?: [];
?>
<form id="address-book-form">
    <input type="hidden" name="address_id" id="address_id" value="">
    <input type="text" name="full_name" placeholder="Họ và tên" required>
    <input type="text" name="phone" placeholder="Số điện thoại" required>
    <textarea name="address" placeholder="Địa chỉ chi tiết" required></textarea>
    <label><input type="checkbox" name="is_default"> Đặt làm mặc định</label>
    <button type="submit">Lưu địa chỉ</button>
</form>

<h3>Danh sách địa chỉ</h3>
<ul>
    <?php foreach ($addresses as $address): ?>
        <li data-id="<?= esc_attr($address['id']) ?>">
            <strong><?= esc_html($address['full_name']) ?></strong> - <?= esc_html($address['phone']) ?><br>
            <?= esc_html($address['address']) ?> <?= !empty($address['is_default']) ? '(Mặc định)' : '' ?><br>
            <button class="delete-address">Xoá</button>
        </li>
    <?php endforeach; ?>
</ul>
