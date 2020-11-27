<!-- 各類別頁面 -->
<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

<!-- Navigation -->
<?php include "includes/navigation.php"; ?>
<!-- Page Content -->
<div class="container">
    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <?php

            if (isset($_GET['category'])) {
                $post_category_id = $_GET['category'];
                // 若角色為admin的話，顯示全部文章
                if (is_admin($_SESSION['username'])) {
                    $stmt1 = mysqli_prepare($connection, "SELECT post_id, post_title , post_author , post_date , post_image , post_content  FROM  posts  WHERE  post_category_id  = ?");
                } else {
                    // 其他角色顯示部分文章
                    $stmt2 = mysqli_prepare($connection, "SELECT post_id, post_title , post_author , post_date , post_image , post_content FROM posts WHERE post_category_id = ? AND post_status = ? ");
                    // 公開文章
                    $published = 'published';
                }

                if (isset($stmt1)) {
                    // sql執行全部文章
                    mysqli_stmt_bind_param($stmt1, "i", $post_category_id);
                    mysqli_stmt_execute($stmt1);
                    mysqli_stmt_bind_result($stmt1, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content);
                    $stmt = $stmt1;
                } else {
                    // sql執行公開文章
                    mysqli_stmt_bind_param($stmt2, "is", $post_category_id, $published);
                    mysqli_stmt_execute($stmt2);
                    mysqli_stmt_bind_result($stmt2, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content);
                    $stmt = $stmt2;
                }

                // 若文章數等於零的話，顯示沒有文章
                if (mysqli_stmt_num_rows($stmt) === 0) {
                    echo "<div class='alert alert-danger text-center' role='alert'>沒有文章</div>";
                }
                // mysqli_stmt_fetch從準備好的語句中獲取結果到綁定變量中
                while ($row = mysqli_stmt_fetch($stmt)) :
                   
            ?>

                    <h1 class="page-header">
                        Page Heading
                        <small>Secondary Text</small>
                    </h1>

                    <!-- First Blog Post -->
                    <h2>
                        <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title ?></a>
                    </h2>
                    <p class="lead">
                        by <a href="index.php"><?php echo $post_author ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                    <hr>
                    <img class="img-responsive" src="images/<?php echo $post_image ?>" alt="">
                    <hr>
                    <p><?php echo $post_content ?></p>
                    <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                    <hr>

            <?php endwhile;
            } else {
                header("Location: index.php");
            }



            ?>

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php"; ?>

    </div>
    <!-- /.row -->

    <hr>
    <?php include "includes/footer.php"; ?>