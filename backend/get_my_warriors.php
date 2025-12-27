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

    // This query finds all accepted friend requests where the user is either the sender or receiver,
    // and then gets the profile details of the OTHER person in that friendship.
    $stmt = $conn->prepare(
       "SELECT u.id, u.full_name, u.email 
        FROM users u
        JOIN friend_requests fr ON (fr.sender_id = u.id OR fr.receiver_id = u.id)
        WHERE (fr.sender_id = ? OR fr.receiver_id = ?)
        AND fr.status = 'accepted'
        AND u.id != ?"
    );
    
    $stmt->bind_param("iii", $userId, $userId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $warriors = [];
    while ($row = $result->fetch_assoc()) {
        $warriors[] = $row;
    }

    echo json_encode(["status" => "success", "warriors" => $warriors]);

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
$conn->close();
?>