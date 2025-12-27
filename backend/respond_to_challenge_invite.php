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
    $invite_id = $_POST['invite_id'] ?? 0;
    $status = $_POST['status'] ?? ''; // Should be 'accepted' or 'rejected'

    if (empty($invite_id) || !in_array($status, ['accepted', 'rejected'])) {
        echo json_encode(["status" => "error", "message" => "Invite ID and a valid status are required."]);
        exit();
    }

    // --- Get invite details ---
    $stmt = $conn->prepare("SELECT challenge_id, invitee_id FROM challenge_invites WHERE id = ? AND status = 'pending'");
    $stmt->bind_param("i", $invite_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $invite = $result->fetch_assoc();
    $stmt->close();

    if (!$invite) {
        echo json_encode(["status" => "error", "message" => "Pending invite not found."]);
        exit();
    }

    $challenge_id = $invite['challenge_id'];
    $user_id = $invite['invitee_id'];

    // --- Use a transaction for safety ---
    $conn->begin_transaction();

    try {
        // Step 1: Update the invite status
        $stmt_update = $conn->prepare("UPDATE challenge_invites SET status = ? WHERE id = ?");
        $stmt_update->bind_param("si", $status, $invite_id);
        $stmt_update->execute();
        $stmt_update->close();

        // Step 2: If accepted, add user to the participants table
        if ($status === 'accepted') {
            $stmt_insert = $conn->prepare("INSERT INTO challenge_participants (user_id, challenge_id) VALUES (?, ?)");
            $stmt_insert->bind_param("ii", $user_id, $challenge_id);
            $stmt_insert->execute();
            $stmt_insert->close();
        }

        // If all steps were successful, commit the changes
        $conn->commit();
        $message = $status === 'accepted' ? "Challenge joined successfully." : "Invite declined.";
        echo json_encode(["status" => "success", "message" => $message]);

    } catch (mysqli_sql_exception $exception) {
        // If any step failed, roll back all changes
        $conn->rollback();
        echo json_encode(["status" => "error", "message" => "An error occurred: " . $exception->getMessage()]);
    }

} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}

$conn->close();
?>