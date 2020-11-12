<!-- 發佈文章 -->
<?php
if(isset($_POST['create_post'])){
    
    $post_title = $_POST['title'];
    $post_author = $_POST['author'];
    $post_category_id = $_POST['post_category'];
    $post_status = $_POST['post_status'];
    $post_image = $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name'];
    $post_tags = $_POST['post_tags'];
    $post_content = $_POST['post_content'];
    $post_date = date('d-m-y');
// 上傳圖片
    move_uploaded_file($post_image_temp, "../images/$post_image");

    $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags,  post_status) ";
    $query .= "VALUES('{$post_category_id}','{$post_title}','{$post_author}',now(),'{$post_image}','{$post_content}','{$post_tags}','{$post_status}')";

    $create_post_query = mysqli_query($connection,$query);
    confirmQuery($create_post_query);
    $the_post_id = mysqli_insert_id($connection);
    // 成功發佈
    echo"<p class='bg-success'>Post Created. <a href='../post.php?p_id={$the_post_id} '>View Post</a> or <a href='posts.php'>Edit More Posts</p>";
}
?>

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="title">
    </div>
    <div class="form-group">
    <!-- 下拉選單 -->
        <select name="post_category" id="">
        <?php
        // 列出所有類別
            $query = "SELECT * FROM categories ";
            // 查詢
            $select_categories = mysqli_query($connection, $query);
            // 確認SQL是否正確
            confirmQuery($select_categories);
            while ($row = mysqli_fetch_assoc($select_categories)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
                echo"<option value='$cat_id'>{$cat_title}</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="title">作者</label>
        <input type="text" class="form-control" name="author">
    </div>
    <div class="form-group">
        <select name="post_status" id="">
        <option value="draft">發佈狀態(預設私人)</option>
        <option value="published">公開</option>
        <option value="draft">私人</option>
        </select>
    </div>
    <div class="form-group">
        <label for="post_image">圖片</label>
        <input type="file" class="form-control" name="image">
    </div>
    
    
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags">
    </div>
    <div class="form-group">
        <label for="post_content">內容</label>
        <textarea type="text" class="form-control" name="post_content" id="body" cols="30" rows="10"></textarea>
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
    </div>

</form>