<?php
include_once "includes/db.php";
$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
$result = '';
for ($i = 0; $i < 22; $i++)
    $result .= $characters[mt_rand(0, 61)];
echo $result . "<br>";


echo strlen('iusesomecrazystring22') . "<br>";
echo strlen('94d45pGubsSi2Fm6jT29A') . "<br>";
echo "<hr>";

$file = "<script type='text/javascript'>alert('nesto');</script>";
//echo $file;
$file = strip_tags($file);
$file = mysqli_real_escape_string($connection, $file);
//$file = preg_replace('<script>', '', $file);
//$file = preg_replace('</script>', '', $file);
echo $file;

echo "<hr>";
$password = "danalo";
$salt = "94d45pGubsSi2Fm6jT29A4";
$password = hash('ripemd256', $password.$salt);
echo $password;

echo "<hr>";

/*1 nacin provere dal je intiger tj ceo broj */
$a = 1;
echo filter_var($a, FILTER_VALIDATE_INT);
echo "<br>";
$a = 1.1;
echo filter_var($a, FILTER_VALIDATE_INT);
echo "<br>";
$a = "2";
echo filter_var($a, FILTER_VALIDATE_INT);
echo "<br>";
$a = "3";
echo filter_var($a, FILTER_VALIDATE_INT);
echo "<br>";
echo "<hr>";


/*2 nacin provere*/
$a = "22";
if ( strval($a) == strval(intval($a)) ) {
    echo "Your variable '$a' is intiger";
}
else {
    echo "Your variable '$a' is not an integer!";
}
//
//echo "<hr>";
//echo "<hr>";
//echo "<hr>";
//echo "<hr>";
//echo "sta sve daje $_SERVER funkcija:";
//$indicesServer = array('PHP_SELF',
//                       'argv',
//                       'argc',
//                       'GATEWAY_INTERFACE',
//                       'SERVER_ADDR',
//                       'SERVER_NAME',
//                       'SERVER_SOFTWARE',
//                       'SERVER_PROTOCOL',
//                       'REQUEST_METHOD',
//                       'REQUEST_TIME',
//                       'REQUEST_TIME_FLOAT',
//                       'QUERY_STRING',
//                       'DOCUMENT_ROOT',
//                       'HTTP_ACCEPT',
//                       'HTTP_ACCEPT_CHARSET',
//                       'HTTP_ACCEPT_ENCODING',
//                       'HTTP_ACCEPT_LANGUAGE',
//                       'HTTP_CONNECTION',
//                       'HTTP_HOST',
//                       'HTTP_REFERER',
//                       'HTTP_USER_AGENT',
//                       'HTTPS',
//                       'REMOTE_ADDR',
//                       'REMOTE_HOST',
//                       'REMOTE_PORT',
//                       'REMOTE_USER',
//                       'REDIRECT_REMOTE_USER',
//                       'SCRIPT_FILENAME',
//                       'SERVER_ADMIN',
//                       'SERVER_PORT',
//                       'SERVER_SIGNATURE',
//                       'PATH_TRANSLATED',
//                       'SCRIPT_NAME',
//                       'REQUEST_URI',
//                       'PHP_AUTH_DIGEST',
//                       'PHP_AUTH_USER',
//                       'PHP_AUTH_PW',
//                       'AUTH_TYPE',
//                       'PATH_INFO',
//                       'ORIG_PATH_INFO') ;
//
//echo '<table cellpadding="10">' ;
//foreach ($indicesServer as $arg) {
//    if (isset($_SERVER[$arg])) {
//        echo '<tr><td>'.$arg.'</td><td>' . $_SERVER[$arg] . '</td></tr>' ;
//    }
//    else {
//        echo '<tr><td>'.$arg.'</td><td>-</td></tr>' ;
//    }
//}
//echo '</table>' ;

echo "<hr>";
echo "<hr>";
$password = "danilo";
echo $hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
echo "<br>";
if (password_verify($password, $hash)) {
    echo 'Password is valid!';
} else {
    echo 'Invalid password.';
}