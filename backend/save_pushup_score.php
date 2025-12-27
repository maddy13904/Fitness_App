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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_POST['user_id'] ?? 0;
    $challenge_id = $_POST['challenge_id'] ?? 0;
    $count = $_POST['count'] ?? 0;

    if (empty($user_id) || empty($challenge_id)) {
        echo json_encode(["status" => "error", "message" => "User and Challenge IDs are required."]);
        exit();
    }

    // This is the key logic. It tries to INSERT a new row for today's date.
    // If a row for this user, for this challenge, for today ALREADY EXISTS,
    // it will UPDATE the existing row instead by adding the new count to the old one.
    $stmt = $conn->prepare(
        "INSERT INTO pushup_results (user_id, challenge_id, pushup_count, recorded_date) 
         VALUES (?, ?, ?, CURDATE())
         ON DUPLICATE KEY UPDATE pushup_count = pushup_count + VALUES(pushup_count)"
    );

    $stmt->bind_param("iii", $user_id, $challenge_id, $count);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Score saved successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to save score: " . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}

$conn->close();
?>