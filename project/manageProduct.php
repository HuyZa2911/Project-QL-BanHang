<?php
require_once './config/database.php';
require_once './config/config.php';
spl_autoload_register(function ($className) {
    require './app/models/' . $className . '.php';
});

$productModel = new ProductModel();
$perPage = 4;
$page = 1;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}
$productList = $productModel->getProduct($perPage, $page);
$totalRow = $productModel->getTotalRow();
$pagination = new Pagination();

$notification = '';
if(isset($_POST['productId'])) {
    if($productModel->deleteProduct($_POST['productId'])&& $productModel->deleteCategory($_POST['productId']))
    {
        $notification = 'Deleted successfully.';
    }
    else
    {
        $notification = 'Deleted failed.';
    }
}
session_start();
if($_SESSION["inLogin"] != true)
{
    header("location:login.php");
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DATA BASE</title>
    <link rel="stylesheet" href="/<?php echo BASE_URL; ?>/public/css/bootstrap.min.css">
</head>
<body>
<div class="container">
<a href="/<?php echo BASE_URL; ?>/index.php"class="btn btn-primary">Home</a>
<a href="/<?php echo BASE_URL; ?>/addProduct.php"class="btn btn-primary">Add Product</a>
    <table class="table">
        <tr>
            <td>Product name</td>
            <td>Action</td>
         </tr>
    <?php foreach ($productList as  $item) {
    ?>
    <tr>
        <td><?php echo $item['product_name']; ?></td>
        <td>
            <!-- Update -->
            <a href="/<?php echo BASE_URL; ?>/addProduct.php?id=<?php echo $item['product_id']; ?>" class="btn btn-primary">Update</a>
            <!-- Delete -->
            <form action="manageproduct.php" method="post" onsubmit="return deleteConfirm();">
                <input type="hidden" name="productId" value="<?php echo $item['product_id']; ?>">
                <br>
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
         </td>
    </tr>
    <?php } ?>
     </table>
    <?php
        echo $pagination->creatPageLinlks('manageProduct.php', $totalRow, $perPage, $page);
     ?>
     
</div>    
</body>
</html>