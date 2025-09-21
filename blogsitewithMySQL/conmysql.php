<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$db_servername = ""; /* Servername for example: localhost */
$db_username = ""; /* sql username */
$db_password = ""; /* sql password */

$conn = new mysqli($db_servername, $db_username, $db_password);

$sql = "CREATE DATABASE IF NOT EXISTS mydb";
if ($conn->query($sql)) {
    $conn->select_db('mydb');

    $sql = "CREATE TABLE IF NOT EXISTS users(
        ID INT AUTO_INCREMENT PRIMARY KEY,
        user_login CHAR(50) UNIQUE, 
        user_email CHAR(100) UNIQUE, 
        user_password CHAR(255) NOT NULL, 
        user_picture TEXT,
        user_logged DATETIME
    );";
    if ($conn->query($sql)) {
        $sql = "CREATE TABLE IF NOT EXISTS posts(
            ID INT AUTO_INCREMENT PRIMARY KEY,
            blog_author TEXT,
            blog_title TEXT,
            blog_text TEXT,
            blog_media TEXT,
            postdate DATETIME
        );";

        $conn->query($sql);
    }
}
