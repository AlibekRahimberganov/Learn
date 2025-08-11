<!DOCTYPE html>
<html lang="en">
<head>
    <title> Upload CSV </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta charset="utf-8"/>    
    <style>
<<<<<<< Updated upstream
        body{
            background-color: lightblue;
        }
    </style>
</head>
<body>
    <form method="POST" enctype="multipart/form-data">
=======
    body{
        background-color: lightgray;
    }
</style>
</head>
<body>
    <form action="showcsv.php" method="POST" enctype="multipart/form-data">
>>>>>>> Stashed changes
        <label> Choose the file
            <input type="file" name="data"/>
        </label>
        <button type="submit"> Upload </button>
    </form>    
</body>
</html>
