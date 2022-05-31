<?php
if (isset($_SESSION['role']) and $_SESSION['role'] != 'admin') {
//    header("Location: index.php");
    echo "You don't have permission to be on this page! <a href='index.php'>Go back to Admin</a>";
    exit();
}
include "modal_delete.php";
if (isset($_POST['selectAllBoxes']) and isset ($_POST['bulk_options'])) {
    foreach ($_POST['selectAllBoxes'] as $postValueId) {
        $bulk_options = $_POST['bulk_options'];
        switch ($bulk_options) {
            case "published":
                $sql = "UPDATE posts SET post_status = '$bulk_options' WHERE post_id = $postValueId";
                $publish = mysqli_query($connection, $sql);
                if (!$publish) {
                    echo "Error publishing post" . mysqli_error($connection);
                    exit();
                }
                header('Location: posts.php');
                break;
            case "draft":
                $sql = "UPDATE posts SET post_status = '$bulk_options' WHERE post_id = $postValueId";
                $draft = mysqli_query($connection, $sql);
                if (!$draft) {
//                    echo mysqli_error($connection);
                    echo "Error changing post to draft";
                    exit();
                }
                header('Location: posts.php');
                break;
            case "delete":
                $sql = "UPDATE posts SET post_status = 'deleted' WHERE post_id = $postValueId";
                $delete = mysqli_query($connection, $sql);
                if (!$delete) {
                    echo "Error deleting ".mysqli_error($connection);
                    exit();
                }
                header('Location: posts.php');
                break;
            case "clone":
                $sql = "SELECT * FROM posts WHERE post_id = $postValueId";
                $select_post_query = mysqli_query($connection, $sql);
                while ($row = mysqli_fetch_object($select_post_query)) {
                    $post_category_id = $row->post_category_id;
                    $post_title = $row->post_title;
                    $post_author = $row->post_author;
                    $post_date = $row->post_date;
                    $post_image = $row->post_image;
                    $post_content = $row->post_content;
//                    $post_content = trim(htmlentities($post_content,ENT_QUOTES));
                    $post_content = mysqli_real_escape_string($connection, strip_tags($post_content));
                    $post_tags = $row->post_tags;
                    $post_status = $row->post_status;
                    $q = "INSERT INTO posts (post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status) VALUES ($post_category_id, '$post_title', '$post_author', now(), '$post_image', '$post_content', '$post_tags', 'draft');";
                    $copy_query = mysqli_query($connection, $q);
//                    echo $q;
                    if (!$copy_query) {
//                        exit("Query failed..." . mysqli_error($connection));
                        echo "Error with cloning";
                        exit();
                    }
                }
                header('Location: posts.php');
                break;
            case "reset":
                $sql = "UPDATE posts SET post_views_count = 0 WHERE post_id = $postValueId";
                $reset = mysqli_query($connection, $sql);
                if (!$reset) {
//                    echo mysqli_error($connection);
                    echo "Error";
                    exit();
                }
                break;
        }
    }
}
?>
<form action="" method="post">
    <div id="bulkOptionsContainer" class="col-xs-3" style="padding-left: 0; margin-bottom: 10px;">
        <select name="bulk_options" id="bulk_options" class="form-control">
            <option value="published">Publish</option>
            <option value="draft">Draft</option>
            <option value="delete">Delete</option>
            <option value="clone">Clone</option>
            <option value="reset">Reset Counter</option>
        </select>
    </div>
    <div class="col-xs-4">
        <input type="submit" name="submit" id="submit" class="btn btn-success" value="Apply">
        <a href="posts.php?source=add_post" class="btn btn-primary">Add New</a>
    </div>
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th><input type="checkbox" id="selectAllBoxes"></th>
            <th class="text-center">ID</th>
            <th class="text-center">Author</th>
            <th class="text-center">Title</th>
            <th class="text-center">Category</th>
            <th class="text-center" style="background: linear-gradient(to right, rgba(255,255,0,0.45), rgba(0,255,0,0.25), rgba(255,0,0,0.25))">Status</th>
            <th class="text-center">Image</th>
            <th class="text-center">Tags</th>
            <th class="text-center">Comments</th>
            <th class="text-center">Date</th>
            <th class="text-center" colspan="2">Counter&nbspViews</th>
            <th class="text-center">Edit</th>
            <th class="text-center">Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php
        /*prikaz vesti*/
        $sql = "SELECT * FROM posts LEFT JOIN categories ON post_category_id = cat_id ORDER BY post_id DESC ";
        //    echo "<hr>".$sql."<hr>";
        $select_posts = mysqli_query($connection, $sql);
        while ($row = mysqli_fetch_assoc($select_posts)) {
            $post_id = $row['post_id'];
            $post_author = $row['post_author'];
            $post_title = $row['post_title'];
            $post_category_id = $row['post_category_id'];
            $cat_title = $row['cat_title'];
            $post_status = $row['post_status'];
            $post_image = $row['post_image'];
            $post_tags = $row['post_tags'];
            $post_comment_count = $row['post_comment_count'];
            $post_views_count = $row['post_views_count'];
            $post_date = $row['post_date'];
            ?>
            <tr>
                <td><input type="checkbox" name="selectAllBoxes[]" class="checkBoxes" value="<?= $post_id ?>"></td><!--ID-->
                <td><?= $post_id ?></td><!--Author-->
                <td><a href="../author_posts.php?author=<?= $post_author ?>"><?= $post_author ?></a></td><!--Author-->
                <td><a href="../post.php?p_id=<?= $post_id ?>"><?= $post_title ?></a></td><!--Title-->
                <td><?= $cat_title ?></td><!--Category-->
                <?php
                switch ($post_status) {
                    case "draft":
                        echo "<td style='background-color: rgba(255,255,0,0.3);'>Draft</td>";
                        break;
                    case "published":
                        echo "<td style='background-color: rgba(0,255,0,0.3);'>Published</td>";
                        break;
                    case "deleted":
                        echo "<td style='background-color: rgba(255,0,0,0.3);'>Deleted</td>";
                        break;
                    default:
                        echo "<td>UNKNOWN!!!</td>";
                }
                ?><!--Status-->
                <td class="text-center">
                    <a href="../post.php?p_id=<?= $post_id ?>"><img height="40px" src="../images/<?= $post_image ?>" alt="no immage"/></a>
                </td><!--Image-->
                <td><?= $post_tags ?></td><!--Tags-->
                <td class="text-center">
                    <?php if ($post_comment_count != 0)
                        echo "<a href='comments.php?source=post_comments&id=$post_id'>$post_comment_count <i class='fa fa-comment-o' aria-hidden='true'></i></a>";
                    ?>
                </td><!--Comments-->
                <td><?= $post_date ?></td><!--Date-->
                <td class="text-center"><?php if ($post_views_count != 0) echo $post_views_count ?></td><!--Counter Views-->
                <td class="text-center">
                    <a href="posts.php?reset=<?= $post_id ?>"><?php if ($post_views_count != 0) echo 'Reset <i class="fa fa-undo" aria-hidden="true"></i>'; ?></a>
                </td><!--Counter Views Reset-->
                <td class="text-center">
                    <a href="posts.php?source=edit_post&p_id=<?= $post_id ?>">Edit
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                </td><!--Edit-->
                <td class="text-center">
<!--                    <a onClick="javascript: return confirm('Are you sure?')" href="posts.php?delete=--><?//= $post_id ?><!--">Delete <i class="fa fa-trash-o" aria-hidden="true"></i></a></td>-->
                    <a href="javascript:void(0)" rel="<?= $post_id ?>" class="delete_link">Delete <i class="fa fa-trash-o" aria-hidden="true"></i></a>
                </td>
                <!--Delete-->
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</form>

<?php
if (isset($_GET['delete']) and is_numeric($_GET['delete']) and strval($_GET['delete']) == strval(intval($_GET['delete']))) {
    $delete = escape($_GET['delete']);
    $sql = "DELETE FROM posts WHERE post_id = $delete";
    global $delete_query;
    $delete_query = mysqli_query($connection, $sql);
    if ($delete_query) {
        header("Location: posts.php");
    }
}
if (isset($_GET['reset']) and is_numeric($_GET['reset'])) {
    $reset = escape($_GET['reset']);
    $sql = "UPDATE posts SET post_views_count = 0 WHERE post_id = $reset";
    $reset_query = mysqli_query($connection, $sql);
    if ($reset_query) {
        header("Location: posts.php");
    }
}
?>