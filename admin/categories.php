<?php include "includes/admin_header.php"; ?>

<?php
$poruka = "";
$bgporuka = "";
/*delete section*/
if (isset($_GET['delete']) and is_numeric($_GET['delete'])) {
    $get_cat_id = escape($_GET['delete']);
    $query = "DELETE FROM categories WHERE cat_id=$get_cat_id";
    $delete_query = mysqli_query($connection, $query);
    header("Location: categories.php?deleted");
}
/*delete checking*/
if (isset($_GET['deleted'])) {
    $poruka = "Category deleted!";
    $bgporuka = "bg-success";
}
/*edit checking*/
if (isset($_GET['edited'])) {
    $poruka = "Category edited!";
    $bgporuka = "bg-success";
}
/*edit category */
if (isset($_GET['edit']) and is_numeric($_GET['edit'])) {
    $get_cat_id = escape($_GET['edit']);
    $query = "SELECT * FROM categories WHERE cat_id=$get_cat_id";
    $result = mysqli_query($connection, $query);
    $red = mysqli_fetch_object($result);
    $editResult = $red->cat_title;
}
if (isset($_POST['cat_title']) and trim($_POST['cat_title']) == "")
    $poruka = "Enter some text!";
if (isset($_POST['cat_title']) and trim($_POST['cat_title']) != "") {
    $cat_title = escape($_POST['cat_title']);
    if ($cat_title == "" || empty($cat_title)) {
        $poruka = "This field should not be empty!";
        $bgporuka = "bg-danger";
    }
    /*checking if category already exists*/
    $sql = "SELECT * FROM categories WHERE cat_title = '$cat_title'";
    $res = mysqli_query($connection, $sql);
    if (mysqli_num_rows($res) > 1) {
        $poruka = "Category name already exists!";
        $bgporuka = "bg-danger";
    }
    else {
        $query = "INSERT INTO categories (cat_title) VALUE ('$cat_title')";
        $create_catagory_query = mysqli_query($connection, $query);
        if (!$create_catagory_query) {
            exit('Query failed ' . mysqli_error($connection));
        }
        header("Location: categories.php");
    }
}


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
                        Wellcome to admin
                        <small><?= $_SESSION['firstname'] ?></small>
                    </h1>

                    <div class="col-xs-6">
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="cat_title">Add Catagory</label>
                                <input type="text" name="cat_title" class="form-control" required/>
                            </div>
                            <div class="form-group">
                                <input class="btn btn-primary" type="submit" value="Add Catagory"/>
                            </div>
                        </form><!--/Add Catagory Form-->

                        <h2 class='text-center <?= $bgporuka ?>'><?= $poruka ?></h2>

                        <?php
                        if (isset($_GET['edit'])) {
                            include_once "includes/update_categories.php";
                        }

                        if (isset($_POST['update_category'])) {
                            $update = escape($_POST['update_category']);
                            $sql = "UPDATE categories SET cat_title='$update' WHERE cat_id=" . $_GET['edit'];
                            $update_query = mysqli_query($connection, $sql);
                            if (!$update_query) {
                                exit("Faild to update!");
                            }
                            header("Location: categories.php?edited");
                        }
                        ?>
                    </div>

                    <div class="col-xs-6">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th colspan="3">Category Title</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $query = "SELECT * FROM categories GROUP BY cat_id";
                            $res = mysqli_query($connection, $query);
                            while ($red = mysqli_fetch_object($res)) {
                                echo "<tr>";
                                echo "<td>$red->cat_id</td>";
                                echo "<td>$red->cat_title</td>";
                                echo "<td><a href='categories.php?edit=$red->cat_id'>Edit <i class='fa fa-pencil-square-o' aria-hidden='true'></i></a></td>";
                                echo "<td><a href='categories.php?delete=$red->cat_id'>Delete <i class='fa fa-trash-o' aria-hidden='true'></i></a></td>";
                                echo "</tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>

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