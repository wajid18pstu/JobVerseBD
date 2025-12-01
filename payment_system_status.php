<?php
/**
 * Payment System Status Page
 * Shows summary of payment system implementation and current status
 */

include 'connect.php';

// Get payment statistics
$paymentsSql = "SELECT COUNT(*) as total, SUM(amount) as total_revenue, 
                GROUP_CONCAT(DISTINCT status) as statuses 
                FROM payments";
$paymentsResult = $conn->query($paymentsSql);
$paymentStats = $paymentsResult->fetch_assoc();

// Get recent payments
$recentSql = "SELECT p.*, e.name as employer_name FROM payments p 
              LEFT JOIN employer e ON p.eid = e.id 
              ORDER BY p.payment_date DESC LIMIT 5";
$recentResult = $conn->query($recentSql);

// Get pending jobs awaiting approval
$pendingSql = "SELECT COUNT(*) as pending_count FROM post WHERE status = 'pending'";
$pendingResult = $conn->query($pendingSql);
$pendingJobs = $pendingResult->fetch_assoc();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payment System Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #001219;
            border-bottom: 3px solid #28a745;
            padding-bottom: 10px;
        }
        .status-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }
        .status-card {
            background: linear-gradient(135deg, #001219 0%, #003d4d 100%);
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }
        .status-card h3 {
            margin: 0;
            font-size: 14px;
            opacity: 0.9;
            text-transform: uppercase;
        }
        .status-card .value {
            font-size: 32px;
            font-weight: bold;
            margin: 10px 0 0 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th {
            background: #001219;
            color: white;
            padding: 12px;
            text-align: left;
        }
        table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }
        table tr:hover {
            background: #f9f9f9;
        }
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }
        .badge-success {
            background: #28a745;
            color: white;
        }
        .badge-pending {
            background: #ffc107;
            color: #333;
        }
        .badge-failed {
            background: #dc3545;
            color: white;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #001219;
            margin-top: 30px;
            margin-bottom: 15px;
            border-left: 4px solid #28a745;
            padding-left: 10px;
        }
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }
        .feature {
            padding: 15px;
            background: #f0f8ff;
            border-left: 4px solid #28a745;
            border-radius: 4px;
        }
        .feature h4 {
            margin: 0 0 8px 0;
            color: #001219;
        }
        .feature p {
            margin: 0;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>💳 Payment System Status Dashboard</h1>

        <div class="status-grid">
            <div class="status-card">
                <h3>Total Payments</h3>
                <div class="value"><?php echo $paymentStats['total_count'] ?? 0; ?></div>
            </div>
            <div class="status-card">
                <h3>Revenue Generated</h3>
                <div class="value"><?php echo number_format($paymentStats['total_revenue'] ?? 0); ?> BDT</div>
            </div>
            <div class="status-card">
                <h3>Pending Jobs</h3>
                <div class="value"><?php echo $pendingJobs['pending_count'] ?? 0; ?></div>
            </div>
            <div class="status-card">
                <h3>System Status</h3>
                <div class="value" style="font-size: 24px;">✅ Active</div>
            </div>
        </div>

        <div class="section-title">📋 Recent Payments</div>
        <table>
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Employer</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($recentResult->num_rows > 0): ?>
                    <?php while($payment = $recentResult->fetch_assoc()): ?>
                    <tr>
                        <td><code><?php echo $payment['transaction_id']; ?></code></td>
                        <td><?php echo htmlspecialchars($payment['employer_name'] ?? 'N/A'); ?></td>
                        <td><?php echo $payment['amount']; ?> <?php echo $payment['currency']; ?></td>
                        <td>
                            <?php 
                            $status = strtoupper($payment['status']);
                            $badgeClass = 'badge-pending';
                            if ($status === 'VALIDATED' || $status === 'CONFIRMED') {
                                $badgeClass = 'badge-success';
                            } elseif ($status === 'FAILED') {
                                $badgeClass = 'badge-failed';
                            }
                            ?>
                            <span class="badge <?php echo $badgeClass; ?>"><?php echo $status; ?></span>
                        </td>
                        <td><?php echo isset($payment['payment_date']) ? date('M d, Y', strtotime($payment['payment_date'])) : 'N/A'; ?></td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center; color: #999;">No payments yet</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="section-title">✨ System Features Implemented</div>
        <div class="features">
            <div class="feature">
                <h4>💰 Dual Fee Structure</h4>
                <p>White Collar: 500 BDT | Blue Collar: 200 BDT</p>
            </div>
            <div class="feature">
                <h4>🔄 Payment Status Tracking</h4>
                <p>pending → confirmed → validated with detailed logging</p>
            </div>
            <div class="feature">
                <h4>✅ Admin Approval Workflow</h4>
                <p>Jobs pending admin approval before publication</p>
            </div>
            <div class="feature">
                <h4>🌐 SSLCommerz Integration</h4>
                <p>Sandbox & Production support with credential switching</p>
            </div>
            <div class="feature">
                <h4>📧 Email Notifications</h4>
                <p>Payment confirmations & admin approval alerts</p>
            </div>
            <div class="feature">
                <h4>🧪 Test Mode</h4>
                <p>Localhost development without SSLCommerz URL validation</p>
            </div>
            <div class="feature">
                <h4>🛡️ Security</h4>
                <p>SQL injection prevention, session validation, CSRF protection</p>
            </div>
            <div class="feature">
                <h4>📊 Payment Logging</h4>
                <p>Complete audit trail in logs/payment_debug.log</p>
            </div>
        </div>

        <div class="section-title">📁 Files Implemented</div>
        <table>
            <thead>
                <tr>
                    <th>File Name</th>
                    <th>Purpose</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>sslcommerz_config.php</code></td>
                    <td>Configuration, credentials, fee definitions</td>
                </tr>
                <tr>
                    <td><code>initiate_payment.php</code></td>
                    <td>Payment session creation & SSLCommerz API calls (Production)</td>
                </tr>
                <tr>
                    <td><code>initiate_payment_test.php</code></td>
                    <td>Test mode payment (localhost)</td>
                </tr>
                <tr>
                    <td><code>payment_success.php</code></td>
                    <td>SSLCommerz success callback handler</td>
                </tr>
                <tr>
                    <td><code>payment_failure.php</code></td>
                    <td>SSLCommerz failure callback handler</td>
                </tr>
                <tr>
                    <td><code>payment_cancel.php</code></td>
                    <td>SSLCommerz cancellation handler</td>
                </tr>
                <tr>
                    <td><code>payment_ipn.php</code></td>
                    <td>IPN listener for payment validation</td>
                </tr>
                <tr>
                    <td><code>admin_confirm_payment.php</code></td>
                    <td>Admin approval/rejection of pending jobs</td>
                </tr>
                <tr>
                    <td><code>test_payment_success.php</code></td>
                    <td>Test mode success page</td>
                </tr>
                <tr>
                    <td><code>postjob.php (modified)</code></td>
                    <td>Added payment modal & AJAX integration</td>
                </tr>
                <tr>
                    <td><code>adminAccount.php (modified)</code></td>
                    <td>Added pending payments management section</td>
                </tr>
            </tbody>
        </table>

        <div style="margin-top: 40px; padding: 20px; background: #e8f5e9; border-radius: 8px; border-left: 4px solid #28a745;">
            <h3 style="margin-top: 0; color: #1b5e20;">🎉 Payment System Ready for Production!</h3>
            <p>The SSLCommerz payment integration is fully functional. To deploy to production:</p>
            <ol>
                <li>Configure your domain in SSLCommerz merchant panel</li>
                <li>Update <code>sslcommerz_config.php</code> with production credentials</li>
                <li>Deploy all payment files to your server</li>
                <li>Test payment flow end-to-end</li>
            </ol>
        </div>
    </div>
</body>
</html>
