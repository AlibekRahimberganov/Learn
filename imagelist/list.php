<!DOCTYPE html>
<html lang="eng">
<head>
    <title> List </title>
    <style>
        body{
            background-color: lightblue;
        }
    </style>
</head>
<body>
<?php
    $directory = "/var/www/html/project/imagelist/uploads/";
    $rows = 5;
    function getFilesFromDir($directory){
        $files = scandir($directory);
        $files = array_diff($files, ['.', '..']);
        return $files;
    }
    $files = GetFilesFromDir($directory);
    $num_files = count($GLOBALS['files']);

    $num_of_pages = ceil($num_files / $rows);
    
    if(isset($_GET['page']))
    {
        $page = (int)$_GET['page'];
    }
    else
    {
        $page = 1;
    }

    $begin = ($page - 1) * $rows;
    $files = array_slice($files, $begin, $rows);

    echo "<ul>";
    foreach($files as $i)
    {
        echo "<li> $i </li>";
    }
    echo "</ul>";


    if($page < $num_of_pages)
    {
        $next = $page + 1;
        echo "<a href='?page=$next'> Next </a>";
    }
    echo "<br>";
    if($page > 1)
    {
        $back = $page - 1;
        echo "<a href='?page=$back'> Back </a>";
    }
    

?>    
</body>
</html>
