<?php
$pdo = new PDO("sqlite:tasks.db");
$pdo->exec("CREATE TABLE IF NOT EXISTS tasks (
    ID INTEGER PRIMARY KEY AUTOINCREMENT,
    task TEXT NOT NULL,
    status INTEGER NOT NULL
)");
function add_task($task){
    $statement = $GLOBALS['pdo']-> prepare("INSERT INTO tasks (task, status) VALUES (:task, :status)");
    $statement->bindValue(':task', $task, PDO::PARAM_STR);
    $statement->bindValue(':status', 0, PDO::PARAM_INT);
    $statement->execute();
}

function delete_task($id){
    $statement = $GLOBALS['pdo']->prepare("DELETE FROM tasks WHERE ID = :id");
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();
}

function clear_all_tasks(){
    $GLOBALS['pdo']->exec("DROP TABLE IF EXISTS tasks");
    $GLOBALS['pdo']->exec("CREATE TABLE tasks (
        ID INTEGER PRIMARY KEY AUTOINCREMENT,
        task TEXT NOT NULL,
        status INTEGER NOT NULL
    )");
}
function print_list(){
    $data = $GLOBALS['pdo']->query("SELECT * FROM tasks"); 
    $rows = $data->fetchAll(PDO::FETCH_ASSOC);

    echo "<form method='POST'>";
    echo "<table>
    <tr>
    <th>ID</th> <th>Task</th> <th>Status</th> <th> Delete </th>
    </tr>";
    foreach($rows as $i)
    {
        echo "<tr>";
        echo "<td>" . $i['ID'] . "</td>";
        echo "<td>" . $i['task'] . "</td>";
        echo "<td>";
        echo "<select name='status[" . $i['ID'] . "]'>";
        echo "<option value='0'" . (!$i['status'] ? " selected" : "") . ">INCOMPLETED</option>";
        echo "<option value='1'" . ($i['status'] ? " selected" : "") . ">COMPLETED</option>";
        echo "</select>";
        echo "</td>";
        echo "<td>
            <button type='submit' name='delete_task' value='".$i['ID']."'>Delete</button>
            </td>";
        echo "</tr>";
        if(isset($_POST['delete_task']))
        {
            delete_task($_POST['delete_task']);
            header("Location: ".$_SERVER['PHP_SELF']);
            exit();
        }
    }
    echo "</table> 
    </form>";

}
function save_all_changes(){
    if(isset($_POST['status']))
    {
        foreach($_POST['status'] as $id => $status)
        {
            $statement = $GLOBALS['pdo']->prepare("UPDATE tasks SET status = :status WHERE ID = :id");
            $statement->bindValue(':status', $status, PDO::PARAM_INT);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->execute();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="eng">
<head>
    <title> To-Do-List </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="todoliststyle.css"></link>
</head>
<body>
    <form method="POST">
        <input type="text" name="task" placeholder="Task">
        <input type="submit" name="submit" value="Add">
        <br>
        <input type='submit' name='delete_all' value='Clear All Tasks'>
        <br>
        <input type="submit" name="save" value="Save All Changes">
        <br>
<?php
    if(isset($_POST['submit']) && isset($_POST['task']))
    {
        add_task($_POST['task']);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
    if(isset($_POST['save']))
    {
        save_all_changes();
    }
    
    print_list();
    
    if(isset($_POST['delete_all']))
    {
        clear_all_tasks();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
?>
    </form>

</body>
</html>