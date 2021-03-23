<?php
require_once './config/database.php';
require_once './config/config.php';
spl_autoload_register(function ($className) {
    require './app/models/' . $className . '.php';
});
session_start();
$productName = '';
$productPrice = 0;
$productDescription = '';
$productImage = '';
$productView = 0;
$notification = '';
$link='';
$id = '';
$urlId = '';
$categoryModel = new Category();

$category = $categoryModel->getCategory();
// Láy thông tin product theo id
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $urlId = "?id=$id";
    $productModel = new ProductModel();
    $item = $productModel->getProductById($id);
    $C = $productModel->getCategoryById($id);
    $productName = $item['product_name'];
    $productPrice = $item['product_price'];
    $productDescription = $item['product_description'];
    $productImage = $item['product_image'];
    $sectionP = $C['product_id'];
    $sectionC = $C['category_id'];
}

if (!empty($_POST['productName']) && !empty($_POST['productPrice']) && !empty($_POST['productDescription'])) {
    $productName = $_POST['productName'];
    $productPrice = $_POST['productPrice'];
    $productDescription = $_POST['productDescription'];

    $productModel = new ProductModel();

    // Update product
    if(isset($_GET['id']))
    {
        // Kiểm tra xem có gửi file upload
        if(!empty($_FILES['productImage']['name']))
        {
            // Đường dẫn lưu trữ file được upload
            $productImage = './public/images/' . basename($_FILES['productImage']['name']) ;

            // Thực hiện 2 công việc upload
            if(is_uploaded_file($_FILES['productImage']['tmp_name']) &&
            move_uploaded_file($_FILES['productImage']['tmp_name'], $productImage))
            {
                // Update
                if($productModel->updateProduct($productName, $productPrice, $productDescription, basename($productImage), $id)&& $productModel->updateCategory( $sectionP, $sectionP, $sectionC))
                {
                    $notification = 'Updated successfully';
                }
                else {
                    $notification = 'Updated Failed';
                }

            }
        }
        // Không gửi file upload
        else {
            $productImage = $_POST['oldProductImage'];
            // Update
            if($productModel->updateProduct($productName, $productPrice, $productDescription, basename($productImage), $id)&& $productModel->updateCategory( $sectionP, $sectionP, $sectionC))
            {
                $notification = 'Updated successfully';
            }
            else {
                $notification = 'Updated Failed';
            }
        }

        
    }
    // Add product
    else
    {
        // Kiểm tra xem có gửi file upload hay không
        if(!empty($_FILES['productImage']['name']))
        {
            // Đường dẫn lưu trữ file được upload
            $productImage = './public/images/' . basename($_FILES['productImage']['name']) ;

            // Thực hiện 2 công việc upload
            if(is_uploaded_file($_FILES['productImage']['tmp_name']) &&
            move_uploaded_file($_FILES['productImage']['tmp_name'], $productImage))
            {
                // Thêm vào database
                if($productModel->addProduct($productName, $productPrice, $productDescription, basename($productImage),$productView))
                {
                    $_SESSION['productName']=$productName;
                    $_SESSION['productPrice']=$productPrice;
                    header("location:addCategory.php");
                }
                else {
                    $notification = 'Added Failed';
                }
            }
        }    
    }
}

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
    <title>Setting Product</title>
    <link rel="stylesheet" href="/<?php echo BASE_URL; ?>/public/css/bootstrap.min.css">
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script> 
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script> 
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js"></script> 
</head>
<script>
    $(document).ready(function() {  
      $('#productDescription').summernote();
    });
</script>
<body>
    <div class="container">
        <p><?php echo $notification; ?></p>
        
        <form action="addproduct.php<?php echo $urlId; ?>" method="post" enctype="multipart/form-data">
            <label for="productName">Product name</label>
            <input type="text" name="productName" id="productName" value="<?php echo $productName ?>">
            <br>
            <label for="productPrice">Product price</label>
            <input type="text" name="productPrice" id="productPrice" value="<?php echo $productPrice ?>">
            <br>
            <label for="productDescription">Product description</label>
            <textarea name="productDescription" id="productDescription"><?php echo $productDescription ?></textarea>
            <br>
            <label > Category</label>
                <select name='access'>
                <option>Loại Sản Phẩm</option>
                <?php foreach ($category as $setC) {?>
                    <option value='<?php echo $setC['category_id'] ?>'><?php echo $setC['category_name'] ?></option>
                <?php
                } ?>   
            <br>     
            <label for="productImage">Product image</label>
            <input type="hidden" name="oldProductImage" value="<?php echo $productImage ?>">
            <input type="file" name="productImage" id="productImage">
            <br>
            <button type="submit"class="btn btn-primary"> GO </button>
            <a href="/<?php echo BASE_URL; ?>/manageproduct.php"class="btn btn-primary">Trở về</a>
        </form>
    </div>
</body>
</html>