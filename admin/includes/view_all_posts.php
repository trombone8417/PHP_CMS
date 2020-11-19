<!-- 所有文章列表 -->
<?php
// bootstrap刪除確認
include("delete_modal.php");
// checkbox批次處理
if (isset($_POST['checkBoxArray'])) {
    // 陣列處理
    foreach ($_POST['checkBoxArray'] as $postValueId) {
        // 選擇模式
        $bulk_options = $_POST['bulk_options'];
        switch ($bulk_options) {
                // 公開發布
            case 'published':
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId} ";
                $update_to_published_status = mysqli_query($connection, $query);
                confirmQuery($update_to_published_status);
                break;
                // 私人不公布
            case 'draft':
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId} ";
                $update_to_draft_status = mysqli_query($connection, $query);
                confirmQuery($update_to_draft_status);
                break;
                // 刪除
            case 'delete':
                $query = "DELETE FROM posts WHERE post_id = {$postValueId} ";
                $update_to_delete_status = mysqli_query($connection, $query);
                confirmQuery($update_to_delete_status);
                break;

                // 批次複製
            case 'clone':
                $query = "SELECT * FROM posts WHERE post_id = {$postValueId} ";
                $select_post_query = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_array($select_post_query)) {
                    $post_title = $row['post_title'];
                    $post_category_id = $row['post_category_id'];
                    $post_date = $row['post_date'];
                    $post_author = $row['post_author'];
                    $post_status = $row['post_status'];
                    $post_image = $row['post_image'];
                    $post_tags = $row['post_tags'];
                    $post_content = $row['post_content'];
                }
                $query = "INSERT INTO posts(post_category_id, post_title, post_date, post_author, post_status, post_image, post_tags, post_content) ";
                $query .= "VALUES({$post_category_id}, '{$post_title}', now(), '{$post_author}', '{$post_status}', '{$post_image}', '{$post_tags}', '{$post_content}')";
                $copy_query = mysqli_query($connection, $query);

                confirmQuery($select_post_query);

                break;
                // 預設
            default:
                # code...
                break;
        }
    }
}
?>

<form action="" method='post'>

    <table id="myTable" class="table table-bordered table-hover">
        <div id="bulkOptionContainer" class="col-xs-4">
            <select class="form-control" name="bulk_options" id="">
                <option value="">選擇狀態</option>
                <option value="published">公開</option>
                <option value="draft">私人</option>
                <option value="delete">刪除</option>
                <option value="clone">複製</option>
            </select>
        </div>
        <div class="col-xs-4">
            <input type="submit" name="submit" class="btn btn-success" value="Apply">
            <a class="btn btn-primary" href="posts.php?source=add_post">新增文章</a>
        </div>

        <thead>
            <tr>
                <th><input id="selectAllBoxes" type="checkbox"></th>
                <th>Id</th>
                <th>Users</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Date</th>
                <th>View Count</th>
                <th>View Post</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * FROM posts ORDER BY post_id DESC ";
            $select_posts = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($select_posts)) {
                $post_id = $row['post_id'];
                $post_author = $row['post_author'];
                $post_user = $row['post_user'];
                $post_title = $row['post_title'];
                $post_category_id = $row['post_category_id'];
                $post_status = $row['post_status'];
                $post_image = $row['post_image'];
                $post_tags = $row['post_tags'];
                
                $post_comment_count = $row['post_comment_count'];
                $post_date = $row['post_date'];
                $post_views_count = $row['post_views_count'];

                echo "<tr>";
            ?>
                <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $post_id; ?>'></td>
            <?php

                echo "<td>$post_id</td>";
                if (!empty($post_author)) {
                    echo "<td>$post_author</td>";
                } elseif(!empty($post_user)) {
                    echo "<td>$post_user</td>";
                }
                
                echo "<td>$post_title</td>";

                $query = "SELECT * FROM categories WHERE cat_id = $post_category_id ";
                $select_categories_id = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($select_categories_id)) {
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];

                    echo "<td>{$cat_title}</td>";
                }

                echo "<td>$post_status</td>";
                echo "<td><img width='100' src='../images/$post_image' alt='image'></td>";
                echo "<td>$post_tags</td>";
                
                $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
                $send_comment_query = mysqli_query($connection, $query);
                $row = mysqli_fetch_array($send_comment_query);
                $comment_id = $row['comment_id'];
                // 計算每個文章評論數
                $count_comments = mysqli_num_rows($send_comment_query);
                echo "<td><a href='post_comments.php?id=$post_id'>$count_comments</a></td>";
                echo "<td>$post_date</td>";
                echo "<td>$post_views_count</td>";
                
                // 查看文章
                echo "<td><a href='../post.php?p_id={$post_id}'>View Post</a></td>";
                // 編輯文章
                echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
                // 確認是否刪除
                echo "<td><a rel='$post_id' href='javascript:void(0)' class='delete_link' >Delete</a></td>";
                echo "</tr>";
                
                echo "</tr>";
            }
            ?>


        </tbody>
    </table>
</form>

<?php

if (isset($_GET['delete'])) {
    $the_post_id = $_GET['delete'];
    $query = "DELETE FROM posts WHERE post_id = {$the_post_id} ";
    $delete_query = mysqli_query($connection, $query);
    header("Location: posts.php");
}

?>

<script>
    $(document).ready(function(){
        $(".delete_link").on('click', function(){
            var id = $(this).attr("rel");
            var delete_url = "posts.php?delete=" + id + " ";
            $(".modal_delete_link").attr("href", delete_url);
            $("#myModal").modal('show');
        });
        
    });
</script>