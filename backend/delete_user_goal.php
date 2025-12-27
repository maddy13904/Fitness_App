<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "12345", "fitness");
if ($conn->connect_error) { die(json_encode(["status" => "error", "message" => "Connection failed."])); }

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $goal_id = $_POST['goal_id'] ?? 0;
    $user_id = $_POST['user_id'] ?? 0; // For security, we ensure the user owns the goal

    if (empty($goal_id) || empty($user_id)) {
        echo json_encode(["status" => "error", "message" => "Goal ID and User ID are required."]);
        exit();
    }

    // The WHERE clause ensures a user can only delete their own goals
    $stmt = $conn->prepare("DELETE FROM user_goals WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $goal_id, $user_id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(["status" => "success", "message" => "Goal deleted successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Goal not found or you do not have permission to delete it."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to delete goal."]);
    }
    $stmt->close();
}
$conn->close();
?>