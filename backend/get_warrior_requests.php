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

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $userId = $_GET['user_id'] ?? 0;

    if (empty($userId)) {
        echo json_encode(["status" => "error", "message" => "User ID is required."]);
        exit();
    }

    // This query gets pending requests sent TO the current user and includes the sender's details.
    $stmt = $conn->prepare(
        "SELECT fr.id as request_id, u.id as user_id, u.full_name, u.email
         FROM friend_requests fr
         JOIN users u ON fr.sender_id = u.id
         WHERE fr.receiver_id = ? AND fr.status = 'pending'
         ORDER BY fr.created_at DESC"
    );
    
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $requests = [];
    while ($row = $result->fetch_assoc()) {
        $requests[] = $row;
    }

    echo json_encode(["status" => "success", "requests" => $requests]);

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
$conn->close();
?>