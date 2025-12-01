<?php
/**
 * Process Payment Completion
 * Called after payment is confirmed to insert the job with pending status
 */

include 'sslcommerz_config.php';
include 'connect.php';
include 'authorizeEmployer.php';

header('Content-Type: application/json');

if (!isset($_POST['transaction_id']) || !isset($_POST['payment_id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

$transaction_id = $_POST['transaction_id'];
$payment_id = $_POST['payment_id'];
$eid = $_SESSION['eid'];

if (!$eid) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

// Verify payment is confirmed
$verify_sql = "SELECT status FROM payments WHERE id = '$payment_id' AND transaction_id = '$transaction_id' AND eid = '$eid'";
$result = $conn->query($verify_sql);

if ($result->num_rows === 0 || !($row = $result->fetch_assoc()) || $row['status'] !== 'confirmed') {
    echo json_encode(['success' => false, 'message' => 'Payment not confirmed']);
    exit;
}

// Get job form data from session
if (!isset($_SESSION['job_form_data'])) {
    echo json_encode(['success' => false, 'message' => 'No job data found']);
    exit;
}

$jobData = $_SESSION['job_form_data'];

// Insert job with pending status
$id = isset($jobData['id']) && $jobData['id'] > 0 ? $jobData['id'] : 'NULL';
$name = $conn->real_escape_string($jobData['name']);
$category = $conn->real_escape_string($jobData['category']);
$minexp = $conn->real_escape_string($jobData['minexp']);
$desc = $conn->real_escape_string($jobData['desc']);
$salary = $conn->real_escape_string($jobData['salary']);
$industry = $conn->real_escape_string($jobData['industry']);
$role = $conn->real_escape_string($jobData['role']);
$eType = $conn->real_escape_string($jobData['employmentType']);
$status = 'pending'; // Job starts as pending until admin confirms payment

$sql = "INSERT INTO `post` (`date`, `eid`, `name`, `category`, `minexp`, `desc`, `salary`, `industry`, `role`, `employmentType`, `status`, `payment_id`, `payment_status`) 
        VALUES (CURRENT_DATE(), '$eid', '$name', '$category', '$minexp', '$desc', '$salary', '$industry', '$role', '$eType', '$status', '$payment_id', 'confirmed')";

if ($conn->query($sql) === TRUE) {
    $post_id = $conn->insert_id;
    
    // Update job_payments with post id and confirmed status
    $update_job_payment = "UPDATE job_payments SET pid = '$post_id', admin_status = 'pending' 
                          WHERE payment_id = '$payment_id' AND eid = '$eid'";
    $conn->query($update_job_payment);
    
    // Clear session data
    unset($_SESSION['job_form_data']);
    
    echo json_encode([
        'success' => true,
        'message' => 'Job posting submitted for admin review',
        'post_id' => $post_id,
        'redirect_url' => 'employerAccount.php'
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error inserting job: ' . $conn->error]);
}

?>
