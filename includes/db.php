<?php
$db['db_host'] = "localhost";
$db['db_user'] = "root";
$db['db_pass'] = "";
$db['db_name'] = "cms";
foreach ($db as $key => $value) {
    define(strtoupper($key), $value);
}
//define("NEKAKONSTANTA", "vrednost"); /*definisanje konstanti kad je string*/
//define("NEKAKONSTANTA2", 156); /*definisanje kad je intiger*/
//echo NEKAKONSTANTA."<br>";
//echo NEKAKONSTANTA2."<br>";
$connection=mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if(!$connection)
    echo "We are not connected";