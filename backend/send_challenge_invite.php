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
    $challenge_id = $_POST['challenge_id'] ?? 0;
    $inviter_id = $_POST['inviter_id'] ?? 0;
    $invitee_id = $_POST['invitee_id'] ?? 0;

    if (empty($challenge_id) || empty($inviter_id) || empty($invitee_id)) {
        echo json_encode(["status" => "error", "message" => "Missing required fields."]);
        exit();
    }

    if ($inviter_id == $invitee_id) {
        echo json_encode(["status" => "error", "message" => "You cannot invite yourself to a challenge."]);
        exit();
    }

    // --- Logic Checks ---
    // 1. Check if an invite already exists
    $stmt = $conn->prepare("SELECT id FROM challenge_invites WHERE challenge_id = ? AND invitee_id = ?");
    $stmt->bind_param("ii", $challenge_id, $invitee_id);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "An invitation has already been sent to this user."]);
        $stmt->close();
        exit();
    }
    $stmt->close();

    // 2. Check if the invitee is already a participant
    $stmt = $conn->prepare("SELECT id FROM challenge_participants WHERE challenge_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $challenge_id, $invitee_id);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "This user is already in the challenge."]);
        $stmt->close();
        exit();
    }
    $stmt->close();

    // --- If all checks pass, insert the new invitation ---
    $stmt = $conn->prepare("INSERT INTO challenge_invites (challenge_id, inviter_id, invitee_id) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $challenge_id, $inviter_id, $invitee_id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Invitation sent successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to send invitation: " . $stmt->error]);
    }
    $stmt->close();

} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}

$conn->close();
?>