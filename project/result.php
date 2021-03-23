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
$keyword = '';
if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
}
$totalRow=0;
$productModel = new ProductModel();
//tìm kiếm sản phẩm
$productList = $productModel->searchProduct($keyword);
// catogery
$getcategory = new Category();
$category_name = $getcategory->getCategory();
//product(danh muc san pham)
$productModel = new ProductModel();
//dem so luong san pham
 $totalRow = $productModel->getSeachTotalRow($keyword);
$pagination = new Pagination();
//lấy thông tin company
$company = $productModel->getCompany();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SEACH</title>
    <link rel="stylesheet" href="/<?php echo BASE_URL; ?>/public/css/style.css">
    <link rel="stylesheet" href="/<?php echo BASE_URL; ?>/public/css/bootstrap.min.css">

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
    <h4>Bạn Tìm Kiếm Từ "<?php echo $keyword; ?>" Có <?php echo $totalRow ?> Sản Phẩm: </h4>
    </div>
  <!-- (: het giao diem chinh :) -->
    <div class="container">
        <?php
        foreach ($productList as $item) {
            $pName = strtolower(str_replace(' ', '-', $item['product_name']));
        ?>
        <div class="row">
            <div class="col-md-2">
                <img src="/<?php echo BASE_URL; ?>/public/images/<?php echo $item['product_image'] ?>" alt="" class="img-fluid">
            </div>
            <div class="col-md-10">
                <h4><a href="/<?php echo BASE_URL; ?>/product.php/<?php echo $pName . '-' . $item['product_id']; ?>"><?php echo $item['product_name']; ?></a></h4>
                <p><?php echo $item['product_price']; ?></p>
            </div>
        </div>
        <?php
        }
        ?>
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
    
</footer>