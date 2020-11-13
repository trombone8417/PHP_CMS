<?php ob_start();?>
<?php session_start();?>
<?php include "../includes/db.php"?>
<?php include "functions.php"?>
<?php
// 確認是否登入
if (!isset($_SESSION['user_role'])) {
    // 未登入導回首頁
    header("Location: ../index.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>管理者</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Custom CSS -->
    <link href="css/styles.css" rel="stylesheet">
    <!-- 圖表 -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <!-- 資料表 DataTables v1.10.16 -->
  <link href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" rel="stylesheet" />
  <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
  
  


</head>

<body>
