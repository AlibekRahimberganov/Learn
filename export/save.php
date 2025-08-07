<?php
if(isset($_POST['data']))
{
    $data = $_POST['data'];
    $cols = 4;

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="edited.csv"');
    $out = fopen("php://output", "w");
    
    for($i = 0; $i < count($data); $i += $cols)
    {
        $row = array_slice($data, $i, $cols);
        fputcsv($out, $row);
    }

    fclose($out);
}
?>