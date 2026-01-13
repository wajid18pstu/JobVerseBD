<?php include 'authorizeAdmin.php'; ?>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="img/jobsConnect.svg" type="image/x-icon">
    <title>Messages | Admin</title>

    <link href="css/simpleGridTemplate.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/Animate.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
    <link href="css/animate.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css">

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

        /* Page Header Section */
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px;
            border-radius: 10px;
            margin-top: 60px;
            margin-bottom: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .page-header h1 {
            margin: 0;
            font-size: 32px;
            font-weight: 700;
        }

        /* Section Headers */
        .section-header {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid #667eea;
        }

        .section-header h3 {
            margin: 0;
            color: #333;
            font-size: 24px;
            font-weight: 700;
        }

        .section-header::before {
            content: '';
            width: 5px;
            height: 25px;
            background-color: #667eea;
            margin-right: 15px;
        }

        /* Table Styling */
        .table-container {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 40px;
        }

        .table {
            margin: 0;
            border-collapse: collapse;
        }

        .table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .table thead th {
            padding: 18px 15px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
            border: none;
        }

        .table tbody td {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background-color: #f5f5f5;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Badge Styling */
        .badge-new {
            display: inline-block;
            background-color: #ff6b6b;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge-read {
            display: inline-block;
            background-color: #51cf66;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }

        /* Action Buttons */
        .btn-view {
            display: inline-block;
            background-color: #667eea;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-view:hover {
            background-color: #764ba2;
            text-decoration: none;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .btn-delete {
            display: inline-block;
            background-color: #ff6b6b;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-left: 5px;
        }

        .btn-delete:hover {
            background-color: #e63946;
            text-decoration: none;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 107, 107, 0.4);
        }

        /* Message text truncation */
        .message-preview {
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            color: #666;
        }

        /* Stats Box */
        .stats-box {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .stat-card {
            flex: 1;
            min-width: 200px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #667eea;
        }

        .stat-card h4 {
            margin: 0 0 10px 0;
            color: #999;
            font-size: 12px;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .stat-card .number {
            font-size: 32px;
            font-weight: 700;
            color: #333;
        }

        .stat-card.unread {
            border-left-color: #ff6b6b;
        }

        .stat-card.read {
            border-left-color: #51cf66;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .empty-state i {
            font-size: 64px;
            color: #ccc;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            color: #999;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #bbb;
            margin: 0;
        }

        .container-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
    </style>
</head>

<body>
    <?php include 'navBar.php'; ?>

    <div class="container-content">
        <!-- Page Header -->
        <div class="page-header">
            <h1>Messages</h1>
            <p style="margin: 10px 0 0 0; opacity: 0.9;">View all messages from users and visitors</p>
        </div>

        <!-- Statistics -->
        <div class="stats-box">
            <?php
            require_once __DIR__ . '/connect.php';
            
            $totalMessages = $conn->query("SELECT COUNT(*) as count FROM messages")->fetch_assoc()['count'];
            $unreadMessages = $conn->query("SELECT COUNT(*) as count FROM messages WHERE is_read = 0")->fetch_assoc()['count'];
            $readMessages = $conn->query("SELECT COUNT(*) as count FROM messages WHERE is_read = 1")->fetch_assoc()['count'];
            ?>
            <div class="stat-card">
                <h4>Total Messages</h4>
                <div class="number"><?php echo $totalMessages; ?></div>
            </div>
            <div class="stat-card unread">
                <h4>Unread Messages</h4>
                <div class="number"><?php echo $unreadMessages; ?></div>
            </div>
            <div class="stat-card read">
                <h4>Read Messages</h4>
                <div class="number"><?php echo $readMessages; ?></div>
            </div>
        </div>

        <!-- Messages Table -->
        <div class="section-header">
            <h3>All Messages</h3>
        </div>

        <div class="table-container">
            <?php
            $result = $conn->query("SELECT * FROM messages ORDER BY created_at DESC");
            
            if($result && $result->num_rows > 0) {
                echo '<table class="table table-hover" id="messagesTable">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>From</th>';
                echo '<th>Email</th>';
                echo '<th>Subject</th>';
                echo '<th>Message</th>';
                echo '<th>Date</th>';
                echo '<th>Status</th>';
                echo '<th>Action</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                
                while($row = $result->fetch_assoc()) {
                    $id = $row['id'];
                    $userName = htmlspecialchars($row['userName']);
                    $userEmail = htmlspecialchars($row['userEmail']);
                    $subject = htmlspecialchars($row['subject']);
                    $content = htmlspecialchars($row['content']);
                    $created_at = date('M d, Y h:i A', strtotime($row['created_at']));
                    $isRead = $row['is_read'];
                    $contentPreview = strlen($content) > 50 ? substr($content, 0, 50) . '...' : $content;
                    
                    $statusBadge = $isRead == 1 ? '<span class="badge-read">Read</span>' : '<span class="badge-new">New</span>';
                    
                    echo '<tr>';
                    echo '<td><strong>' . $userName . '</strong></td>';
                    echo '<td>' . $userEmail . '</td>';
                    echo '<td><strong>' . $subject . '</strong></td>';
                    echo '<td><span class="message-preview">' . $contentPreview . '</span></td>';
                    echo '<td><small>' . $created_at . '</small></td>';
                    echo '<td>' . $statusBadge . '</td>';
                    echo '<td>';
                    echo '<a href="viewMessage.php?id=' . $id . '" class="btn-view">View</a>';
                    echo '<a href="deleteMessage.php?id=' . $id . '" class="btn-delete" onclick="return confirm(\'Are you sure?\');">Delete</a>';
                    echo '</td>';
                    echo '</tr>';
                }
                
                echo '</tbody>';
                echo '</table>';
            } else {
                echo '<div class="empty-state">';
                echo '<i class="fa fa-envelope"></i>';
                echo '<h3>No Messages</h3>';
                echo '<p>You haven\'t received any messages yet.</p>';
                echo '</div>';
            }
            
            $conn->close();
            ?>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#messagesTable').DataTable({
                "order": [[4, "desc"]],
                "pageLength": 10,
                "responsive": true
            });
        });
    </script>
</body>

</html>
