<?php
$pdo = new PDO("sqlite:data.db");
$pdo->exec("CREATE TABLE IF NOT EXISTS POST_DATA (
    ID INTEGER PRIMARY KEY AUTOINCREMENT,
    txt TEXT NOT NULL
)");
    
if(isset($_POST['id']))
{
    $id = (int) $_POST['id'];
    $statement = $pdo->prepare("SELECT txt FROM POST_DATA WHERE ID = :id");
    $statement->execute(([':id' => $id]));
    $post = $statement->fetch(PDO::FETCH_ASSOC);

    echo "Edit: <br>";
    echo "
    <form method='POST'> 
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

    $stmt = $pdo->prepare("UPDATE POST_DATA SET txt = :txt WHERE ID = :id");
    $stmt->execute([':txt' => $txt, ':id' => $id]);
    header("Location: main.php");
}
?>