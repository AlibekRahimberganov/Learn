<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$pdo = new PDO("sqlite:data.db");
$pdo->exec("CREATE TABLE IF NOT EXISTS POST_DATA (
    ID INTEGER PRIMARY KEY AUTOINCREMENT,
    txt TEXT NOT NULL
)");
?>
<!DOCTYPE html>
<html>
<head lang="eng">
    <title> Upload a post </title>
    <link rel="stylesheet" href="blogstyle.css">
</head>

<body>
    <form method="POST"> 
        <label for="text">Write your post there:</label><br>
        <textarea name="txt" rows="20" cols="150" placeholder="Enter the text"></textarea>
        <br>
        <input type="submit" name="create" value="Create">
    </form>
<?php
    if(isset($_POST['create']))
    {
        if(!empty($_POST['txt']))
        {
            $statement = $pdo->prepare("INSERT INTO POST_DATA (txt) VALUES (:txt)");
            $statement->bindValue(':txt', $_POST['txt'], PDO::PARAM_STR);
            $statement->execute();
            header("Location: main.php");
        }
    }
    
?>
</body>

</html>
