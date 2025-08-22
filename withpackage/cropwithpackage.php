<?php

require __DIR__ . '/vendor/autoload.php';

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

function set_watermark($img)
{
    $height = $img->height();
    $img->text('github.com/AlibekRahimberganov', 10, $height - 20, function ($font) {
        $font->file('font/markfont.ttf');
        $font->size(20);
        $font->color('#fff');
        $font->align('left');
        $font->valign('bottom');
    });
}
function crop_image($width, $height)
{
    $manager = new ImageManager(new Driver());

    $image = $manager->read(__DIR__ . '/uploads/' . $_FILES['image']['name']);

    $image->crop($width, $height);
    $hash_name = hash('sha256', $_FILES['image']['name']);
    $image->save(__DIR__ . '/uploads/' . $hash_name);
    set_watermark($image);
    $image->save(__DIR__ . '/uploads/' . $hash_name);
    unlink('uploads/' . $_FILES['image']['name']);
    echo "<img src='uploads/" . $hash_name . "'>";
}
?>


<!DOCTYPE html>
<html lang="eng">

<head>
    <title>Upload & Crop</title>
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
    if (!is_dir(__DIR__ . "/uploads/")) {
        mkdir(__DIR__ . "/uploads/", 0777, true);
    }

    $location = __DIR__ . "/uploads/" . $_FILES['image']['name'];
    if (!empty($_FILES['image']['name'])) {
        if (!empty($_POST['x']) && !empty($_POST['y'])) {
            move_uploaded_file($_FILES['image']['tmp_name'], $location);
            crop_image((int)$_POST['x'], (int)$_POST['y']);
        } else {
            echo "Width and height cannot be empty!<br>";
        }
    }
    ?>
</body>

</html>
