<!-- 登入頁面 -->
<?php session_start(); ?>
<?php ob_start(); ?>
<?php include "db.php"; ?>
<?php include "../admin/functions.php"; ?>
<?php
if (isset($_POST['login'])) {
    login_user($_POST['username'],$_POST['password']);
    
}

?>