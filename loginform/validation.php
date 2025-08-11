<?php
    session_start();
    date_default_timezone_set('Asia/Tashkent');
    $email = $_SESSION['email'];
    $password = $_SESSION['password'];
    if(!isset($_SESSION['attempt']))
    {
        $_SESSION['attempt'] = 0;
    }

    function check_ban_time(){
        if(time() <= $_SESSION['ban_time'])
        {
            echo "YOU ARE BANNED FOR A FEW MINUTES! <br> BAN EXPIRATION TIME: " . date("h:i:s",$_SESSION['ban_time']) . "<br>";
            exit();
        }
        else
        {
            unset($_SESSION['ban_time']);
            $_SESSION['attempt'] = 0;
        }
    }
    function ban_time(){
        if(isset($_SESSION['ban_time']))
        {
            check_ban_time();
        }
    }
    function set_bantime(){
        if($_SESSION['attempt'] == 3)
        {
            $_SESSION['ban_time'] = time() + 600;
        }
    }
    function iscorrect($email, $password){
        if($_POST['val_email'] == $email && $_POST['val_password'] == $password)
        {
            echo "SUCCESSFULLY LOGGED IN! <br>";
            session_destroy();
            exit();
        }
        $_SESSION['attempt']++;
        header("Location: " . $_SERVER['PHP_SELF']);
        set_bantime();
            
    }
    ban_time();
    if(isset($_POST['submit_button']))
    {
        iscorrect($email, $password);
    }

?>
<!DOCTYPE html>
<html>
<head>
    <title> Validation </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8"/>    
    <style>
    body{
        background-color: lightblue;
    }
    </style>
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
</body>
</html>
