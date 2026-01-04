<?php

// Allow both admin and employers to delete posts
// Admin can delete any post, employer can only delete their own

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$isAdmin = isset($_SESSION['aid']);

if (!$isAdmin) {
    include 'authorizeEmployer.php';
}

if(isset($_GET['id'])){
    include 'connect.php';
    $id = intval($_GET['id']);
    
    // If employer (not admin), verify they own this post
    if (!$isAdmin) {
        $checkSql = "SELECT eid FROM post WHERE id = $id";
        $checkResult = $conn->query($checkSql);
        if ($checkResult->num_rows === 0 || $checkResult->fetch_assoc()['eid'] != $_SESSION['eid']) {
            echo "Unauthorized: You can only delete your own posts";
            exit;
        }
    }
    
    // First, delete related job_payments records
    $deletePaymentsSql = "DELETE FROM job_payments WHERE pid = $id";
    if (!$conn->query($deletePaymentsSql)) {
        echo "Error deleting related payments: " . $conn->error;
        exit;
    }
    
    // Then delete the post
    $sql = "DELETE FROM post WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        if ($isAdmin) {
            header('Location: adminAccount.php');
            exit;
        } else {
            header('Location: employerAccount.php');
            exit;
        }
    } else {
        echo "Error Deleting Post: " . $conn->error;
    }
} else {
    echo "No post ID provided";
}

?>