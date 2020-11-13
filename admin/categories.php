<!-- 類別頁面 -->
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
                        <div class="col-xs-6">
                            <!-- 新增類別函數 -->
                            <?php insert_categories(); ?>
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="cat-title">新增類別</label>
                                    <input class="form-control" type="text" name="cat_title">
                                </div>
                                <div class="form-group">
                                    <input class="btn btn-primary" type="submit" name="submit" value="新增類別">
                                </div>
                            </form>
                            <!-- 編輯 -->
                        <?php 
                        if(isset($_GET['edit'])){
                            $cat_id = $_GET['edit'];
                            include "includes/update_categories.php";
                        }
                        ?>
                        </div>
                        <div class="col-xs-6">
                        
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Category Title</th>
                                        <th>編輯</th>
                                        <th>刪除</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <!-- 列出所有項目 -->
                                <?php
                                
                                findAllCategories();
                                ?>
                                <!-- 刪除類別 -->
                                <?php
                                deleteCategories();
                                ?>
                                   
                                        
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

<?php include "includes/admin_footer.php" ?>  