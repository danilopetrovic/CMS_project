<?php include "includes/admin_header.php"; ?>
    <body>

<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/admin_navigation.php"; ?>

    <div id="page-wrapper">

        <div class="container-fluid">
            <?php
            /*prikaz imena pocetne strane*/
            if (isset($_GET['source'])) {
                $source = escape($_GET['source']);
                if ($_GET['source'] == 'edit_post')
                    $naslovStranice = "Edit post:";
                if ($_GET['source'] == 'add_post')
                    $naslovStranice = "Add post:";
            }
            else {
                $source = "";
                $naslovStranice = "Posts:";
            }
            ?>
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <?= $naslovStranice ?>
                        <small><?= $_SESSION['firstname'] ?></small>

                    </h1>
                    <?php
                    if (isset($_GET['source'])) {
                        $source = $_GET['source'];
                    }
                    else {
                        $source = "";
                    }

                    switch ($source) {
                        case 'add_post':
                            include_once "includes/add_post.php";
                            break;
                        case 'edit_post':
                            include_once "includes/edit_post.php";
                            break;
                            /*ideja da posalje posle edita na view_all_posts i da prikaze post updated success...*/
//                        case 'success':
//                            echo "<h2 style='color: blue;' class='text-center'>Post updated succesfully!!!</h2>";
//                            break;
                        default:
                            include_once "includes/view_all_posts.php";
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