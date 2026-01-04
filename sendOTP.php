<?php
require_once 'PHPMailer/src/Exception.php';
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';
require_once 'connect.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';
    $userType = isset($_POST['user_type']) ? $_POST['user_type'] : ''; // 'employer' or 'seeker'

    // Validate input
    if (empty($email) || empty($userType)) {
        echo json_encode(['status' => 'error', 'message' => 'Email and user type are required']);
        exit();
    }

    if ($userType !== 'employer' && $userType !== 'seeker') {
        echo json_encode(['status' => 'error', 'message' => 'Invalid user type']);
        exit();
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email format']);
        exit();
    }

    // Check if email already exists
    if ($userType === 'employer') {
        $checkQuery = "SELECT email FROM employer WHERE email = '$email'";
    } else {
        $checkQuery = "SELECT email FROM seeker WHERE email = '$email'";
    }

    $checkResult = $conn->query($checkQuery);
    if ($checkResult && $checkResult->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Email already registered. Please login instead']);
        exit();
    }

    try {
        // Generate 6-digit OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Set expiry time (2 minutes from now)
        $expiryTime = date('Y-m-d H:i:s', strtotime('+2 minutes'));

        // Check if there's an existing OTP for this email and user type
        $existingQuery = "SELECT id FROM otp_verification WHERE email = '$email' AND user_type = '$userType' AND is_verified = 0";
        $existingResult = $conn->query($existingQuery);

        if ($existingResult && $existingResult->num_rows > 0) {
            // Update existing OTP record
            $updateQuery = "UPDATE otp_verification SET otp = '$otp', created_at = NOW(), expires_at = '$expiryTime', attempts = 0 WHERE email = '$email' AND user_type = '$userType' AND is_verified = 0";
            $conn->query($updateQuery);
        } else {
            // Insert new OTP record
            $insertQuery = "INSERT INTO otp_verification (email, otp, user_type, expires_at) VALUES ('$email', '$otp', '$userType', '$expiryTime')";
            $conn->query($insertQuery);
        }

        // Send OTP via email
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Username = 'wajid567765@gmail.com'; // Your Gmail address
        $mail->Password = 'lits vyee uvnh geab'; // Your app password
        $mail->Port = 465;

        $mail->setFrom('wajid567765@gmail.com', 'JobVerseBD');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Your JobVerseBD OTP for Registration';
        
        $userTypeDisplay = ucfirst($userType);
        $mail->Body = "
            <html>
            <body style='font-family: Arial, sans-serif;'>
                <div style='max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px;'>
                    <h2 style='color: #1d3557;'>Welcome to JobVerseBD</h2>
                    <p>You are registering as a <strong>$userTypeDisplay</strong>.</p>
                    <p>Your One-Time Password (OTP) for email verification is:</p>
                    <div style='background-color: #f0f0f0; padding: 15px; text-align: center; border-radius: 5px; margin: 20px 0;'>
                        <h1 style='color: #e9c46a; margin: 0;'>$otp</h1>
                    </div>
                    <p><strong>Valid for 2 minutes only.</strong></p>
                    <p>If you didn't request this OTP, please ignore this email.</p>
                    <p style='color: #666; font-size: 12px;'>
                        <strong>Note:</strong> Do not share this OTP with anyone. JobVerseBD will never ask for your OTP via email, phone, or any other channel.
                    </p>
                </div>
            </body>
            </html>
        ";

        $mail->send();

        echo json_encode([
            'status' => 'success',
            'message' => 'OTP sent successfully to your email',
            'email' => $email,
            'user_type' => $userType
        ]);

    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => "Failed to send OTP: {$mail->ErrorInfo}"
        ]);
    }

} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

$conn->close();
?>
