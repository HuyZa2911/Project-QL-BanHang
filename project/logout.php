<?php 
require_once './config/database.php';
require_once './config/config.php';
spl_autoload_register(function ($classname) {
    require './app/models/'.$classname.'.php';
});
$path = explode('-', $_SERVER['REQUEST_URI']);
session_start();
session_destroy();
header("location:index.php");
