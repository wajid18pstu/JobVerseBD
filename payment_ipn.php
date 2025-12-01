<?php
/**
 * Payment IPN (Instant Payment Notification) Handler
 * Called by SSLCommerz asynchronously for payment confirmation
 */

include 'sslcommerz_config.php';
include 'connect.php';

// Log IPN requests for debugging
$log_file = 'logs/payment_ipn.log';
if (!is_dir('logs')) {
    mkdir('logs', 0755, true);
}

$ipn_data = $_POST;
file_put_contents($log_file, date('Y-m-d H:i:s') . ' - IPN Received: ' . json_encode($ipn_data) . "\n", FILE_APPEND);

// Get IPN data
$tran_id = isset($_POST['tran_id']) ? $_POST['tran_id'] : '';
$bank_tran_id = isset($_POST['bank_tran_id']) ? $_POST['bank_tran_id'] : '';
$status = isset($_POST['status']) ? $_POST['status'] : '';
$amount = isset($_POST['amount']) ? $_POST['amount'] : '';
$store_amount = isset($_POST['store_amount']) ? $_POST['store_amount'] : '';

// Validate transaction
if (empty($tran_id)) {
    file_put_contents($log_file, date('Y-m-d H:i:s') . ' - Invalid IPN: No transaction ID' . "\n", FILE_APPEND);
    http_response_code(400);
    exit('Invalid transaction ID');
}

// Update payment based on IPN status
if ($status === 'VALID' || $status === 'valid') {
    $update_sql = "UPDATE payments SET status = 'validated' 
                   WHERE transaction_id = '$tran_id' AND status = 'pending'";
    
    if ($conn->query($update_sql)) {
        file_put_contents($log_file, date('Y-m-d H:i:s') . ' - Payment validated: ' . $tran_id . "\n", FILE_APPEND);
        
        // Also update job_payments
        $update_job_sql = "UPDATE job_payments SET payment_status = 'validated' 
                          WHERE payment_id = (SELECT id FROM payments WHERE transaction_id = '$tran_id')";
        $conn->query($update_job_sql);
        
        http_response_code(200);
        exit('IPN Processed');
    }
} else {
    // Invalid or failed payment
    $update_sql = "UPDATE payments SET status = 'failed' 
                   WHERE transaction_id = '$tran_id'";
    $conn->query($update_sql);
    
    file_put_contents($log_file, date('Y-m-d H:i:s') . ' - Payment failed/invalid: ' . $tran_id . ' Status: ' . $status . "\n", FILE_APPEND);
    
    http_response_code(200);
    exit('IPN Processed - Failed');
}

?>
