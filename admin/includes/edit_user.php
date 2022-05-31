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
if (isset ($_GET['edit_user']) && is_numeric($_GET['edit_user'])) {
    $user_id = $_GET['edit_user'];
    $sql = "SELECT * FROM users WHERE user_id = $user_id";
    $res = mysqli_query($connection, $sql);
    if (mysqli_num_rows($res) != 1) {
        echo "User not found!";
        exit();
    }
    $red = mysqli_fetch_object($res);
    $u_username = $red->user_username;
    $u_firstname = $red->user_firstname;
    $u_lastname = $red->user_lastname;
    $u_email = $red->user_email;
    $u_image = $red->user_image;
    $u_role = $red->user_role;
}
else {
    echo "Invalid user id!";
    exit();
}
if (isset($_POST['update_user']) and (
        !isset($_POST['first_name']) ||
        !isset($_POST['last_name']) ||
        !isset($_POST['username']) ||
        !isset($_POST['password']) ||
        !isset($_POST['email']) ||
        !isset($_POST['role']))
) {
    echo "<h2 style='color: red' class='text-center bg-danger'>Fill all fields to edit the user!</h2>";
    exit();
}
if (isset($_POST['first_name']) &&
    isset($_POST['last_name']) &&
    isset($_POST['username']) &&
    isset($_POST['password']) &&
    isset($_POST['repeat_password']) &&
    isset($_POST['email']) &&
    isset($_POST['role'])
) {
    $first_name = mysqli_real_escape_string($connection, strip_tags($_POST['first_name']));
    $last_name = mysqli_real_escape_string($connection, strip_tags($_POST['last_name']));
    $email = mysqli_real_escape_string($connection, strip_tags($_POST["email"]));
    $username = mysqli_real_escape_string($connection, strip_tags($_POST['username']));
    $password = mysqli_real_escape_string($connection, strip_tags($_POST['password']));
    $repeat_password = mysqli_real_escape_string($connection, strip_tags($_POST['repeat_password']));
    $salt = "$2y$10$94d45pGubsSi2Fm6jT29A3";
    $password = hash('ripemd256', $password . $salt);
    $repeat_password = hash('ripemd256', $repeat_password . $salt);
    $role = $_POST["role"];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format!";
        exit();
    }
    if ($password != $repeat_password) {
        echo "Password and repeated password don't match!!!";
        exit();
    }
    $sql = "UPDATE users SET 
    user_username = '$username',
    user_password = '$password', 
    user_firstname = '$first_name', 
    user_lastname = '$last_name', 
    user_email = '$email', 
    user_role = '$role' 
    WHERE user_id = $user_id";
//    echo $sql."<hr>";
    if ($_POST['password'] == "") {
        $sql = "UPDATE users SET 
    user_username = '$username',
    user_firstname = '$first_name', 
    user_lastname = '$last_name', 
    user_email = '$email', 
    user_role = '$role' 
    WHERE user_id = $user_id";
    }
    $create_user_query = mysqli_query($connection, $sql);
    if (!$create_user_query) {
        exit("<h2 style='color: red' class='text-center'>Failed to Edit User!</h2>");
    }
    else {
        echo "<h2 style='color: blue;' class='text-center'>User edited succesfully!!! <a href='users.php'>Go to all Users</a></h2>";
    }
}
/*UPDATE SLIKE*/
$image = $u_image;
if (isset($_FILES['image']['name']) and $_FILES['image']['name'] != "") {
    $image = $_FILES['image']['name'];
    $image_temp = $_FILES['image']['tmp_name'];
    move_uploaded_file($image_temp, "../images/users/$image");
}
$sql = "UPDATE users SET user_image = '$image' WHERE user_id = $user_id";
$res = mysqli_query($connection, $sql);
/*END UPDATE SLIKE*/
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="first_name">First Name</label>
        <input type="text" class="form-control" name="first_name" value="<?= $u_firstname ?>"/>
    </div>
    <div class="form-group">
        <label for="last_name">Last Name</label>
        <input type="text" class="form-control" name="last_name" value="<?= $u_lastname ?>"/>
    </div>
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username" value="<?= $u_username ?>"/>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" name="password"/>
    </div>
    <div class="form-group">
        <label for="repeat_password">Repeat Password</label>
        <input type="password" class="form-control" name="repeat_password"/>
    </div>
    <div class="form-group">
        <label for="image">User Image</label><br>
        <img src="../images/users/<?= $u_image ?>" alt="no image" style="max-height: 200px; max-width: 400px"/>
        <input type="file" name="image">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="text" class="form-control" name="email" value="<?= $u_email ?>"/>
    </div>
    <div class="form-group">
        <label for="role">User Role</label>
        <select name="role" id="role">
            <?php
            switch ($u_role) {
                case 'admin':
                    $admin = "selected";
                    $sub = "";
                    break;
                case 'subscriber':
                    $admin = "";
                    $sub = "selected";
                    break;
            }
            ?>
            <option value="admin" <?= $admin ?> >Administrator</option>
            <option value="subscriber" <?= $sub ?> >Subscriber</option>
        </select>
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="update_user" value="Edit User">
    </div>
</form>