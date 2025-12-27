<?php
$servername = "localhost";
$username = "root";
$password = "12345";
$dbname = "fitness";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed."]));
}

// Handle GET request
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $admin_id = $_GET['admin_id'] ?? '';

    if (!empty($admin_id)) {
        // Admin-specific challenges
        $stmt = $conn->prepare("SELECT * FROM challenges WHERE admin_id = ?");
        $stmt->bind_param("i", $admin_id);
    } else {
        // All challenges (for users)
        $stmt = $conn->prepare("SELECT * FROM challenges");
    }

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $challenges = [];

        while ($row = $result->fetch_assoc()) {
            $challenges[] = $row;
        }

        echo json_encode(["status" => "success", "data" => $challenges]);
    } else {
        echo json_encode(["status" => "error", "message" => "Query failed."]);
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}

$conn->close();
?>
