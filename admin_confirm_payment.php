<?php
/**
 * Admin Payment Confirmation/Rejection Handler
 * Handles admin acceptance or rejection of payments and job postings
 */

include 'authorizeAdmin.php';
include 'connect.php';
include 'sendEmail.php';

if (!isset($_GET['action']) || !isset($_GET['jp_id']) || !isset($_GET['post_id'])) {
    header('Location: adminAccount.php');
    exit;
}

$action = $_GET['action'];
$jp_id = $_GET['jp_id'];
$post_id = $_GET['post_id'];

// Get job payment and payment details
$select_sql = "SELECT jp.*, post.name as job_name, post.status, 
                      e.email, e.name as employer_name, pay.amount, pay.transaction_id
               FROM job_payments jp
               JOIN payments pay ON jp.payment_id = pay.id
               JOIN post ON jp.pid = post.id
               JOIN employer e ON jp.eid = e.id
               WHERE jp.id = '$jp_id' AND jp.pid = '$post_id'";

$result = $conn->query($select_sql);

if ($result->num_rows === 0) {
    $_SESSION['error'] = 'Payment record not found';
    header('Location: adminAccount.php');
    exit;
}

$row = $result->fetch_assoc();
$eid = $row['eid'];
$email = $row['email'];
$employer_name = $row['employer_name'];
$job_name = $row['job_name'];
$amount = $row['amount'];
$transaction_id = $row['transaction_id'];
$current_status = $row['status'];

$success = false;
$message = '';

if ($action === 'accept') {
    // Update job status from 'pending' to 'open'
    $update_post_sql = "UPDATE post SET status = 'open' WHERE id = '$post_id'";
    
    if ($conn->query($update_post_sql) === TRUE) {
        // Update job_payments admin status
        $update_jp_sql = "UPDATE job_payments SET admin_status = 'approved', admin_confirmed_date = NOW() 
                         WHERE id = '$jp_id'";
        $conn->query($update_jp_sql);
        
        // Send confirmation email to employer
        $subject = "Your Job Posting #$post_id - Payment Approved & Published";
        $message_body = "
Dear $employer_name,

Great news! Your job posting \"$job_name\" has been approved and is now live on JobVerse BD.

Payment Details:
- Transaction ID: $transaction_id
- Amount: $amount Taka
- Status: Approved

Your job posting will now be visible to all job seekers and will start receiving applications.

You can manage your job posting from your employer dashboard at: https://jobversebd.cse.pstu.ac.bd/employerAccount.php

Best regards,
JobVerse BD Team
";
        
        // Use your sendEmail function here if available
        // sendEmail($email, $subject, $message_body);
        
        $success = true;
    } else {
        $message = 'Error updating job status: ' . $conn->error;
    }
    
} else if ($action === 'reject') {
    // Update job status to 'rejected' or delete it
    $update_post_sql = "UPDATE post SET status = 'rejected' WHERE id = '$post_id'";
    
    if ($conn->query($update_post_sql) === TRUE) {
        // Update job_payments admin status
        $update_jp_sql = "UPDATE job_payments SET admin_status = 'rejected', admin_confirmed_date = NOW(),
                          admin_notes = 'Payment rejected by admin' 
                         WHERE id = '$jp_id'";
        $conn->query($update_jp_sql);
        
        // Send rejection email to employer
        $subject = "Your Job Posting #$post_id - Payment Rejected";
        $message_body = "
Dear $employer_name,

We regret to inform you that your job posting \"$job_name\" could not be approved at this time.

Payment Details:
- Transaction ID: $transaction_id
- Amount: $amount Taka
- Status: Rejected

Possible reasons for rejection:
- Payment validation failure
- Content policy violation
- Other compliance issues

Please contact our support team for more information or to resubmit your job posting.

Best regards,
JobVerse BD Team
";
        
        // Use your sendEmail function here if available
        // sendEmail($email, $subject, $message_body);
        
        $success = true;
    } else {
        $message = 'Error updating job status: ' . $conn->error;
    }
}

// Redirect with success/error message
if ($success) {
    $_SESSION['success'] = "Payment " . ($action === 'accept' ? 'approved' : 'rejected') . " successfully. Job posting status updated.";
} else {
    $_SESSION['error'] = $message;
}

header('Location: adminAccount.php');
exit;

?>
