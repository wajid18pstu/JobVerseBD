<?php

// Allow both admin and employers to delete posts
// Admin can delete any post, employer can only delete their own
$isAdmin = isset($_SESSION['adminid']);

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
    $conn->query($deletePaymentsSql);
    
    // Then delete the post
    $sql = "DELETE FROM post WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        if ($isAdmin) {
            header('location: adminAccount.php');
        } else {
            header('location: employerAccount.php');
        }
    } else {
        echo "Error Deleting Post: " . $conn->error;
    }
} else {
    echo "No post ID provided";
}

?>