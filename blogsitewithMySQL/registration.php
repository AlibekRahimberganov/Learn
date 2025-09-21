<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "conmysql.php";
$checkmail = true;
$checkpassword = true;
$checklogin = true;
function check_valid_email()
{
    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        echo "E-mail is not valid!";
        $GLOBALS['checkmail'] = false;
    }
}
function check_valid_password()
{
    if (strpos($_POST['password'], " ") !== false) {
        echo "Password cannot include any space!<br>";
        $GLOBALS['checkpassword'] = false;
    }
}
function check_valid_login($login)
{
    if (strpos($login, " ") !== false) {
        echo "Login cannot include any space";
        $GLOBALS['checklogin'] = false;
    }
}
function iscorrect($checkmail, $checkpassword, $checklogin)
{
    if ($checkmail && $checkpassword && $checklogin) {
        $date = new DateTime();
        $loggedtime = $date->format('Y-m-d H:i:s');
        $sql = "INSERT INTO users(user_login, user_email, user_password, user_logged)
                VALUES('" . $_SESSION['login'] . "', '" . $_SESSION['email'] . "', '" . $_SESSION['password'] . "', '" . $loggedtime . "' )";
        $GLOBALS['conn']->query($sql);
        header("Location: login.php");
    }
}
function check_login_password($checkmail, $checkpassword, $checklogin)
{
    if (strlen($_POST['email']) > 0 && strlen($_POST['password'])) {
        $_SESSION['login'] = $_POST['login'];
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['password'] = $_POST['password'];
        check_valid_email();
        check_valid_password();
        check_valid_login($_POST['login']);
        iscorrect($checkmail, $checkpassword, $checklogin);
    } else {
        echo "FIELDS CANNOT BE EMPTY!";
    }
}

if (isset($_POST['submit_button'])) {
    check_login_password($checkmail, $checkpassword, $checklogin);
}
?>
<!DOCTYPE html>

<html lang="eng">

<head>
    <title> Login </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8" />
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            color: black;
            background-color: aquamarine;
        }
    </style>
</head>

<body class="registration">
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
    <form method="POST">
        Login <input type="text" name="login" placeholder="Login">
        <br>
        E-mail: <input type="text" name="email" placeholder="E-mail">
        <br>
        Password: <input type="password" name="password" placeholder="Password" minlength="8">
        <br>
        <button type="submit" name="submit_button" class="login"> Register</button>
    </form>
</body>

</html>