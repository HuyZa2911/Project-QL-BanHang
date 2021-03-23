<?php
require_once './config/database.php';
require_once './config/config.php';
spl_autoload_register(function ($classname) {
    require './app/models/' . $classname . '.php';
});

$perpage = 8;
$page = 1;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}

// catogery
$getcategory = new Category();
$category_name = $getcategory->getCategory();
//product(danh muc san pham)
$productModel = new ProductModel();
//lay san pham
$getproduct = $productModel->getProduct($perpage, $page);
//dem so luong san pham
$totalRow = $productModel->getTotalRow();
$pagination = new Pagination();
//lấy thông tin company
$company = $productModel->getCompany();
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BLOG MOTO</title>
    <link rel="stylesheet" href="/<?php echo BASE_URL; ?>/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="/<?php echo BASE_URL; ?>/public/css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" integrity="sha384-KA6wR/X5RY4zFAHpv/CnoG2UW1uogYfdnP67Uv7eULvTveboZJg0qUpmJZb5VqzN" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-sm navbar-light bg-light">
        <a class="navbar-brand" href="/<?php echo BASE_URL; ?>/">BLOG MOTO</a>
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <a class="nav-link" href="/<?php echo BASE_URL; ?>/">Home <span class="sr-only">(current)</span></a>
                </li>
                <!-- In Category -->
                <?php
foreach ($category_name as $name) {
    $catName = strtolower(str_replace(' ', '-', $name['category_name']));
    ?>
    
                <li class="nav-item">
                    <a class="nav-link" href="/<?php echo BASE_URL; ?>/category.php/<?php echo $catName . '-' . $name['category_id'] ?>"><?php echo $name['category_name']; ?></a>
                </li>
                <?php }?>  <!-- dong vong lap Category -->
            </ul>
            <form class="form-inline my-2 my-lg-0"method="get" action="/<?php echo BASE_URL ?>/result.php">
                <input class="form-control mr-sm-2" type="text" placeholder="Search"name="keyword">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>
    <div class="background">
    <div class="container">
        <div class="row">
            <div class="col md-2">
            <?php
foreach ($category_name as $name) {
    ?>
                <li class="btn">
                    <a class="btn" href="/<?php echo BASE_URL; ?>/category.php/<?php echo $catName . '-' . $name['category_id'] ?>"><?php echo $name['category_name']; ?></a>
                </li>
                <?php }?>  <!-- dong vong lap Category -->
            </div>
            <div class="col-md-10">
                <div class="display-container-center" style="display: block;">
                         <!-- <a href=""><img src="./public/images/ducati-panigale-899.jpg" alt="" class="img-fluid" style="with:100%"></a> -->
                </div>
            </div>
        </div>
    </div>
    </div>
  <!-- (: het giao diem chinh :) -->

    <br>
    <h1>WELCOME</h1>
    <p style=" text-align: center;">Xin Chào Các Bạn</p>
    <div class="blog">
    <form action="" method="get">

        <div class="container">
            <div class="row">
                <?php
foreach ($getproduct as $item) {
    $pName = strtolower(str_replace(' ', '-', $item['product_name']));
    ?>
                <div class="col-md-3">

                    <div class="gallery"style=" background: rgb(201, 189, 201);">
                    <a href="/<?php echo BASE_URL; ?>/product.php/<?php echo $pName . '-' . $item['product_id']; ?>"><img src="./public/images/<?php echo $item['product_image']; ?>">
                    </a>
                    <div class="desc"><a href="/<?php echo BASE_URL; ?>/product.php/<?php echo $pName . '-' . $item['product_id']; ?>"style=" color: black;"><?php echo $item['product_name']; ?></a></div>

                    <p><button class="addBuy"><a href="/<?php echo BASE_URL; ?>/product.php/<?php echo $pName . '-' . $item['product_id']; ?>"style=" color: white;">See More</a> </button></p>
                    </div>
    </div>
                <?php
}
?>
            </div>

            <?php
echo $pagination->creatPageLinlks('', $totalRow, $perpage, $page);
?>
        </div>

    </form>

    
    <img src="./public/images/banner.png" alt="" style=" max-width:100% ;margin: 0 auto; display: block;">
<!-- các thương hiệu -->
    <br><br>
    <div class="container">
    <div class="row">
    <?php
foreach ($company as $c) {
    $cat=strtolower(str_replace(' ', '-', $c['company_name']));
    ?>

        <div class="col-md-2">
            <div class="br">
            <a href="/<?php echo BASE_URL; ?>/company.php/<?php echo $cat . '-' . $c['company_id']; ?>"><img src="./public/images/<?php echo $c['company_image']; ?>"style="width:100%; height:100px"class="img-fluid"></a>
            </div>
        </div>

        <?php }?>

        </div>
        </div>
        <br><br><br>

    </div>
    <footer> 
        <div class="btn btn-info"style="  position: fixed;bottom: 5px;right: 5px;">
        <?php 
        if (!isset($_SESSION['name'])) {
        ?>
           <a href="/<?php echo BASE_URL; ?>/login.php"style="color:white">Log In</a> / <a href="singup.php"style="color:white">Sing Up</a>

         <?php 
        }else{
        ?>
            <a href="#"style="color:white">TK: <?php $_SESSION['name'] ?></a> (<a href="/<?php echo BASE_URL; ?>/logout.php"style="color:black">LogOut</a>)
        <?php
        }
        ?>
        

    </div>
</body>

    <br>
    <div class="container">
        <div class="row">
            <div class="col-md-4">

                <ul>
                    <li>Bùi Văn Huy</li>
                    <li>18211TT2894</li>
                    <li>Gmail: huyza.2911@gmail.com</li>
                </ul>    
        
            </div>
            <div class="col-md-4">
                <li>Nguyễn Hoàng Duy</li>
                <li>18211TT4718</li>
                <li>Gmail:nguyenhoangduy18032000@gmail.com</li>
            </div>
            <div class="col-md-4">
                <h6>BLOG MOTO</h6>
                <p>Liên Hệ</p>
                <a href="https://www.facebook.com/Bui.Huy.47"><i class="fab fa-facebook"></i></a>
                <a href="http://zaloapp.com/qr/p/4y9ui2w5f2nk"><i class="fas fa-user-circle"></i></a>
                <a href="https://www.instagram.com/romza_2911"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </div>
    <br>
    <p style="text-align: center;">Copyright&copy;2019-Bui Van Huy-Nguyen Hoang Duy</p>
    <br>
</footer>
</html>