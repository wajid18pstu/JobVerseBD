<?php include 'authorizeAdmin.php'; ?>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="img/jobsConnect.svg" type="image/x-icon">
    <title>Message Detail | Admin</title>

    <link href="css/simpleGridTemplate.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/Animate.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <link href="css/animate.min.css" rel="stylesheet" type="text/css">

    <!--FONTS-->
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@200&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #f8f9fa;
        }

        .container-content {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Page Header */
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px;
            border-radius: 10px;
            margin-top: 80px;
            margin-bottom: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .page-header h1 {
            margin: 0;
            font-size: 32px;
            font-weight: 700;
        }

        .breadcrumb {
            background-color: transparent;
            padding: 10px 0;
            margin: 15px 0 0 0;
        }

        .breadcrumb a {
            color: rgba(255, 255, 255, 0.8);
        }

        .breadcrumb a:hover {
            color: white;
        }

        .breadcrumb > li + li:before {
            color: rgba(255, 255, 255, 0.6);
        }

        /* Message Card */
        .message-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .message-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .message-title {
            flex: 1;
            min-width: 250px;
        }

        .message-title h2 {
            margin: 0 0 10px 0;
            font-size: 24px;
            font-weight: 700;
        }

        .message-title p {
            margin: 0;
            opacity: 0.9;
            font-size: 14px;
        }

        .message-status {
            flex-shrink: 0;
        }

        .badge-new {
            display: inline-block;
            background-color: #ff6b6b;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge-read {
            display: inline-block;
            background-color: #51cf66;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        /* Message Body */
        .message-body {
            padding: 30px;
        }

        .message-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
            padding-bottom: 30px;
            border-bottom: 1px solid #e0e0e0;
        }

        .info-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            border-left: 3px solid #667eea;
        }

        .info-label {
            font-size: 11px;
            text-transform: uppercase;
            color: #999;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 16px;
            color: #333;
            font-weight: 500;
            word-break: break-word;
        }

        /* Message Content */
        .message-content {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 6px;
            line-height: 1.8;
            color: #333;
            white-space: pre-wrap;
            word-wrap: break-word;
            margin-bottom: 30px;
            min-height: 200px;
        }

        /* Action Buttons */
        .message-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn-action {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .btn-back {
            background-color: #667eea;
            color: white;
        }

        .btn-back:hover {
            background-color: #764ba2;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
            text-decoration: none;
            color: white;
        }

        .btn-delete {
            background-color: #ff6b6b;
            color: white;
        }

        .btn-delete:hover {
            background-color: #e63946;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 107, 107, 0.4);
            text-decoration: none;
            color: white;
        }

        .btn-mark-read {
            background-color: #51cf66;
            color: white;
        }

        .btn-mark-read:hover {
            background-color: #40c057;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(81, 207, 102, 0.4);
            text-decoration: none;
            color: white;
        }

        .btn-mark-unread {
            background-color: #ffa94d;
            color: white;
        }

        .btn-mark-unread:hover {
            background-color: #ff922b;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 165, 77, 0.4);
            text-decoration: none;
            color: white;
        }

        .btn-reply {
            background-color: #4c6ef5;
            color: white;
        }

        .btn-reply:hover {
            background-color: #364fc7;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(76, 110, 245, 0.4);
            text-decoration: none;
            color: white;
        }
    </style>
</head>

<body>
    <?php include 'navBar.php'; ?>

    <div class="container-content">
        <!-- Page Header -->
        <div class="page-header">
            <h1>Message Details</h1>
            <ol class="breadcrumb" style="margin: 15px 0 0 0;">
                <li><a href="adminMessages.php">Messages</a></li>
                <li class="active">View Message</li>
            </ol>
        </div>

        <?php
        require_once __DIR__ . '/connect.php';

        if(!isset($_GET['id']) || empty($_GET['id'])) {
            echo '<div class="alert alert-danger">Message not found.</div>';
            exit;
        }

        $messageId = intval($_GET['id']);
        
        // Fetch message details
        $stmt = $conn->prepare("SELECT * FROM messages WHERE id = ?");
        $stmt->bind_param("i", $messageId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows == 0) {
            echo '<div class="alert alert-danger">Message not found.</div>';
            $conn->close();
            exit;
        }

        $message = $result->fetch_assoc();
        
        // Mark as read
        if($message['is_read'] == 0) {
            $updateStmt = $conn->prepare("UPDATE messages SET is_read = 1 WHERE id = ?");
            $updateStmt->bind_param("i", $messageId);
            $updateStmt->execute();
            $updateStmt->close();
        }

        // Format date
        $createdDate = date('F d, Y \a\t h:i A', strtotime($message['created_at']));
        $status = $message['is_read'] == 1 ? '<span class="badge-read">Read</span>' : '<span class="badge-new">New</span>';

        // Sanitize output
        $userName = htmlspecialchars($message['userName']);
        $userEmail = htmlspecialchars($message['userEmail']);
        $subject = htmlspecialchars($message['subject']);
        $content = htmlspecialchars($message['content']);
        ?>

        <!-- Message Card -->
        <div class="message-card">
            <!-- Message Header -->
            <div class="message-header">
                <div class="message-title">
                    <h2><?php echo $subject; ?></h2>
                    <p>From: <strong><?php echo $userName; ?></strong></p>
                </div>
                <div class="message-status">
                    <?php echo $status; ?>
                </div>
            </div>

            <!-- Message Body -->
            <div class="message-body">
                <!-- Sender Information -->
                <div class="message-info">
                    <div class="info-item">
                        <div class="info-label">From</div>
                        <div class="info-value"><?php echo $userName; ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Email</div>
                        <div class="info-value">
                            <a href="mailto:<?php echo $userEmail; ?>" style="color: #667eea; text-decoration: none;">
                                <?php echo $userEmail; ?>
                            </a>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Received</div>
                        <div class="info-value"><?php echo $createdDate; ?></div>
                    </div>
                </div>

                <!-- Message Content -->
                <h4 style="margin-bottom: 15px; color: #333;">Message Content:</h4>
                <div class="message-content">
<?php echo $content; ?>
                </div>

                <!-- Action Buttons -->
                <div class="message-actions">
                    <a href="adminMessages.php" class="btn-action btn-back">
                        <i class="fa fa-arrow-left"></i> Back to Messages
                    </a>
                    <a href="mailto:<?php echo $userEmail; ?>?subject=Re: <?php echo urlencode($subject); ?>" class="btn-action btn-reply">
                        <i class="fa fa-reply"></i> Reply via Email
                    </a>
                    <?php if($message['is_read'] == 1): ?>
                    <a href="markMessageUnread.php?id=<?php echo $messageId; ?>" class="btn-action btn-mark-unread">
                        <i class="fa fa-envelope"></i> Mark as Unread
                    </a>
                    <?php else: ?>
                    <a href="markMessageRead.php?id=<?php echo $messageId; ?>" class="btn-action btn-mark-read">
                        <i class="fa fa-check"></i> Mark as Read
                    </a>
                    <?php endif; ?>
                    <a href="deleteMessage.php?id=<?php echo $messageId; ?>" class="btn-action btn-delete" onclick="return confirm('Are you sure you want to delete this message?');">
                        <i class="fa fa-trash"></i> Delete
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php
    $stmt->close();
    $conn->close();
    ?>
</body>

</html>
