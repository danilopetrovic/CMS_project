<?php include "includes/admin_header.php"; ?>
<?php //ob_start(); ?>
    <body>

<div id="wrapper">
    <!-- Navigation -->
    <?php include "includes/admin_navigation.php"; ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Comments:
                        <small>
                            <?php
                            if (isset($_GET['id'])) {
                                $id = mysqli_real_escape_string($connection, $_GET['id']);
                                $sql = "SELECT post_title FROM posts WHERE post_id = $id";
                                $res = mysqli_query($connection, $sql);
                                $red = mysqli_fetch_object($res);
                                echo $red->post_title;
                            }
                            ?>
                        </small>
                    </h1>
                    <?php
                    /*ideja je da vidim komentare samo za 1 post*/
                    if (isset($_GET['source']) and isset($_GET['id'])) {
                        $source = $_GET['source'];
                    } else {
                        $source = "";
                    }
                    switch ($source) {
                        case 'post_comments':
                            include_once "includes/post_comments.php";
                            break;

                        default:
                            include_once "includes/view_all_comments.php";
                            break;
                    }
                    ?>
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<?php include_once "includes/admin_footer.php"; ?>