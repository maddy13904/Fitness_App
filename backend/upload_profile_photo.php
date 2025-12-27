<?php
header('Content-Type: application/json');

// --- Standard Database Connection ---
$conn = new mysqli("localhost", "root", "12345", "fitness");
if ($conn->connect_error) { die(json_encode(["status" => "error", "message" => "Connection failed."])); }

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_POST['user_id'] ?? 0;

    if (empty($user_id) || !isset($_FILES['profile_photo'])) {
        echo json_encode(["status" => "error", "message" => "User ID and photo are required."]);
        exit();
    }

    // --- UPDATED: Use the server's reliable temporary directory ---
    $temp_dir = sys_get_temp_dir();
    $target_dir = $temp_dir . "/fitness_uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $file_extension = strtolower(pathinfo($_FILES["profile_photo"]["name"], PATHINFO_EXTENSION));
    $new_filename = "user_" . $user_id . "_" . time() . "." . $file_extension;
    $target_file = $target_dir . $new_filename;

    // This command will now succeed.
    if (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $target_file)) {
        
        // IMPORTANT: The URL for accessing this file is now different.
        // We need a separate script to securely serve these images later.
        // For now, we will save the file path.
        $stmt = $conn->prepare("UPDATE users SET profile_photo_url = ? WHERE id = ?");
        $stmt->bind_param("si", $target_file, $user_id);
        
        if ($stmt->execute()) {
            echo json_encode([
                "status" => "success", 
                "message" => "Photo uploaded successfully (using temp directory).", 
                "file_path" => $target_file
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => "File uploaded, but failed to save path to database."]);
        }
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Critical Error: move_uploaded_file failed."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}

$conn->close();
?>