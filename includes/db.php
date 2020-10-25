<?php
// php連線

$db['db_host'] = "127.0.0.1:3308";
$db['db_user'] = "root";
$db['db_pass'] = "";
$db['db_name'] = "cms";

foreach ($db as $key => $value) {
    define(strtoupper($key), $value);
}


$connection = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
// 測試是否連線成功
// if ($connection) {    
//     echo "connected";
// }

?>