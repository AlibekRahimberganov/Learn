<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];

        // Shu yerda ma'lumotlar bilan ishlashingiz mumkin (bazaga yozish va h.k.)

        echo "<!DOCTYPE html>
        <html>
        <body>
            <h3>Ma'lumot qabul qilindi ✅</h3>
            <p>Ismingiz: <b>$ism</b></p>
            <p>Familiyangiz: <b>$familiya</b></p>
            <a href='index.html'>Orqaga qaytish</a>
        </body>
        </html>";
    }
?>
