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
                    if (!isset($_SESSION['id'])) {
                        $stmt1 = mysqli_prepare($connection, "SELECT post_id,post_title,post_author,post_date,post_image,post_content from posts JOIN categories ON post_category_id = cat_id WHERE cat_id = ? and post_status = ? ORDER BY post_id DESC");
                    }
                    $published = 'published';
                    $stmt2 = mysqli_prepare($connection, "SELECT post_id,post_title,post_author,post_date,post_image,post_content from posts JOIN categories ON post_category_id = cat_id WHERE cat_id = ? ORDER BY post_id DESC");
                    if (isset($stmt1)) {
                        mysqli_stmt_bind_param($stmt1, "is", $category, $published); /*intiger string*/
                        mysqli_stmt_execute($stmt1);
                        mysqli_stmt_bind_result($stmt1, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content);
                        $stmt = $stmt1;
                    }
                    else {
                        mysqli_stmt_bind_param($stmt2, "i", $category); /*intiger*/
                        mysqli_stmt_execute($stmt2);
                        mysqli_stmt_bind_result($stmt2, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content);
                        $stmt = $stmt2;
                    }
//                    print_r($stmt);
                }
                else {
                    echo "<h2 class='text-center bg-danger'>Error with the category id!!!</h2>";
                    exit();
                }
                if (mysqli_stmt_num_rows($stmt) == 0)
                    echo "<h2 class='text-center bg-info'>No posts to show!</h2>";
                while (mysqli_stmt_fetch($stmt)) {
                    ?>
                    <h2>
                        <a href="post.php?p_id=<?= $post_id ?>"><?= $post_title ?></a>
                    </h2>
                    <p class="lead">
                        by <a href="index.php"><?= $post_author ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span><?= $post_date ?></p>

                    <img class="img-responsive" src="images/<?= $post_image ?>" alt="thers no image!">
                    <hr>
                    <p><?= substr(htmlspecialchars_decode($post_content), 0, 220) ?>...</p>
                    <a class="btn btn-primary" href="post.php?p_id=<?= $post_id ?>">Read More
                        <span class="glyphicon glyphicon-chevron-right"></span></a>
                    <hr>
                    <?php
                }
                mysqli_stmt_close($stmt); /*zatvara statement pa ne mozes vise da ga koristis...*/
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