<?php
include_once "db.php";
require_once "../admin/functions.php";
require_once "../admin/class_Log.php";

session_start();

if (isset($_POST['login']))
{
    $username = escape($_POST['username']);
    $password = $passZaLog = $_POST['password'];
    $salt = "$2y$10$94d45pGubsSi2Fm6jT29A3";
    $password = hash('ripemd256', $password.$salt);

    $sql = "SELECT * FROM users WHERE user_username = '$username' && user_password = '$password'";
//    echo $sql . "<br>";
    $query = mysqli_query($connection, $sql);
    if (!$query)
    {
        echo "Query failed!";
    }
    if (mysqli_num_rows($query) != 1)
    {
        $obj=new Log("Neuspesna prijava sa korime: $username i lozinka: $passZaLog"); /*upisivanje u log fajl, za neuspesan podatke koje mi prosledi korisnik formom...*/
        $obj->upisLogovanje();
        header("Location: ../index.php?error");
    } else
    {
        while ($red = mysqli_fetch_object($query))
        {
            $db_user_id = $red->user_id;
            $db_user_username = $red->user_username;
            $db_user_password = $red->user_password;
            $db_user_firstname = $red->user_firstname;
            $db_user_lastname = $red->user_lastname;
            $db_user_role = $red->user_role;

        }
        $_SESSION['id'] = $db_user_id;
        $_SESSION['username'] = $db_user_username;
        $_SESSION['firstname'] = $db_user_firstname;
        $_SESSION['lastname'] = $db_user_lastname;
        $_SESSION['role'] = $db_user_role;
        $obj=new Log("Uspesna prijava korisnika: ".$_SESSION['username']);
        $obj->upisLogovanje(); /*za uspesan login koristim sesiju*/
        header("Location: ../admin");
    }
}