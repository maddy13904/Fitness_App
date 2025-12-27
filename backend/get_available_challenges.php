<?php
header('Content-Type: application/json');

// --- Database Connection ---
$servername = "localhost";
$username = "root";
$password = "12345";
$dbname = "fitness";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed."]));
}

// UPDATED: This query now fetches ALL challenges (from users and admins)
// and gets the correct creator name for each.
$sql = "SELECT 
            c.id, 
            c.title, 
            c.description, 
            c.start_date, 
            c.end_date,
            c.duration,
            c.mode,
            c.metric,
            -- This COALESCE function gets the name from the users table first,
            -- and if that's NULL, it gets the name from the admin_users table.
            COALESCE(u.full_name, au.full_name) AS creator_name,
            (SELECT COUNT(*) FROM challenge_participants cp WHERE cp.challenge_id = c.id) AS participant_count
        FROM challenges c
        LEFT JOIN users u ON c.creator_user_id = u.id
        LEFT JOIN admin_users au ON c.admin_id = au.id
        ORDER BY c.created_at DESC";

$result = $conn->query($sql);

$challenges = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $challenges[] = $row;
    }
    echo json_encode(["status" => "success", "data" => $challenges]);
} else {
    echo json_encode(["status" => "error", "message" => "Query failed: " . $conn->error]);
}

$conn->close();
?>