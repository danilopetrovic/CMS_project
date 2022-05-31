<!--ova stranica sluzi da mi prikaze sve komentare vezane za 1 post! inkluduje se u comments ako je setovan source za ovu stranu i id za odredjeni post-->
<?php
if (isset($_GET['d']) and isset($_GET['cc']) and is_numeric($_GET['d']) and is_numeric($_GET['cc'])) {
    $delete_comment_id = $_GET['d'];
    $delete_comment_post_id = $_GET['cc'];
    $delete_sql = "UPDATE posts SET post_comment_count = post_comment_count-1 WHERE post_id = $delete_comment_post_id;";
    $delete_sql .= "DELETE FROM comments WHERE comment_id = $delete_comment_id;";
//    $delete_sql = "UPDATE comments SET comment_status = 'deleted' WHERE comment_id = $delete_comment_id";
    $delete_query = mysqli_multi_query($connection, $delete_sql); /*multiquery upit gde 2 upita odradim jednim querijem*/
//    echo $delete_sql;
    echo '<script>alert("Comment Deleted"); window.location="comments.php?source=post_comments&id='.$id.'"</script>';
//    header("Location: comments.php?source=post_comments&id=$id");
}
if (isset($_GET['a'])) {
    $approved_comment_id = $_GET['a'];
    $approved_sql = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = $approved_comment_id";
    $approved_query = mysqli_query($connection, $approved_sql);
}
if (isset($_GET['u'])) {
    $unapproved_comment_id = $_GET['u'];
    $unapproved_sql = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = $unapproved_comment_id";
    $unapproved_query = mysqli_query($connection, $unapproved_sql);
}
?>
<!--Form search-->
<form action="comments.php" method="post">
    <label for="search">Search Comments:</label>
    <div class="form-inline">
        <input type="text" class="form-control" name="search" placeholder="Search comments..." required/>
        <input class="btn btn-primary" type="submit" value="Search">
        <a href="comments.php"> <button class="btn btn-primary" type="button"><i class="fa fa-comments-o" aria-hidden="true"></i> View All Comments</button></a>
    </div>
</form><!--END Form search-->
<hr>

<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th class="text-center">ID</th>
        <th class="text-center">Author</th>
        <th class="text-center">Comment</th>
        <th class="text-center">Email</th>
        <th class="text-center">Status</th>
        <th class="text-center">In response to title</th>
        <th class="text-center">Date</th>
        <th class="text-center">Appruve</th>
        <th class="text-center">Unapprove</th>
        <!--        <th class="text-center">Edit</th>-->
        <th class="text-center">Delete</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $sql = "SELECT * FROM posts JOIN comments ON post_id = comment_post_id ORDER BY comment_id DESC";
    if (isset($_POST['search'])) {
        $search = mysqli_real_escape_string($connection, $_POST['search']);
        $sql = "SELECT * FROM posts JOIN comments ON post_id = comment_post_id WHERE 
                comment_author LIKE '%" . $search . "%' OR 
                comment_content LIKE '%" . $search . "%' OR 
                post_title LIKE '%" . $search . "%' 
                ORDER BY comment_id DESC";
    }

    if (isset($_GET['id'])) {
        $id = mysqli_real_escape_string($connection, $_GET['id']);
        $sql = "SELECT * FROM posts JOIN comments ON post_id = comment_post_id WHERE comment_post_id = $id ORDER BY comment_id DESC";
    }
    $select_posts = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_object($select_posts)) {
        $post_id = $row->post_id;
        $post_title = $row->post_title;
        $comment_id = $row->comment_id;
        $comment_post_id = $row->comment_post_id;
        $comment_author = $row->comment_author;
        $comment_email = $row->comment_email;
        $comment_content = $row->comment_content;
        $comment_status = $row->comment_status;
        $comment_date = $row->comment_date;
        ?>
        <tr>
            <td><?= $comment_id ?></td>
            <td><?= $comment_author ?></td>
            <td><?= substr($comment_content, 0, 250) ?></td>
            <td><?= $comment_email ?></td>
            <?php
            switch ($comment_status) {
                case "unapproved":
                    echo "<td style='background-color: rgba(255,255,0,0.2);'>Unapproved</td>";
                    break;
                case "approved":
                    echo "<td style='background-color: rgba(0,255,0,0.2);'>Approved</td>";
                    break;
                case "deleted":
                    echo "<td style='background-color: rgba(255,0,0,0.2);'>Deleted</td>";
                    break;
            }
            ?>
            <td class="text-center"><a href="../post.php?p_id=<?= $post_id ?>"><?= $post_title ?></td>
            <td><?php echo date("Y M d - G:i:s", strtotime($comment_date)) ?></td>
            <td class="text-center"><a href="comments.php?source=post_comments&id=<?= $id ?>&a=<?= $comment_id ?>">Appruve
                    <i class="fa fa-check" aria-hidden="true"></i></a></td>
            <td class="text-center"><a href="comments.php?source=post_comments&id=<?= $id ?>&u=<?= $comment_id ?>">Unapproved
                    <i class="fa fa-times" aria-hidden="true"></i></a></td>
            <!--            <td class="text-center"><a href="comments.php?source=post_comments&id=<?= $id ?>&e=--><?//= $comment_id ?><!--">Edit <i class="fa fa-pencil" aria-hidden="true"></i></a></td>-->
            <td class="text-center"><a href="comments.php?source=post_comments&id=<?= $id ?>&d=<?= $comment_id ?>&cc=<?= $post_id ?>">Delete
                    <i class="fa fa-ban" aria-hidden="true"></i></a></td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>
