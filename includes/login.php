<!-- 登入頁面 -->
<?php include "db.php"; ?>
<?php ob_start(); ?>
<?php session_start(); ?>
<?php
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    // mysqli_real_escape_string 轉義在 SQL 語句中使用的字符串中的特殊字符
    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);

    $query = "SELECT * FROM users WHERE username = '{$username}' ";
    $select_user_query = mysqli_query($connection, $query);
    if (!$select_user_query) {
        die("QUERY FAILED" . mysqli_error($connection));
    }

    while ($row = mysqli_fetch_array($select_user_query)) {
        $db_user_id = $row['user_id'];
        $db_username = $row['username'];
        $db_user_password = $row['user_password'];
        $db_user_firstname = $row['user_firstname'];
        $db_user_lastname = $row['user_lastname'];
        $db_user_role = $row['user_role'];
    }
    // 確認加密密碼
    $password = crypt($password, $db_user_password);
    // 驗證使用者名稱以及密碼是否正確
    if ($username === $db_username && $password === $db_user_password) {
        // SESSION儲存資訊
        $_SESSION['username'] = $db_username;
        $_SESSION['firstname'] = $db_user_firstname;
        $_SESSION['lastname'] = $db_user_lastname;
        $_SESSION['user_role'] = $db_user_role;
        // 導到管理者介面
        header("Location: ../admin ");
    } else {
        // 錯誤導回首頁
        header("Location: ../index.php");
    }
}

?>