<?php

if (isset($_SESSION['id']))
{
    $user_id = escape($_SESSION['id']);
    $sql = "SELECT * FROM users WHERE user_id = $user_id";
    $res = mysqli_query($connection, $sql);
    if (mysqli_num_rows($res) != 1)
    {
        echo "User not found!";
        exit();
    }
    $red = mysqli_fetch_object($res);
    $u_username = $red->user_username;
    $u_firstname = $red->user_firstname;
    $u_lastname = $red->user_lastname;
    $u_email = $red->user_email;
    $u_image = $red->user_image;
}
else
{
    exit("Try to login!");
}
if (isset($_POST['update_user']) and (
        !isset($_POST['first_name']) ||
        !isset($_POST['last_name']) ||
        !isset($_POST['username']) ||
        !isset($_POST['password']) ||
        !isset($_POST['email'])))
{
    echo "<h2 style='color: red' class='text-center'>Fill all fields to edit the user!</h2>";
    exit();
}
if (isset($_POST['first_name']) &&
    isset($_POST['last_name']) &&
    isset($_POST['username']) &&
    isset($_POST['password']) &&
    isset($_POST['repeat_password']) &&
    isset($_POST['email'])
)
{
    $first_name = escape($_POST['first_name']);
    $last_name = escape($_POST['last_name']);
    $username = escape($_POST['username']);
    $password = trim(htmlentities($_POST['password'], ENT_QUOTES));
    $repeat_password = trim(htmlentities(mysqli_real_escape_string($connection, $_POST['repeat_password']), ENT_QUOTES));
    $email = escape($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        echo "Invalid email format!";
        exit();
    }
    if ($password != $repeat_password)
    {
        echo "Password and repeated password don't match!!!";
        exit();
    }
    if ($_POST['password'] == "")
    {

        $sql = "UPDATE users SET 
                user_username = '$username',
                user_firstname = '$first_name', 
                user_lastname = '$last_name', 
                user_email = '$email' 
                WHERE user_id = $user_id";
    }
    else
    {
        $salt = "$2y$10$94d45pGubsSi2Fm6jT29A3";
        $password = hash('ripemd256', $password . $salt);
        $sql = "UPDATE users SET 
                user_username = '$username',
                user_password = '$password', 
                user_firstname = '$first_name', 
                user_lastname = '$last_name', 
                user_email = '$email' 
                WHERE user_id = $user_id";
    }

//    echo $sql."<hr>";
    $create_user_query = mysqli_query($connection, $sql);
    if (!$create_user_query)
    {
        exit("<h2 style='color: red' class='text-center'>Failed to Edit User!</h2>");
    }
    else
    {
        echo "<h2 style='color: blue;' class='text-center'>User edited succesfully!!! <a href='index.php'>Go to Admin</a></h2>";
    }
}
/*UPDATE SLIKE*/
$image = $u_image;
if (isset($_FILES['image']['name']) and $_FILES['image']['name'] != "")
{
    $image = $_FILES['image']['name'];
    $image_temp = $_FILES['image']['tmp_name'];
    move_uploaded_file($image_temp, "../images/users/$image");
}
$sql = "UPDATE users SET user_image = '$image' WHERE user_id = $user_id";
$res = mysqli_query($connection, $sql);
/*END UPDATE SLIKE*/
?>


<form action="#" method="post" enctype="multipart/form-data">
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
        <input type="submit" class="btn btn-primary" name="update_user" value="Edit User">
    </div>
</form>
