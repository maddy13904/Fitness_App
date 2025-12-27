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
    $searchTerm = $_GET['search'] ?? '';

    if (empty($userId)) {
        echo json_encode(["status" => "error", "message" => "User ID is required."]);
        exit();
    }
    
    if (empty($searchTerm)) {
         echo json_encode(["status" => "success", "users" => []]); // Return empty list if search is empty
         exit();
    }

    // This query finds users matching the search term, excluding the current user and their existing friends.
    $stmt = $conn->prepare(
        "SELECT id, full_name, email FROM users
         WHERE (full_name LIKE ? OR email LIKE ?)
         AND id != ?
         AND id NOT IN (
             SELECT sender_id FROM friend_requests WHERE receiver_id = ? AND status = 'accepted'
             UNION
             SELECT receiver_id FROM friend_requests WHERE sender_id = ? AND status = 'accepted'
         )"
    );

    $searchTerm = "%" . $searchTerm . "%"; // Prepare search term for LIKE query
    $stmt->bind_param("ssiii", $searchTerm, $searchTerm, $userId, $userId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    echo json_encode(["status" => "success", "users" => $users]);

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
$conn->close();
?>