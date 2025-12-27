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
    $user_id = $_POST['user_id'] ?? 0;
    $provided_password = $_POST['password'] ?? '';

    if (empty($user_id) || empty($provided_password)) {
        echo json_encode(["status" => "error", "message" => "User ID and password are required."]);
        exit();
    }

    // --- Step 1: Fetch the user's real password ---
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if (!$user) {
        echo json_encode(["status" => "error", "message" => "User not found."]);
        exit();
    }
    
    $stored_password = $user['password'];

    // --- Step 2: Compare passwords ---
    if ($provided_password === $stored_password) {
        
        // --- Step 3: Delete the user and all their data using a transaction ---
        $conn->begin_transaction();
        try {
            // --- UPDATED: Replaced execute_query with the traditional prepare/bind/execute method ---

            // Delete from challenge_invites
            $stmt = $conn->prepare("DELETE FROM challenge_invites WHERE inviter_id = ? OR invitee_id = ?");
            $stmt->bind_param("ii", $user_id, $user_id);
            $stmt->execute();
            $stmt->close();

            // Delete from challenge_participants
            $stmt = $conn->prepare("DELETE FROM challenge_participants WHERE user_id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $stmt->close();

            // Delete from daily_steps
            $stmt = $conn->prepare("DELETE FROM daily_steps WHERE user_id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $stmt->close();

            // Delete from friend_requests
            $stmt = $conn->prepare("DELETE FROM friend_requests WHERE sender_id = ? OR receiver_id = ?");
            $stmt->bind_param("ii", $user_id, $user_id);
            $stmt->execute();
            $stmt->close();

            // Delete from pushup_results
            $stmt = $conn->prepare("DELETE FROM pushup_results WHERE user_id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $stmt->close();

            // Finally, delete the user from the main users table
            $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $stmt->close();

            // If all deletions were successful, commit the transaction
            $conn->commit();
            echo json_encode(["status" => "success", "message" => "Account deleted successfully."]);

        } catch (mysqli_sql_exception $exception) {
            $conn->rollback();
            echo json_encode(["status" => "error", "message" => "Failed to delete account due to a database error."]);
        }

    } else {
        echo json_encode(["status" => "error", "message" => "Incorrect password."]);
    }

} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}

$conn->close();
?>