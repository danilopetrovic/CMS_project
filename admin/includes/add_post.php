<?php
$post_author = $_SESSION['firstname']." ".$_SESSION['lastname'];
if (isset($_POST['create_post'])) {
    $post_category_id = escape($_POST['category_id']);
    $post_title = escape($_POST['title']);
    $post_status = 'draft';

    $post_image = $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name'];

    $post_tags = escape($_POST['tags']);
    $post_content = escape($_POST['content']);
    $post_date = date('d-m-y');

    move_uploaded_file($post_image_temp, "../images/$post_image");
    $sql = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status) VALUES ($post_category_id, '$post_title', '$post_author', now(), '$post_image', '$post_content', '$post_tags', '$post_status')";
//    echo $sql."<hr>";
    $create_post_query = mysqli_query($connection, $sql);
    $p_id = mysqli_insert_id($connection); /*zadnji poslednji ID koji je ubacen u bazu*/
    if (!$create_post_query) {
        exit("<h2 style='color: red' class='text-center bg-danger'>Failed to add post!</h2>");
    } else {
        echo "<h2 style='color: blue;' class='text-center bg-success'>Post created succesfully!!! <a href='../post.php?p_id=$p_id'>View Post</a> or <a href='posts.php'>Go to all posts</a></h2>";
    }
}
?>

<form action="#" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="title"/>
    </div>
    <div class="form-group">
        <label for="category_id">Category Title</label>
        <select name="category_id" id="category_id">
        <?php
        $sql2 = "SELECT * FROM categories ORDER BY cat_id";
        $res = mysqli_query($connection, $sql2);
        while ($red = mysqli_fetch_object($res)) {
            echo "<option value='$red->cat_id'>$red->cat_title</option>";
        }
        ?>
        </select>
    </div>
    <div class="form-group">
        <label for="image">Post Image</label>
        <input type="file" name="image"/>
    </div>
    <div class="form-group">
        <label for="tags">Post Tags</label>
        <input type="text" class="form-control" name="tags"/>
    </div>
    <div class="form-group">
        <label for="content">Post Content</label>
        <textarea class="form-control" name="content" id="content" rows="20"></textarea>
    </div>
    <div class="form-group">
        <label for="author">Author is </label> "<?= $post_author ?>"
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
    </div>
</form>