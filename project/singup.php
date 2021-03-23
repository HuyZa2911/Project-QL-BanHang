<?php
require_once './config/database.php';
require_once './config/config.php';
spl_autoload_register(function ($classname) {
    require './app/models/' . $classname . '.php';
});

$Username='';
$Password='';
$email='';
$access='';
$notification='';

$productModel = new ProductModel();
if (isset($_POST['Username']) && isset($_POST['Password']) && isset($_POST['email']) && isset($_POST['access'])) {
    $Username=$_POST['Username'];
    $Password=md5($_POST['Password']);
    $email=$_POST['email'];
    $access=$_POST['access'];
    $list_user = $productModel->getUser();
    foreach ($list_user as  $user_name) {
        if($user_name['user_name'] == $Username)
        {
            $Username = '';
        }
    }
    if($Username == '')
    {
        $notification = 'Tài Khoản Đã Tồn Tại!!!!';
    }else
    {
        $productModel = new ProductModel();
        $productModel->getSingup($Username,$Password,$email,$access);
        header("location: login.php");
    }
}

?>
<html>
    <head>
        <title>Đăng kí</title>
        <link rel="stylesheet" href="./public/css/singupstyle.css">
    </head>
    <body>
    <form action="" method="post">
        <div class="to">
            <div class="form">
                <h2>Đăng ký</h2>
                <i class="fab fa-app-store-ios"></i>
                <label style="margin-left: -120px;">Tên Tài Khoản</label>
                <input type="text" name="Username"id="Username">
                <label  style="margin-left: -150px;">Mật Khẩu</label>
                <input type="Password" name="Password" id="Password"> 
                <label style="margin-left: -180px;">Email</label>
               <input type="email" name="email" id="email">
                <label style="margin-left: -180px;"> Level:</label>
                <select name='access'>
                    <option value='2'>Member</option>
                    <option value='1'>Admin </option>
                </select> 
                <p style="color:red;margin-left: -70px;"><?php echo $notification; ?></p>
                <button type="submit"id="submit" type="submit" name="submit">Đăng Kí</button>               
            </div>                
        </div>
        </form>
    </body>
</html>