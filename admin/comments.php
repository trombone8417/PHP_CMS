<!-- 評論頁面 -->
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
                        <small>Author</small>
                    </h1>

                    <?php
                    if (isset($_GET['source'])) {
                        // GET到source資料
                        $source = $_GET['source'];
                    } else {
                        // 未GET到source資料
                        $source = '';
                    }
                    switch ($source) {
                            // 新增文章
                        case 'add_post';
                            include "includes/add_post.php";
                            break;
                            // 編輯文章
                        case 'edit_post';
                            include "includes/edit_post.php";
                            break;
                        case '200';
                            echo "NICE 200";
                            break;
                            // 預設
                        default:
                            // 所有評論
                            include "includes/view_all_comments.php";
                            break;
                    }
                    ?>

                </div>
            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

<?php include "includes/admin_footer.php" ?>