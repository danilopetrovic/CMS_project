<?php
if (!isset($_GET['p_id'])) {
    echo "Id of post isn't set for editing...";
    exit();
}
if (isset($_GET['p_id']) and is_numeric($_GET['p_id'])) {
    $p_id = escape($_GET['p_id']);
    $sql = "SELECT * FROM posts LEFT JOIN categories ON cat_id = post_category_id WHERE post_id = $p_id";
//    echo $sql;
    $select_post_by_id = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($select_post_by_id);
    $post_id = $row['post_id'];
    $post_author = $row['post_author'];
    $post_title = $row['post_title'];
    $post_category_id = $row['post_category_id'];
    $post_status = $row['post_status'];
    $post_image = $row['post_image'];
    $post_tags = $row['post_tags'];
    $post_comment_count = $row['post_comment_count'];
    $post_date = $row['post_date'];
    $post_content = $row['post_content'];
    $cat_title = $row['cat_title'];

    //    $sql2 = "SELECT * FROM categories ORDER BY cat_id";
//    $res = mysqli_query($connection, $sql2);
//    $kategorija = array();
//    $i=0; $j=0; /*ovo su mi brojaci za nizove*/
//    while ($red = mysqli_fetch_assoc($res)) {
//        $kategorija_id[$i++] = $red['cat_id']; /*ubacio sam u 2 niza podatke iz baze o id-u i imenu kategorije*/
//        $kategorija_title[$j++] = $red['cat_title'];
//    }
//    print_r($kategorija_id);
//    echo "<hr>";
//    print_r($kategorija_title);
}

if (isset($_POST['update_post'])) {
    $post_category_id = $_POST['category_id'];
    $post_title = trim(htmlentities($_POST['title'],ENT_QUOTES));
    $post_status = trim(htmlentities($_POST['status'],ENT_QUOTES));
    $post_image = $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name'];
    $post_tags = trim(htmlentities($_POST['tags'],ENT_QUOTES));
    $post_content = trim(htmlentities($_POST['content'],ENT_QUOTES));
    $post_date = date('d-m-y');

    /*deo koji sluzi da kada lupis vise puta upload a ne dodas sliku da je ne obrise...*/
    if (empty($post_image)) {
        $sql3 = "SELECT * FROM posts WHERE post_id = $p_id";
        $select_image = mysqli_query($connection, $sql3);
        $row = mysqli_fetch_object($select_image);
        $post_image=$row->post_image;
    }

    move_uploaded_file($post_image_temp, "../images/$post_image");
    $sql3 = "UPDATE posts SET
    post_category_id = $post_category_id,
    post_title = '$post_title',
    post_date = now(),
    post_image = '$post_image',
    post_content = '$post_content',
    post_tags = '$post_tags',
    post_status = '$post_status' 
    WHERE post_id = $p_id";

    $create_post_query = mysqli_query($connection, $sql3);
    if (!$create_post_query) {
        echo "<h2 style='color: red' class='text-center bg-danger'>Failed to update post!</h2>";
//        echo mysqli_error($connection);
        exit();
    } else {
        echo "<h2 style='color: blue;' class='text-center bg-success'>Post updated succesfully!!! <a href='../post.php?p_id=$p_id'>View Post</a> or <a href='posts.php'>Edit More Posts</a></h2>";
//        header("location: posts.php?source=edit_post&p_id=$p_id");
    }
}
?>
<form action="#" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="title" value="<?= $post_title ?>"/>
    </div>
    <div class="form-group">
        <label for="category_id">Category </label>
        <span style="border: 1px dotted; padding: 0"><?= $cat_title ?></span>
        <label for="category_id">Change to:</label>
        <select name="category_id" id="category_id">
            <option value="<?= $post_category_id ?>" selected hidden><?= $cat_title ?></option>
            <?php
            /*uradjeno sa 2 niza u koje sam smestio podatke iz baze*/
            //            for ($i = 0; $i < count($kategorija_id); $i++) {
            //                echo "<option value='$kategorija_id[$i]'>$kategorija_title[$i]</option>";
            //            }

            /*uradjeno na klasican nacin*/
            $sql2 = "SELECT * FROM categories ORDER BY cat_id";
            $res = mysqli_query($connection, $sql2);
            while ($red = mysqli_fetch_object($res)) {
                echo "<option value='$red->cat_id'>$red->cat_title</option>";
            }

            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="status">Post Status </label>
        <span style="border: 1px dotted; padding: 0"><?= ucfirst($post_status) ?></span>
        <label>Change to: </label>
        <select name="status" id="status">
            <option value="<?= $post_status ?>" selected hidden><?= ucfirst($post_status) ?></option>
            <option value="published">Published</option>
            <option value="draft">Draft</option>
        </select>
    </div>
    <div class="form-group">
        <label for="image">Post Image</label><br>
        <img style="border: 1px dashed; max-height: 100px; max-width: 600px" src="../images/<?= $post_image ?>"><br>
        <input type="file" name="image" value="<?= $post_image ?>"/>
        <?php
        if (isset($_FILES['image'])) {
            echo "Tempfile: " . $_FILES['image']['tmp_name'] . "<Br>";
            echo "Uploaded Filename: " . $_FILES['image']['name'] . "<Br>";
            echo "Tempfile size: " . $_FILES['image']['size'] . "<br>";
        }
        ?>
    </div>
    <div class="form-group">
        <label for="tags">Post Tags</label>
        <input type="text" class="form-control" name="tags" value="<?= $post_tags ?>"/>
    </div>
    <div class="form-group">
        <label for="content">Post Content</label>
        <textarea class="form-control" name="content" id="content" rows="20"><?= $post_content ?></textarea>
    </div>
    <div class="form-group">
        <label for="author">Post Author: </label> "<?= $post_author ?>"
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_post" value="Update Post">
    </div>
</form>
