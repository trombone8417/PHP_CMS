<!-- 登入頁面 -->
<?php session_start(); ?>
<?php ob_start(); ?>
<?php include "db.php"; ?>
<?php include "../admin/functions.php"; ?>
<?php
if (isset($_POST['login'])) {
    // 傳送帳號密碼到登入使用者的function，在VScode可用F12查看
    login_user($_POST['username'],$_POST['password']);
    
}

?>