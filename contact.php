<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<!-- Navigation -->
<?php include "includes/navigation.php"; ?>

<?php
$message = "";
if (isset($_POST['submit'])) {
    $subject = escape($_POST['subject']);
    $content = escape($_POST['content']);
    $email = escape($_POST['email']);

    if (empty($subject) or empty($content) or empty($email)) {
        $message = '<h4 class="text-center bg-danger">Fill all fields...</h4>';
    }
    if (!empty($subject) and !empty($content) and !empty($email)) {
        $to = "danilo86petrovic@gmail.com";
        $header = "From: ".$email;
        $a = mail($to, $subject, $content, $header);
        $message = "Your message was sent!";
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
                        <h1>Contact us:</h1>
                        <form role="form" action="#" method="post" id="login-form" autocomplete="off">
                            <div class="form-group">
                                <label for="subject" class="sr-only">Subject</label>
                                <input type="text" name="subject" id="subject" class="form-control" placeholder="Subject">
                            </div>
                            <div class="form-group">
                                <label for="content" class="sr-only">Message</label>
                                <textarea name="content" id="content" class="form-control" placeholder="Message content" rows="8"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email">
                            </div>

                            <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Submit">
                        </form>
                    </div>
                    <h2 style='color: blue;' class='text-center bg-success'><?= $message ?></h2>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>


    <hr>


    <?php include "includes/footer.php"; ?>
