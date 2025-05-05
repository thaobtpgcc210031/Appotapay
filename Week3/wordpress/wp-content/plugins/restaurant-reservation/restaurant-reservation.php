<?php
/*
Plugin Name: Restaurant Reservation
Description: Plugin đặt bàn nhà hàng.
Version: 1.0
Author: Your Name
*/

// Load PHPMailer
require_once plugin_dir_path(__FILE__) . 'PHPMailer/src/PHPMailer.php';
require_once plugin_dir_path(__FILE__) . 'PHPMailer/src/SMTP.php';
require_once plugin_dir_path(__FILE__) . 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Tạo menu quản trị
function rr_add_admin_menu() {
    add_menu_page(
        'Restaurant Reservation', 
        'Restaurant Reservation', 
        'manage_options', 
        'restaurant_reservation', 
        'rr_admin_page', 
        'dashicons-calendar'
    );
}
add_action('admin_menu', 'rr_add_admin_menu');

// Trang cài đặt admin
function rr_admin_page() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['available_slots'])) {
        update_option('rr_available_slots', sanitize_text_field($_POST['available_slots']));
        echo '<p style="color:green;">Settings saved!</p>';
    }

    ?>
    <h1>Restaurant Reservation Settings</h1>
    <form method="post" action="">
        <label for="available_slots">Set Available Time Slots:</label><br>
        <input type="text" id="available_slots" name="available_slots" placeholder="e.g. 12:00 PM, 2:00 PM, 6:00 PM" value="<?php echo esc_attr(get_option('rr_available_slots')); ?>"><br><br>
        <input type="submit" value="Save Settings">
    </form>
    <?php
}

// Tạo form thanh toán
// Tạo form thanh toán giả lập Momo
function rr_payment_form($seats) {
    // Giả sử giá mỗi ghế là $20
    $price_per_seat = 20;
    $total_amount = $seats * $price_per_seat;

    // Giả lập thanh toán Momo
    ?>
    <h3>Your Total: $<?php echo $total_amount; ?></h3>
    <form method="post" action="">
        <p>Thanh toán giả lập bằng Momo:</p>
        
        <label for="momo_account">Tài khoản Momo của bạn:</label><br>
        <input type="text" id="momo_account" name="momo_account" required><br><br>
        
       

        <button type="submit" name="momo_payment" value="pay">Thanh toán qua Momo</button>
    </form>
    <?php
}

// Xử lý thanh toán Momo giả lập
function rr_process_momo_payment() {
    if (isset($_POST['momo_payment']) && $_POST['momo_payment'] == 'pay') {
        // Kiểm tra thông tin tài khoản và mã MR
        $momo_account = sanitize_text_field($_POST['momo_account']);
        $momo_reference = sanitize_text_field($_POST['momo_reference']);

        if (empty($momo_account) || empty($momo_reference)) {
            echo '<p style="color:red;">Vui lòng điền đầy đủ thông tin tài khoản và mã MR.</p>';
            return;
        }

        // Giả lập thanh toán thành công
        echo '<p style="color:green;">Thanh toán qua Momo thành công! Cảm ơn bạn đã đặt bàn.</p>';

        // Thực hiện các bước tiếp theo như gửi email xác nhận, v.v.
    }
}

add_action('wp_footer', 'rr_process_momo_payment');




// Kiểm tra bàn trống
function rr_check_availability($booking_date, $booking_time, $seats_required) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'restaurant_bookings';

    // Lấy số lượng bàn đã đặt cho ngày và giờ cụ thể
    $seats_booked = $wpdb->get_var($wpdb->prepare(
        "SELECT SUM(seats_required) FROM $table_name WHERE booking_date = %s AND booking_time = %s",
        $booking_date, $booking_time
    ));

    // Kiểm tra nếu số ghế đã đặt không vượt quá số ghế tối đa
    $seats_available = 50; // Số ghế tối đa có sẵn
    if (($seats_available - $seats_booked) >= $seats_required) {
        return true;
    } else {
        return false;
    }
}

// Gửi email xác nhận đặt bàn
function rr_send_confirmation_email($to, $name, $date, $time) {
    $mail = new PHPMailer(true);

    try {
        // Cấu hình SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'thaobtpgcc210031@fpt.edu.vn'; // Thay bằng email của bạn
        $mail->Password   = 'hzhk liom sieo bfho';    // App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Người gửi
        $mail->setFrom('thaobtpgcc210031@fpt.edu.vn', 'Restaurant Reservation');
        $mail->addAddress($to, $name);

        // Nội dung
        $mail->isHTML(true);
        $mail->Subject = 'Table Booking Confirmation';
        $mail->Body    = "Hi $name,<br>Your table booking is confirmed for <strong>$date</strong> at <strong>$time</strong>.<br><br>Thank you!";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mailer Error: " . $mail->ErrorInfo);
        return false;
    }
}

// Xử lý đặt bàn và hiển thị form thanh toán
function rr_handle_booking() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['booking_date'])) {
        $date  = sanitize_text_field($_POST['booking_date']);
        $time  = sanitize_text_field($_POST['booking_time']);
        $seats = isset($_POST['seats_required']) ? intval($_POST['seats_required']) : 0;
        $name  = sanitize_text_field($_POST['customer_name']);
        $email = sanitize_email($_POST['customer_email']);

        if (!rr_check_availability($date, $time, $seats)) {
            echo '<p style="color:red;">Sorry, this time slot is already taken or not enough seats available. Please choose a different time or number of seats.</p>';
            return;
        }

        if ($seats <= 0) {
            echo '<p style="color:red;">Please specify the number of seats.</p>';
            return;
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'restaurant_bookings';

        $wpdb->insert($table_name, [
            'booking_date'    => $date,
            'booking_time'    => $time,
            'customer_name'   => $name,
            'customer_email'  => $email,
            'seats_required'  => $seats
        ]);

        // Gửi email xác nhận
        $mail_sent = rr_send_confirmation_email($email, $name, $date, $time);

        if ($mail_sent) {
            echo '<p style="color:green;">Thank you for your booking! A confirmation email has been sent.</p>';

            // Hiển thị form thanh toán
            rr_payment_form($seats); // Hiển thị form thanh toán với số tiền cần thanh toán
        } else {
            echo '<p style="color:red;">There was an error sending the confirmation email.</p>';
        }
    }
}

// Shortcode hiển thị form đặt bàn
function rr_booking_form() {
    ob_start();
    ?>
    <form method="post" action="">
    <label for="booking_date">Choose a Date:</label><br>
    <input type="date" id="booking_date" name="booking_date" required><br><br>

    <label for="booking_time">Choose a Time:</label><br>
    <select name="booking_time" required>
        <?php 
        $slots = get_option('rr_available_slots');
        if ($slots) {
            $slots = array_map('trim', explode(',', $slots));
            foreach ($slots as $slot) {
                echo '<option value="' . esc_attr($slot) . '">' . esc_html($slot) . '</option>';
            }
        } else {
            echo '<option value="">No available slots</option>';
        }
        ?>
    </select><br><br>

    <label for="seats_required">Number of Seats:</label><br>
    <input type="number" id="seats_required" name="seats_required" required><br><br>

    <label for="customer_name">Your Name:</label><br>
    <input type="text" id="customer_name" name="customer_name" required><br><br>

    <label for="customer_email">Your Email:</label><br>
    <input type="email" id="customer_email" name="customer_email" required><br><br>

    <input type="submit" value="Book Table">
</form>

    <?php
    rr_handle_booking();
    return ob_get_clean();
}

add_shortcode('restaurant_booking_form', 'rr_booking_form');
