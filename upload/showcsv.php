<html>
<head>
    <title> Show CSV </title>
    <style>
    table, tr, th, td{
        border: 1px solid black;
        border-collapse: collapse;
        padding: 10px;
    }
    th{
        text-align: center;
    }
    table, tr, td{
        text-align: left;
    }
    table{
        width: auto;
    }
    body{
        background-color: lightgray;
    }
</style>
</head>
<body>
<?php 
    if(isset($_FILES['data']))
    {
        if($_FILES['data']['type'] == 'text/csv')
        {
            $handle = fopen($_FILES['data']['tmp_name'] ,'r');
            if($handle != false)
            {
                echo "<table>";
                echo "<tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>E-mail</th>
                    <th>Phone Number</th>
                    </tr>";

                while(($info = fgetcsv($handle, 1000, ",")) !== false)
                {
                    echo "<tr>";
                    foreach($info as $text)
                    {
                        if($text != NULL)
                        echo "<td>" . htmlspecialchars($text) . "</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            }
        }
        else
        {
            print("File is not a CSV!");
        }
    }
?>
</body>
</html>
