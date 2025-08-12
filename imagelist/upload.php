<!DOCTYPE html>
<html lang = "eng">
<head>
    <title> Upload </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8"/>    
    <style>
        body{
            background-color: gray;
        }
    </style>
</head>
<body>
    <form method="POST" enctype="multipart/form-data">
        Select files:
        <input type="file" name="files[]" multiple>
        <input type="submit" value="Upload" name="submit">
    </form>
<?php

if(isset($_POST['submit']) && isset($_FILES['files'])){
    $types = ["jpg", "jpeg", "png"];

    function is_img($i){
        $file_details = strtolower(pathinfo($i, PATHINFO_EXTENSION));
        return in_array($file_details, $GLOBALS['types']);
    }

    function is_less($i){
        $index = array_search($i, $_FILES['files']['name']);
        if($_FILES['files']['size'][$index] <= 2*1024*1024)
        {
            return true;
        }
        return false;
    }

    foreach($_FILES['files']['name'] as $i)
    {
        if(is_img($i) && is_less($i))
        {
            $index = array_search($i, $_FILES['files']['name']);
            move_uploaded_file($_FILES['files']['tmp_name'][$index], __DIR__ . '/uploads/' . $i);
        }
    }
    header("Location: list.php");
}
?>
</body>
</html>