<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "12345";
$dbname = "fitness";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check DB connection
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed: " . $conn->connect_error]));
}

// Handle POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $full_name = $_POST['full_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Basic validation
    if (empty($full_name) || empty($email) || empty($password) || empty($confirm_password)) {
        echo json_encode(["status" => "error", "message" => "All fields are required."]);
        exit();
    }

    if ($password !== $confirm_password) {
        echo json_encode(["status" => "error", "message" => "Passwords do not match."]);
        exit();
    }

    // Insert into users table with role = 'admin'
    $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, 'admin')");

    if (!$stmt) {
        echo json_encode(["status" => "error", "message" => "Prepare failed: " . $conn->error]);
        exit();
    }

    $stmt->bind_param("sss", $full_name, $email, $password);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Admin registered successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}

$conn->close();
?>
