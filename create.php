<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "conmysql.php";
if (!is_dir(__DIR__ . "/uploads/")) {
    mkdir(__DIR__ . "/uploads/", 0755, true);
}
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="style.css">
    <title>Create a post</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8" />
    <style>
        body {
            background-color: burlywood;
        }
    </style>
</head>

<body class="create">
    <header>
        <div class="navbar">
            <a href="mainpage.php"> Main </a>
            <?php
            if ($_SESSION['profile'] == true) {
                echo "<a href='profile.php'>" . $_SESSION['login'] . "</a>";
            } else {
                echo "<a href='login.php'> Login </a>";
            }
            ?>
            <a href="create.php"> Create a Post </a>
            <a href="about.php"> About Me </a>
        </div>
    </header>
    <br>
    <?php
    if (!$_SESSION['login']) {
        echo "You have to register to write a post. 
        Register <a href='login.php'> <b>here</b> </a>";
        exit();
    }
    ?>
    <form method="POST" enctype="multipart/form-data">
        <label>
            Upload the media <input type="file" name="media">
            <input type="submit" name="upl_media" value="Upload"> <br><br>
        </label>
        <label>
            Blog is title: <br>
            <input type="text" name="title"> <br><br>
        </label>
        <label>
            Blog is body: <br>
            <textarea name="blog_body" rows="20" cols="150" placeholder="Write blog is body here"></textarea> <br><br>
        </label>
        <input type="submit" name="create" value="Create a post">
    </form>
    <?php
    if (isset($_POST['create'])) {
        if (!empty($_POST['blog_body']) && !empty($_POST['title'])) {
            $date = new DateTime();
            $posttime = $date->format('Y-m-d H:i:s');
            if (!empty($_FILES['media']['name'])) {
                $img_ext = pathinfo($_FILES['media']['name'], PATHINFO_EXTENSION);
                $hash = hash("sha256", $_FILES['media']['name']) . "." . $img_ext;
                move_uploaded_file($_FILES['media']['tmp_name'], __DIR__ . "/uploads/" . $hash);
                $postbody = $conn->real_escape_string($_POST['blog_body']);
                $sql = "INSERT INTO posts(blog_author, blog_title, blog_media, blog_text, postdate)
                        VALUES ('" . $_SESSION['login'] . "', '" .  $_POST['title'] . "', '" . $hash . "', '" . $postbody . "', '" . $posttime . "')";
                $conn->query($sql);
            } else {
                $title = $conn->real_escape_string($_POST['title']);
                $postbody = $conn->real_escape_string($_POST['blog_body']);
                $sql = "INSERT INTO posts(blog_author, blog_title, blog_text, postdate)
                        VALUES ('" . $_SESSION['login'] . "', '" . $title . "', '" . $postbody . "', '" . $posttime . "')";
                $conn->query($sql);
            }
            header("Location: mainpage.php");
        } else {
            echo "<b>Title</b> or <b>blog body</b> cannot be empty!<br><>br";
        }
    }
    ?>

</html>