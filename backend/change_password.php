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
    // --- UPDATED: Only requires user_id and the new_password ---
    $user_id = $_POST['user_id'] ?? 0;
    $new_password = $_POST['new_password'] ?? '';

    if (empty($user_id) || empty($new_password)) {
        echo json_encode(["status" => "error", "message" => "User ID and new password are required."]);
        exit();
    }

    // --- Directly update the password for the given user ID ---
    // No old password check is performed as requested.
    // In a real app, you MUST hash the new password before saving it.
    // Example: $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $new_password, $user_id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(["status" => "success", "message" => "Password updated successfully."]);
        } else {
            // This might happen if the user ID is not found.
            echo json_encode(["status" => "error", "message" => "User not found or password was not changed."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update password: " . $stmt->error]);
    }
    $stmt->close();

} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}

$conn->close();
?>