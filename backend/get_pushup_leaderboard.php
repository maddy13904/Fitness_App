<?php
header('Content-Type: application/json');

// --- Standard Database Connection ---
$servername = "localhost";
$username = "root";
$password = "12345";
$dbname = "fitness";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed."]));
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $challenge_id = $_GET['challenge_id'] ?? 0;

    if (empty($challenge_id)) {
        echo json_encode(["status" => "error", "message" => "Challenge ID is required."]);
        exit();
    }

    // This query calculates the leaderboard.
    // It JOINS tables to get names, SUMS up all scores for each user,
    // GROUPS the results, and ORDERS them to create the ranking.
    $stmt = $conn->prepare(
        "SELECT 
            u.id as user_id, 
            u.full_name,
            SUM(pr.pushup_count) as total_score
         FROM pushup_results pr
         JOIN users u ON pr.user_id = u.id
         WHERE pr.challenge_id = ?
         GROUP BY u.id, u.full_name
         ORDER BY total_score DESC"
    );

    $stmt->bind_param("i", $challenge_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $leaderboard = [];
    while ($row = $result->fetch_assoc()) {
        $leaderboard[] = $row;
    }

    echo json_encode(["status" => "success", "leaderboard" => $leaderboard]);

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}

$conn->close();
?>