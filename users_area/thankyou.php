<!-- 
include('../includes/connect.php');
include('../functions/common_function.php');
session_start();

if (isset($_GET['orderId']) && isset($_GET['resultCode'])) {
    $order_id = $_GET['orderId']; // Mã đơn hàng MoMo
    $resultCode = $_GET['resultCode']; // Kết quả thanh toán (0 = thành công)

    if ($resultCode == 0) { // Nếu thanh toán thành công
        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];

            // Lấy user_id từ bảng user_table
            $get_user = "SELECT user_id FROM `user_table` WHERE username='$username'";
            $result_user = mysqli_query($con, $get_user);
            $row_user = mysqli_fetch_assoc($result_user);
            $user_id = $row_user['user_id'];

            // **Cập nhật trạng thái đơn hàng**
            $update_order = "UPDATE `user_orders` SET order_status='Hoàn thành' WHERE user_id='$user_id' ORDER BY order_id DESC LIMIT 1";
            mysqli_query($con, $update_order);

            // **Xóa giỏ hàng sau khi thanh toán**
            $delete_cart = "DELETE FROM `cart_details` WHERE ip_address='" . getIPAddress() . "'";
            mysqli_query($con, $delete_cart);

            echo "<script>alert('Thanh toán thành công! Đơn hàng đã được cập nhật.'); window.location='../index.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Thanh toán thất bại! Vui lòng thử lại.'); window.location='../index.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('Dữ liệu không hợp lệ!'); window.location='../index.php';</script>";
    exit();
}
?> -->
<?php
include('../includes/connect.php');
include('../functions/common_function.php');
session_start();

if (isset($_GET['orderId']) && isset($_GET['resultCode'])) {
    $order_id = $_GET['orderId']; // Mã đơn hàng MoMo
    $resultCode = $_GET['resultCode']; // Kết quả thanh toán (0 = thành công)

    if ($resultCode == 0) { // Nếu thanh toán thành công
        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];

            // Lấy user_id từ bảng user_table
            $get_user = "SELECT user_id FROM `user_table` WHERE username='$username'";
            $result_user = mysqli_query($con, $get_user);
            $row_user = mysqli_fetch_assoc($result_user);
            $user_id = $row_user['user_id'];

            // **Cập nhật trạng thái đơn hàng**
            $update_order = "UPDATE `user_orders` SET order_status='Hoàn thành' WHERE user_id='$user_id' ORDER BY order_id DESC LIMIT 1";
            mysqli_query($con, $update_order);

            // **Xóa giỏ hàng sau khi thanh toán**
            $delete_cart = "DELETE FROM `cart_details` WHERE ip_address='" . getIPAddress() . "'";
            mysqli_query($con, $delete_cart);

            echo "<script>alert('Thanh toán thành công! Đơn hàng đã được cập nhật.'); window.location='../index.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Thanh toán thất bại! Vui lòng thử lại.'); window.location='../index.php';</script>";
        exit();
    }
}
elseif (isset($_GET['vnp_TxnRef']) && isset($_GET['vnp_ResponseCode'])) {
        // --- XỬ LÝ THANH TOÁN VNPAY ---
        $vnp_TxnRef = $_GET['vnp_TxnRef']; // Mã đơn hàng VNPAY
        $vnp_ResponseCode = $_GET['vnp_ResponseCode']; // Mã phản hồi (00 = thành công)

        if ($vnp_ResponseCode == "00") { // Nếu thanh toán thành công
            if (isset($_SESSION['username'])) {
                $username = $_SESSION['username'];

                // Lấy user_id từ bảng user_table
                $get_user = "SELECT user_id FROM `user_table` WHERE username='$username'";
                $result_user = mysqli_query($con, $get_user);
                $row_user = mysqli_fetch_assoc($result_user);
                $user_id = $row_user['user_id'];

                // **Cập nhật trạng thái đơn hàng**
                $update_order = "UPDATE `user_orders` SET order_status='Hoàn thành' WHERE user_id='$user_id' ORDER BY order_id DESC LIMIT 1";
                mysqli_query($con, $update_order);

                // **Xóa giỏ hàng sau khi thanh toán**
                $delete_cart = "DELETE FROM `cart_details` WHERE ip_address='" . getIPAddress() . "'";
                mysqli_query($con, $delete_cart);

                echo "<script>alert('Thanh toán VNPAY thành công! Đơn hàng đã được cập nhật.'); window.location='../index.php';</script>";
                exit();
            }
        } else {
            echo "<script>alert('Thanh toán VNPAY thất bại! Vui lòng thử lại.'); window.location='../index.php';</script>";
            exit();
        }
} else {
    echo "<script>alert('Dữ liệu không hợp lệ!'); window.location='../index.php';</script>";
    exit();
}

?>