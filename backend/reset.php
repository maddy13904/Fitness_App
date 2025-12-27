<?php
session_start();
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

// Get data from the request
$user_email = $_SESSION['email'] ?? null;
$new_password = $_POST['new_password'] ?? null;
// --- ADDED: Get the confirmation password ---
$confirm_password = $_POST['confirm_password'] ?? null;

if (!$user_email || !$new_password || !$confirm_password) {
    echo json_encode(['status' => 'error', 'message' => 'Session expired or password fields are missing.']);
    exit;
}

// Check if the OTP was actually verified before allowing a reset.
if (!isset($_SESSION['forgot_password_otp'])) {
    echo json_encode(['status' => 'error', 'message' => 'OTP verification is required before resetting password.']);
    exit;
}

// --- ADDED: Server-side check to ensure passwords match ---
if ($new_password !== $confirm_password) {
    echo json_encode(['status' => 'error', 'message' => 'Passwords do not match.']);
    exit;
}

// --- Server-Side Password Complexity Validation (Unchanged) ---
$errors = [];
if (strlen($new_password) < 8) { $errors[] = "Password must be at least 8 characters long."; }
if (!preg_match('/[A-Z]/', $new_password)) { $errors[] = "Password must include at least one uppercase letter."; }
if (!preg_match('/[a-z]/', $new_password)) { $errors[] = "Password must include at least one lowercase letter."; }
if (!preg_match('/[0-9]/', $new_password)) { $errors[] = "Password must include at least one number."; }
if (!preg_match('/[!@#$%^&*+=?-]/', $new_password)) { $errors[] = "Password must include at least one special character."; }

if (!empty($errors)) {
    echo json_encode(["status" => "error", "message" => implode("\n", $errors)]);
    exit();
}

// Prepare the statement to update the password in the database.
$stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
$stmt->bind_param("ss", $new_password, $user_email);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Password updated successfully']);
    unset($_SESSION['forgot_password_otp']);
    unset($_SESSION['otp_generated_time']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update password']);
}

$stmt->close();
$conn->close();
?>