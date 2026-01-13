<?php
require_once __DIR__ . '/connect.php';

$userName = isset($_POST["userName"]) ? trim($_POST["userName"]) : '';
$userEmail = isset($_POST["userEmail"]) ? trim($_POST["userEmail"]) : '';
$subject = isset($_POST["subject"]) ? trim($_POST["subject"]) : '';
$content = isset($_POST["content"]) ? trim($_POST["content"]) : '';

// Validate inputs
if(empty($userName) || empty($userEmail) || empty($subject) || empty($content)) {
    print "<p class='error'>All fields are required.</p>";
    exit;
}

// Save message to database
$stmt = $conn->prepare("INSERT INTO messages (userName, userEmail, subject, content) VALUES (?, ?, ?, ?)");
if(!$stmt) {
    print "<p class='error'>Database error. Please try again later.</p>";
    exit;
}

$stmt->bind_param("ssss", $userName, $userEmail, $subject, $content);
if(!$stmt->execute()) {
    print "<p class='error'>Failed to send message. Please try again.</p>";
    exit;
}
$stmt->close();

// Also send email to admin
$toEmail = "prot.das15@gmail.com";
$mailHeaders = "From: " . $userName . "<". $userEmail .">\r\n";
if(mail($toEmail, $subject, $content, $mailHeaders)) {
    print "<p class='success'>Your message has been sent successfully.</p>";
} else {
    // Message saved to DB, but email failed - still consider it success
    print "<p class='success'>Your message has been saved and will be reviewed soon.</p>";
}
$conn->close();
?>