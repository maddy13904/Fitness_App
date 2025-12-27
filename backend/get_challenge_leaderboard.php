<?php
header('Content-Type: application/json');

// --- Standard Database Connection ---
$servername = "localhost";
$username = "root";
$password = "12345";
$dbname = "fitness";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) { die(json_encode(["status" => "error", "message" => "Connection failed."])); }

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $challenge_id = $_GET['challenge_id'] ?? 0;
    if (empty($challenge_id)) {
        echo json_encode(["status" => "error", "message" => "Challenge ID is required."]);
        exit();
    }

    // --- Step 1: Find out what kind of challenge this is (Steps, Pushups, etc.) ---
    $stmt = $conn->prepare("SELECT metric FROM challenges WHERE id = ?");
    $stmt->bind_param("i", $challenge_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $challenge_details = $result->fetch_assoc();
    $stmt->close();

    if (!$challenge_details) {
        echo json_encode(["status" => "error", "message" => "Challenge not found."]);
        exit();
    }
    $metric = $challenge_details['metric'];

    // --- Step 2: Build the correct SQL query based on the metric ---
    $sql = "";
    if ($metric === 'Steps') {
        // Query to get total steps for each participant
        $sql = "SELECT u.id as user_id, u.full_name, SUM(ds.step_count) as total_score
                FROM challenge_participants cp
                JOIN users u ON cp.user_id = u.id
                LEFT JOIN daily_steps ds ON cp.user_id = ds.user_id 
                WHERE cp.challenge_id = ?
                GROUP BY u.id, u.full_name
                ORDER BY total_score DESC";
    } elseif ($metric === 'Pushups') {
        // Query to get total pushups for each participant
        $sql = "SELECT u.id as user_id, u.full_name, SUM(pr.pushup_count) as total_score
                FROM challenge_participants cp
                JOIN users u ON cp.user_id = u.id
                LEFT JOIN pushup_results pr ON cp.user_id = pr.user_id AND pr.challenge_id = cp.challenge_id
                WHERE cp.challenge_id = ?
                GROUP BY u.id, u.full_name
                ORDER BY total_score DESC";
    } else {
        // If the metric is a "Daily Habit" or something else, return an empty list for now
        echo json_encode(["status" => "success", "leaderboard" => []]);
        exit();
    }
    
    // --- Step 3: Execute the query and return the results ---
    $stmt = $conn->prepare($sql);
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