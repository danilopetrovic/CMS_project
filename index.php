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
                /*beginning pagination paginating*/
                $post_query_count = "SELECT post_id FROM posts WHERE post_status = 'published'";
                $count_query = mysqli_query($connection, $post_query_count);
                $count = mysqli_num_rows($count_query);
                $limit = 5;
                $count = ceil($count / $limit);
                if (isset($_GET['page']) and
                    is_numeric($_GET['page']) and
                    $_GET['page'] > 1 and
                    strval($_GET['page']) == strval(intval($_GET['page'])) and
                    filter_var($_GET['page'], FILTER_VALIDATE_INT)
                ) {
                    $page = $_GET['page'];
                    $startPage = ($page - 1) * $limit;
                }
                else
                    $startPage = "0";
                /*end pagination*/
                $sql = "SELECT * from posts WHERE post_status = 'published' ORDER BY post_id DESC LIMIT $startPage,$limit";
//                echo $sql;
                $res = mysqli_query($connection, $sql);
                while ($red = mysqli_fetch_object($res)) {
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
                        by <a href="author_posts.php?author=<?= $post_author ?>"><?= $post_author ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span><?= $post_date ?></p>
                    <a href="post.php?p_id=<?= $post_id ?>"><img style="max-width: 100%; max-height: 300px;" class="img-responsive" src="images/<?= $post_image ?>" alt="thers no image!"></a>
                    <hr>
                    <a class="btn btn-primary" href="post.php?p_id=<?= $post_id ?>">Read More
                        <span class="glyphicon glyphicon-chevron-right"></span></a>
                    <hr>
                    <hr style="border-bottom: 1px solid black">
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

    <ul class="pager">
        <?php
        if (!isset($_GET['page']) or $_GET['page'] <= 1) {
            $page = "1";
        }
        for ($i = 1; $i <= $count; $i++) {
            if ($i == $page) {
                echo "<li><a class='active_link' href='index.php?page=$i'>$i</a></li>";
            }
            else {
                echo "<li><a href='index.php?page=$i'>$i</a></li>";
            }
        }
        ?>
    </ul>
<?php
include "includes/footer.php";
?>