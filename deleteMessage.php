<?php
include 'authorizeAdmin.php';
require_once __DIR__ . '/connect.php';

if(!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: adminMessages.php");
    exit;
}

$messageId = intval($_GET['id']);

// Delete message
$stmt = $conn->prepare("DELETE FROM messages WHERE id = ?");
$stmt->bind_param("i", $messageId);
$stmt->execute();
$stmt->close();

$conn->close();

// Redirect back to messages page
header("Location: adminMessages.php?deleted=1");
exit;
?>
