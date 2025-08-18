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
    $statement = $pdo->query("SELECT ID, picture, title, txt, posttime FROM POST_DATA");
    $posts = $statement->fetchAll(PDO::FETCH_ASSOC);

    $images = scandir("/var/www/html/project/blog/uploads/");
    $images = array_diff($images, ['.','..']);

function show_all_posts(){
    if(!empty($GLOBALS['posts']))
    {
        echo "
            <table>
            <tr>
                <th> Posts </th>
            </tr>
            ";
            foreach( $GLOBALS['posts'] as $i){
                echo "<tr><td> Title: ". $i['title'] . "<br>";
                if(!empty($i['picture'])){
                    $path = "uploads/" . $i['picture'];
                    echo "<img src='$path' style='max-width:auto; height:500px;'><br>";
                }
                echo "<br>" . $i['txt'] . "
                <form action='edit.php' method='POST'> 
                    <input type='hidden' name='id' value='". $i['ID'] . "'>
                    <button type='submit' name='edit'> Edit  </button>
                </form>
                <form method='POST'>
                    <input type='hidden' name='id' value='". $i['ID'] . "'>
                    <button type='submit' name='delete'> Delete this post</button>
                </form>
                </td>
                </tr>";
            }    
        echo "
        </table>";
    }
    else
    {
        echo "There are no posts written yet...";
    }
}
if(isset($_POST['delete']))
{
    $id = (int) $_POST['id'];
    $stmt = $pdo->prepare("DELETE FROM POST_DATA WHERE ID = :id");
    $stmt->execute([':id' => $id]);
    header("Location: " . $_SERVER['PHP_SELF']); // sahifani yangilash
    exit;   
}
function clear(){
    $tableName = 'POST_DATA';
    $sql = "DELETE FROM $tableName";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();
    header("Location:" . $_SERVER['PHP_SELF']);
}
?>
<!DOCTYPE html>
<html lang="eng-us">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8"/>
    <title> Blog </title>
    <link rel="stylesheet" href="blogstyle.css">
</head>
<body>

    <form action="create.php" method="POST">
        <input type="submit" name="create" value="Create a post">
    </form>
    <?php
        if(!empty($posts))
        {
            show_all_posts();
        }
    ?>
    <br>
    <form method="post">
        <input type="submit" name="clear" value="Clear">
    </form>
    <?php
        if(isset($_POST['clear']))
        {
            clear();
        }
    ?>
</body>
</html>