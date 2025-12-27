<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "12345", "fitness");
if ($conn->connect_error) { die(json_encode(["status" => "error", "message" => "Connection failed."])); }

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_POST['user_id'] ?? 0;
    $title = $_POST['title'] ?? '';

    if (empty($user_id) || empty($title)) {
        echo json_encode(["status" => "error", "message" => "User ID and goal title are required."]);
        exit();
    }

    // New goals start with 0% progress by default
    $stmt = $conn->prepare("INSERT INTO user_goals (user_id, title, progress) VALUES (?, ?, 0)");
    $stmt->bind_param("is", $user_id, $title);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Goal added successfully.", "goal_id" => $conn->insert_id]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to add goal."]);
    }
    $stmt->close();
}
$conn->close();
?>
