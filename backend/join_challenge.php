<?php
// --- ADDED: This ensures all errors are caught and reported ---
ini_set('display_errors', 1);
error_reporting(E_ALL);
set_exception_handler(function($exception) {
    echo json_encode(["status" => "error", "message" => "Fatal Error: " . $exception->getMessage()]);
    exit();
});

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

// --- THIS IS THE CRUCIAL FIX ---
// This line tells mysqli to throw exceptions on errors,
// so our try...catch block will actually work.
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
// -------------------------------

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_POST['user_id'] ?? 0;
    $challenge_id = $_POST['challenge_id'] ?? 0;

    if (empty($user_id) || empty($challenge_id)) {
        echo json_encode(["status" => "error", "message" => "User ID and Challenge ID are required."]);
        exit();
    }

    // --- UPDATED: The 'try...catch' block will now work correctly ---
    try {
        $stmt = $conn->prepare("INSERT INTO challenge_participants (user_id, challenge_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $user_id, $challenge_id);
        
        // This will now throw an exception if it fails (e.g., duplicate entry)
        $stmt->execute();

        // This code will only run if the execute() was successful
        echo json_encode(["status" => "success", "message" => "You have joined the challenge."]);

    } catch (mysqli_sql_exception $e) {
        // This 'catch' block will now run when the database error occurs.
        
        // Use strpos() for compatibility with your PHP version
        if (strpos($e->getMessage(), "Duplicate entry") !== false) {
            echo json_encode(["status" => "error", "message" => "You have already joined this challenge."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
        }
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}

$conn->close();
?>