<!-- 編輯文章 -->
<?php

if (isset($_GET['p_id'])) {
    // 文章 ID
    $the_post_id = $_GET['p_id'];
}
// 文章ID內容
$query = "SELECT * FROM posts WHERE post_id = $the_post_id ";
$select_posts_by_id = mysqli_query($connection, $query);
while ($row = mysqli_fetch_assoc($select_posts_by_id)) {
    $post_id = $row['post_id'];
    $post_user = $row['post_user'];
    $post_title = $row['post_title'];
    $post_category_id = $row['post_category_id'];
    $post_status = $row['post_status'];
    $post_image = $row['post_image'];
    $post_content = $row['post_content'];
    $post_tags = $row['post_tags'];
    $post_comment_count = $row['post_comment_count'];
    $post_date = $row['post_date'];
}
// 更新文章ID
if (isset($_POST['update_post'])) {

    $post_user = $_POST['post_user'];
    $post_title = $_POST['post_title'];
    $post_category_id = $_POST['post_category'];
    $post_status = $_POST['post_status'];
    $post_image = $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name'];

    $post_content = $_POST['post_content'];
    $post_tags = $_POST['post_tags'];
    // 上傳圖片
    move_uploaded_file($post_image_temp, "../images/$post_image");
    // 若未上傳圖片的話，選擇原本圖片相對位址
    if (empty($post_image)) {
        $query = "SELECT * FROM posts WHERE post_id = $the_post_id ";
        $select_image = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_array($select_image)) {
            $post_image = $row['post_image'];
        }
    }
    // 更新圖片SQL
    $query = "UPDATE posts SET ";
    $query .= "post_title = '{$post_title}', ";
    $query .= "post_category_id = {$post_category_id}, ";
    $query .= "post_date = now() , ";
    $query .= "post_user = '{$post_user}', ";
    $query .= "post_status = '{$post_status}', ";
    $query .= "post_tags = '{$post_tags}', ";
    $query .= "post_content = '{$post_content}', ";
    $query .= "post_image = '{$post_image}' ";
    $query .= "WHERE post_id = '{$the_post_id}'; ";

    $update_post_query = mysqli_query($connection, $query);
    confirmQuery($update_post_query);
    // 更新成功
    echo "<p class='bg-success'>Post Updated. <a href='../post.php?p_id={$the_post_id}'>View Post</a> or <a href='posts.php'>Edit More Posts</a></p>";
}
?>
<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="title">文章標題</label>
        <input value="<?php echo $post_title; ?>" type="text" class="form-control" name="post_title">
    </div>
    <div class="form-group">
        <select name="post_category" id="">
            <?php
            // 選擇所有類別
            $query = "SELECT * FROM categories ";
            $select_categories = mysqli_query($connection, $query);
            confirmQuery($select_categories);
            while ($row = mysqli_fetch_assoc($select_categories)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
                if ($cat_id == $post_category_id) {
                    // 選擇的類別
                    echo "<option selected value='$cat_id'>{$cat_title}</option>";
                } else {
                    // 其他項目的類別
                    echo "<option value='$cat_id'>{$cat_title}</option>";
                }
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="category">作者</label>
        <!-- 下拉選單 -->
        <select name="post_user" id="">
            <?php echo "<option value='{$post_user}'>{$post_user}</option>"; ?>
            <?php
            // 列出所有作者
            $query = "SELECT * FROM users ";
            // 查詢
            $select_users = mysqli_query($connection, $query);
            // 確認SQL是否正確
            confirmQuery($select_users);
            while ($row = mysqli_fetch_assoc($select_users)) {
                $user_id = $row['user_id'];
                $username = $row['username'];
                echo "<option value='$username'>{$username}</option>";
            }
            ?>
        </select>
    </div>
    <!-- 下拉選單是否公開 -->
    <select name="post_status" id="">
        <option value='<?php echo $post_status; ?>'><?php echo $post_status; ?></option>
        <?php
        if ($post_status == 'published') {
            echo "<option value='draft'>Draft</option>";
        } else {
            echo "<option value='published'>Publish</option>";
        }

        ?>

    </select>

    <div class="form-group">
        <img width="100" src="../images/<?php echo $post_image; ?>" alt="">
        <input type="file" name="image">
    </div>


    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input value="<?php echo $post_tags; ?>" type="text" class="form-control" name="post_tags">
    </div>
    <div class="form-group">
        <label for="post_content">內容</label>
        <textarea type="text" class="form-control" name="post_content" id="body" cols="30" rows="10">
        <?php echo $post_content; ?>
        </textarea>
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_post" value="Update Post">
    </div>

</form>