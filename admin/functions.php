<?php

function redirect($location)
{
    header("Location:" . $location);
    exit;
}

function ifItIsMethod($method = null)
{
    if ($_SERVER['REQUEST_METHOD'] == strtoupper($method)) { {
            return true;
        }
        return false;
    }
}

function isLoggedIn()
{
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
            // 第一次上線插入session
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
