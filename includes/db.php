<?php
// php連線

$db['db_host'] = "localhost";
$db['db_user'] = "root";
$db['db_pass'] = "0000";
$db['db_name'] = "cms_php";

foreach ($db as $key => $value) {
    define(strtoupper($key), $value);
}


$connection = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
if ($connection) {
    // 連線成功
    echo "connected";
}




?>