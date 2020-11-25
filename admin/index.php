<!-- 管理者首頁 -->
<?php include "includes/admin_header.php" ?>
<div id="wrapper">

    <?php

    ?>
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



                                    <div class='huge'><?php echo $post_counts = recordCount('posts'); ?></div>

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
                                    <div class='huge'><?php echo $comment_counts = recordCount('comments'); ?></div>
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
                                    <div class='huge'><?php echo $user_counts = recordCount('users'); ?></div>
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
                                    <div class='huge'><?php echo $categories_counts = recordCount('categories'); ?></div>
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
            
            $post_published_counts = checkStatus('posts', 'post_status','published');
            // 文章非公開總數
            $post_draft_counts = checkStatus('posts', 'post_status','draft');
            // 評論非公開總數
            $unapproved_comment_counts = checkStatus('comments', 'comment_status','unapproved');
            // 訂閱者總數
            
            $subscriber_counts = checkUserRole('users', 'user_role','subscriber');

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
                $element_text = ['所有文章', '公開文章', '私人文章', '評論', '未公開評論', '使用者', '訂閱者', '類別'];
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