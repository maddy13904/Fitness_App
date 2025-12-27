<?php
header('Content-Type: application/json');

// --- Database Connection ---
$servername = "localhost";
$username = "root";
// Using "12345" as a password is very insecure, even for development.
// Please change this to a strong, unique password.
$password = "12345"; 
$dbname = "fitness";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    // Stop execution and send a JSON error
    die(json_encode(["status" => "error", "message" => "Database connection failed: " . $conn->connect_error]));
}

// --- Request Handling ---
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $full_name = $_POST['full_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password_plain = $_POST['password'] ?? ''; // Renamed to _plain
    $confirm_password = $_POST['confirm_password'] ?? '';
    $role = $_POST['role'] ?? 'user';

    // --- Basic Validation ---
    if (empty($full_name) || empty($email) || empty($password_plain) || empty($confirm_password)) {
        echo json_encode(["status" => "error", "message" => "All fields are required."]);
        $conn->close();
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["status" => "error", "message" => "Please enter a valid email address."]);
        $conn->close();
        exit();
    }

    if ($password_plain !== $confirm_password) {
        echo json_encode(["status" => "error", "message" => "Passwords do not match."]);
        $conn->close();
        exit();
    }

    // --- Password Complexity Validation ---
    $errors = [];
    if (strlen($password_plain) < 8) { $errors[] = "Password must be at least 8 characters long."; }
    if (!preg_match('/[A-Z]/', $password_plain)) { $errors[] = "Password must include at least one uppercase letter."; }
    if (!preg_match('/[a-z]/', $password_plain)) { $errors[] = "Password must include at least one lowercase letter."; }
    if (!preg_match('/[0-9]/', $password_plain)) { $errors[] = "Password must include at least one number."; }
    if (!preg_match('/[!@#$%^&*+=?-]/', $password_plain)) { $errors[] = "Password must include at least one special character."; }

    if (!empty($errors)) {
        echo json_encode(["status" => "error", "message" => implode("\n", $errors)]);
        $conn->close();
        exit();
    }
    
    // Validate role
    if ($role !== "user" && $role !== "admin") {
        $role = "user"; // Default to 'user' for security
    }

    // --- CRITICAL SECURITY FIX: HASH THE PASSWORD ---
    // We use password_hash() to securely store the password.
    // We NEVER store the plain-text password.
    $hashed_password = password_hash($password_plain, PASSWORD_DEFAULT);

    
    // --- Database Insertion ---
    // Note: We are NOT storing confirm_password in the database. It's unnecessary.
    // Ensure your 'users' table has columns: 'full_name', 'email', 'password', 'role'
    $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
         echo json_encode(["status" => "error", "message" => "Prepare failed: " . $conn->error]);
         $conn->close();
         exit();
    }

    // "ssss" = 4 string parameters
    $stmt->bind_param("ssss", $full_name, $email, $hashed_password, $role);

    if ($stmt->execute()) {
         echo json_encode(["status" => "success", "message" => ucfirst($role) . " registered successfully."]);
    } else {
         if (strpos($stmt->error, "Duplicate entry") !== false) {
             echo json_encode(["status" => "error", "message" => "An account with this email already exists."]);
         } else {
             echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
         }
    }

    $stmt->close();

} else {
    // Not a POST request
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}

$conn->close();
?>