<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "conmysql.php";

$email = $_SESSION['email'];
$password = $_SESSION['password'];
$login = $_SESSION['login'];

date_default_timezone_set('Asia/Tashkent');

echo $email . "<br>" . $password;

if (!isset($_SESSION['attempt'])) {
    $_SESSION['attempt'] = 0;
}
function att_left()
{
    $left = 3 - $_SESSION['attempt'];
    echo $left . " attempts left. <br>";
}
function check_ban_time()
{
    if (time() <= $_SESSION['ban_time']) {
        echo "YOU ARE BANNED FOR A FEW MINUTES! <br> BAN EXPIRATION TIME: " . date("h:i:s", $_SESSION['ban_time']) . "<br>";
        exit();
    } else {
        unset($_SESSION['ban_time']);
        $_SESSION['attempt'] = 0;
    }
}
function ban_time()
{
    if (isset($_SESSION['ban_time'])) {
        check_ban_time();
    }
}
function set_bantime()
{
    if ($_SESSION['attempt'] == 3) {
        $_SESSION['ban_time'] = time() + 600;
    }
}
function iscorrect($email, $password)
{
    if (htmlspecialchars($_POST['val_email']) == htmlspecialchars($email) && htmlspecialchars($_POST['val_password']) == htmlspecialchars($password)) {
        header("Location: mainpage.php");
    }
    $_SESSION['attempt']++;
    header("Location: " . $_SERVER['PHP_SELF']);
    set_bantime();
}
ban_time();
?>
<!DOCTYPE html>
<html>

<head>
    <title> Validation </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8" />
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <form method="POST">
        <label> E-mail: </label>
        <input type="text" name="val_email">
        <br>
        <label> Password: </label>
        <input type="password" name="val_password">
        <br>
        <button type="submit" name="submit_button"> Log in</button>
    </form>
    <?php
    att_left();
    if (isset($_POST['submit_button'])) {
        iscorrect($email, $password);
        echo $email . "<br>" . $password . "<br" . $_POST['val_email'] . "<br>" . $_POST['val_password'] . "<br>";
    }
    ?>
</body>

</html>