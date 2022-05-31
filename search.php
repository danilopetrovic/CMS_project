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
            if (isset($_GET['search']))
            {
                $search = $_GET['search'];
                $sql = "SELECT * FROM posts WHERE 
                        post_title LIKE '%$search%' or 
                        post_content LIKE '%$search%' or 
                        post_author LIKE '%$search%' or 
                        post_tags LIKE '%$search%' ORDER BY post_id DESC";
                $res = mysqli_query($connection, $sql);
                if (!$res)
                {
                    echo "Query failed" . mysqli_error($connection);
                    exit();
                }
                $count = mysqli_num_rows($res);
                echo "<h2 class='bg-success'>Number of results: $count</h2>";
                if ($count == 0) {
                    echo "<h2 class='bg-danger'>No result!</h2>";
                }
                else
                {
                    $res = mysqli_query($connection, $sql);

                    while ($red = mysqli_fetch_object($res))
                    {
                        $post_id = $red->post_id;
                        $post_title = $red->post_title;
                        $post_author = $red->post_author;
                        $post_date = $red->post_date;
                        $post_image = $red->post_image;
                        $post_content = htmlspecialchars_decode($red->post_content);
                        ?>
                        <h2>
                            <a href="post.php?p_id=<?= $post_id ?>"><?= $post_title ?></a>
                        </h2>
                        <p class="lead">
                            by <a href="index.php"><?= $post_author ?></a>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span><?= $post_date ?></p>
                        <a href="post.php?p_id=<?= $post_id ?>"><img class="img-responsive" src="images/<?= $post_image ?>" alt="thers no image!"></a>
                        <hr>
                        <p><?= substr($post_content, 0, 200) ?></p>
                        <a class="btn btn-primary" href="post.php?p_id=<?= $post_id ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                        <hr>
                        <?php
                    }
                }
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