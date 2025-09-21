<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "conmysql.php";

$checkmail = true;
$checkpassword = true;
$checklogin = true;

function check_from_db($login, $email, $password)
{
    $sql = "SELECT user_login FROM users WHERE user_login = '" . $login . "'";
    $res = $GLOBALS['conn']->query($sql);
    /* login checked */
    if ($res && $res->num_rows > 0) {
        $sql = "SELECT user_email FROM users WHERE user_email = '" . $email . "'";
        $res = $GLOBALS['conn']->query($sql);
        /* e-mail checked */
        if ($res && $res->num_rows > 0) {
            $sql = "SELECT user_password FROM users WHERE user_password = '" . $password . "'";
            $res = $GLOBALS['conn']->query($sql);
            /* password checked */
            if ($res && $res->num_rows > 0) {
                $_SESSION['profile'] = true;
                header("Location: mainpage.php");
                exit;
            } else {
                /* password is incorrect */
                echo "This <b>password</b> is incorrect!<br>";
            }
        } else {
            /* e-mail isn't matched */
            echo "This <b>e-mail</b> isn't registered!<br>";
        }
    } else {
        /*Login isn't matched*/
        echo "This <b>Login</b> isn't registered!<br>";
    }
}
function check_valid_email()
{
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        echo "E-mail is not valid!";
        $GLOBALS['checkmail'] = false;
    }
}
function check_valid_password()
{
    if (strpos($_POST['password'], " ") !== false) {
        echo "Password cannot include any space!";
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
        $login = $_POST['login'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        check_from_db($login, $email, $password);
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
            background-color: lightcyan;
        }

        button {
            border-radius: 5px;
            color: black;
            font-size: 13px;
        }
    </style>
</head>

<body class="login">
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
    <h3>Log in to an existent account</h3>
    <form method="POST">
        Login <input type="text" name="login" placeholder="Login">
        <br>
        E-mail: <input type="text" name="email" placeholder="E-mail">
        <br>
        Password: <input type="password" name="password" placeholder="Password" minlength="8">
        <br>
        <button type="submit" name="submit_button" class="login"> Register</button>
        <br>
        <a class="link" href="registration.php"> Don't have an account? Register here.</a>
        <br><br><br>
    </form>
    <?php
    if (isset($_POST['submit_button'])) {
        check_login_password($checkmail, $checkpassword, $checklogin);
    }
    ?>
</body>

</html>