<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<!-- Navigation -->
<?php include "includes/navigation.php"; ?>
<?php
if (isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}
$message = "";
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordR = $_POST['passwordR'];

    if (empty($username) or empty($email) or empty($password) or empty($passwordR)) {
        $message = "<h4 class='text-center bg-danger'>Fields cannot be empty...</h4>";
    }
    if ($password != $passwordR) {
        $message = "<h4 class='text-center bg-danger'>Password and repeated password don't match...</h4>";
    }
    $sql = "SELECT user_username FROM users where user_username = '$username'";
    $res = mysqli_query($connection, $sql);
    if (mysqli_num_rows($res) == 1) {
        echo "<h2 style='color: red' class='text-center'>Username already exists!<a href='registration.php'> Try again!</a></h2>";
        exit();
    }
    $sql = "SELECT user_email FROM users where user_email = '$email'";
    $res = mysqli_query($connection, $sql);
    if (mysqli_num_rows($res) == 1) {
        echo "<h2 style='color: red' class='text-center'>Email already exists!<a href='registration.php'> Try again!</a></h2>";
        exit();
    }
    if (!empty($username) and !empty($email) and !empty($password) and !empty($passwordR) and ($password == $passwordR)) {
        $username = escape($username);
        $firstname = escape($firstname);
        $lastname = escape($lastname);
        $email = escape($email);
        $salt = "$2y$10$94d45pGubsSi2Fm6jT29A3";
        $password = hash('ripemd256', $password . $salt);
        $sql = "INSERT INTO users SET
        user_username = '$username',
        user_password = '$password',
        user_firstname = '$firstname',
        user_lastname = '$lastname',
        user_email = '$email',
        user_image = '',
        user_role = 'subscriber'";
//        echo $sql;
        $res=mysqli_query($connection, $sql);
        if (!$res){
            echo "<h2 style='color: red' class='text-center'>Failed to add user!!!!</h2>";
            exit();
        }
        else
            $message = "<h2 style='color: blue' class='text-center bg-success'>User added succesfully!</h2>";
    }
}
?>
<!-- Page Content -->
<div class="container">

    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <h1>Register</h1>
                        <?= $message ?>
                        <form role="form" action="#" method="post" id="login-form" autocomplete="off">
                            <div class="form-group">
                                <label for="username" class="sr-only">username</label>
                                <input type="text" name="username" id="username" class="form-control" autocomplete="on" placeholder="Enter Username" value="<?php echo isset($username)?$username:""; ?>">
                            </div>
                            <div class="form-group">
                                <label for="firstname" class="sr-only">firstname</label>
                                <input type="text" name="firstname" id="firstname" class="form-control" autocomplete="on" placeholder="First Name" value="<?php echo isset($firstname)?$firstname:""; ?>">
                            </div>
                            <div class="form-group">
                                <label for="lastname" class="sr-only">lastname</label>
                                <input type="text" name="lastname" id="lastname" class="form-control" autocomplete="on" placeholder="Last Name" value="<?php echo isset($lastname)?$lastname:""; ?>">
                            </div>
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" autocomplete="on" placeholder="YourEmail@email.com" value="<?php echo isset($email)?$email:""; ?>">
                            </div>
                            <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <label for="passwordR" class="sr-only">Password Repeat</label>
                                <input type="password" name="passwordR" id="passwordR" class="form-control" placeholder="Repeat Password">
                            </div>

                            <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                        </form>

                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>


    <hr>


    <?php include "includes/footer.php"; ?>
