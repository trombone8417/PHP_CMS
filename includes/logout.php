<?php session_start(); ?>
<?php
// 清空SESSION資料
$_SESSION['username']  = null;
$_SESSION['firstname'] = null;
$_SESSION['lastname']  = null;
$_SESSION['user_role'] = null;
// 導回首頁
header("Location: ../index.php");
?>