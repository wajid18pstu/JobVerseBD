<?php
/**
 * Chatbot Setup Script
 * Run this file once to initialize the chatbot database tables and FAQs
 * 
 * Usage: Open http://your-domain/setup_chatbot.php in your browser
 */

error_reporting(1);
require_once 'connect.php';

$setup_complete = false;
$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['setup_chatbot'])) {
    // Create tables
    $sql_conversations = "CREATE TABLE IF NOT EXISTS chatbot_conversations (
        id INT PRIMARY KEY AUTO_INCREMENT,
        user_id INT,
        session_id VARCHAR(255) NOT NULL,
        user_message VARCHAR(1000) NOT NULL,
        bot_response VARCHAR(2000) NOT NULL,
        timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
        user_ip VARCHAR(50),
        INDEX(session_id),
        INDEX(timestamp)
    )";

    $sql_faqs = "CREATE TABLE IF NOT EXISTS chatbot_faqs (
        id INT PRIMARY KEY AUTO_INCREMENT,
        question VARCHAR(500) NOT NULL,
        answer VARCHAR(2000) NOT NULL,
        category VARCHAR(100),
        keywords VARCHAR(500),
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        is_active BOOLEAN DEFAULT TRUE,
        INDEX(category),
        INDEX(is_active)
    )";

    if ($conn->query($sql_conversations) === TRUE && $conn->query($sql_faqs) === TRUE) {
        // Insert sample FAQs
        $faqs = [
            ['How do I register on JobVerseBD?', 'To register on JobVerseBD, click on the "Sign Up" button on the homepage and fill in your details. Choose whether you want to register as a Job Seeker or Employer. Verify your email and start using the platform.', 'Registration', 'register, signup, account, create account'],
            ['How do I post a job?', 'If you are an employer, go to your account dashboard and click on "Post a Job". Fill in the job details including title, description, requirements, and salary. Review and publish your job posting.', 'Jobs', 'post job, create job, job posting'],
            ['How do I apply for a job?', 'Log in to your account as a Job Seeker. Browse available jobs and click on any job you are interested in. Click the "Apply" button and submit your application along with your resume.', 'Jobs', 'apply job, application, submit application'],
            ['What is the coding exam feature?', 'The coding exam feature allows employers to assess technical skills of job seekers. Job seekers can practice coding problems and take timed exams as part of the application process.', 'Coding Exam', 'coding exam, test, assessment, practice'],
            ['How do I reset my password?', 'Click on "Forgot Password" on the login page. Enter your email address and you will receive a password reset link. Click the link and set a new password.', 'Account', 'password reset, forgot password, password change'],
            ['How do I contact support?', 'You can contact us through the Contact page. Fill in your query and we will get back to you as soon as possible. You can also email us or call our support team.', 'Support', 'contact, support, help, assistance'],
            ['What is the payment system?', 'We use a secure payment gateway (SSL Commerz) to process payments. All transactions are encrypted and secure. Premium features and services can be accessed through this payment system.', 'Payment', 'payment, billing, subscription, premium'],
            ['How do I view my application status?', 'Log in to your account and go to "My Applications" or "Applied Jobs". Here you can see all your applications and their current status.', 'Application', 'application status, view applications, applied jobs'],
            ['Can I edit my profile?', 'Yes, you can edit your profile by going to your Account page and clicking "Edit Profile". Update your information and save the changes.', 'Account', 'profile, edit profile, update profile'],
            ['What is a saved job?', 'You can save jobs to view them later. Click the heart icon on a job listing to save it. Access your saved jobs from your dashboard.', 'Jobs', 'saved job, save job, favorites, bookmark']
        ];

        $inserted = 0;
        foreach ($faqs as $faq) {
            $stmt = $conn->prepare("INSERT INTO chatbot_faqs (question, answer, category, keywords) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE question=question");
            $stmt->bind_param("ssss", $faq[0], $faq[1], $faq[2], $faq[3]);
            if ($stmt->execute()) {
                $inserted++;
            }
            $stmt->close();
        }

        $success_message = "✅ Chatbot setup completed successfully!<br>";
        $success_message .= "• Database tables created<br>";
        $success_message .= "• " . $inserted . " FAQ entries added<br>";
        $success_message .= "<br><strong>Next Steps:</strong><br>";
        $success_message .= "1. Delete this setup file (setup_chatbot.php)<br>";
        $success_message .= "2. Refresh your website pages to see the chatbot<br>";
        $success_message .= "3. Test the chatbot functionality";
        $setup_complete = true;
    } else {
        $error_message = "Error creating tables: " . $conn->error;
    }
}

// Check if tables already exist
$tables_exist = true;
$result = $conn->query("SHOW TABLES LIKE 'chatbot_conversations'");
if ($result->num_rows === 0) {
    $tables_exist = false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobVerseBD Chatbot Setup</title>
    <link href="mcss/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .setup-container {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            max-width: 600px;
            width: 100%;
        }
        .setup-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .setup-header h1 {
            color: #333;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .setup-header p {
            color: #666;
            font-size: 16px;
        }
        .status-box {
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .status-success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }
        .status-error {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }
        .status-info {
            background: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
        }
        .setup-form {
            text-align: center;
        }
        .btn-setup {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 40px;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .btn-setup:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
        .btn-setup:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        .setup-features {
            list-style: none;
            padding: 0;
            margin-top: 20px;
        }
        .setup-features li {
            padding: 10px;
            margin: 5px 0;
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            text-align: left;
        }
        .check-icon {
            color: #28a745;
            margin-right: 10px;
        }
        .warning-icon {
            color: #ffc107;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="setup-container">
        <div class="setup-header">
            <h1>🤖 JobVerseBD Chatbot Setup</h1>
            <p>Initialize the chatbot system for your website</p>
        </div>

        <?php if ($setup_complete): ?>
            <div class="status-box status-success">
                <strong>Setup Successful! ✅</strong><br>
                <?php echo $success_message; ?>
            </div>
        <?php elseif ($error_message): ?>
            <div class="status-box status-error">
                <strong>Setup Error:</strong><br>
                <?php echo $error_message; ?>
            </div>
        <?php elseif ($tables_exist): ?>
            <div class="status-box status-info">
                <strong>ℹ️ Chatbot Already Installed</strong><br>
                The chatbot database tables are already set up and ready to use. The chatbot widget has been integrated into your pages.
            </div>
        <?php else: ?>
            <div class="status-box status-info">
                <strong>⚠️ Setup Required</strong><br>
                Click the button below to initialize the chatbot database and load the FAQ data.
            </div>

            <form method="POST" class="setup-form">
                <button type="submit" name="setup_chatbot" class="btn-setup">
                    Initialize Chatbot System
                </button>
            </form>

            <h5 style="margin-top: 30px; text-align: left;">What will be installed:</h5>
            <ul class="setup-features">
                <li><span class="check-icon">✓</span> Chatbot Conversations Table</li>
                <li><span class="check-icon">✓</span> FAQ Database Table</li>
                <li><span class="check-icon">✓</span> 10 Pre-loaded FAQ Entries</li>
                <li><span class="check-icon">✓</span> Chat History Tracking</li>
                <li><span class="check-icon">✓</span> User Session Management</li>
            </ul>
        <?php endif; ?>

        <?php if ($setup_complete || $tables_exist): ?>
            <div style="margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 8px; text-align: left;">
                <h5>📋 Next Steps:</h5>
                <ol>
                    <li>Delete this setup file (<code>setup_chatbot.php</code>) from your server</li>
                    <li>Visit your website and look for the chatbot in the bottom-right corner</li>
                    <li>Test the chatbot by asking sample questions</li>
                    <li>Add more FAQ entries as needed through the database</li>
                    <li>Customize the colors and responses to match your brand</li>
                </ol>
                <p style="margin-top: 15px; color: #666; font-size: 14px;">
                    <strong>📚 Documentation:</strong> See <code>CHATBOT_SETUP_GUIDE.md</code> for complete setup and customization instructions.
                </p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
