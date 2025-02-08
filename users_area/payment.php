<?php
include('../includes/connect.php');
include('../functions/common_function.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang thanh toán</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
    .payment_img {
        max-width: 220px;
        height: auto;
    }

    .vnpay_img {
        max-width: 180px;
        height: auto;
    }

    .payment_img2 {
        max-width: 180px;
        height: auto;
    }

    .payment-title {
        font-size: 20px;
    }
    </style>
</head>

<body>
    <!-- Lấy ID người dùng -->
    <?php
    $user_ip = getIPAddress();
    $get_user = "SELECT * FROM `user_table` WHERE user_ip='$user_ip'";
    $result = mysqli_query($con, $get_user);
    $run_query = mysqli_fetch_array($result);
    $user_id = $run_query['user_id'];
    ?>

    <div class="container">
        <h1 class="text-center text-info my-4">Chọn hình thức thanh toán</h1>

        <!-- Hàng chứa tiêu đề và ảnh -->
        <div class="row justify-content-center text-center gap-3">
            <div class="col-md-2 d-flex flex-column align-items-center">
                <span class="fw-bold fs-3 mb-2">MoMo</span>
                <a href="momo.php">
                    <img src="../images/momo.jpg" alt="Momo Payment" class="payment_img img-fluid">
                </a>
            </div>
            <div class="col-md-2 d-flex flex-column align-items-center">
                <span class="fw-bold fs-3 mb-2">MoMo QR</span>
                <a href="momo_qr.php">
                    <img src="../images/momo_qr.png" alt="Momo QR Payment" class="payment_img img-fluid">
                </a>
            </div>
            <div class="col-md-2 d-flex flex-column align-items-center">
                <span class="fw-bold fs-3 mb-2">VNPAY</span>
                <a href="vnpay.php">
                    <img src="../images/vnpay.png" alt="VNPAY Payment" class="vnpay_img img-fluid">
                </a>
            </div>
            <div class="col-md-2 d-flex flex-column align-items-center">
                <span class="fw-bold fs-3 mb-2">VNPAY QR</span>
                <a href="vnpay_qr.php">
                    <img src="../images/vnpay_qr.jpg" alt="VNPAY QR Payment" class="vnpay_img img-fluid">
                </a>
            </div>
            <div class="col-md-2 d-flex flex-column align-items-center">
                <span class="fw-bold fs-3 mb-2">COD</span>
                <a href="order.php?user_id=<?php echo $user_id ?>">
                    <img src="../images/cod.png" alt="Cash on Delivery" class="payment_img2 img-fluid">
                </a>
            </div>
        </div>

    </div>

</body>

</html>