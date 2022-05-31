<?php
if (isset($_SESSION['role']) and $_SESSION['role'] != 'admin') {
//    header("Location: index.php");
    echo "<h4 class='bg-danger'>You don't have permission to be on this page! <a href='index.php'>Go back to Admin</a><br>";
    echo "You will be automaticaly redirected in 5 seconds</h4>";
    ?>
    <script type="text/javascript">
        window.setTimeout(function(){ window.location = "index.php"; },5000);
    </script>
    <?php
    exit();
}
if (isset($_GET['d']) and isset($_SESSION['role']) and $_SESSION['role']=="admin") {
    $delete_user = mysqli_real_escape_string($connection, $_GET['d']);
    $delete_user_sql = "DELETE FROM users WHERE user_id = $delete_user";
//    $delete_sql = "UPDATE comments SET comment_status = 'deleted' WHERE comment_id = $delete_comment_id";
    $delete_query = mysqli_query($connection, $delete_user_sql);
    if (!$delete_query)
        echo "<h2 style='color: red' class='text-center'>Fail to delete user!</h2>";
    else
        echo "<h2 style='color: blue' class='text-center'>User deleted!</h2>";
}
if (isset($_GET['change_to_admin']) and isset($_SESSION['role']) and $_SESSION['role']=="admin") {
    $change_to_admin = mysqli_real_escape_string($connection, $_GET['change_to_admin']);
    $change_role_sql = "UPDATE users SET user_role = 'admin' WHERE user_id = $change_to_admin";
    $change_query = mysqli_query($connection, $change_role_sql);
    if (!$change_query)
        echo "<h2 style='color: red' class='text-center'>Fail to change role to Administrator!</h2>";
    else
        echo "<h2 style='color: blue' class='text-center'>Role changed to Administrator successfully!</h2>";
}
if (isset($_GET['change_to_sub']) and isset($_SESSION['role']) and $_SESSION['role']=="admin") {
    $change_to_sub = $_GET['change_to_sub'];
    $change_role_sql = "UPDATE users SET user_role = 'subscriber' WHERE user_id = $change_to_sub";
    $change_query = mysqli_query($connection, $change_role_sql);
    if (!$change_query)
        echo "<h2 style='color: red' class='text-center'>Fail to change role to Subscriber!</h2>";
    else
        echo "<h2 style='color: blue' class='text-center'>Role changed to Subscriber successfully!</h2>";
}

?>
<!--Form search-->
<form action="" method="post">
    <label for="search">Search Users:</label>
    <div class="form-inline">
        <input type="text" class="form-control" name="search" placeholder="Search comments..." required/>
        <input class="btn btn-primary" type="submit" value="Search">
    </div>
</form><!--END Form search-->

<hr>

<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th class="text-center">ID</th>
        <th class="text-center">Image</th>
        <th class="text-center">Username</th>
        <th class="text-center">Firstname</th>
        <th class="text-center">Lastname</th>
        <th class="text-center">Email</th>
        <th class="text-center">Role</th>
        <th class="text-center" colspan="2">Change Role</th>
        <th class="text-center">Edit</th>
        <th class="text-center">Delete</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $sql = "SELECT * FROM users ORDER BY user_id DESC";
    if (isset($_POST['search'])) {
        $search = $_POST['search'];
        $search_numeric = 0;
        if (is_numeric($search))
            $search_numeric = $search;
        $sql = "SELECT * FROM users WHERE 
                user_id = $search_numeric OR 
                user_username LIKE '%$search%' OR 
                user_firstname LIKE '%$search%' OR 
                user_lastname LIKE '%$search%' OR 
                user_email LIKE '%$search%' 
                ORDER BY user_id DESC";
//        echo $sql;
    }
    $select_users = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_object($select_users)) {
        $user_id = $row->user_id;
        $user_image = $row->user_image;
        $user_username = $row->user_username;
        $user_firstname = $row->user_firstname;
        $user_lastname = $row->user_lastname;
        $user_email = $row->user_email;
        $user_role = $row->user_role;
        ?>
        <style>
            td {
                text-align: center;
            }
        </style>
        <tr>
            <td><?= $user_id ?></td>
            <td style="padding: 0">
                <img style="max-width: 100px; max-height: 60px" src="../images/users/<?= $user_image ?>" alt="no image">
            </td>
            <td><?= $user_username ?></td>
            <td><?= $user_firstname ?></td>
            <td><?= $user_lastname ?></td>
            <td><?= $user_email ?></td>
            <?php
            switch ($user_role) {
                case "subscriber":
                    echo "<td style='background-color: rgba(255,255,0,0.2);'>Subscriber</td>";
                    break;
                case "user":
                    echo "<td style='background-color: rgba(0,255,0,0.2);'>Approved</td>";
                    break;
                case "admin":
                    echo "<td style='background-color: rgba(255,0,0,0.2);'>Administrator</td>";
                    break;
                default:
                    echo "<td>no rolle!!!</td>";
            }
            ?>
            <td class="text-center"><a href="users.php?change_to_admin=<?= $user_id ?>">Admin <i class="fa fa-user-secret" aria-hidden="true"></i></a></td>
            <td class="text-center"><a href="users.php?change_to_sub=<?= $user_id ?>">Subscriber <i class="fa fa-user" aria-hidden="true"></i></a></td>
            <td class="text-center"><a href="users.php?source=edit_user&edit_user=<?= $user_id ?>">Edit <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
            <td class="text-center"><a href="users.php?d=<?= $user_id ?>">Delete <i class="fa fa-ban" aria-hidden="true"></i></a></td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>
