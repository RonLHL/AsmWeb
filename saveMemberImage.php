<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "assignment");

$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$filename = time() . '.jpg';
$filepath = 'profileImg/';
if (!is_dir($filepath))
    mkdir($filepath);

if (isset($_FILES['webcam'])) {
    move_uploaded_file($_FILES['webcam']['tmp_name'], $filepath . $filename);
    if (isset($_GET['username'])) {
            $username = $_GET['username'];
            $sql = "UPDATE user SET profile_picture = ? WHERE username = ?";
            $stmt = $con->prepare($sql);
            if ($stmt === false) {
                die('Prepare failed: ' . htmlspecialchars($con->error));
            }
            $stmt->bind_param("ss", $filename, $username);
            if ($stmt->execute() === false) {
                die('Execute failed: ' . htmlspecialchars($stmt->error));
            }
            $stmt->close();
        }
        echo $filename;
    $con->close();
}
