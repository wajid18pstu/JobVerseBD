<?php
/**
 * Payment Success Handler
 * Called by SSLCommerz after successful payment
 * Inserts job posting with pending status waiting for admin confirmation
 */

include 'sslcommerz_config.php';
include 'connect.php';

// Log payment success callback
$log_file = 'logs/payment_success.log';
if (!is_dir('logs')) {
    mkdir('logs', 0755, true);
}
file_put_contents($log_file, date('Y-m-d H:i:s') . " - Payment Success Callback Received\n", FILE_APPEND);
file_put_contents($log_file, date('Y-m-d H:i:s') . " - POST Data: " . json_encode($_POST) . "\n", FILE_APPEND);

// Get payment response from SSLCommerz
$tran_id = isset($_POST['tran_id']) ? $_POST['tran_id'] : '';
$bank_tran_id = isset($_POST['bank_tran_id']) ? $_POST['bank_tran_id'] : '';
$card_type = isset($_POST['card_type']) ? $_POST['card_type'] : '';
$store_amount = isset($_POST['store_amount']) ? $_POST['store_amount'] : '';
$currency = isset($_POST['currency']) ? $_POST['currency'] : '';
$card_number = isset($_POST['card_number']) ? $_POST['card_number'] : '';
$base_fair = isset($_POST['base_fair']) ? $_POST['base_fair'] : '';
$value_a = isset($_POST['value_a']) ? $_POST['value_a'] : '';
$risk_level = isset($_POST['risk_level']) ? $_POST['risk_level'] : '';
$response_code = isset($_POST['response_code']) ? $_POST['response_code'] : '';
$response_desc = isset($_POST['response_desc']) ? $_POST['response_desc'] : '';
$status = isset($_POST['status']) ? $_POST['status'] : '';

// Validate transaction
if (empty($tran_id)) {
    ?>
    <html>
    <head>
        <title>Payment Failed</title>
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="container" style="margin-top: 50px; text-align: center;">
            <h2 style="color: red;">Payment Verification Failed</h2>
            <p>Invalid transaction ID received.</p>
            <a href="postjob.php" class="btn btn-primary">Go Back to Post Job</a>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// Update payment status in database
$update_sql = "UPDATE payments SET status = 'confirmed' 
               WHERE transaction_id = '$tran_id'";
$conn->query($update_sql);

// Get payment details
$select_sql = "SELECT p.id, p.eid, p.amount, jp.id as job_payment_id, jp.job_type 
               FROM payments p 
               LEFT JOIN job_payments jp ON p.id = jp.payment_id 
               WHERE p.transaction_id = '$tran_id'";
$result = $conn->query($select_sql);

if ($result->num_rows === 0) {
    ?>
    <html>
    <head>
        <title>Payment Failed</title>
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="container" style="margin-top: 50px; text-align: center;">
            <h2 style="color: red;">Payment Not Found</h2>
            <p>The payment record could not be found in our system.</p>
            <a href="postjob.php" class="btn btn-primary">Go Back to Post Job</a>
        </div>
    </body>
    </html>
    <?php
    exit;
}

$row = $result->fetch_assoc();
$payment_id = $row['id'];
$eid = $row['eid'];
$job_payment_id = $row['job_payment_id'];
$job_type = $row['job_type'];

// Update job_payments status
if ($job_payment_id) {
    $update_job_payment = "UPDATE job_payments SET payment_status = 'confirmed' 
                          WHERE id = '$job_payment_id'";
    $conn->query($update_job_payment);
}

// Try to retrieve job data from temporary storage
$temp_storage_file = 'temp/job_data_' . $payment_id . '.json';
$job_data = null;
$post_id = 0;

file_put_contents($log_file, date('Y-m-d H:i:s') . " - Looking for temp file: " . $temp_storage_file . "\n", FILE_APPEND);

if (file_exists($temp_storage_file)) {
    file_put_contents($log_file, date('Y-m-d H:i:s') . " - Temp file found, reading job data\n", FILE_APPEND);
    $job_data = json_decode(file_get_contents($temp_storage_file), true);
    
    // Insert job posting with 'pending' status (waiting for admin confirmation)
    if ($job_data) {
        file_put_contents($log_file, date('Y-m-d H:i:s') . " - Job data decoded successfully\n", FILE_APPEND);
        $name = $conn->real_escape_string($job_data['name']);
        $category = $conn->real_escape_string($job_data['category']);
        $minexp = $conn->real_escape_string($job_data['minexp']);
        $salary = $conn->real_escape_string($job_data['salary']);
        $industry = $conn->real_escape_string($job_data['industry']);
        $desc = $conn->real_escape_string($job_data['desc']);
        $role = $conn->real_escape_string($job_data['role']);
        $eType = $conn->real_escape_string($job_data['eType']);
        $jobStatus = 'pending'; // Job status is pending until admin confirms payment
        
        $insert_sql = "INSERT INTO `post` (`date`, `eid`, `name`, `category`, `minexp`, `desc`, `salary`, `industry`, `role`, `employmentType`, `status`, `payment_id`, `payment_status`) 
                      VALUES (CURRENT_DATE(), '$eid', '$name', '$category', '$minexp', '$desc', '$salary', '$industry', '$role', '$eType', '$jobStatus', '$payment_id', 'confirmed')";
        
        file_put_contents($log_file, date('Y-m-d H:i:s') . " - Inserting Job SQL: " . $insert_sql . "\n", FILE_APPEND);
        
        if ($conn->query($insert_sql) === TRUE) {
            $post_id = $conn->insert_id;
            file_put_contents($log_file, date('Y-m-d H:i:s') . " - Job inserted successfully with ID: " . $post_id . "\n", FILE_APPEND);
            
            // Update job_payments with post id
            if ($job_payment_id) {
                $update_jp = "UPDATE job_payments SET pid = '$post_id', admin_status = 'pending' 
                             WHERE id = '$job_payment_id'";
                $conn->query($update_jp);
            }
            
            // Delete temporary file
            unlink($temp_storage_file);
        } else {
            file_put_contents($log_file, date('Y-m-d H:i:s') . " - Job insertion FAILED: " . $conn->error . "\n", FILE_APPEND);
        }
    } else {
        file_put_contents($log_file, date('Y-m-d H:i:s') . " - Job data could not be decoded\n", FILE_APPEND);
    }
} else {
    file_put_contents($log_file, date('Y-m-d H:i:s') . " - Temp file NOT FOUND: " . $temp_storage_file . "\n", FILE_APPEND);
}

// Store payment details for reference
session_start();
$_SESSION['payment_confirmed'] = true;
$_SESSION['payment_tran_id'] = $tran_id;
$_SESSION['payment_id'] = $payment_id;
$_SESSION['job_payment_id'] = $job_payment_id;
$_SESSION['post_id'] = $post_id;

?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment Successful</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@200&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <style>
        body {
            font-family: 'Sora', sans-serif;
            background-color: #f5f5f5;
        }
        .success-container {
            margin-top: 100px;
            background: white;
            padding: 50px;
            border-radius: 10px;
            box-shadow: 0px 0px 20px #ccc;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        .success-icon {
            font-size: 80px;
            color: #28a745;
            text-align: center;
        }
        .details {
            margin-top: 30px;
            text-align: left;
        }
        .detail-item {
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
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
    <div class="success-container">
        <div class="success-icon">✓</div>
        <h2 style="text-align: center; color: #28a745; margin-top: 20px;">Payment Successful!</h2>
        <p style="text-align: center; font-size: 16px; color: #666; margin-top: 20px;">
            Your payment has been received and processed successfully!
        </p>
        <?php if ($post_id > 0): ?>
        <p style="text-align: center; font-size: 14px; color: #28a745; margin-top: 10px;">
            ✓ Your job posting has been submitted for admin review.
        </p>
        <?php else: ?>
        <p style="text-align: center; font-size: 14px; color: #ffc107; margin-top: 10px;">
            Your payment is confirmed. Job posting is being processed.
        </p>
        <?php endif; ?>
        
        <div class="details">
            <div class="detail-item">
                <span class="detail-label">Transaction ID:</span><br>
                <span class="detail-value"><?php echo htmlspecialchars($tran_id); ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Bank Transaction ID:</span><br>
                <span class="detail-value"><?php echo htmlspecialchars($bank_tran_id); ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Amount:</span><br>
                <span class="detail-value"><?php echo htmlspecialchars($store_amount); ?> <?php echo htmlspecialchars($currency); ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Payment Status:</span><br>
                <span class="detail-value" style="color: #28a745; font-weight: bold;">Confirmed</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Job Posting Status:</span><br>
                <span class="detail-value" style="color: #ff9800; font-weight: bold;">Pending Admin Confirmation</span>
            </div>
        </div>

        <div style="margin-top: 40px; text-align: center;">
            <p style="font-size: 14px; color: #666;">
                You will receive an email notification once the admin verifies and approves your job posting. Thank you!
            </p>
            <a href="employerAccount.php" class="btn btn-primary" style="background-color: #001219; border-color: #001219; margin: 10px 5px;">Go to Dashboard</a>
            <a href="postjob.php" class="btn btn-outline-primary" style="margin: 10px 5px;">Post Another Job</a>
        </div>
    </div>

    <script>
        console.log('Payment confirmed - Transaction: <?php echo htmlspecialchars($tran_id); ?>');
        <?php if ($post_id > 0): ?>
        console.log('Job posting created with ID: <?php echo $post_id; ?>');
        <?php endif; ?>
    </script>
</body>
</html>
<?php

?>
