<?php
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "12345", "fitness");

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "DB connection failed"]);
    exit;
}

$sql = "SELECT 
            l.user_id, 
            u.full_name, 
            MAX(l.score) AS top_score
        FROM leaderboard l
        JOIN users u ON l.user_id = u.id
        GROUP BY l.user_id
        ORDER BY top_score DESC
        LIMIT 10"; // top 10 users

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $leaderboard = [];
    while ($row = $result->fetch_assoc()) {
        $leaderboard[] = $row;
    }
    echo json_encode(["status" => "success", "data" => $leaderboard]);
} else {
    echo json_encode(["status" => "success", "data" => []]);
}

$conn->close();
?>
