<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!isset($_SESSION['profile'])) {
    $_SESSION['profile'] = false;
}
include "conmysql.php";

$images = scandir(__DIR__ . "/uploads/");
$images = array_diff($images, ['.', '..']);

$get_all_posts = $conn->query("SELECT * FROM posts");
while ($rows = $get_all_posts->fetch_assoc()) {
    $posts[] = $rows;
}
if (!isset($_SESSION['login'])) {
    $_SESSION['login'] = false;
}
function show_all_posts()
{
    if (!empty($GLOBALS['posts'])) {
        echo "
        <h3> Posts </h3>
            <table>
            ";
        foreach ($GLOBALS['posts'] as $i) {
            echo "
            <tr>
            <td> 
            Title: " . $i['blog_title'] . "
            <br>
            Author: " . $i['blog_author'] . "
            <br>";
            if (!empty($i['blog_media'])) {
                $path = "uploads/" . $i['blog_media'];
                echo "<img src='$path' style='max-width:auto; height:500px;'><br>";
            }
            echo "
                <pre>" . $i['blog_text'] . "</pre>
            </td>    
            </tr>";
        }
        echo "
        </table>";
    } else {
        echo "There are no posts written yet...";
    }
}
if (isset($_POST['delete'])) {
    $id = (int) $_POST['id'];
    $sql = $conn->query("DELETE FROM posts WHERE ID = " . $id);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="eng">

<head>
    <title> Main Page </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: gray;
        }

        a {
            text-decoration: none;
            color: white;
            background-color: black;
        }
    </style>
    </style>
</head>

<body>
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
    show_all_posts();
    ?>
    <br><br><br><br><br><br><br>

    <form method="post">
        Clear all data:
        <input type="submit" name="cleardb" value="DROP DB">
    </form>
    <?php
    if (isset($_POST['cleardb'])) {
        $sql = "DROP TABLE users";
        $conn->query($sql);
        $sql = "DROP TABLE posts";
        $conn->query($sql);
        header("Location: " . $_SERVER['PHP_SELF']);
    }
    ?>
</body>