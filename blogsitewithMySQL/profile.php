<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "conmysql.php";


function show_posts()
{
    $sql = "SELECT * FROM posts WHERE blog_author = '" . $_SESSION['login'] . "'";
    $res = $GLOBALS['conn']->query($sql);
    $posts = [];
    while ($rows = $res->fetch_assoc()) {
        $posts[] = $rows;
    }
    if ($res->num_rows != 0) {
        if (!empty($posts)) {
            echo "
            <table>
            <tr>
                <th> Posts </th>
            </tr>
            ";
            foreach ($posts as $i) {
                echo "<tr><td> Title: " . $i['blog_title'] . "<br>";
                if (!empty($i['blog_media'])) {
                    $path = "uploads/" . $i['blog_media'];
                    echo "<img src='$path' style='max-width:auto; height:500px;'><br>";
                }
                echo "<br> <pre>" . $i['blog_text'] . "</pre>
                <form action='edit.php' method='POST'> 
                    <input type='hidden' name='id' value='" . (int)$i['ID'] . "'>
                    <button type='submit' name='edit'> Edit  </button>
                </form>
                <form method='POST'>
                    <input type='hidden' name='id' value='" . (int)$i['ID'] . "'>
                    <button type='submit' name='delete'> Delete this post</button>
                </form>
                    </td>
                    </tr>";
            }
            echo "
        </table>";
        } else {
            echo "You haven't written any post yet<br>";
        }
    } else {
        echo "<br>You don't have any posts yet...<br>";
    }
}
function log_out()
{
    session_destroy();
    header("Location: mainpage.php");
    exit;
}
function show_all_users()
{
    global $conn;
    $sql = "SELECT user_login FROM users";
    $tmp = $conn->query($sql);
    $users = [];
    while ($rows = $tmp->fetch_assoc()) {
        $users[] = $rows;
    }
    if (!empty($users)) {
        echo "
        <h3> Users </h3>
            <ul>
            ";
        foreach ($users as $i) {
            echo "
            <li> 
            " . $i['user_login'] . "   
            </li>";
        }
        echo "
        </ul>";
    } else {
        echo "There are no users registered yet...";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="style.css">
    <title>Profile</title>
    <style>
        body {
            background-color: darkcyan;
        }
    </style>
</head>

<body class="profile">
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
    if ($_SESSION['profile'] == false) {
        echo "You haven't logged yet!<br>
        Log In <a href='login.php'>here</a>";
        exit;
    }
    echo "Login: <b>" . $_SESSION['login'] . "</b> <br>";
    show_posts();
    echo "<br>";
    show_all_users();
    ?>
    <br>

    <form method="POST">
        Log out:
        <input type="submit" name="log_out" value="Log out">
    </form>
    <?php

    if (isset($_POST['log_out'])) {
        log_out();
    }
    ?>
</body>

</html>
<?php
