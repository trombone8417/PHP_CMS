<?php
if (ifItIsMethod('post')) {
    login_user($_POST['username'], $_POST['password']);
}
?>
<!-- 側邊欄 -->
<div class="col-md-4">

    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog 搜尋</h4>
        <form action="search.php" method="post">
            <div class="input-group">
                <input name="search" type="text" class="form-control">
                <span class="input-group-btn">
                    <button name="submit" class="btn btn-default" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
        <!-- /.input-group -->
    </div>

    <!-- Login -->
    
    <div class="well">
    <?php if(isset($_SESSION['user_role'])): ?>
        <h4>Logged in as <?php echo $_SESSION['username']; ?></h4>
        <a href="includes/logout.php" class="btn btn-primary">登出</a>
    <?php else: ?>
        <h4>登入</h4>
        <form method="post">
            <div class="input-group">
                <input name="username" type="text" class="form-control" placeholder="Enter Username">
            </div>
            <div class="input-group">
                <input name="password" type="password" class="form-control" placeholder="Enter Password">
            </div>
            <button class="btn btn-primary" name="login" type="submit">Submit</button>
        </form>
        <!-- /.input-group -->
    <?php endif; ?>
        
    </div>

    <!-- Blog Categories Well -->
    <div class="well">
        <?php
        $query = "SELECT * FROM categories";
        $select_categories_sidebar = mysqli_query($connection, $query);
        ?>
        <h4>Blog 類別</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
                    <?php
                    while ($row = mysqli_fetch_assoc($select_categories_sidebar)) {
                        $cat_title = $row['cat_title'];
                        $cat_id = $row['cat_id'];
                        echo "<li><a href='category.php?category=$cat_id'>{$cat_title}</a></li>";
                    }
                    ?>
                </ul>
            </div>

            <!-- /.col-lg-6 -->
        </div>
        <!-- /.row -->
    </div>

    <!-- Side Widget Well -->
    <?php include "includes/widget.php"; ?>

</div>