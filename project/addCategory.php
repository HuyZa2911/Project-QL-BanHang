<?php
require_once './config/database.php';
require_once './config/config.php';
spl_autoload_register(function ($classname) {
    require './app/models/' . $classname . '.php';
});
session_start();
$i='';
$categoryModel = new Category();

$category = $categoryModel->getCategory();

$productModel= new ProductModel();
$product = $productModel->setProduct();

if (isset($_POST['access'])) {
    foreach ($product as  $P) { 
        if($_SESSION['productName'] == $P['product_name'] &&  $_SESSION['productPrice']==$P['product_price'])
        {  
             $productModel->setCategory($P['product_id'],$_POST['access']);
             unset($_SESSION['productName']);
             unset($_SESSION['productPrice']);
             header("location:addProduct.php");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $_SESSION['productName']?></title>
</head>
<body>

<h3 style="text-align: center;">Loại Sản Phẩm</h3>
<h5>Tên Sản Phẩm: <?php  echo $_SESSION['productName']?></h5>
    <form action="" method="post">
    <label > Category</label>
        <select name='access'>
        <option>Loại Sản Phẩm</option>
        <?php foreach ($category as $setC) {?>
            <option value='<?php echo $setC['category_id'] ?>'><?php echo $setC['category_name'] ?></option>
        <?php
        } ?>    
        </select>
        <button type="submit">GO</button>
    </form>
</body>
</html>