<!-- 編輯使用者 -->
<?php

if (isset($_GET['edit_user'])) {
    $the_user_id = $_GET['edit_user'];

    $query = "SELECT * FROM users WHERE user_id = $the_user_id ";
    $select_users = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($select_users)) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_role = $row['user_role'];
    }

    if (isset($_POST['edit_user'])) {

        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_role     = $_POST['user_role'];
        // $user_image = $_FILES['image']['name'];
        // $user_image_temp = $_FILES['image']['tmp_name'];
        $username    = $_POST['username'];
        $user_email = $_POST['user_email'];
        $user_password = $_POST['user_password'];
        // $user_date = date('d-m-y');

        if (!empty($user_password)) {
            $query_password = "SELECT user_password FROM users WHERE user_id = $the_user_id ";
            $get_user_query = mysqli_query($connection, $query_password);
            $row = mysqli_fetch_array($get_user_query);
            $db_user_password = $row['user_password'];
            confirmQuery($get_user_query);


            if ($db_user_password != $user_password) {
                $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
            }else {
                $user_password = $db_user_password;
            }

            $query = "UPDATE users SET ";
            $query .= "user_firstname = '{$user_firstname}', ";
            $query .= "user_lastname = '{$user_lastname}', ";
            $query .= "user_role = '{$user_role}', ";
            $query .= "username = '{$username}', ";
            $query .= "user_email = '{$user_email}', ";
            $query .= "user_password = '{$user_password}' ";
            $query .= "WHERE user_id = {$the_user_id}; ";

            $edit_user_query = mysqli_query($connection, $query);
            confirmQuery($edit_user_query);
            echo "User Updated" . " <a href='users.php'>View Users?</a>";
        }
    }
} else {
    header("Location: index.php");
}

?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">姓名</label>
        <input type="text" value="<?php echo $user_firstname; ?>" class="form-control" name="user_firstname">
    </div>
    <div class="form-group">
        <label for="post_status">姓氏</label>
        <input type="text" value="<?php echo $user_lastname; ?>" class="form-control" name="user_lastname">
    </div>

    <div class="form-group">
        <select name="user_role" id="">
            <option value="<?php echo $user_role; ?>"><?php echo $user_role; ?></option>
            <?php
            if ($user_role == 'admin') {
                echo "<option value='subscriber'>Subscriber</option>";
            } else {
                echo "<option value='admin'>Admin</option>";
            }


            ?>

        </select>
    </div>
    <!--     
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" class="form-control" name="image">
    </div> -->


    <div class="form-group">
        <label for="post_tags">帳號</label>
        <input type="text" value="<?php echo $username; ?>" class="form-control" name="username">
    </div>
    <div class="form-group">
        <label for="post_content">Email</label>
        <input type="email" value="<?php echo $user_email; ?>" class="form-control" name="user_email">
    </div>
    <div class="form-group">
        <label for="post_content">密碼</label>
        <input autocomplete="off" type="password" value="<?php echo $user_password; ?>" class="form-control" name="user_password">
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="edit_user" value="Add User">
    </div>

</form>