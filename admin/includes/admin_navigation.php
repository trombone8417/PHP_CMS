
<!-- 管理者上方狀態列 -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">管理員</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                
                <li><a href="">使用者上線人數: <span class="usersonline"></span></a></li>
                <li><a href="../index.php">Blog首頁</a></li>
           
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>
                    <!-- 使用者名稱 -->
                    <?php
                    if (isset($_SESSION['username'])) {
                        echo $_SESSION['username'];
                    }
                    ?>
                     
                     <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
     
                        <li class="divider"></li>
                        <li>
                            <a href="../includes/logout.php"><i class="fa fa-fw fa-power-off"></i> 登出</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="index.php"><i class="fa fa-fw fa-dashboard"></i> 儀表板</a>
                    </li>
                    
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#posts_dropdown"><i class="fa fa-fw fa-arrows-v"></i> 文章 <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="posts_dropdown" class="collapse">
                            <li>
                                <a href="./posts.php">全部發佈文章</a>
                            </li>
                            <li>
                                <a href="posts.php?source=add_post">新增文章</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="./categories.php"><i class="fa fa-fw fa-wrench"></i> 類別</a>
                    </li>
                    
                    <li class="">
                        <a href="./comments.php"><i class="fa fa-fw fa-file"></i>評論</a>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> 使用者 <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo" class="collapse">
                            <li>
                                <a href="./users.php">全部使用者</a>
                            </li>
                            <li>
                                <a href="users.php?source=add_user">新增使用者</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="profile.php"><i class="fa fa-fw fa-dashboard"></i> 個人資料</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>