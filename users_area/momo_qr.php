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

// Tạo invoice_number ngẫu nhiên
$invoice_number = mt_rand();

// Chèn đơn hàng vào bảng user_orders
$insert_order = "INSERT INTO `user_orders` (user_id, amount_due, invoice_number, total_products, order_status, order_date) 
                 VALUES ('$user_id', '$total_price', '$invoice_number', '$total_products', '$order_status', NOW())";
mysqli_query($con, $insert_order);

// Cấu hình MoMo API
$endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
$partnerCode = 'MOMOBKUN20180529';
$accessKey = 'klm05TvNBzhg7h7j';
$secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
$orderInfo = "Thanh toán đơn hàng qua MoMo";
$ipnUrl = "http://localhost/Ecommerce%20Web%20-%20Copy/users_area/thankyou.php"; 
$redirectUrl = "http://localhost/Ecommerce%20Web%20-%20Copy/users_area/thankyou.php";

$extraData = "";
$orderId = time();
$requestId = time();
$requestType = "captureWallet";

// Tạo chữ ký bảo mật
$rawHash = "accessKey=$accessKey&amount=$total_price&extraData=$extraData&ipnUrl=$ipnUrl&orderId=$orderId&orderInfo=$orderInfo&partnerCode=$partnerCode&redirectUrl=$redirectUrl&requestId=$requestId&requestType=$requestType";
$signature = hash_hmac("sha256", $rawHash, $secretKey);

$data = array(
    'partnerCode' => $partnerCode,
    'partnerName' => "Test",
    'storeId' => "MomoTestStore",
    'requestId' => $requestId,
    'amount' => $total_price,
    'orderId' => $orderId,
    'orderInfo' => $orderInfo,
    'redirectUrl' => $redirectUrl,
    'ipnUrl' => $ipnUrl,
    'lang' => 'vi',
    'extraData' => $extraData,
    'requestType' => $requestType,
    'signature' => $signature
);

function execPostRequest($url, $data) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data)
    ]);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

// Gửi yêu cầu thanh toán
$result = execPostRequest($endpoint, json_encode($data));
$jsonResult = json_decode($result, true);

if (isset($jsonResult['payUrl'])) {
    header('Location: ' . $jsonResult['payUrl']);
    exit();
} else {
    echo "Lỗi: Không thể tạo yêu cầu thanh toán. Vui lòng thử lại.";
}
?>