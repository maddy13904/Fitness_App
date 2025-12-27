<?php
session_start();
header('Content-Type: application/json');

require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Get email from POST or session
$user_email = $_POST['email'] ?? ($_SESSION['email'] ?? null);

if (!$user_email) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Email is required'
    ]);
    exit;
}

// Save email to session
$_SESSION['email'] = $user_email;

// Generate OTP
$otp = rand(100000, 999999);
$_SESSION['forgot_password_otp'] = $otp;
$_SESSION['otp_generated_time'] = time();

// Create mailer
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'saisuryha12@gmail.com';   // your Gmail
    $mail->Password   = 'umop mpqz bmsg dmzp';         // Gmail App Password
    $mail->SMTPSecure = 'ssl';                         // SSL
    $mail->Port       = 465;

    // Recipients
    $mail->setFrom('saisuryha12@gmail.com', 'Fitness');
    $mail->addAddress($user_email);

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Your Password Reset OTP';
    $mail->Body    = "Hello,<br><br>Your OTP is: <b>$otp</b><br><br>It is valid for 10 minutes.";

    // Send
    if ($mail->send()) {
        echo json_encode([
            'status' => 'success',
            'message' => 'OTP sent successfully'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Mailer Error: Could not send email'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Mailer Exception: ' . $e->getMessage()
    ]);
}
?>
