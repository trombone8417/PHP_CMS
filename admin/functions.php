<?php
// 轉址
function redirect($location)
{
    header("Location:" . $location);
    exit;
}

function ifItIsMethod($method = null)
{
    if ($_SERVER['REQUEST_METHOD'] == strtoupper($method)) {
        return true;
    }
    return false;
}
// 確認是否登入
function isLoggedIn()
{
    // 使否有角色的session值
    if (isset($_SESSION['user_role'])) {
        return true;
    }
    return false;
}

function checkIfUserIsLoggedInAndRedirect($redirectLocation=null){
    if (isLoggedIn()) {
        redirect($redirectLocation);
    }
}
// 線上使用者人數
function users_online()
{

    global $connection;
    if (!$connection) {
        session_start();
        include("../includes/db.php");

        $session = session_id();
        $time = time();
        // 幾秒以內上線人數
        $time_out_in_seconds = 05;
        $time_out = $time - $time_out_in_seconds;

        $query = "SELECT * FROM users_online WHERE session = '$session'";
        $send_query = mysqli_query($connection, $query);
        $count = mysqli_num_rows($send_query);

        if ($count == NULL) {
            // 第一次上線新增session
            $insert_session_query = "INSERT INTO users_online (session, time) VALUES ('$session','$time')";
            mysqli_query($connection, $insert_session_query);
        } else {
            // 之後上線更新session
            mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
        }
        // 計算幾秒以內上線人數
        $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
        // 註冊上線人數
        echo $count_user = mysqli_num_rows($users_online_query);
    }
}
// call function
users_online();

// 確認SQL是否執行成功
function confirmQuery($result)
{
    global $connection;
    if (!$result) {
        // 未執行成功，報錯
        die("QUERY FAILED ." . mysqli_error($connection));
    }
    return $result;
}
// 新增類別
function insert_categories()
{
    global $connection;
    if (isset($_POST['submit'])) {
        $cat_title = $_POST['cat_title'];
        // 判斷類別標題是否為空
        if ($cat_title == "" || empty($cat_title)) {
            echo "類別標題不得為空";
        } else {
            $query = "INSERT INTO categories(cat_title) ";
            $query .= "VALUE('{$cat_title}')";

            $create_category_query = mysqli_query($connection, $query);
            if (!$create_category_query) {
                die('Query FAILED' . mysqli_error($connection));
            }
        }
    }
}

// 顯示所有類別
function findAllCategories()
{
    global $connection;
    $query = "SELECT * FROM categories";
    $select_categories = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($select_categories)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        echo "<tr>";
        echo "<td>{$cat_id}</td>";
        echo "<td>{$cat_title}</td>";
        echo "<td><a href='categories.php?delete={$cat_id}'>刪除</a></td>";
        echo "<td><a href='categories.php?edit={$cat_id}'>編輯</a></td>";
        echo "</tr>";
    }
}

// 刪除類別
function deleteCategories()
{
    global $connection;
    if (isset($_GET['delete'])) {
        $the_cat_id = $_GET['delete'];
        $query = "DELETE FROM categories WHERE cat_id = {$the_cat_id} ";
        $delete_query = mysqli_query($connection, $query);
        header("Location: categories.php");
    }
}
// 計算儀錶板小部件資料(各個資料總數)
function recordCount($table)
{
    global $connection;
    // 選擇要計算的資料表
    $query = "SELECT * FROM " . $table ;
    $select_all_post = mysqli_query($connection, $query);
    // 計算數量
    $result = mysqli_num_rows($select_all_post);
    confirmQuery($result);
    return $result;
}
// 計算狀態
function checkStatus($table, $column, $status)
{
    global $connection;
    $query = "SELECT * FROM $table WHERE $column = '$status'";
    $select_all_published_post = mysqli_query($connection, $query);
    return  mysqli_num_rows($select_all_published_post);
}
// 計算使用者角色
function checkUserRole($table, $column, $role)
{
    global $connection;
    $query = "SELECT * FROM $table WHERE $column = '$role'";
    $select_all_subscribers = mysqli_query($connection, $query);
    return  mysqli_num_rows($select_all_subscribers);
}
// 確認是否為admin角色
function is_admin($username = ''){
    global $connection;
    // 查詢使用者角色
    $query = "SELECT user_role FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($result);
    // 若使用者角色為admin
    if ($row['user_role'] == 'admin') {
        // 回傳值true
        return true;
    }else{
        // 回傳值false
        return false;
    }
}
// 判斷使用者是否註冊過
function username_exists($username)
{
    global $connection;
    // 資料庫查找使用者名稱
    $query = "SELECT username FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    // 判斷使用者名稱總數是否大於零
    if (mysqli_num_rows($result) > 0) {
        // 有
        return true;
    } else {
        // 沒有
        return false;
    }
    
}

// 判斷email是否註冊過
function email_exists($email)
{
    global $connection;
    // 資料庫查找email
    $query = "SELECT user_email FROM user_email WHERE email = '$email'";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    // 判斷email總數是否大於零
    if (mysqli_num_rows($result) > 0) {
        // 有
        return true;
    } else {
        // 沒有
        return false;
    }
    
}
// 使用者註冊
function register_user($username, $email, $password)
{
    global $connection;
    $username = mysqli_real_escape_string($connection, $username);
    $email = mysqli_real_escape_string($connection, $email);
    $password = mysqli_real_escape_string($connection, $password);
    // 密碼加密
    $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
    $query = "INSERT INTO users (username, user_email, user_password, user_role) ";
    $query .= "VALUES('{$username}','{$email}', '{$password}', 'subscriber')";
    $register_user_query = mysqli_query($connection, $query);
    confirmQuery($register_user_query);
}
// 使用者登入
function login_user($username,$password){
    global $connection;
    // trim 清除字串前後空白
    // 帳號
    $username = trim($username);
    // 密碼
    $password = trim($password);
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
    // $password = crypt($password, $db_user_password);
    // 驗證使用者名稱以及密碼是否正確
    if (password_verify($password, $db_user_password)) {
        // SESSION儲存資訊
        $_SESSION['username'] = $db_username;
        $_SESSION['firstname'] = $db_user_firstname;
        $_SESSION['lastname'] = $db_user_lastname;
        $_SESSION['user_role'] = $db_user_role;
        // 導到管理者介面
        header("Location: /PHP_CMS/admin ");
    } else {
        // 錯誤導回首頁
        header("Location: /PHP_CMS/index.php");
    }
}

