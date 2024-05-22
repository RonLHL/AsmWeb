<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "assignment");

$con = mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$filename = time() . 'jpg';
$filepath = 'uploads/';
if (!is_dir($filepath)) {
    mkdir($filepath);
}
if (isset($_FILES['webcam'])) {
    move_uploaded_file($_FILES['webcam']['tmp_name'], $filepath . $filename);
    $sql = "INSERT INTO user(profile_picture) values('$filename')";
    $result = mysqli_query($con, $sql);
    echo $filepath . $filename;
}