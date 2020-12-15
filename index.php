<!-- 首頁 -->
<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

<!-- Navigation 上方導覽列 -->
<?php include "includes/navigation.php"; ?>
<!-- Page Content -->
<div class="container">
    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <?php
            // 每頁文章數
            $per_page = 5;
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = "";
            }

            if ($page == "" || $page == 1) {
                $page1 = 0;
            } else {
                $page1 = ($page * $per_page) - $per_page;
            }
            // 若角色為admin的話，顯示全部文章
            if (isset($_SESSION['user_role']) && $_SESSION['user_role']=='admin') {
                $post_query_count = "SELECT * FROM posts ";
            }
            else {
                // 其他角色顯示部分文章
                $post_query_count = "SELECT * FROM posts WHERE post_status = 'published'";
            }
            
            $find_count = mysqli_query($connection, $post_query_count);
            // 計算文章總數
            $count = mysqli_num_rows($find_count);
            // 若文章數小於1(沒有文章)的話，顯示沒有文章
            if ($count < 1) {
                echo "<div class='alert alert-danger text-center' role='alert'>
                沒有文章
              </div>";
            }else{
            // ceil() 函數向上捨入為最接近的整數。
            // 分頁數量
            $count = ceil($count / $per_page);
            // 分頁第幾頁文章
            // 若角色為admin的話，顯示文章(第幾頁)
            if (isset($_SESSION['user_role']) && $_SESSION['user_role']=='admin') {
                $query = "SELECT * FROM posts LIMIT $page1, $per_page ";
            }
            else {
                // 其他角色顯示部分文章(第幾頁)
                $query = "SELECT * FROM posts WHERE post_status = 'published'  LIMIT $page1, $per_page";
            }
            // $query = "SELECT * FROM posts LIMIT $page1, $per_page";
            $select_all_posts_query = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                $post_author = $row['post_user'];
                $post_date = $row['post_date'];
                $post_image = $row['post_image'];
                $post_content = substr($row['post_content'], 0, 100);
                $post_status = $row['post_status'];
                

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
                        by <a href="author_posts.php?author=<?php echo $post_author ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_author ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                    <hr>
                    <a href="post.php?p_id=<?php echo $post_id; ?>">
                        <img class="img-responsive" src="images/<?php echo $post_image ?>" alt="">
                    </a>
                    <hr>
                    <p><?php echo $post_content ?></p>
                    <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                    <hr>

            <?php }
            } ?>

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php"; ?>

    </div>
    <!-- /.row -->
    <hr>
    <ul class="pager">
        <?php
        for ($i = 1; $i <= $count; $i++) {
            if ($i == $page) {
                // 分頁第幾頁連結被按下的時候，class='active_link'
                echo "<li><a class='active_link' href='index.php?page={$i}'>{$i}</a></li>";
            } else {
                // 其他分頁
                echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
            }
        }
        ?>
    </ul>
    <?php include "includes/footer.php"; ?>