<?php
header('Content-Type: application/json');

// --- Standard Database Connection ---
$servername = "localhost";
$username = "root";
$password = "12345";
$dbname = "fitness";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get all the data
    $creatorUserId = $_POST['creator_user_id'] ?? 0;
    $challengeTitle = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $mode = $_POST['mode'] ?? '';
    $metric = $_POST['metric'] ?? '';
    $duration = $_POST['duration'] ?? 0;
    $startDate = $_POST['start_date'] ?? ''; // Expects 'YYYY-MM-DD'

    // --- Validation ---
    // UPDATED: Now checks if the user ID is 0
    if (empty($creatorUserId) || empty($challengeTitle) || empty($mode) || empty($duration) || empty($startDate)) {
        echo json_encode(["status" => "error", "message" => "Missing required fields. Check that user_id is not 0."]);
        exit();
    }

    // --- Use a Transaction for data safety ---
    $conn->begin_transaction();
    try {
        // Step 1: Insert the new challenge
        $stmt = $conn->prepare(
            "INSERT INTO challenges (creator_user_id, title, description, mode, metric, duration, start_date) 
             VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("issssis", $creatorUserId, $challengeTitle, $description, $mode, $metric, $duration, $startDate);
        $stmt->execute();
        
        $newChallengeId = $conn->insert_id;
        $stmt->close();

        // Step 2: Automatically add the creator as the first participant
        $stmt_participant = $conn->prepare(
            "INSERT INTO challenge_participants (challenge_id, user_id) VALUES (?, ?)"
        );
        $stmt_participant->bind_param("ii", $newChallengeId, $creatorUserId);
        $stmt_participant->execute();
        $stmt_participant->close();

        // If both steps succeed, commit the changes to the database
        $conn->commit();

        // ONLY send success message AFTER the commit is successful
        echo json_encode([
            "status" => "success",
            "message" => "Challenge created successfully!",
            "challenge_id" => $newChallengeId
        ]);

    } catch (mysqli_sql_exception $exception) {
        // If ANY part of the 'try' block fails, undo all changes
        $conn->rollback();
        // And send a specific error message
        echo json_encode([
            "status" => "error", 
            "message" => "Failed to create challenge. Database error: " . $exception->getMessage()
        ]);
    }

} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}

$conn->close();
?>