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

    // UPDATED: This query now groups by date and SUMs the step_count from all devices
    $stmt = $conn->prepare(
        "SELECT step_date, SUM(step_count) as total_steps
         FROM daily_steps
         WHERE user_id = ?
         GROUP BY step_date
         ORDER BY step_date DESC
         LIMIT 7"
    );

    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $history = [];
    while ($row = $result->fetch_assoc()) {
        // Rename the key to match what the Android app model expects
        $history[] = [
            "step_date" => $row['step_date'],
            "step_count" => $row['total_steps']
        ];
    }

    echo json_encode(["status" => "success", "history" => $history]);

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}

$conn->close();
?>