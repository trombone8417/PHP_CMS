
<?php
ob_start();
// PHP資料庫連線
$db['db_host'] = "127.0.0.1";
$db['db_user'] = "root";
// 密碼
$db['db_pass'] = "";
// 資料庫
$db['db_name'] = "cms";


foreach ($db as $key => $value) {
    // 定義
    // 英文名稱轉大寫
    define(strtoupper($key), $value);
}

// 連線
$connection = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);

$query = "SET NAMES utf8";
mysqli_query($connection, $query);

// 測試是否連線成功
// if ($connection) {    
//     echo "connected";
// }

?>