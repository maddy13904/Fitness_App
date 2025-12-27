<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "12345";
$dbname = "fitness";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed."]));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // UPDATED: Read raw input data instead of relying on $_POST
    $postData = json_decode(file_get_contents('php://input'), true);
    
    // If json_decode fails, try parsing form-data as a fallback
    if (json_last_error() !== JSON_ERROR_NONE) {
        parse_str(file_get_contents('php://input'), $postData);
    }
    
    $requestId = $postData['request_id'] ?? 0;
    $status = $postData['status'] ?? '';

    if (empty($requestId) || empty($status)) {
        echo json_encode(["status" => "error", "message" => "Request ID and status are required."]);
        exit();
    }

    if ($status !== 'accepted' && $status !== 'rejected') {
        echo json_encode(["status" => "error", "message" => "Invalid status provided."]);
        exit();
    }

    $stmt = $conn->prepare("UPDATE friend_requests SET status = ? WHERE id = ?");
    
    if (!$stmt) {
        die(json_encode(["status" => "error", "message" => "SQL Prepare failed: " . $conn->error]));
    }

    $stmt->bind_param("si", $status, $requestId);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $message = $status === 'accepted' ? "Friend request accepted." : "Friend request rejected.";
            echo json_encode(["status" => "success", "message" => $message]);
        } else {
            echo json_encode(["status" => "error", "message" => "No pending request found with that ID."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update request: " . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}

$conn->close();
?>