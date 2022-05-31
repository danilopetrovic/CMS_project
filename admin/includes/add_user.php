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
if (isset($_POST['create_user']) and (
        !isset($_POST['first_name']) ||
        !isset($_POST['last_name']) ||
        !isset($_POST['username']) ||
        !isset($_POST['password']) ||
        !isset($_POST['email']) ||
        !isset($_POST['role']))
) {
    echo "<h2 style='color: red' class='text-center'>Fill all fields to create the user!</h2>";
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
//    echo "<br>".$password . "<br>" . $repeat_password. "<br>";

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format!";
        exit();
    }
    if ($password != $repeat_password) {
        echo "Password and repeated password don't match!!!";
        exit();
    }
    $sql = "SELECT user_username FROM users where user_username = '$username'";
    $res = mysqli_query($connection, $sql);
    if (mysqli_num_rows($res) == 1) {
        echo "<h2 style='color: red' class='text-center'>Username already exists!</h2>";
        exit();
    }

    if (isset($_FILES['image'])) {
        $image = $_FILES['image']['name'];
        $image_temp = $_FILES['image']['tmp_name'];
    }
    else {
        $image = "no image";
    }
    $sql = "INSERT INTO users(user_username, user_password, user_firstname, user_lastname, user_email, user_image, user_role)
                          VALUES ('$username', '$password', '$first_name', '$last_name', '$email', '$image', '$role')";
    $create_user_query = mysqli_query($connection, $sql);
    if (!$create_user_query) {
        exit("<h2 style='color: red' class='text-center'>Failed to add User!</h2>");
    }
    else {
        move_uploaded_file($image_temp, "../images/users/$image");
        echo "<h2 style='color: blue;' class='text-center'>User added succesfully!!! <a href='users.php'>View All Users</a></h2>";
    }
}
?>

<form action="#" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="first_name">First Name</label>
        <input type="text" class="form-control" name="first_name"/>
    </div>
    <div class="form-group">
        <label for="last_name">Last Name</label>
        <input type="text" class="form-control" name="last_name"/>
    </div>
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username"/>
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
        <label for="image">User Image</label>
        <input type="file" name="image"/>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="text" class="form-control" name="email"/>
    </div>
    <div class="form-group">
        <label for="role">User Role</label>
        <select name="role" id="role">
            <option value="admin">Administrator</option>
            <option value="subscriber" selected>Subscriber</option>
        </select>
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_user" value="Create User">
    </div>
</form>