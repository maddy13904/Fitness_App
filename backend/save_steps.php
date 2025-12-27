<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "12345";
$dbname = "fitness";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userId = $_POST['user_id'] ?? 0;
    $deviceId = $_POST['device_id'] ?? '';
    $steps = $_POST['steps'] ?? 0;
    $calories = $_POST['calories'] ?? 0.0;
    $distance_km = $_POST['distance_km'] ?? 0.0; // ADDED: Get the new distance value
    $date = date('Y-m-d');

    if (empty($userId) || empty($deviceId)) {
        echo json_encode(["status" => "error", "message" => "User ID and Device ID are required."]);
        exit();
    }

    // UPDATED: This query is now more robust. It inserts a new row for the day,
    // or if one already exists, it adds the new values to the existing ones.
    $stmt = $conn->prepare(
        "INSERT INTO daily_steps (user_id, device_id, step_date, step_count, calories_burned, distance_km)
         VALUES (?, ?, ?, ?, ?, ?)
         ON DUPLICATE KEY UPDATE 
             step_count = step_count + VALUES(step_count), 
             calories_burned = calories_burned + VALUES(calories_burned),
             distance_km = distance_km + VALUES(distance_km)"
    );

    // UPDATED: The types are now 'issidd' for 6 parameters:
    // i(user_id), s(device_id), s(date), i(steps), d(calories), d(distance_km)
    $stmt->bind_param("issidd", $userId, $deviceId, $date, $steps, $calories, $distance_km);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Steps and distance saved successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Execute failed: " . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}

$conn->close();
?>