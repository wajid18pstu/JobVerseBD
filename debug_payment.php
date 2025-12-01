<?php
/**
 * Payment Debug - See exactly what's being sent to SSLCommerz
 */

include 'sslcommerz_config.php';
include 'connect.php';

header('Content-Type: application/json');

// Simulate what initiate_payment.php does
$eid = 31; // Use actual employer from database (wajidd)
$jobType = 'white_collar';
$amount = getJobPostingFee($jobType);

// Get employer details
$sqlE = "SELECT name, email FROM employer WHERE id = '$eid' LIMIT 1";
$resultE = $conn->query($sqlE);

if ($resultE->num_rows === 0) {
    echo json_encode(['error' => 'Employer not found']);
    exit;
}

$rowE = $resultE->fetch_assoc();
$ename = $rowE['name'];
$email = $rowE['email'];

// Generate transaction ID
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

echo "<h2>📊 Payment Debug Information</h2>";
echo "<h3>Request Data Being Sent to SSLCommerz:</h3>";
echo "<pre style='background: #f4f4f4; padding: 10px; border: 1px solid #ccc;'>";
print_r($post_data);
echo "</pre>";

echo "<h3>Making cURL Request to SSLCommerz...</h3>";

// Make the request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, SSLCOMMERZ_SESSION_API);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);

$response = curl_exec($ch);
$error = curl_error($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "<h3>Response from SSLCommerz:</h3>";
echo "<strong>HTTP Code:</strong> " . $http_code . "<br>";
echo "<strong>cURL Error:</strong> " . ($error ? $error : "None") . "<br>";

echo "<h3>Response Body:</h3>";
echo "<pre style='background: #f4f4f4; padding: 10px; border: 1px solid #ccc;'>";
echo htmlspecialchars($response);
echo "</pre>";

// Parse response
$response_data = json_decode($response, true);
echo "<h3>Parsed JSON Response:</h3>";
echo "<pre style='background: #f4f4f4; padding: 10px; border: 1px solid #ccc;'>";
print_r($response_data);
echo "</pre>";

if (isset($response_data['status']) && $response_data['status'] === 'success') {
    echo "<h3 style='color: green;'>✅ SUCCESS! Gateway URL:</h3>";
    echo "https://sandbox.sslcommerz.com/gwprocess/v3/gw.php?Q=sendtoken&val=" . $response_data['sessionkey'];
} else {
    echo "<h3 style='color: red;'>❌ FAILED - Check response above for errors</h3>";
}

?>
