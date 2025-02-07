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
    <!-- boostrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<style>
.payment_img {
    width: 95%;
    margin: auto;
    display: block;
}

.payment_img2 {
    width: 80%;
    margin: auto;
    display: block;
}

/* .row{
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 50px;
    } */
/* .container{
        padding-top:30px;
    } */
</style>

<body>
    <!-- code php truy cap id cua nguoi dung -->
    <?php
    $user_ip=getIPAddress();
    $get_user="SELECT * FROM `user_table` where user_ip='$user_ip'";
    $result=mysqli_query($con,$get_user);
    $run_query=mysqli_fetch_array($result);
    $user_id=$run_query['user_id'];
    ?>
    <div class="container">
        <h2 class="text-center text-info">Chọn hình thức thanh toán</h2>
        <div class="row d-flex justify-content-center align-items-center my-5">
            <div class="col-md-4 text-center">
                <h3 class="text-center">MoMo OTP</h3>
                <a href="momo.php">
                    <img src="../images/momo.jpg" alt="Momo Payment" class="payment_img">
                </a>
                <div class="momo_qr mt-4">
                    <h3 class="text-center">MoMo QR</h3>
                    <a href="momo_qr.php">
                        <img src="../images/momo_qr.png" alt="Momo Payment" class="payment_img">
                    </a>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <h3 class="text-center">VNPAY</h3>
                <a href="vnpay.php">
                    <img src="../images/vnpay.png" alt="Bank Payment" class="payment_img">
                </a>
            </div>
            <div class="col-md-4 text-center">
                <a href="order.php?user_id=<?php echo $user_id ?>" class="d-block">
                    <h2 class="text-center">Trả khi nhận hàng</h2>
                    <img src="../images/cod.png" alt="Cash on Delivery" class="payment_img2">
                </a>
            </div>
        </div>
    </div>

</body>

</html>