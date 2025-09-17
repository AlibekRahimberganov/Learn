<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="style.css">
    <title>About us</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8" />
    <style>
        body {
            background-color: darkturquoise;
        }
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
    <h2>About me</h2>
    <p>Developed by <b>Raximberganov Ali</b> to learn how to use <b>MySQL</b> DataBase. </p>
</body>

</html>