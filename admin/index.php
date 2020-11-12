<!-- 管理者首頁 -->
<?php include "includes/admin_header.php" ?>
<div id="wrapper">
    <!-- Navigation -->
    <?php include "includes/admin_navigation.php" ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome to admin
                        <small> <?php echo $_SESSION['username'] ?></small>
                    </h1>

                </div>
            </div>
            <!-- /.row -->

            <!-- /.row -->

            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-file-text fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
<!-- 文章總數 -->
                                    <?php
                                    $query = "SELECT * FROM posts";
                                    $select_all_post = mysqli_query($connection, $query);
                                    $post_counts = mysqli_num_rows($select_all_post);
                                    echo "<div class='huge'>{$post_counts}</div>"
                                    ?>
                                    <div>文章總數</div>
                                </div>
                            </div>
                        </div>
                        <a href="./posts.php">
                            <div class="panel-footer">
                                <span class="pull-left">看細節...</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                <!-- 評論總數 -->
                                    <?php
                                    $query = "SELECT * FROM comments";
                                    $select_all_comments = mysqli_query($connection, $query);
                                    $comment_counts = mysqli_num_rows($select_all_comments);
                                    echo "<div class='huge'>{$comment_counts}</div>"
                                    ?>
                                    <div>評論總數</div>
                                </div>
                            </div>
                        </div>
                        <a href="./comments.php">
                            <div class="panel-footer">
                                <span class="pull-left">看細節...</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                <!-- 使用者總數 -->
                                    <?php
                                    $query = "SELECT * FROM users";
                                    $select_all_users = mysqli_query($connection, $query);
                                    $user_counts = mysqli_num_rows($select_all_users);
                                    echo "<div class='huge'>{$user_counts}</div>"
                                    ?>
                                    <div>使用者總數</div>
                                </div>
                            </div>
                        </div>
                        <a href="./users.php">
                            <div class="panel-footer">
                                <span class="pull-left">看細節...</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-list fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                <!-- 類別總數 -->
                                    <?php
                                    $query = "SELECT * FROM categories";
                                    $select_all_categories = mysqli_query($connection, $query);
                                    $categories_counts = mysqli_num_rows($select_all_categories);
                                    echo "<div class='huge'>{$categories_counts}</div>"
                                    ?>
                                    <div>類別總數</div>
                                </div>
                            </div>
                        </div>
                        <a href="./categories.php">
                            <div class="panel-footer">
                                <span class="pull-left">看細節...</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <?php
// 文章公開總數
            $query = "SELECT * FROM posts WHERE post_status = 'published'";
            $select_all_published_post = mysqli_query($connection, $query);
            $post_published_counts = mysqli_num_rows($select_all_published_post);
// 文章非公開總數
            $query = "SELECT * FROM posts WHERE post_status = 'draft'";
            $select_all_draft_post = mysqli_query($connection, $query);
            $post_draft_counts = mysqli_num_rows($select_all_draft_post);
// 評論公開總數
            $query = "SELECT * FROM comments WHERE comment_status = 'unapproved'";
            $unapproved_comments_query = mysqli_query($connection, $query);
            $unapproved_comment_counts = mysqli_num_rows($unapproved_comments_query);
// 評論非公開總數
            $query = "SELECT * FROM users WHERE user_role = 'subscriber'";
            $select_all_subscribers = mysqli_query($connection, $query);
            $subscriber_counts = mysqli_num_rows($select_all_subscribers);

            ?>
            <div class="row ">
<!-- google長條圖統計 -->
                <div id="top_x_div" style="width: 95%; height: 300px; margin : auto;
"></div>
            </div>
        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

    <?php include "includes/admin_footer.php" ?>
<!-- google長條圖統計javascript -->
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['bar']
        });
        google.charts.setOnLoadCallback(drawStuff);

        function drawStuff() {
            var data = new google.visualization.arrayToDataTable([
                ['Data', 'Count'],

                <?php
                // 標題
                $element_text = ['All Posts', 'Active Posts', 'Draft Posts', 'Comments', 'Pending Comments', 'Users', 'Subscribers', 'Categories'];
                // 長條圖
                $element_count = [$post_counts, $post_published_counts, $post_draft_counts, $comment_counts, $unapproved_comment_counts, $user_counts, $subscriber_counts, $categories_counts];
                for ($i = 0; $i < 8; $i++) {
                    echo "['{$element_text[$i]}'" . ",", "{$element_count[$i]}],";
                }
                ?>

            ]);

            var options = {

                chart: {
                    title: '',
                    subtitle: ''
                }
            };

            var chart = new google.charts.Bar(document.getElementById('top_x_div'));
            // Convert the Classic options to Material options.
            chart.draw(data, google.charts.Bar.convertOptions(options));
        };
    </script>