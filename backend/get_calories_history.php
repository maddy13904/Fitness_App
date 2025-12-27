<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "12345";
$dbname = "fitness";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Get user_id from the URL query parameter
    $userId = $_GET['user_id'] ?? 0;

    if (empty($userId)) {
        echo json_encode(["status" => "error", "message" => "User ID is required."]);
        exit();
    }

    // Prepare a statement to get the last 7 days of calorie history
    $stmt = $conn->prepare(
        "SELECT step_date, calories_burned 
         FROM daily_steps 
         WHERE user_id = ? 
         ORDER BY step_date DESC 
         LIMIT 7"
    );

    if (!$stmt) {
        echo json_encode(["status" => "error", "message" => "Prepare failed: " . $conn->error]);
        exit();
    }

    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $history = [];
    while ($row = $result->fetch_assoc()) {
        $history[] = $row;
    }

    // Return the history as a JSON object
    echo json_encode(["status" => "success", "history" => $history]);

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method. Please use GET."]);
}

$conn->close();
?>