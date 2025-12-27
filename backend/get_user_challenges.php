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

    // UPDATED: This query is more robust and uses the correct 'title' column name.
    $stmt = $conn->prepare(
       "SELECT 
            c.id, 
            c.title, 
            c.start_date, 
            c.end_date,
            c.duration,
            c.mode,
            c.metric,
            COALESCE(u.full_name, au.full_name) as creator_name,
            (SELECT COUNT(*) FROM challenge_participants WHERE challenge_id = c.id) as participant_count
        FROM challenge_participants cp
        JOIN challenges c ON cp.challenge_id = c.id
        LEFT JOIN users u ON c.creator_user_id = u.id
        LEFT JOIN admin_users au ON c.admin_id = au.id
        WHERE cp.user_id = ?
        ORDER BY c.start_date DESC"
    );
    
    // This is a critical debugging step. If the prepare fails, it will now tell us why.
    if (!$stmt) {
        die(json_encode(["status" => "error", "message" => "SQL Prepare failed: " . $conn->error]));
    }
    
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $challenges = [];
    while ($row = $result->fetch_assoc()) {
        $challenges[] = $row;
    }

    echo json_encode(["status" => "success", "challenges" => $challenges]);

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
$conn->close();
?>