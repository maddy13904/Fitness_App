<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "12345";
$dbname = "fitness";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "DB connection failed."]));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // UPDATED: Read raw input data instead of relying on $_POST
    $postData = json_decode(file_get_contents('php://input'), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        // Fallback for form-data if the body is not JSON
        parse_str(file_get_contents('php://input'), $postData);
    }

    $sender_id = $postData['sender_id'] ?? 0;
    $receiver_id = $postData['receiver_id'] ?? 0;

    if (empty($sender_id) || empty($receiver_id)) {
        echo json_encode(["status" => "error", "message" => "Sender and Receiver IDs are required."]);
        exit();
    }

    if ($sender_id == $receiver_id) {
        echo json_encode(["status" => "error", "message" => "You cannot send a friend request to yourself."]);
        exit();
    }
    
    // Check if a request already exists between these two users
    $checkStmt = $conn->prepare("SELECT id FROM friend_requests WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?)");
    $checkStmt->bind_param("iiii", $sender_id, $receiver_id, $receiver_id, $sender_id);
    $checkStmt->execute();
    if ($checkStmt->get_result()->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "A friend request already exists."]);
        $checkStmt->close();
        exit();
    }
    $checkStmt->close();
    
    // Insert new request
    $stmt = $conn->prepare("INSERT INTO friend_requests (sender_id, receiver_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $sender_id, $receiver_id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Friend request sent."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}

$conn->close();
?>