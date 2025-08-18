<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$pdo = new PDO("sqlite:data.db");
$pdo->exec("CREATE TABLE IF NOT EXISTS POST_DATA (
    ID INTEGER PRIMARY KEY AUTOINCREMENT,
    picture	text,
	title TEXT NOT NULL,
	txt	TEXT NOT NULL,
	posttime TEXT
)");
if (!is_dir(__DIR__ . "/uploads/")) {
    mkdir(__DIR__ . "/uploads/", 0755, true);
}
?>
<!DOCTYPE html>
<html>
<head lang="eng">
    <title> Upload a post </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="blogstyle.css">
</head>

<body>
    <form method="POST" enctype="multipart/form-data">
        <label> Choose the Picture
            <input type="file" name="image"/>
        </label>
        <button type="submit"> Upload </button>
        <br><br>
        <label>Write your title:</label>
        <input type="text" name="title"> 
        <br><br>
        <label for="text">Write your post there:</label><br>
        <textarea name="txt" rows="20" cols="150" placeholder="Enter the text"></textarea>
        <br>
        <input type="submit" name="create" value="Create">
    </form>
<?php
    if(isset($_POST['create']))
    {
        if(!empty($_POST['txt']) && !empty($_POST['title']))
        {
            $posttime = date("Y-m-d H:i:s");

            if(!empty($_FILES['image']['name'])) {
                $img_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $hash = hash('sha256', $_FILES['image']['name']) . "." . $img_ext;
                move_uploaded_file($_FILES['image']['tmp_name'], "/var/www/html/project/blog/uploads/" . $hash);
                $statement = $pdo->prepare("INSERT INTO POST_DATA (picture, title, txt, posttime) VALUES (:picture, :title, :txt, :posttime)");
                $statement->bindValue(':picture', $hash);
                $statement->bindValue(':title', $_POST['title'], PDO::PARAM_STR);
                $statement->bindValue(':txt', $_POST['txt'], PDO::PARAM_STR);
                $statement->bindValue(':posttime', $posttime, PDO::PARAM_STR);
                $statement->execute();
            }
            else{
                $statement = $pdo->prepare("INSERT INTO POST_DATA (title, txt, posttime) VALUES (:title, :txt, :posttime)");
                $statement->bindValue(':title', $_POST['title'], PDO::PARAM_STR);
                $statement->bindValue(':txt', $_POST['txt'], PDO::PARAM_STR);
                $statement->bindValue(':posttime', $posttime, PDO::PARAM_STR);
                $statement->execute();
            }
            header("Location: main.php");
        }
    }
    
?>
</body>

</html>
