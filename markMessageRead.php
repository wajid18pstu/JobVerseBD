<?php
include 'authorizeAdmin.php';
require_once __DIR__ . '/connect.php';

if(!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: adminMessages.php");
    exit;
}

$messageId = intval($_GET['id']);

// Mark as read
$stmt = $conn->prepare("UPDATE messages SET is_read = 1 WHERE id = ?");
$stmt->bind_param("i", $messageId);
$stmt->execute();
$stmt->close();

$conn->close();

// Redirect back to message view
header("Location: viewMessage.php?id=" . $messageId);
exit;
?>
