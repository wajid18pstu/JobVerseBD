<?php
/**
 * Payment Cancelled Handler
 * Called by SSLCommerz when user cancels payment
 */

include 'sslcommerz_config.php';
include 'connect.php';

// Get cancel response
$tran_id = isset($_POST['tran_id']) ? $_POST['tran_id'] : '';
$status = isset($_POST['status']) ? $_POST['status'] : '';

// Update payment status to cancelled
if (!empty($tran_id)) {
    $update_sql = "UPDATE payments SET status = 'cancelled' 
                   WHERE transaction_id = '$tran_id'";
    $conn->query($update_sql);
    
    // Also update job_payments
    $update_job_sql = "UPDATE job_payments SET payment_status = 'cancelled' 
                      WHERE payment_id = (SELECT id FROM payments WHERE transaction_id = '$tran_id')";
    $conn->query($update_job_sql);
}

?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment Cancelled</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <style>
        body {
            font-family: 'Sora', sans-serif;
            background-color: #f5f5f5;
        }
        .cancel-container {
            margin-top: 100px;
            background: white;
            padding: 50px;
            border-radius: 10px;
            box-shadow: 0px 0px 20px #ccc;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        .cancel-icon {
            font-size: 80px;
            color: #ffc107;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="cancel-container">
        <div class="cancel-icon">⚠</div>
        <h2 style="text-align: center; color: #ffc107; margin-top: 20px;">Payment Cancelled</h2>
        <p style="text-align: center; font-size: 16px; color: #666; margin-top: 20px;">
            You have cancelled the payment process. Your job posting has not been submitted.
        </p>
        
        <div style="margin-top: 40px; text-align: center;">
            <p style="font-size: 14px; color: #666; margin-bottom: 20px;">
                You can try again whenever you're ready.
            </p>
            <a href="postjob.php" class="btn btn-primary" style="background-color: #001219; border-color: #001219; margin: 10px 5px;">Post Job Again</a>
            <a href="employerAccount.php" class="btn btn-outline-primary" style="margin: 10px 5px;">Go to Dashboard</a>
        </div>
    </div>
</body>
</html>
<?php

?>
