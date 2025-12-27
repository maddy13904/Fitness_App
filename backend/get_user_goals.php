<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "fitness");
if ($conn->connect_error) { die(json_encode(["status" => "error", "message" => "Connection failed."])); }

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $user_id = $_GET['user_id'] ?? 0;
    if (empty($user_id)) {
        echo json_encode(["status" => "error", "message" => "User ID is required."]);
        exit();
    }

    $stmt = $conn->prepare("SELECT id, title, progress FROM user_goals WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $goals = [];
    while ($row = $result->fetch_assoc()) {
        $goals[] = $row;
    }

    echo json_encode(["status" => "success", "goals" => $goals]);
    $stmt->close();
}
$conn->close();
?>