<?php
    session_start();
    $checkmail = true;
    $checkpassword = true; 
    if(isset($_POST['submit_button']))
    {
        if(strlen($_POST['email']) > 0 && strlen($_POST['password']))
        {
                $_SESSION['email'] = $_POST['email'];
                $_SESSION['password'] = $_POST['password'];
            if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
            {
                echo "E-mail is not valid!";
                $checkmail = false;
            }
            if(strpos($_POST['password'], " ") !== false && strlen($_POST['password']) != 0)
            {
                echo "Password cannot include any space!";
                $checkpassword = false;
            }
            if($checkmail && $checkpassword)
            {
                header("Location: validation.php");
                exit();
            }
        }
        else
        {
            echo "FIELDS CANNOT BE EMPTY!";
        }
    }
?>
<!DOCTYPE html>

<html lang="eng">

<head>
    <title> Login </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8"/>    
    <style>
        button{
            border-radius: 5px;
            color: black;
            font-size: 13px;
            padding: 5px;
            margin-top: 5px;
        }
        body{
            color: black;
            padding: 20px;
            text-align: center;
            background-color: lightcyan;
            font-size: 20px;
        }
    </style>
</head>
<body>
    <form method="POST">
        E-mail: <input type="text" name="email">
        <br>
        Password: <input type="password" name="password" minlength="8">
        <br>
        <button type="submit" name="submit_button"> Register</button>
    </form>
</body>
</html>
