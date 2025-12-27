<?php
header("Content-Type: application/json");

// Connect to DB
$conn = new mysqli("localhost", "root", "12345", "fitness");

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database connection failed."]);
    exit;
}

// Get raw input
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data["invitee_id"])) {
    echo json_encode(["status" => "error", "message" => "Missing invitee_id"]);
    exit;
}

$invitee_id = $data["invitee_id"];

// Only using fields from 'challenge_invites' table, no JOINs
$sql = "SELECT id, challenge_id, inviter_id, status, created_at 
        FROM challenge_invites 
        WHERE invitee_id = ? AND status = 'pending'";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode([
        "status" => "error",
        "message" => "SQL prepare failed.",
        "debug" => $conn->error
    ]);
    exit;
}

$stmt->bind_param("i", $invitee_id);
$stmt->execute();
$result = $stmt->get_result();

$invites = [];
while ($row = $result->fetch_assoc()) {
    $invites[] = $row;
}

echo json_encode(["status" => "success", "data" => $invites]);
$conn->close();
?>
 