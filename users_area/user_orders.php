<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
$username=$_SESSION['username'];
$get_user="SELECT * from `user_table` where username='$username'";
$result=mysqli_query($con,$get_user);
$row_fetch=mysqli_fetch_assoc($result);
$user_id=$row_fetch['user_id'];
// echo $user_id;
?>
    <h3 class="text-success">Tất cả đơn hàng</h3>
    <table class="table table-bordered mt-5">
        <thead class="bg-info">
            <tr>
                <th>Thứ tự</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Mã đơn hàng</th>
                <th>Ngày</th>
                <th>Trạng thái đơn hàng</th>
                <th>Trạng thái thanh toán</th>
            </tr>
        </thead>
        <tbody class="bg-secondary text-light">
            <?php
        $get_order_details="SELECT * from `user_orders` where user_id=$user_id";
        $result_orders=mysqli_query($con,$get_order_details);
        $number=1;
        while($row_orders=mysqli_fetch_assoc($result_orders)){
            $order_id=$row_orders['order_id'];
            $amount_due=$row_orders['amount_due'];
            $total_products=$row_orders['total_products'];
            $invoice_number=$row_orders['invoice_number'];
            $order_status=$row_orders['order_status'];
            $order_date=$row_orders['order_date'];
            if($order_status == 'pending'){
                $order_status='Chưa hoàn thành';
            }else{
                $order_status='Hoàn thành';
            }
            $order_date=$row_orders['order_date'];
            $amount_due_format = number_format($amount_due, 0, ',', '.');
            echo "
            <tr>
                <td>$number</td>
                <td>$amount_due_format</td>
                <td>$total_products</td>
                <td>$invoice_number</td>
                <td>$order_date</td>
                <td>$order_status</td>";
            ?>
            <?php
            if($order_status=='Hoàn thành'){
                echo "<td>Đã Xác Nhận</td>";
            }else{
                echo "<td><a href='confirm_payment.php?order_id=$order_id' 
                class='text-light'>Xác Nhận</a></td>
                </tr>";
            }
            $number++;
        }
        ?>

        </tbody>
    </table>
</body>

</html>