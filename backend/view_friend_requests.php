<?php
$servername = "localhost";
$username = "root";
$password = "12345";
$dbname = "fitness";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "DB connection failed."]));
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $receiver_id = $_GET['receiver_id'] ?? '';

    if (empty($receiver_id)) {
        echo json_encode(["status" => "error", "message" => "Receiver ID is required."]);
        exit();
    }

    $stmt = $conn->prepare("SELECT fr.id, fr.sender_id, u.full_name, fr.status, fr.created_at
                            FROM friend_requests fr
                            JOIN users u ON fr.sender_id = u.id
                            WHERE fr.receiver_id = ? AND fr.status = 'pending'");
    $stmt->bind_param("i", $receiver_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $requests = [];

        while ($row = $result->fetch_assoc()) {
            $requests[] = $row;
        }

        echo json_encode(["status" => "success", "data" => $requests]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to fetch requests."]);
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}

$conn->close();
?>
