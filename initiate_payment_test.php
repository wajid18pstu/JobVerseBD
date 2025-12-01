<?php
/**
 * Test Payment Simulation Mode
 * For local development when SSLCommerz won't accept localhost URLs
 * This simulates a successful payment transaction
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

// Store payment transaction in database with VALIDATED status (test mode auto-confirms)
$insertPaymentSql = "INSERT INTO payments (transaction_id, eid, amount, status, validated_date) 
                     VALUES ('$transaction_id', '$eid', '$amount', 'validated', NOW())";

if (!$conn->query($insertPaymentSql)) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
    exit;
}

$payment_id = $conn->insert_id;

// Store job payment reference with job data temporarily
$insertJobPaymentSql = "INSERT INTO job_payments (payment_id, eid, job_type, amount, payment_status, admin_status) 
                        VALUES ('$payment_id', '$eid', '$jobType', '$amount', 'confirmed', 'pending')";

if (!$conn->query($insertJobPaymentSql)) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
    exit;
}

$job_payment_id = $conn->insert_id;

// Insert the job posting immediately with the provided data
$insertJobSql = "INSERT INTO post (
    eid, name, category, minexp, salary, industry, `desc`, role, employmentType, status
) VALUES (
    '$eid',
    '{$conn->real_escape_string($jobData['name'])}',
    '{$conn->real_escape_string($jobData['category'])}',
    '{$conn->real_escape_string($jobData['minexp'])}',
    '{$conn->real_escape_string($jobData['salary'])}',
    '{$conn->real_escape_string($jobData['industry'])}',
    '{$conn->real_escape_string($jobData['desc'])}',
    '{$conn->real_escape_string($jobData['role'])}',
    '{$conn->real_escape_string($jobData['eType'])}',
    'open'
)";

if (!$conn->query($insertJobSql)) {
    echo json_encode(['success' => false, 'message' => 'Database error creating job: ' . $conn->error]);
    exit;
}

$post_id = $conn->insert_id;

// Update job_payments with the post_id
$updateJobPaymentSql = "UPDATE job_payments SET pid = '$post_id' WHERE id = '$job_payment_id'";
$conn->query($updateJobPaymentSql);

// Return test success page URL
echo json_encode([
    'success' => true,
    'gateway_url' => 'test_payment_success.php?payment_id=' . $payment_id . '&transaction_id=' . $transaction_id . '&post_id=' . $post_id,
    'transaction_id' => $transaction_id,
    'payment_id' => $payment_id,
    'post_id' => $post_id,
    'job_payment_id' => $job_payment_id,
    'amount' => $amount,
    'test_mode' => true
]);

?>
