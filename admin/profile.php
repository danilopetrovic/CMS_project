<?php
include "includes/admin_header.php";
ob_start();
?>

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
                        Your Profile
                        <small>(Status:
                            <?php
                            switch ($_SESSION['role'])
                            {
                                case 'admin':
                                    echo "Administrator";
                                    break;
                                case 'subscriber':
                                    echo "Subscriber";
                                    break;
                            }
                            ?>)<!--ovo je kraj zagrade nek ostane-->
                        </small>
                    </h1>

                    <?php include_once "includes/profile_inc.php" ?>
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
