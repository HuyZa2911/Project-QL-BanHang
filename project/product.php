<?php
require_once './config/database.php';
require_once './config/config.php';
spl_autoload_register(function ($classname) {
    require './app/models/'.$classname.'.php';
});
session_start();
$path = explode('-', $_SERVER['REQUEST_URI']);
$catId = $path[count($path) - 1];

$perpage=3;
$page=1;
if(isset($_GET['page'])){
    $page=$_GET['page'];
}
$path = explode('-', $_SERVER['REQUEST_URI']);
$id = $path[count($path) - 1];
// catogery
$getcategory = new Category();
$category_name = $getcategory->getCategory();
//product(danh muc san pham)
$productModel= new ProductModel();
//lay san pham
//$getproduct = $productModel->getProduct($perpage,$page); 
$item = $productModel->getProductById($id);

//dem so luong san pham
$totalRow= $productModel->getTotalRow();

//them comment
if (isset($_POST['comment-t'])) {

    $productModel->addComment($id,$_SESSION['name'],$_POST['comment-t'],date("Y-m-d H:i:s"));
}
// lay thong tin comment
$viewComment= $productModel->getComment($catId);
$_SESSION['view']= $item['product_view'] + 1;

$addView = $productModel->updateView($id,$_SESSION['view']);
unset($_SESSION['view']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $item['product_name']; ?></title>
    <link rel="stylesheet" href="/<?php echo BASE_URL; ?>/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="/<?php echo BASE_URL; ?>/public/css/styleProduct.css">
    <link rel="stylesheet" href="/<?php echo BASE_URL; ?>/public/css/style.css">
    <link rel="stylesheet" href="/<?php echo BASE_URL; ?>/public/js/scrip.js">
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
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="text" placeholder="Search">
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
                    <a class="btn" href="#"><?php echo $name['category_name']; ?></a>
                </li>
                <?php }?>  <!-- dong vong lap Category -->
            </div>
            <div class="col-md-10">
                <div class="display-container-center" style="display: block;">
                         <!-- <a href=""><img src="/<?php echo BASE_URL; ?>/public/images/ducati-panigale-899.jpg" alt="" class="img-fluid" style="with:100%;"></a> -->
                </div>
            </div>
        </div>
    </div>
    <!-- (: het giao diem chinh :) -->
    </div>
    <h1>WELCOME</h1>
    <form action="" method="get">
        <div class="container">
            <div class="imageProduct">
                <img src="/<?php echo BASE_URL; ?>/public/images/<?php echo $item['product_image']; ?>"     alt=""class="img-fluid">
            </div>
             <br>
    
             <h4><?php echo $item['product_name']; ?></h4>
             <p style="font-size: 80%;color:#83898e "> <?php echo $item['product_view']?> Lượt Xem</p>
             <p>Giá Tham Khảo : <?php echo $item['product_price']; ?>$</p>
             <br>
            <p><?php echo $item['product_description']; ?></p>    
            </div>
        </div>
    </form>
    <div class="comment">
        <div class="container">
        <h3 style="text-align:center">COMMENT</h3>
        <?php
        foreach ($viewComment as  $Comment) {
            ?>
                   <div class="row">
                        <div class="col-md-1">
                        <img src="/<?php echo BASE_URL; ?>/public/images/avatar.jpg" alt="Avatar"class="img-fluid">
                        </div>
                        <div class="col-md-11">
                            <h4 style="color:blue"><?php  echo $Comment['user_name'] ?></h4>
                            <p style="font-size: 80%;color:#83898e "><?php echo $Comment['comment_time']?></p>
                            <p><?php echo $Comment['comment_text']?></p>
                        </div>
                    </div>
                   <hr>
            <?php
                }
                ?>
        <?php  if(!isset($_SESSION["inLogin"])) {
            ?>
             <div class=""><a href="../login.php">đăng nhập</a> để comment</div>
             <br>
        <?php }
        else{
         ?>
         <form action="#" method="post">
            <textarea class="form-control" name="comment-t" id="comment-t" rows="5"></textarea>
             <button type="submit">Comment</button>
         </form>
         <?php
        } ?>
        </div>
   </div>
</body>
<footer style="background: #38bb94;"> 
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