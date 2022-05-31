<?php
function users_online($connection)
{
        $session = session_id();
//    $time = time();
        $time_out_in_seconds = 60;
//    $time_out = $time - $time_out_in_seconds;

        $query = "SELECT * FROM users_online WHERE session = '$session'";
        $send_query = mysqli_query($connection, $query);
        $count = mysqli_num_rows($send_query);
        $red = mysqli_fetch_object($send_query);

        if ($count == NULL) {
            mysqli_query($connection, "INSERT INTO users_online (session) VALUE ('$session')");
        }
        else {
            mysqli_query($connection, "UPDATE users_online SET time = now() WHERE session = '$session'");
        }
//    $users_online = mysqli_query($connection, "SELECT users_online_id FROM users_online WHERE time > '$time_out'");
        $users_online = mysqli_query($connection,
                                     "SELECT * FROM `users_online` where time > NOW()- INTERVAL $time_out_in_seconds SECOND ");
        return $count_users = mysqli_num_rows($users_online);
}
global $connection;
if (!$connection) {
    session_start();
    include("../includes/db.php");
}
function users_online_ajax($connection)
{
    /*ajax uslov*/
    if (isset($_GET['onlineusers'])) {
        $session = session_id();
        $time_out_in_seconds = 5;

        $query = "SELECT * FROM users_online WHERE session = '$session'";
        $send_query = mysqli_query($connection, $query);
        $count = mysqli_num_rows($send_query);

        if ($count == NULL) {
            mysqli_query($connection, "INSERT INTO users_online (session) VALUE ('$session')");
        }
        else {
            mysqli_query($connection, "UPDATE users_online SET time = now() WHERE session = '$session'");
        }
        $users_online = mysqli_query($connection,
                                     "SELECT * FROM `users_online` where time > NOW()- INTERVAL $time_out_in_seconds SECOND ");
        $count_users = mysqli_num_rows($users_online);
        echo $count_users;
    }
}
users_online_ajax($connection);

function escape($string)
{
    global $connection;
    return mysqli_real_escape_string($connection, trim( strip_tags($string, tagovi() ))); /*trebalo bi i strip_tags*/
}
function tagovi()
{
    return '<h1><h2><h3><h4><h5><h6><p><a><em><strong><img><ul><li><ol><table><tr><td><th><tbody><thead><sub><sup><span><mark><blockquote><dfn><dl><pre><CODE>';
    /*trim(htmlentities($_POST['comment_author'], ENT_QUOTES));*/
}

/*u funkciju guram kolonu ili kolone neke tabele opciono where nesto*/
function recordCount($columnName, $tableName, $whereClause='1')
{
    global $connection;
    $sql = "SELECT $columnName FROM $tableName WHERE $whereClause";
    $res = mysqli_query($connection, $sql);
    $count = mysqli_num_rows($res);
    return $count;
}