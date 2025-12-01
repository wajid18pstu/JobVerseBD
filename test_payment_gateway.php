<?php
/**
 * Payment Gateway Diagnostic Test
 * Run this to check if your server can connect to SSLCommerz
 */

header('Content-Type: text/html; charset=utf-8');

echo "<h2>🔍 Payment Gateway Diagnostics</h2>";

// Check 1: cURL Extension
echo "<h3>1. cURL Extension</h3>";
if (extension_loaded('curl')) {
    echo "✅ cURL is enabled<br>";
    echo "cURL Version: " . curl_version()['version'] . "<br>";
} else {
    echo "❌ cURL is NOT enabled - Contact your hosting provider<br>";
}

// Check 2: SSL/TLS Support
echo "<h3>2. SSL/TLS Support</h3>";
if (extension_loaded('openssl')) {
    echo "✅ OpenSSL is enabled<br>";
} else {
    echo "❌ OpenSSL is NOT enabled<br>";
}

// Check 3: Try to reach SSLCommerz
echo "<h3>3. SSLCommerz Connectivity Test</h3>";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://sandbox.sslcommerz.com/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

$response = curl_exec($ch);
$error = curl_error($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($error) {
    echo "❌ Connection Error: " . $error . "<br>";
} else {
    echo "✅ Can reach SSLCommerz (HTTP Code: " . $http_code . ")<br>";
}

// Check 4: Configuration
echo "<h3>4. Configuration Check</h3>";
include 'sslcommerz_config.php';

echo "Store ID: " . SSLCOMMERZ_STORE_ID . "<br>";
echo "Store Password: " . (strlen(SSLCOMMERZ_STORE_PASSWORD) > 0 ? "✅ Set" : "❌ Not Set") . "<br>";
echo "Session API: " . SSLCOMMERZ_SESSION_API . "<br>";
echo "Registered URL: " . SSLCOMMERZ_REGISTERED_URL . "<br>";

// Check 5: Database Connection
echo "<h3>5. Database Connection</h3>";
include 'connect.php';

$result = $conn->query("SHOW TABLES LIKE 'payments'");
if ($result && $result->num_rows > 0) {
    echo "✅ Payment tables exist<br>";
} else {
    echo "❌ Payment tables NOT found - Run SQL migration<br>";
}

// Check 6: PHP Info
echo "<h3>6. Server Information</h3>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Operating System: " . php_uname() . "<br>";
echo "Max Execution Time: " . ini_get('max_execution_time') . " seconds<br>";

echo "<hr>";
echo "<h3>📝 Next Steps:</h3>";
echo "If you see ❌ errors:<br>";
echo "1. Enable cURL in php.ini<br>";
echo "2. Enable OpenSSL in php.ini<br>";
echo "3. Run the SQL migration to create payment tables<br>";
echo "4. Check your firewall allows outbound HTTPS connections<br>";

?>
