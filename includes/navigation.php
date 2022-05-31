<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?php
            $pageName = basename($_SERVER['PHP_SELF']);
            $index_class = '';
            if ($pageName == 'index.php')
                $index_class = 'style="color:white;"';
            ?>
            <a class="navbar-brand" <?= $index_class ?> href="index.php">HOME</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php
                if (isset($_SESSION['id'])) {
                    echo "<li><a href='admin/index.php'>ADMIN</a></li>";
                }
                $pageName = basename($_SERVER['PHP_SELF']);
                $contactUs_class = '';
                $registration_class = '';
                if ($pageName == 'contact.php')
                    $contactUs_class = 'active';
                if ($pageName == 'registration.php')
                    $registration_class = 'active';
                if (!isset($_SESSION['id'])) {
                    echo "<li class='$contactUs_class'><a href='contact.php'>Contact us</a></li>";
                    echo "<li class='$registration_class'><a href='registration.php'>Registration</a></li>";
                }
                if (isset($_SESSION['role']) and isset($_GET['p_id'])) {
                    echo "<li><a href=''>Edit Post &nbsp<i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></a></li>";
                }
                $sql = "SELECT * FROM categories ORDER BY cat_id";
                $res = mysqli_query($connection, $sql);
                while ($red = mysqli_fetch_object($res)) {
                    $cat_id = $red->cat_id;
                    $cat_title = $red->cat_title;
                    $category_class = '';
                    if (isset($_GET['category']) and $_GET['category'] == $cat_id)
                        $category_class = 'active';
                    echo "<li class='$category_class'><a href='category.php?category=$cat_id'>$cat_title</a></li>";
                }
                ?>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>