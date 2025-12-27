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
    $email = $_POST['email'] ?? '';

    // Basic validation to ensure an email was sent
    if (empty($email)) {
        echo json_encode(["status" => "error", "message" => "Email is required."]);
        exit();
    }

    // Prepare a statement to securely check for the email's existence.
    // This is safe against SQL injection.
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any rows were found
    if ($result->num_rows > 0) {
        // If num_rows is greater than 0, the email exists.
        // Respond with a success status and a true 'exists' flag.
        echo json_encode(["status" => "success", "exists" => true]);
    } else {
        // If no rows were found, the email does not exist.
        // Respond with a success status and a false 'exists' flag.
        echo json_encode(["status" => "success", "exists" => false]);
    }

    $stmt->close();
} else {
    // Reject any requests that are not POST
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}

$conn->close();
?>