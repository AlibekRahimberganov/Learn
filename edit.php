<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="style.css">
    <title>Create a post</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8" />
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
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include "conmysql.php";

    if (!is_dir(__DIR__ . "/uploads/")) {
        mkdir(__DIR__ . "/uploads/", 0755, true);
    }

    if (isset($_POST['id'])) {
        $id = (int) $_POST['id'];
        $sql = "SELECT blog_media, blog_title, blog_text, postdate FROM posts WHERE ID = '" . $id . "';";
        $res = $conn->query($sql);
        if ($res && $res->num_rows > 0) {
            $post = $res->fetch_assoc();
        }

        if (!empty($post['blog_media'])) {
            $path = "/uploads/" . $post['blog_media'];
            echo "<img src='$path' alt='Post image' style='max-width:100%; height:500px;'><br>";
        }
        echo "Edit: <br>";
        echo "
    <form method='POST' enctype='multipart/form-data'>
        <label>Change Image (optional):</label>
        <br>
        <input type='file' name='image'>
        <br><br>

        <input type='text' name='title' value='" . $post['blog_title'] . "'>
        <br>
        <textarea name='txt' rows='20' cols='150'>" . $post['blog_text'] . "</textarea>
        <br>
        <input type='hidden' name='id' value='$id'>
        <input type='submit' name='save' value='Save'>
    </form>";
    }
    if (isset($_POST['save'])) {
        $id = (int) $_POST['id'];
        $txt = $conn->real_escape_string($_POST['txt']);;
        $newtitle = $conn->real_escape_string($_POST['title']);
        $posttime = date("Y-m-d H:i:s");
        $imageData = NULL;

        if (!empty($_FILES['image']['name'])) {
            $imageData = $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . "/uploads/" . $_FILES['image']['name']);
        }

        if ($imageData !== NULL) {
            $sql = "UPDATE posts 
        SET blog_text = '" . $txt . "',
        blog_title = '" . $newtitle . "', 
        postdate = '" . $posttime . "', 
        blog_media = '" . $imageData . "
        WHERE id = " . $id;
            $conn->query($sql);
        } else {
            $sql = "UPDATE posts 
        SET blog_text = '" . $txt . "', 
        blog_title = '" . $newtitle . "', 
        postdate = '" . $posttime . "' 
        WHERE id = " . $id;
            $conn->query($sql);
        }
        header("Location: mainpage.php");
        exit();
    }
    ?>
</body>