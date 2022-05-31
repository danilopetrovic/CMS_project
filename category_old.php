<?php include "includes/db.php" ?>
<?php include "includes/header.php"; ?>
    <!-- Navigation -->
<?php include "includes/navigation.php" ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <?php
                if (isset($_GET['category']) and is_numeric($_GET['category'])) {
                    $category = $_GET['category'];
                    $sql = "SELECT * from posts JOIN categories ON post_category_id = cat_id WHERE cat_id = $category and post_status = 'published' ORDER BY post_id DESC";
                }
                else {
                    echo "<h2 class='text-center bg-danger'>Error with the category id!!!</h2>";
                    exit();
                }
                $res = mysqli_query($connection, $sql);
                if(mysqli_num_rows($res) == 0)
                    echo "<h2 class='text-center bg-info'>No posts to show!</h2>";
                while ($red = mysqli_fetch_object($res)) {
                    $post_id = $red->post_id;
                    $post_title = $red->post_title;
                    $post_author = $red->post_author;
                    $post_date = $red->post_date;
                    $post_image = $red->post_image;
                    $post_content = $red->post_content;
                    ?>
                    <h1 class="page-header">
                        Page Heading
                        <small>Secondary Text</small>
                    </h1>

                    <h2>
                        <a href="post.php?p_id=<?= $post_id ?>"><?= $post_title ?></a>
                    </h2>
                    <p class="lead">
                        by <a href="index.php"><?= $post_author ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span><?= $post_date ?></p>

                    <img class="img-responsive" src="images/<?= $post_image ?>" alt="thers no image!">
                    <hr>
                    <p><?= substr($post_content, 0, 220) ?>...</p>
                    <a class="btn btn-primary" href="post.php?p_id=<?= $post_id ?>">Read More
                        <span class="glyphicon glyphicon-chevron-right"></span></a>
                    <hr>
                    <?php
                }
                ?>


            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php" ?>
            <hr>
        </div><!-- /.row -->
        <hr>
    </div><!-- /.container -->
<?php
include "includes/footer.php";
?>