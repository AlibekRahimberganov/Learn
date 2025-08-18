<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ob_start();
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

if(isset($_POST['id']))
{
    $id = (int) $_POST['id'];
    $statement = $pdo->prepare("SELECT picture, title, txt, posttime FROM POST_DATA WHERE ID = :id");
    $statement->execute(([':id' => $id]));
    $post = $statement->fetch(PDO::FETCH_ASSOC);
    if(!empty($post['picture'])){
        $path = "/uploads/" . $post['picture'];
        echo "<img src='$path' alt='Post image' style='max-width:100%; height:500px;'><br>";
    }
    echo "Edit: <br>";
    echo "
    <form method='POST' enctype='multipart/form-data'>
        <label>Change Image (optional):</label>
        <br>
        <input type='file' name='image'>
        <br><br>

        <input type='text' name='title' value='". $post['title'] ."'>
        <br>
        <textarea name='txt' rows='20' cols='150'>" . $post['txt'] ."</textarea>
        <br>
        <input type='hidden' name='id' value='$id'>
        <input type='submit' name='save' value='Save'>
    </form>";
}
if(isset($_POST['save']))
{
    $id = (int) $_POST['id'];
    $txt = $_POST['txt'];
    $newtitle = $_POST['title'];
    $posttime = date("Y-m-d H:i:s");
    $imageData = NULL;

    if(!empty($_FILES['image']['name'])){
        $imageData = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "/var/www/html/project/blog/uploads/" . $_FILES['image']['name']);
    }

    if($imageData !== NULL){
        $stmt = $pdo->prepare("UPDATE POST_DATA SET txt = :txt, title = :title, posttime = :posttime, picture = :picture WHERE ID = :id");
        $stmt->execute([':txt'=>$txt, ':title'=>$newtitle, ':posttime'=>$posttime, ':picture'=>$imageData, ':id'=>$id]);
    }
    else{
        $stmt = $pdo->prepare("UPDATE POST_DATA SET txt = :txt, title = :title, posttime = :posttime WHERE ID = :id");
        $stmt->execute([':txt'=>$txt, ':title'=>$newtitle, ':posttime'=>$posttime, ':id'=>$id]);
    }
    header("Location: main.php");
    exit();
}
?>