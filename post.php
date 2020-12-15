<!-- 詳細文章頁面 -->
<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

<!-- Navigation -->
<?php include "includes/navigation.php"; ?>
<?php 
// 按讚
if (isset($_POST['liked'])) {
    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];
    // 1 = SELECT POST
    // 撈出id文章的資料
    $query = "SELECT * FROM posts WHERE post_id=$post_id";
    $postResult = mysqli_query($connection, $query);
    $post = mysqli_fetch_array($postResult);
    // id文章的likes的數量
    $likes = $post['likes'];
    if (mysqli_num_rows($postResult) >= 1) {
        echo $post['post_id'];
    }
    // 2 = UPDATE POST WITH LIKES
    // 按讚+1
    mysqli_query($connection, "UPDATE posts SET likes=$likes+1 WHERE post_id=$post_id");
    // 3 = CREATE LIKES FOR POST
    mysqli_query($connection, "INSERT INTO likes(user_id,post_id) VALUES ($user_id,$post_id)");
    exit();
}
// 取消按讚
if (isset($_POST['unliked'])) {
    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];
    // 1 = SELECT POST
    // 撈出id文章的資料
    $query = "SELECT * FROM posts WHERE post_id=$post_id";
    $postResult = mysqli_query($connection, $query);
    $post = mysqli_fetch_array($postResult);
    // id文章的likes的數量
    $likes = $post['likes'];
    
    // 2 刪除按讚資料
    mysqli_query($connection, "DELETE FROM likes WHERE post_id=$post_id AND user_id=$user_id");
    // 3 按讚-1
    mysqli_query($connection, "UPDATE posts SET likes=$likes-1 WHERE post_id=$post_id");
    
    exit();
}
?>
<!-- Page Content -->
<div class="container">
    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <!-- 文章內容 -->
            <?php
            if (isset($_GET['p_id'])) {
            $the_post_id = $_GET['p_id'];
            
            $view_query = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = $the_post_id ";
            $send_query = mysqli_query($connection, $view_query);
            if (!$send_query) {
                die("query failed");
            }
            if (isset($_SESSION['user_role']) && $_SESSION['user_role']=='admin') {
                $query = "SELECT * FROM posts WHERE post_id = $the_post_id";
            }
            else {
                $query = "SELECT * FROM posts WHERE post_id = $the_post_id AND post_status = 'published' ";
            }
           
            

            $select_all_posts_query = mysqli_query($connection, $query);
            if (mysqli_num_rows($select_all_posts_query)<1) {
                echo "<div class='alert alert-danger text-center' role='alert'>
            沒有文章
          </div>";
            }else{
            while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                $post_title = $row['post_title'];
                $post_author = $row['post_user'];
                $post_date = $row['post_date'];
                $post_image = $row['post_image'];
                $post_content = $row['post_content'];
            ?>

                <h1 class="page-header">
                    文章
                </h1>

                <!-- First Blog Post -->
                <h2>
                    <a href="#"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image ?>" alt="">
                <hr>
                <p><?php echo $post_content ?></p>
                <hr>
               
                <?php if(isLoggedIn()){ ?>
                    
                <div class="row">
                    <p class="pull-right"><a 
                    class="<?php echo userLikedThisPost($the_post_id)? 'unlike' : 'like'; ?>"
                     href="post.php?p_id=<?php echo $the_post_id; ?>"><span class="glyphicon glyphicon-thumbs-up" data-toggle="tooltip" data-placement="top" title="<?php echo userLikedThisPost($the_post_id)? '取消按讚' : '按讚'; ?>"></span>&nbsp;<?php echo userLikedThisPost($the_post_id)? 'unlike' : 'like'; ?></a></p>
                </div>

                <?php } else { ?>
                    <div class="row">
                    <p class="pull-right login-to-post">You need to <a href="login.php">Login</a> to like </p>
                </div>
                <?php } ?>
                <div class="row">
                    <p class="pull-right likes">Like:<?php getPostlikes($the_post_id); ?></p>
                </div>
                <div class="clearfix"></div>

            <?php } 
            
            ?>
            <!-- Blog Comments -->
            <!-- 文章評論 -->
            <?php
            // 新增評論
            if (isset($_POST['create_comment'])) {
                $the_post_id = $_GET['p_id'];
                $comment_author = $_POST['comment_author'];
                $comment_email = $_POST['comment_email'];
                $comment_content = $_POST['comment_content'];
                if (!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {
                    $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date ) ";

                    $query .= "VALUES ($the_post_id, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'unapproved', now())";

                    $create_comment_query = mysqli_query($connection, $query);
                    if (!$create_comment_query) {
                        die('QUERY FAILED' . mysqli_error($connection));
                    }
                    // $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 ";
                    // $query .= "WHERE post_id = $the_post_id ";
                    // $update_comment_count = mysqli_query($connection, $query);
                } else {
                    echo "<script>alert('Fields cannot be empty')</script>";
                }
            }
            ?>
            <!-- Comments Form -->
            <div class="well">
                <h4>Leave a Comment:</h4>
                <form action="" method="post" role="form">
                    <div class="form-group">
                        <label for="Author">Author</label>
                        <input type="text" class="form-control" name="comment_author">
                    </div>
                    <div class="form-group">
                        <label for="Email">Email</label>
                        <input type="email" class="form-control" name="comment_email">
                    </div>
                    <div class="form-group">
                        <label for="comment">Your Comment</label>
                        <textarea name="comment_content" class="form-control" rows="3"></textarea>
                    </div>
                    <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <hr>
            <?php
            // 顯示公開評論
            $query = "SELECT * FROM comments WHERE comment_post_id = {$the_post_id} ";
            $query .= "AND comment_status = 'approve' ";
            $query .= "ORDER BY comment_id DESC ";
            $select_comment_query = mysqli_query($connection, $query);
            if (!$select_comment_query) {
                die('Query Failed. ' . mysqli_error($connection));
            }
            while ($row = mysqli_fetch_array($select_comment_query)) {
                $comment_date = $row['comment_date'];
                $comment_content = $row['comment_content'];
                $comment_author = $row['comment_author'];
            ?>
                <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">
                            <?php echo $comment_author; ?>
                            <small><?php echo $comment_date; ?></small>
                        </h4>
                        <?php echo $comment_content; ?>
                    </div>
                </div>
            <?php }}} else{
                header("Location: index.php");
            } ?>


        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php"; ?>

    </div>
    <!-- /.row -->

    <hr>
    
    <?php include "includes/footer.php"; ?>
    <script>
        $(document).ready(function(){
            // 顯示tooltip
            $("[data-toggle='tooltip']").tooltip();
            var post_id = <?php echo $the_post_id; ?>;
            var user_id = <?php echo loggedInUserId() ?>;
            // 按讚
            $('.like').click(function(){
                $.ajax({
                    url: "post.php?p_id=<?php echo $the_post_id; ?>",
                    type:'post',
                    data: {
                        'liked':1,
                        'post_id':post_id,
                        'user_id':user_id
                    }
                });
            });
            // 取消按讚
            $('.unlike').click(function(){
                $.ajax({
                    url: "post.php?p_id=<?php echo $the_post_id; ?>",
                    type:'post',
                    data: {
                        'unliked':1,
                        'post_id':post_id,
                        'user_id':user_id
                    }
                });
            });
        });

    </script>