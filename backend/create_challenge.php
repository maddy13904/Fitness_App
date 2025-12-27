<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "12345";
$dbname = "fitness";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed."]));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $admin_id = $_POST['admin_id'] ?? '';
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $start_date = $_POST['start_date'] ?? '';
    $end_date = $_POST['end_date'] ?? '';

    // Validation
    if (empty($admin_id) || empty($title) || empty($start_date) || empty($end_date)) {
        echo json_encode(["status" => "error", "message" => "All fields except description are required."]);
        exit();
    }

    // Check if admin exists
    $checkAdmin = $conn->prepare("SELECT id FROM admin_users WHERE id = ?");
    $checkAdmin->bind_param("i", $admin_id);
    $checkAdmin->execute();
    $checkAdminResult = $checkAdmin->get_result();

    if ($checkAdminResult->num_rows === 0) {
        echo json_encode(["status" => "error", "message" => "Invalid admin ID."]);
        exit();
    }

    // Insert challenge
    $stmt = $conn->prepare("INSERT INTO challenges (admin_id, title, description, start_date, end_date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $admin_id, $title, $description, $start_date, $end_date);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Challenge created successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Database error: " . $stmt->error]);
    }

    $stmt->close();
    $checkAdmin->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}

$conn->close();
?>
