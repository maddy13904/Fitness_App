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

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $user_id = $_GET['user_id'] ?? 0;

    if (empty($user_id)) {
        echo json_encode(["status" => "error", "message" => "User ID is required."]);
        exit();
    }

    // This query joins three tables to get all the necessary info for the UI:
    // - The invite ID from `challenge_invites`
    // - The inviter's name from `users`
    // - The challenge title from `challenges`
    $stmt = $conn->prepare(
       "SELECT 
            ci.id as invite_id,
            c.title as challenge_title,
            u.full_name as inviter_name,
            ci.created_at
        FROM challenge_invites ci
        JOIN users u ON ci.inviter_id = u.id
        JOIN challenges c ON ci.challenge_id = c.id
        WHERE ci.invitee_id = ? AND ci.status = 'pending'
        ORDER BY ci.created_at DESC"
    );

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $invites = [];
    while ($row = $result->fetch_assoc()) {
        $invites[] = $row;
    }

    echo json_encode(["status" => "success", "invites" => $invites]);

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}

$conn->close();
?>