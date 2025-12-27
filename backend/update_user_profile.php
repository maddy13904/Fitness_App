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
    // Get all the profile fields from the request
    $user_id = $_POST['user_id'] ?? 0;
    $full_name = $_POST['full_name'] ?? '';
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $height = $_POST['height'] ?? '';
    $weight = $_POST['weight'] ?? '';
    $age = $_POST['age'] ?? 0;
    $fitness_level = $_POST['fitness_level'] ?? '';
    $weekly_goal = $_POST['weekly_goal'] ?? '';
    $bio = $_POST['bio'] ?? '';

    if (!empty($phone) && strlen($phone) != 10) {
        echo json_encode(["status" => "error", "message" => "Phone number must be 10 digits."]);
        exit();
    }
    
    // Height validation (checks if it's a realistic number in cm)
    if (!empty($height)) {
        $height_val = (float)$height; // Convert string "175.5" to number 175.5
        if ($height_val < 50 || $height_val > 250) {
            echo json_encode(["status" => "error", "message" => "Please enter a realistic height (50-250 cm)."]);
            exit();
        }
    }
    
    // Weight validation (checks if it's a realistic number in kg)
    if (!empty($weight)) {
        $weight_val = (float)$weight; // Convert string "68.2" to number 68.2
        if ($weight_val < 20 || $weight_val > 300) {
            echo json_encode(["status" => "error", "message" => "Please enter a realistic weight (20-300 kg)."]);
            exit();
        }
    }
    // --- END OF VALIDATION ---
    if (empty($user_id)) {
        echo json_encode(["status" => "error", "message" => "User ID is required."]);
        exit();
    }

    $stmt = $conn->prepare("UPDATE users SET 
        full_name = ?, username = ?, email = ?, phone = ?, height = ?, 
        weight = ?, age = ?, fitness_level = ?, weekly_goal = ?, bio = ? 
        WHERE id = ?");

    $stmt->bind_param("ssssssisssi", 
        $full_name, $username, $email, $phone, $height, 
        $weight, $age, $fitness_level, $weekly_goal, $bio, 
        $user_id
    );

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(["status" => "success", "message" => "Profile updated successfully."]);
        } else {
            echo json_encode(["status" => "success", "message" => "No changes were made."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update profile: " . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}

$conn->close();
?>  