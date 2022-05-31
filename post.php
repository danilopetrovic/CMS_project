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
                if (isset($_GET['p_id']) and is_numeric($_GET['p_id'])) {
                    $p_id = escape($_GET['p_id']);
                }
                else {
                    echo "<h2 class='text-center bg-info'>Error with the post id!!!!</h2>";
                    exit();
                }
                /*reading post*/
                if (isset($_SESSION['role']) and $_SESSION['role'] == 'admin') {
                    $sql = "SELECT * from posts WHERE post_id = $p_id";
                }
                else
                    $sql = "SELECT * from posts WHERE post_id = $p_id and post_status = 'published'";
                $res = mysqli_query($connection, $sql);
                if (mysqli_num_rows($res) != 1) {
                    echo "<h2 class='text-center bg-info'>No such post...</h2>";
                    exit();
                }
                /*updating views of the post - sabere samo +1 kad se ucita ova strana*/
                if (!isset($_SESSION['id'])) {
                    $viewQuery = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = $p_id";
                    mysqli_query($connection, $viewQuery);
                }
                while ($red = mysqli_fetch_object($res)) {
                    $title = $red->post_title;
                    $author = $red->post_author;
                    $date = $red->post_date;
                    $image = $red->post_image;
                    $content = htmlspecialchars_decode($red->post_content);
                    ?>
                    <h1 class="page-header">
                        Page Heading
                        <small>Secondary Text</small>
                    </h1>

                    <h2>
                        <a href="#"><?= $title ?></a>
                    </h2>
                    <p class="lead">
                        by <a href="author_posts.php?author=<?= $author ?>"><?= $author ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span><?= $date ?></p>

                    <img style="max-width: 100%; max-height: 800px;" class="img-responsive" src="images/<?= $image ?>" alt="photo">
                    <hr>
                    <p><?= $content ?>...</p>

                    <hr>
                    <?php
                }
                ?>

                <?php
                /*updating*/
                if (isset($_POST['create_comment']) && isset($_POST['comment_author']) && isset($_POST['comment_email']) && isset($_POST['comment_content'])) {
                    $comment_author = escape($_POST['comment_author']);
                    $comment_email = escape($_POST['comment_email']);
                    $comment_content = escape($_POST['comment_content']);
                    $sql_insert = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content) VALUES ($p_id, '$comment_author', '$comment_email', '$comment_content')";
//                echo $sql_insert;
                    if ($comment_author == "" || $comment_email == "" || $comment_content == "") {
                        echo "<h2 style='color: red' class='text-center bg-danger'>Fill all fields!!!</h2>";
                    }
                    else {
                        $res_insert = mysqli_query($connection, $sql_insert);
                        if (!$res_insert)
                            echo "<h3 style='color:red' class='text-center bg-danger'>Adding comment was unsuccessfull!!!</h3>";
                        else {
                            /*ako je sve uspelo izbaci poruku i onda poveca za 1 komentar u bazi*/
                            echo "<h3 style='color:blue'>Comment added succesfully! Wait for his approval...</h3>";
                            $sql_numOfComments = "UPDATE posts SET post_comment_count = post_comment_count + 1 WHERE post_id = $p_id";
                            $upcate_numOfComments = mysqli_query($connection, $sql_numOfComments);
                        }
                    }
                }
                ?>

                <!-- Blog Comments -->

                <!-- Comments Form -->
                <div class="well">
                    <h4 style="margin-top: 0">Leave a Comment:</h4>
                    <form role="form" method="post" action="">
                        <div class="form-group">
                            <label for="comment_author">Author</label>
                            <input type="text" class="form-control" name="comment_author" placeholder="Leave your name">
                        </div>
                        <div class="form-group">
                            <label for="comment_email">E-mail</label>
                            <input type="text" class="form-control" name="comment_email" placeholder="Leave your e-mail">
                        </div>
                        <div class="form-group">
                            <label for="comment_content">Comment</label>
                            <textarea class="form-control" rows="4" name="comment_content"
                                    placeholder="Leave your comment"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" name="create_comment">Submit</button>
                    </form>
                </div><!-- END Comments Form -->

                <hr>

                <!-- Comments -->
                <?php
                $sql_comments = "SELECT * FROM comments WHERE comment_status = 'approved' and comment_post_id = $p_id ORDER BY comment_date DESC";
                $comments_res = mysqli_query($connection, $sql_comments);
                while ($row = mysqli_fetch_object($comments_res)) {
                    $author_comment = $row->comment_author;
                    $date_comment = $row->comment_date;
                    $content_comment = $row->comment_content;
                    ?>
                    <div class="media">
                        <a class="pull-left" href="#">
                            <img class="media-object" src="http://placehold.it/64x64" alt="">
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading"><?= $author_comment ?>
                                <small><?= date('Y M d - G:i:s', strtotime($date_comment)) ?></small>
                            </h4>
                            <?= $content_comment ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div><!--End comments-->

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php" ?>
            <hr>
        </div><!-- /.row -->
        <hr>
    </div><!-- /.container -->

<?php
include "includes/footer.php";
?>