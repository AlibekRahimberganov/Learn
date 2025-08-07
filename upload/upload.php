<!DOCTYPE html>
<html lang="en">
<head>
    <title> Upload CSV </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8"/>    
    <style>
        body{
            background-color: lightblue;
        }
    </style>
</head>
<body>
    <form method="POST" enctype="multipart/form-data">
        <label> Choose the file
            <input type="file" name="data"/>
        </label>
        <button type="submit"> Upload </button>
    </form>    
</body>
</html>
