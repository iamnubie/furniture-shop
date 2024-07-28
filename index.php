<!-- connect file -->
<?php
include('includes/connect.php');
include('functions/common_function.php');
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web thương mại.</title>
    <!-- boostrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" 
    crossorigin="anonymous">
     <!-- font awesome link -->
     <link rel="stylesheet" 
     href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" 
     integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" 
     crossorigin="anonymous" referrerpolicy="no-referrer" />

     <!-- css file -->
    <link rel="stylesheet" href="style.css">
    <style>
      body{
        overflow-x: hidden;
      }
    </style>
</head>
<body>
    <!-- navbar -->
     <div class="container-fluid p-0">
        <!-- first child -->
        <nav class="navbar navbar-expand-lg navbar-light bg-info">
  <div class="container-fluid">
    <img src="./images/logo.png" alt="" class="logo">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Trang chủ</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="display_all.php">Sản phẩm</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./users_area/user_register.php">Đăng ký</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Liên hệ</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cart.php"><i class="fa-solid fa-cart-plus"></i><sup>
            <?php cart_item();?>
          </sup></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Tổng tiền: <?php total_cart_price();?><sup>đ</sup>/-</a>
        </li>
      </ul>
      <form class="d-flex" action="search_product.php" method="get">
        <input class="form-control me-2" type="search" placeholder="Tìm kiếm" 
        aria-label="Search" name="search_data">
        <input type="submit" value="Tìm Kiếm" class="btn btn-outline-light"
        name="search_data_product">
      </form>
    </div>
  </div>
</nav>

<!-- calling cart function -->
 <?php
  cart();
 ?>

<!-- second child -->
<nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
<ul class="navbar-nav me-auto">
        <?php
        if(!isset($_SESSION['username'])){
          echo "<li class='nav-item'>
                  <a class='nav-link' href='#'>Chào Mừng Bạn</a>
                </li>";
        }else{
          echo "<li class='nav-item'>
                <a class='nav-link' href='#'>Chào Mừng ".$_SESSION['username']."</a>
                </li>";
        }
        if(!isset($_SESSION['username'])){
          echo "<li class='nav-item'>
                <a class='nav-link' href='./users_area/user_login.php'>Đăng Nhập</a>
                </li>";
        }else{
          echo "<li class='nav-item'>
                <a class='nav-link' href='./users_area/logout.php'>Đăng Xuất</a>
                </li>";
        }
        ?>
</ul>
</nav>

<!-- third chile -->
<div class="bg-light my-3">
    <h3 class="text-center">Mong Linh Store</h3>
    <p class="text-center">Lắng Nghe - Kiên Trì - Đổi Mới</p>
</div>

<!-- fourth child -->
 <div class="row px-1">
    <div class="col-md-10">
        <!-- products -->
         <div class="row">
          <!-- fetching products -->
          <?php
          //calling function
            getproducts();
            get_unique_categories();
            get_unique_brands();
            // $ip = getIPAddress();  
            // echo 'User Real IP Address - '.$ip; 
          ?>
<!-- row end -->
</div>
<!-- col end -->
</div>
    <div class="col-md-2 bg-secondary p-0">
      <!-- brands to be displayed -->
        <ul class="navbar-nav me-auto text-center">
          <li class="nav-item bg-info">
            <a href="#" class="nav-link text-light"><h4>Thương Hiệu</h4></a>
          </li>
          <?php
            getbrands();
          ?>
        </ul>

        <!-- categories to be displayed -->
        <ul class="navbar-nav me-auto text-center">
          <li class="nav-item bg-info">
            <a href="#" class="nav-link text-light"><h4>Mục Hàng</h4></a>
          </li>
          <?php
            getcategories();
          ?>
        </ul>
    </div>
 </div>


<!-- last child -->
<!-- include footer -->
 <?php include("./includes/footer.php") ?>
     </div>

<!-- boostrap js link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" 
crossorigin="anonymous"></script>
</body>
</html>