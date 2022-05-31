<?php include "includes/admin_header.php"; ?>
<?php ob_start(); ?>
<body>

<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/admin_navigation.php"; ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <?php
            if (isset($_GET['source'])) {
                $source = $_GET['source'];
                if ($source == "add_user") {
                    $naslovStranice = "Create user:";
                }
                if ($source == "edit_user") {
                    $naslovStranice = "Edit user:";
                }
            } else {
                $source = "";
                $naslovStranice = "Users:";
            }
            ?>
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <?= $naslovStranice ?>

                    </h1>
                    <?php
                    switch ($source) {
                        case 'add_user':
                            include_once "includes/add_user.php";
                            break;
                        case 'edit_user':
                            include_once "includes/edit_user.php";
                            break;
                        default:
                            include_once "includes/view_all_users.php";
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