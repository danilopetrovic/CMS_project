<?php include "includes/admin_header.php"; ?>

    <body>

<div id="wrapper">
    <?php
    ?>
    <!-- Navigation -->
    <?php include "includes/admin_navigation.php"; ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Wellcome to admin
                        <small><?= $_SESSION['firstname'] ?></small>
                    </h1>

                    <?php include "admin_widgets.php"; ?>

                    <?php
                    /*php za js*/
                    $post_count = recordCount("post_id", "posts");
                    $post_count_draft = recordCount("post_id","posts","post_status = 'draft'");

                    $comment_count = recordCount("comment_id","comments");
                    $comment_count_unnaproved = recordCount("comment_id","comments", "comment_status = 'unapproved'" );

                    $user_count = recordCount("user_id","users");
                    $user_count_subscribers = recordCount("user_id","users", "user_role != 'admin'" );

                    $category_count = recordCount("cat_id","categories");
                    ?>
                    <script type="text/javascript">
                        google.charts.load('current', {'packages': ['bar']});
                        google.charts.setOnLoadCallback(drawChart);

                        function drawChart() {
                            var data = google.visualization.arrayToDataTable([
                                ['Date', 'Count'],
//                                ['Year', 'Sales', 'Expenses', 'Profit'],
//                                ['2014', 1000, 400, 200],
//                                ['2015', 1170, 460, 250],
//                                ['2016', 660, 1120, 300],
//                                ['2017', 1030, 540, 350]
                                <?php
                                $element_text = [
                                    'Active Posts',
                                    'Draft Posts',
                                    'Comments',
                                    'Comments Unnaproved',
                                    'Users',
                                    'User Subscribers',
                                    'Categories'
                                ];
                                $element_count = array(
                                    $post_count,
                                    $post_count_draft,
                                    $comment_count,
                                    $comment_count_unnaproved,
                                    $user_count,
                                    $user_count_subscribers,
                                    $category_count
                                );
                                for ($i = 0; $i < count($element_text); $i++) {
                                    echo "['{$element_text[$i]}'" . "," . "{$element_count[$i]}],";
                                }
                                ?>
//                                ['Posts', 1000]
                            ]);
                            var options = {
                                chart: {
                                    title: '',
                                    subtitle: ''
                                }
                            };
                            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                            chart.draw(data, google.charts.Bar.convertOptions(options));
                        }
                    </script>
                    <div id="columnchart_material" style="width: auto; height: 500px;"></div>

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