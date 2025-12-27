<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "12345", "fitness");
if ($conn->connect_error) { die(json_encode(["status" => "error", "message" => "Connection failed."])); }

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $user_id = $_GET['user_id'] ?? 0;
    if (empty($user_id)) { /* ... handle error ... */ }

    // UPDATED: Selects all the new profile fields
    $stmt = $conn->prepare("SELECT id, full_name, username, email, phone, height, weight, age, fitness_level, weekly_goal, bio, profile_photo_url FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        echo json_encode(["status" => "success", "user" => $user]);
    } else {
        echo json_encode(["status" => "error", "message" => "User not found."]);
    }
    $stmt->close();
}
$conn->close();
?>