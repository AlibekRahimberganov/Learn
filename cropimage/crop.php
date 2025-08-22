<?php

function show_cropped($crop, $address, $ext)
{
    if ($ext == 'jpeg' || $ext == 'jpg') {
        imagejpeg($crop, $address);
    } else if ($ext == 'png') {
        imagepng($crop, $address);
    } else if ($ext == 'gif') {
        imagegif($crop, $address);
    }

    echo " <br><br><br> 
        <img src='uploads/" . basename($address) . "'>";
}
function start_crop($width, $height)
{
    $dir = __DIR__ . "/uploads/";
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
    move_uploaded_file($_FILES['image']['tmp_name'], $dir . $_FILES['image']['name']);
    crop($width, $height);
}
function crop($width, $height)
{
    $address = __DIR__ . "/uploads/" . $_FILES['image']['name'];
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

    if ($ext == 'jpeg' || $ext == 'jpg') {
        $source = imagecreatefromjpeg($address);
    } else if ($ext == 'png') {
        $source = imagecreatefrompng($address);
    } else if ($ext == 'gif') {
        $source = imagecreatefromgif($address);
    } else {
        echo "Not supported image type!!!";
    }

    $crop = imagecrop($source, ['x' => 0, 'y' => 0, 'width' => $width, 'height' => $height]);

    if ($crop !== false) {
        show_cropped($crop, $address, $ext);
    }
}

?>

<!DOCTYPE html>
<html lang="eng">

<head>
    <title>Upload</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8" />
</head>

<body>
    <form method="post" enctype="multipart/form-data">
        <label> Upload an image </label>
        <input type="file" name="image">
        <br><br><br><br>
        <label>Enter width and height:</label>
        <br>
        <input type="text" name="x">
        <br>
        <input type="text" name="y">
        <br>
        <input type="submit" name="submit" value="Crop">
    </form>
    <?php
    if (!empty($_FILES['image']['name'])) {
        if (isset($_POST['x']) && isset($_POST['y'])) {
            start_crop($_POST['x'], $_POST['y']);
        } else {
            echo "Width and height cannot be empty!<br>";
        }
    }
    ?>
</body>

</html>