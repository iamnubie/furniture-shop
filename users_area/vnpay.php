<?php
    include('../includes/connect.php');
    include('../functions/common_function.php');

    session_start();

    $get_ip_add = getIPAddress();
    $total_price = 0;
    $total_products = 0;
    $cart_query = "SELECT * FROM `cart_details` WHERE ip_address='$get_ip_add'";
    $result = mysqli_query($con, $cart_query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $product_id = $row['product_id'];
            $quantity = $row['quantity'];
            $total_products += $quantity;
            
            $select_products = "SELECT * FROM `products` WHERE product_id='$product_id'";
            $result_products = mysqli_query($con, $select_products);
            while ($row_product_price = mysqli_fetch_array($result_products)) {
                $product_price = $row_product_price['product_price'];
                $subtotal = $product_price * $quantity;
                $total_price += $subtotal;
            }
        }
    } else {
        echo "<script>alert('Giỏ hàng trống!'); window.location='cart.php';</script>";
        exit();
    }

    // Nếu người dùng đã đăng nhập, lấy user_id
    if (!isset($_SESSION['username'])) {
        echo "<script>alert('Bạn cần đăng nhập để thanh toán!'); window.location='../users_area/login.php';</script>";
        exit();
    }
    $username = $_SESSION['username'];
    $get_user = "SELECT user_id FROM `user_table` WHERE username='$username'";
    $result_user = mysqli_query($con, $get_user);
    $row_user = mysqli_fetch_assoc($result_user);
    $user_id = $row_user['user_id'];
    $order_status = 'pending';

    // Tạo invoice_number ngẫu nhiên
    $invoice_number = mt_rand();

    // Chèn đơn hàng vào bảng user_orders
    $insert_order = "INSERT INTO `user_orders` (user_id, amount_due, invoice_number, total_products, order_status, order_date) 
                    VALUES ('$user_id', '$total_price', '$invoice_number', '$total_products', '$order_status', NOW())";
    mysqli_query($con, $insert_order);


    //Tích hợp VNPAY
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    
    $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
    $vnp_Returnurl = "http://localhost/Ecommerce%20Web%20-%20Copy/users_area/thankyou.php";
    $vnp_TmnCode = "QCV5CZ7W";
    $vnp_HashSecret = "WRZAJTBSGTFFFJPGKK34YXKGRQ9MLOWV"; //Chuỗi bí mật
    //Expire
    $startime = date("YmdHis");
    $expire = date('YmdHis', strtotime('+15 minutes',strtotime($startime)));


    //Thanh Toán VNPAY
    $vnp_TxnRef = time() ."" ; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này 
    $vnp_OrderInfo = 'Thanh toán đơn hàng qua VNPAY';
    $vnp_OrderType = 'billpayment';
    $vnp_Amount = $total_price * 100;
    $vnp_Locale = 'vn';
    $vnp_BankCode = 'NCB';
    $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
    //Add Params of 2.0.1 Version
    $vnp_ExpireDate = $expire;

    $inputData = array(
        "vnp_Version" => "2.1.0",
        "vnp_TmnCode" => $vnp_TmnCode,
        "vnp_Amount" => $vnp_Amount,
        "vnp_Command" => "pay",
        "vnp_CreateDate" => date('YmdHis'),
        "vnp_CurrCode" => "VND",
        "vnp_IpAddr" => $vnp_IpAddr,
        "vnp_Locale" => $vnp_Locale,
        "vnp_OrderInfo" => $vnp_OrderInfo,
        "vnp_OrderType" => $vnp_OrderType,
        "vnp_ReturnUrl" => $vnp_Returnurl,
        "vnp_TxnRef" => $vnp_TxnRef,
        "vnp_ExpireDate"=>$vnp_ExpireDate
    );
    
    if (isset($vnp_BankCode) && $vnp_BankCode != "") {
        $inputData['vnp_BankCode'] = $vnp_BankCode;
    }
    
    //var_dump($inputData);
    ksort($inputData);
    $query = "";
    $i = 0;
    $hashdata = "";
    foreach ($inputData as $key => $value) {
        if ($i == 1) {
            $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
        } else {
            $hashdata .= urlencode($key) . "=" . urlencode($value);
            $i = 1;
        }
        $query .= urlencode($key) . "=" . urlencode($value) . '&';
    }
    
    $vnp_Url = $vnp_Url . "?" . $query;
    if (isset($vnp_HashSecret)) {
        $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
        $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
    }
    $returnData = array('code' => '00'
        , 'message' => 'success'
        , 'data' => $vnp_Url);
            header('Location: ' . $vnp_Url);
            exit();
?>