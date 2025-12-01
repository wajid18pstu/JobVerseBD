<?php
/**
 * Payment Initiation Script
 * Initiates SSLCommerz payment gateway session for job posting
 */

include 'sslcommerz_config.php';
include 'connect.php';
include 'authorizeEmployer.php';

header('Content-Type: application/json');

// Get POST data
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['job_type']) || !isset($data['job_data'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

$jobType = $data['job_type'];
$jobData = $data['job_data'];
$eid = $_SESSION['eid'];

// Validate employer session
if (!$eid) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

// Get job posting fee
$amount = getJobPostingFee($jobType);

if ($amount <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid job type']);
    exit;
}

// Get employer details
$sqlE = "SELECT name, email FROM employer WHERE id = '$eid'";
$resultE = $conn->query($sqlE);

if ($resultE->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Employer not found']);
    exit;
}

$rowE = $resultE->fetch_assoc();
$ename = $rowE['name'];
$email = $rowE['email'];

// Generate unique transaction ID
$transaction_id = 'JOB' . $eid . time() . rand(1000, 9999);

// Prepare SSLCommerz API data
$post_data = array(
    'store_id' => SSLCOMMERZ_STORE_ID,
    'store_passwd' => SSLCOMMERZ_STORE_PASSWORD,
    'total_amount' => $amount,
    'currency' => 'BDT',
    'tran_id' => $transaction_id,
    'success_url' => PAYMENT_SUCCESS_URL,
    'fail_url' => PAYMENT_FAILURE_URL,
    'cancel_url' => PAYMENT_CANCEL_URL,
    'ipn_url' => PAYMENT_IPN_URL,
    'cus_name' => $ename,
    'cus_email' => $email,
    'cus_add1' => 'Bangladesh',
    'cus_country' => 'Bangladesh',
    'shipping_method' => 'NO',
    'product_name' => 'Job Posting - ' . $jobType,
    'product_category' => 'Job Posting',
    'product_profile' => 'general',
);

// Initialize CURL request to SSLCommerz
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, SSLCOMMERZ_SESSION_API);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$response = curl_exec($ch);
$curlError = curl_error($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Log the response for debugging
$log_file = 'logs/payment_debug.log';
if (!is_dir('logs')) {
    mkdir('logs', 0755, true);
}
file_put_contents($log_file, date('Y-m-d H:i:s') . " - Request to: " . SSLCOMMERZ_SESSION_API . "\n", FILE_APPEND);
file_put_contents($log_file, date('Y-m-d H:i:s') . " - HTTP Code: " . $httpCode . "\n", FILE_APPEND);
file_put_contents($log_file, date('Y-m-d H:i:s') . " - Response: " . $response . "\n", FILE_APPEND);
file_put_contents($log_file, date('Y-m-d H:i:s') . " - cURL Error: " . $curlError . "\n\n", FILE_APPEND);

if ($curlError) {
    echo json_encode(['success' => false, 'message' => 'Gateway error: ' . $curlError . ' (HTTP: ' . $httpCode . ')']);
    exit;
}

// Parse response
$response_data = json_decode($response, true);

if (!isset($response_data['status']) || strtoupper($response_data['status']) !== 'SUCCESS') {
    // Log detailed error
    file_put_contents($log_file, date('Y-m-d H:i:s') . " - API ERROR DETAILS: " . json_encode($response_data, JSON_PRETTY_PRINT) . "\n", FILE_APPEND);
    
    $errorMsg = isset($response_data['failedreason']) ? $response_data['failedreason'] : 'Unknown error';
    echo json_encode([
        'success' => false,
        'message' => 'Payment gateway error: ' . $errorMsg,
        'gateway_response' => $response_data
    ]);
    exit;
}

// Store payment transaction in database with PENDING status
$jobDataJson = $conn->real_escape_string(json_encode($jobData));
$insertPaymentSql = "INSERT INTO payments (transaction_id, eid, amount, status) 
                     VALUES ('$transaction_id', '$eid', '$amount', 'pending')";

if (!$conn->query($insertPaymentSql)) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
    exit;
}

$payment_id = $conn->insert_id;

// Store job payment reference with job data temporarily
$insertJobPaymentSql = "INSERT INTO job_payments (payment_id, eid, job_type, amount, payment_status) 
                        VALUES ('$payment_id', '$eid', '$jobType', '$amount', 'pending')";

if (!$conn->query($insertJobPaymentSql)) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
    exit;
}

$job_payment_id = $conn->insert_id;

// Store job data in a temporary file or session-like storage
// This will be used after payment success to insert the job
$temp_storage_file = 'temp/job_data_' . $payment_id . '.json';
if (!is_dir('temp')) {
    mkdir('temp', 0755, true);
}
file_put_contents($temp_storage_file, $jobDataJson);

// Return gateway token for redirect
echo json_encode([
    'success' => true,
    'gateway_url' => 'https://sandbox.sslcommerz.com/gwprocess/v3/gw.php?Q=sendtoken&val=' . $response_data['sessionkey'],
    'transaction_id' => $transaction_id,
    'payment_id' => $payment_id,
    'job_payment_id' => $job_payment_id,
    'amount' => $amount
]);

?>
