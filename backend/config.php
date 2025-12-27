<?php
$servername = "localhost";
$username = "root"; 
$password = "12345"; 
$dbname = "fitness";  

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed: " . $conn->connect_error]));
}
?>