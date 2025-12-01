<?php
/**
 * Payment Failure Handler
 * Called by SSLCommerz after failed payment
 */

include 'sslcommerz_config.php';
include 'connect.php';

// Get failure response
$tran_id = isset($_POST['tran_id']) ? $_POST['tran_id'] : '';
$status = isset($_POST['status']) ? $_POST['status'] : '';
$currency = isset($_POST['currency']) ? $_POST['currency'] : '';
$amount = isset($_POST['amount']) ? $_POST['amount'] : '';
$store_amount = isset($_POST['store_amount']) ? $_POST['store_amount'] : '';
$card_number = isset($_POST['card_number']) ? $_POST['card_number'] : '';
$card_type = isset($_POST['card_type']) ? $_POST['card_type'] : '';

// Update payment status to failed
if (!empty($tran_id)) {
    $update_sql = "UPDATE payments SET status = 'failed' 
                   WHERE transaction_id = '$tran_id'";
    $conn->query($update_sql);
    
    // Also update job_payments
    $update_job_sql = "UPDATE job_payments SET payment_status = 'failed' 
                      WHERE payment_id = (SELECT id FROM payments WHERE transaction_id = '$tran_id')";
    $conn->query($update_job_sql);
}

?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment Failed</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <style>
        body {
            font-family: 'Sora', sans-serif;
            background-color: #f5f5f5;
        }
        .failure-container {
            margin-top: 100px;
            background: white;
            padding: 50px;
            border-radius: 10px;
            box-shadow: 0px 0px 20px #ccc;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        .failure-icon {
            font-size: 80px;
            color: #dc3545;
            text-align: center;
        }
        .details {
            margin-top: 30px;
            text-align: left;
            background: #fff3cd;
            padding: 20px;
            border-radius: 5px;
            border-left: 4px solid #dc3545;
        }
        .detail-item {
            padding: 10px 0;
        }
        .detail-label {
            font-weight: bold;
            color: #333;
        }
        .detail-value {
            color: #666;
        }
    </style>
</head>
<body>
    <div class="failure-container">
        <div class="failure-icon">✕</div>
        <h2 style="text-align: center; color: #dc3545; margin-top: 20px;">Payment Failed</h2>
        <p style="text-align: center; font-size: 16px; color: #666; margin-top: 20px;">
            Your payment could not be processed. Please try again or contact support.
        </p>
        
        <div class="details">
            <div class="detail-item">
                <span class="detail-label">Transaction ID:</span><br>
                <span class="detail-value"><?php echo htmlspecialchars($tran_id); ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Status:</span><br>
                <span class="detail-value" style="color: #dc3545; font-weight: bold;">Failed</span>
            </div>
            <?php if (!empty($store_amount)): ?>
            <div class="detail-item">
                <span class="detail-label">Amount:</span><br>
                <span class="detail-value"><?php echo htmlspecialchars($store_amount); ?> <?php echo htmlspecialchars($currency); ?></span>
            </div>
            <?php endif; ?>
        </div>

        <div style="margin-top: 40px; text-align: center;">
            <p style="font-size: 14px; color: #666; margin-bottom: 20px;">
                Your payment was not successful. Please verify your card details and try again.
            </p>
            <a href="postjob.php" class="btn btn-primary" style="background-color: #001219; border-color: #001219; margin: 10px 5px;">Retry Payment</a>
            <a href="employerAccount.php" class="btn btn-outline-danger" style="margin: 10px 5px;">Go to Dashboard</a>
        </div>

        <div style="margin-top: 30px; padding: 15px; background: #f0f0f0; border-radius: 5px; text-align: center;">
            <p style="font-size: 12px; color: #666; margin: 0;">
                If you continue to experience issues, please contact our support team.
            </p>
        </div>
    </div>
</body>
</html>
<?php

?>
