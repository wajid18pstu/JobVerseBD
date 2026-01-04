<?php
require_once 'connect.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';
    $otp = isset($_POST['otp']) ? $_POST['otp'] : '';
    $userType = isset($_POST['user_type']) ? $_POST['user_type'] : '';

    // Validate input
    if (empty($email) || empty($otp) || empty($userType)) {
        echo json_encode(['status' => 'error', 'message' => 'Email, OTP, and user type are required']);
        exit();
    }

    if ($userType !== 'employer' && $userType !== 'seeker') {
        echo json_encode(['status' => 'error', 'message' => 'Invalid user type']);
        exit();
    }

    // Validate OTP format (should be 6 digits)
    if (!preg_match('/^\d{6}$/', $otp)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid OTP format']);
        exit();
    }

    try {
        // Query to verify OTP
        $query = "SELECT id, expires_at, attempts FROM otp_verification 
                  WHERE email = '$email' 
                  AND otp = '$otp' 
                  AND user_type = '$userType' 
                  AND is_verified = 0
                  LIMIT 1";

        $result = $conn->query($query);

        if (!$result || $result->num_rows == 0) {
            // Increment attempts
            $updateAttemptsQuery = "UPDATE otp_verification 
                                   SET attempts = attempts + 1 
                                   WHERE email = '$email' 
                                   AND user_type = '$userType' 
                                   AND is_verified = 0";
            $conn->query($updateAttemptsQuery);

            echo json_encode(['status' => 'error', 'message' => 'Invalid OTP']);
            exit();
        }

        $row = $result->fetch_assoc();
        $expiresAt = strtotime($row['expires_at']);
        $currentTime = time();

        // Check if OTP has expired
        if ($currentTime > $expiresAt) {
            echo json_encode([
                'status' => 'error',
                'message' => 'OTP has expired',
                'expired' => true
            ]);
            exit();
        }

        // OTP is valid, mark it as verified
        $updateQuery = "UPDATE otp_verification 
                       SET is_verified = 1 
                       WHERE email = '$email' 
                       AND user_type = '$userType' 
                       AND is_verified = 0";

        if ($conn->query($updateQuery)) {
            echo json_encode([
                'status' => 'success',
                'message' => 'OTP verified successfully',
                'email' => $email,
                'user_type' => $userType
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to verify OTP']);
        }

    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
    }

} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Check if OTP has expired and needs auto-resend
    $email = isset($_GET['email']) ? filter_var($_GET['email'], FILTER_SANITIZE_EMAIL) : '';
    $userType = isset($_GET['user_type']) ? $_GET['user_type'] : '';

    if (empty($email) || empty($userType)) {
        echo json_encode(['status' => 'error', 'message' => 'Email and user type are required']);
        exit();
    }

    $query = "SELECT expires_at FROM otp_verification 
              WHERE email = '$email' 
              AND user_type = '$userType' 
              AND is_verified = 0
              ORDER BY created_at DESC
              LIMIT 1";

    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $expiresAt = strtotime($row['expires_at']);
        $currentTime = time();

        if ($currentTime > $expiresAt) {
            // OTP has expired, mark as auto-expired and allow resend
            echo json_encode([
                'status' => 'expired',
                'message' => 'OTP has expired. Please request a new one.',
                'expired' => true
            ]);
        } else {
            $timeRemaining = $expiresAt - $currentTime;
            echo json_encode([
                'status' => 'active',
                'message' => 'OTP is still valid',
                'time_remaining' => $timeRemaining,
                'expires_at' => $row['expires_at']
            ]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No OTP found for this email']);
    }

} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

$conn->close();
?>
