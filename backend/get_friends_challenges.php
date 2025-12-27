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
    $userId = $_GET['user_id'] ?? 0;

    if (empty($userId)) {
        echo json_encode(["status" => "error", "message" => "User ID is required."]);
        exit();
    }

    // This is the core logic.
    // 1. It finds all of the user's friends from the 'friend_requests' table.
    // 2. It finds all the unique challenges those friends are participating in.
    // 3. It excludes challenges the current user has already joined.
    // 4. It fetches the details for the remaining challenges.
    $stmt = $conn->prepare(
       "SELECT 
            c.id, c.title, c.description, c.duration,
            COALESCE(u.full_name, au.full_name) AS creator_name,
            (SELECT COUNT(*) FROM challenge_participants cp_count WHERE cp_count.challenge_id = c.id) AS participant_count
        FROM challenges c
        JOIN challenge_participants cp ON c.id = cp.challenge_id
        LEFT JOIN users u ON c.creator_user_id = u.id
        LEFT JOIN admin_users au ON c.admin_id = au.id
        WHERE 
            cp.user_id IN (
                SELECT sender_id FROM friend_requests WHERE receiver_id = ? AND status = 'accepted'
                UNION
                SELECT receiver_id FROM friend_requests WHERE sender_id = ? AND status = 'accepted'
            )
            AND c.id NOT IN (
                SELECT challenge_id FROM challenge_participants WHERE user_id = ?
            )
        GROUP BY c.id
        ORDER BY c.created_at DESC"
    );

    $stmt->bind_param("iii", $userId, $userId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $challenges = [];
    while ($row = $result->fetch_assoc()) {
        $challenges[] = $row;
    }

    // Note: The JSON key is "challenges" to match the UserChallengesResponse model
    echo json_encode(["status" => "success", "challenges" => $challenges]);

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}

$conn->close();
?>