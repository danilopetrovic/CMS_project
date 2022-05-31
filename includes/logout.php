<?php
session_start();
$_SESSION['id'] = null;
$_SESSION['username'] = null;
$_SESSION['firstname'] = null;
$_SESSION['lastname'] = null;
$_SESSION['role'] = null;
unset($_SESSION['id']);
unset($_SESSION['username']);
unset($_SESSION['firstname']);
unset($_SESSION['lastname']);
unset($_SESSION['role']);
session_destroy();
header("Location: ../index.php");
exit();
