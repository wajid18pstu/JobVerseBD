<?php
/**
 * Payment Error Log Checker
 * Shows the latest payment errors for debugging
 */

$log_file = 'logs/payment_debug.log';

if (!file_exists($log_file)) {
    echo "No payment log file found yet.";
    exit;
}

$log_contents = file_get_contents($log_file);
$lines = explode("\n", $log_contents);

// Show last 50 lines
$recent_lines = array_slice($lines, -50);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Payment Debug Log</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        pre { background: #fff; padding: 20px; border: 1px solid #ddd; overflow-x: auto; }
        h2 { color: #333; }
    </style>
</head>
<body>
    <h2>📋 Latest Payment Debug Log</h2>
    <pre><?php echo htmlspecialchars(implode("\n", $recent_lines)); ?></pre>
    <hr>
    <p><a href="check_payment_error.php">Refresh</a> | <a href="postjob.php">Back to Job Posting</a></p>
</body>
</html>
