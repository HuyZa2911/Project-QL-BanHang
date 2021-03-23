<?php
require_once './config/database.php';
require_once './config/config.php';
spl_autoload_register(function ($classname) {
    require './app/models/' . $classname . '.php';
});

$productModel = new ProductModel();
$list_user = $productModel ->getUser();
$username = '';
$pass = '';
$TB='';

if (isset($_POST['Username']) && isset($_POST['Password'])) {
    foreach ($list_user as  $user) {
        if(($_POST['Username']) == $user['user_name'] && md5($_POST['Password'])==$user['user_pass'])
        {
             $username=$user['user_name'];
             $pass=$user['user_pass'];
             $rol=$user['user_rol'];
        }
    }
    if(($_POST['Username']) == $username && md5($_POST['Password'])==$pass)
    {
         session_start();
         $_SESSION['inLogin'] = true;
         $_SESSION['name'] = $username;
         if($rol == 1)
         {
             header('location: manageproduct.php');
         }
         else{
            $_SESSION["inLogin"] = false;
            header('location:index.php');
         }    
    }
    else{
       $TB = "Nhap Sai!!!";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LogIn</title>
    <link rel="stylesheet" href="./public/css/loginstyle.css">
</head>
<body>
    <form action="" method="post">
        <h1>Login</h1>       
        <input placeholder="Username" type="text" required=""name="Username" id="Username">
        <input placeholder="Password" type="password" required=""name="Password" id="Password">
        <p style = "color: red;"><?php echo $TB; ?></p>
        <br> <br>
        <button>Submit</button>
        <p>chưa có tài khoản <a href="/<?php echo BASE_URL; ?>/singup.php"> đăng kí</a></p>
    </form>

</body>
</html>