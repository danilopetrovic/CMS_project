<div class="col-md-4">
    <!-- Blog Search Well -->
    <?php
    if (isset($_SESSION['role']) and isset($_GET['p_id'])) {
        $p_id = $_GET['p_id'];
        echo <<<kraj
<div class="well">
    <div class="btn-group btn-group-sm">
        <a class="btn btn-info" href="admin/posts.php?source=edit_post&p_id=$p_id">Edit this post &nbsp<i class="fa fa-pencil" aria-hidden="true"></i></a>
    </div>
    <div class="btn-group btn-group-sm">
        <a onClick="javascript: return confirm('Are you sure?')" class="btn btn-info" 
        href="admin/posts.php?delete=$p_id">Remove this post &nbsp<i class="fa fa-trash-o" aria-hidden="true"></i></a>
    </div>
</div>
kraj;
    }
    ?>
    <div class="well">
        <h4>Blog Search</h4>
        <form action="search.php" method="get">
            <div class="input-group">
                <input type="text" name="search" class="form-control"
                        placeholder="Search title, content, author or tags">
                <span class="input-group-btn">
                    <button name="submit" type="submit" class="btn btn-default">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form><!--END Blog Search Well-->
    </div>

    <!-- Login -->

    <div class="well">
        <?php
        $loginString = "Login:";
        $displayString = "";
        if (isset($_SESSION['id'])) {
            $loginString = "Logged in as ".$_SESSION['firstname']." ".$_SESSION['lastname']."!";
            $displayString = 'style="display: none"';
        }
        ?>
        <h4><?= $loginString ?></h4>
        <form action="includes/login.php" method="post" <?= $displayString ?>>
            <div class="form-group">
                <input type="text" name="username" class="form-control" placeholder="Enter Username">
            </div>
            <div class="input-group">
                <input type="password" name="password" class="form-control" placeholder="Enter Password">
                <span class="input-group-btn">
                    <button class="btn btn-primary" name="login" type="submit">Submit</button>
                </span>
            </div>
        </form>

        <!--END Login-->
        <?php
        if (isset($_GET['error'])) {
            echo "<div class='text-center text-capitalize'>Failed to login...</div>";
        }
        ?>
    </div>

    <!--Blog categories-->
    <div class="well">
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <table class="table">
                    <?php
                    $sql = "SELECT * FROM categories ORDER BY rand()";
                    $res = mysqli_query($connection, $sql);
                    $i = 0;
                    while ($red = mysqli_fetch_object($res)) {
                        if ($i % 2 == 0) echo "<tr>";
                        echo "<td><a href='category.php?category=$red->cat_id'>$red->cat_title</a></td>";
                        if ($i + 1 % 2 == 0) echo "</tr>";
                        $i++;
                    }
                    if ($i % 2 != 0)
                        echo "<td></td></tr>"; /*ako je neparan broj kategorija onda da doda jos 1 prazno polje i da zatvori na kraju tr jer nije zatvoren u petlji kad je neparan broj kategorija...*/
                    ?>

                </table>
            </div>
        </div

    </div><!--END Blog categories-->

    <!-- Side Widget Well -->
    <?php include "widget.php"; ?>
</div>