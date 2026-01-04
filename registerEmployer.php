<?php

include 'connect.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/lang.php';

header('Content-Type: application/json');

$name = $email = $password = $verifiedOtp = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = isset($_POST["name"]) ? $_POST["name"] : "";
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";
    $verifiedOtp = isset($_POST["verified_otp"]) ? $_POST["verified_otp"] : "no";

    // Validate required fields
    if (empty($name) || empty($email) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
        $conn->close();
        exit();
    }

    // Check if OTP was verified
    if ($verifiedOtp !== "yes") {
        echo json_encode(['status' => 'error', 'message' => 'Email verification required. Please verify with OTP']);
        $conn->close();
        exit();
    }

    // Verify that the OTP was indeed verified in database
    $checkOtpQuery = "SELECT is_verified FROM otp_verification 
                      WHERE email = '$email' 
                      AND user_type = 'employer' 
                      AND is_verified = 1 
                      ORDER BY created_at DESC 
                      LIMIT 1";

    $otpResult = $conn->query($checkOtpQuery);
    
    if (!$otpResult || $otpResult->num_rows == 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid verification. Please verify your email again']);
        $conn->close();
        exit();
    }

    // Check if email already exists
    $checkEmail = "SELECT email FROM employer WHERE email = '$email'";
    $emailResult = $conn->query($checkEmail);
    
    if ($emailResult && $emailResult->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Email already registered']);
        $conn->close();
        exit();
    }

    // Hash password for security
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO employer (name, email, password) VALUES ('$name', '$email', '$hashedPassword')";

    if ($conn->query($sql) === TRUE) {
        // Clear OTP record after successful registration
        $clearOtpQuery = "DELETE FROM otp_verification WHERE email = '$email' AND user_type = 'employer'";
        $conn->query($clearOtpQuery);

        echo json_encode([
            'status' => 'success',
            'message' => 'Registration successful! Please log in with your credentials.',
            'redirect' => 'index.php?msg=login'
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Registration failed: ' . $conn->error]);
    }

    $conn->close();
    exit();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit();
}
