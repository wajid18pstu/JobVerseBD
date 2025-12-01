<?php
/**
 * Test Payment Success Page
 * Simulates a successful payment return from SSLCommerz
 */

include 'sslcommerz_config.php';
include 'connect.php';
include 'authorizeEmployer.php';

$payment_id = isset($_GET['payment_id']) ? intval($_GET['payment_id']) : 0;
$transaction_id = isset($_GET['transaction_id']) ? $_GET['transaction_id'] : '';
$post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;

if (!$payment_id || !$transaction_id) {
    echo "<h3>❌ Invalid Payment Parameters</h3>";
    exit;
}

// Get payment details
$paymentSql = "SELECT * FROM payments WHERE id = '$payment_id' AND transaction_id = '$transaction_id'";
$paymentResult = $conn->query($paymentSql);

if ($paymentResult->num_rows === 0) {
    echo "<h3>❌ Payment Record Not Found</h3>";
    exit;
}

$payment = $paymentResult->fetch_assoc();

// Get job details if post_id provided
$jobName = 'Job Posting';
if ($post_id > 0) {
    $jobSql = "SELECT name FROM post WHERE id = '$post_id'";
    $jobResult = $conn->query($jobSql);
    if ($jobResult->num_rows > 0) {
        $job = $jobResult->fetch_assoc();
        $jobName = $job['name'];
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payment Success</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        h2 {
            color: #28a745;
            margin-top: 0;
        }
        .checkmark {
            font-size: 60px;
            color: #28a745;
        }
        .details {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
            text-align: left;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: bold;
            color: #333;
        }
        .value {
            color: #666;
            word-break: break-all;
        }
        .btn {
            display: inline-block;
            padding: 10px 30px;
            background: #001219;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            cursor: pointer;
            border: none;
            font-size: 16px;
        }
        .btn:hover {
            background: #003d4d;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="checkmark">✅</div>
        <h2>TEST MODE: Payment Successful!</h2>
        
        <div class="details">
            <div class="detail-row">
                <span class="label">Job Title:</span>
                <span class="value"><?php echo htmlspecialchars($jobName); ?></span>
            </div>
            <div class="detail-row">
                <span class="label">Transaction ID:</span>
                <span class="value"><?php echo htmlspecialchars($transaction_id); ?></span>
            </div>
            <div class="detail-row">
                <span class="label">Amount:</span>
                <span class="value"><?php echo $payment['amount'] . ' ' . $payment['currency']; ?></span>
            </div>
            <div class="detail-row">
                <span class="label">Status:</span>
                <span class="value" style="color: #28a745; font-weight: bold;">CONFIRMED</span>
            </div>
        </div>
        
        <p style="color: #666; font-size: 14px;">
            Your job posting has been created and published successfully!<br>
            <small>(In production, jobs require admin approval before publication.)</small>
        </p>
        
        <a href='employerAccount.php' class='btn'>View My Jobs</a>
    </div>
</body>
</html>


