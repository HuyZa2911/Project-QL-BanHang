<?php
require_once './config/database.php';
require_once './config/config.php';
spl_autoload_register(function ($classname) {
    require './app/models/' . $classname . '.php';
});
//lay san pham
$path = explode('-', $_SERVER['REQUEST_URI']);
$id = $path[count($path) - 1];
// catogery
$getcategory = new Category();
$category_name = $getcategory->getCategory();
$productModel = new ProductModel();
//lấy thông tin company
$company = $productModel->getCompany();
$item = $productModel->getCompanyById($id)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BLOG MOTO</title>
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
</body>
<section>
<div class="container">
    <h2 style="text-align: center;"><?php echo $item['company_name']; ?></h2>
    <p><?php echo $item['company_description']; ?></p>
</div>
</section>