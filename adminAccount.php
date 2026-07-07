<?php include 'authorizeAdmin.php'; ?>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="img/jobsConnect.svg" type="image/x-icon">
    <title> Account | Admin</title>

    <link href="css/simpleGridTemplate.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/Animate.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
    <link href="css/Animate.css" rel="stylesheet" type="text/css">
    <link href="css/animate.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css">
    
    <!-- Font Awesome for Chatbot Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

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

        /* Profile Header Section */
        .profile-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 50px;
            border-radius: 10px;
            margin-top: 60px;
            margin-bottom: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .profile-content {
            display: flex;
            align-items: center;
            gap: 50px;
            flex-wrap: wrap;
        }

        .profile-image-container {
            flex-shrink: 0;
        }

        .profile-image {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            border: 5px solid white;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-15px);
            }
        }

        .profile-info {
            flex: 1;
            min-width: 250px;
        }

        .profile-field {
            margin-bottom: 25px;
        }

        .profile-field-label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.9;
            margin-bottom: 5px;
        }

        .profile-field-value {
            font-size: 28px;
            font-weight: 700;
            word-break: break-word;
        }

        /* Section Headers */
        .section-header {
            display: flex;
            align-items: center;
            margin-top: 50px;
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
            overflow-y: auto;
            max-height: 500px;
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

        .table tbody tr {
            border-bottom: 1px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background-color: #f8f9ff;
            box-shadow: inset 0 1px 3px rgba(102, 126, 234, 0.1);
        }

        .table tbody td {
            padding: 15px;
            vertical-align: middle;
            color: #333;
        }

        .table tbody tr:last-child {
            border-bottom: none;
        }

        /* Badge Styling */
        .badge {
            padding: 8px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-success {
            background-color: #28a745 !important;
            color: white;
        }

        .badge-danger {
            background-color: #dc3545 !important;
            color: white;
        }

        .badge-info {
            background-color: #17a2b8 !important;
            color: white;
        }

        /* Button Styling */
        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
            font-weight: 600;
            border-radius: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-success {
            background-color: #28a745;
            color: white;
        }

        .btn-success:hover {
            background-color: #218838;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
            margin-left: 5px;
            display: inline-block;
            padding: 6px 12px;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn-danger:hover {
            background-color: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
            color: white;
            text-decoration: none;
        }

        .btn-danger:visited {
            color: white;
        }

        .btn-danger:focus {
            color: white;
            text-decoration: none;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #999;
        }

        /* Divider */
        .divider {
            margin: 60px 0;
            border: none;
            height: 2px;
            background: linear-gradient(to right, transparent, #ddd, transparent);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .profile-content {
                flex-direction: column;
                text-align: center;
            }

            .profile-image {
                width: 150px;
                height: 150px;
            }

            .profile-field-value {
                font-size: 20px;
            }

            .profile-header {
                padding: 30px;
            }

            .section-header h3 {
                font-size: 18px;
            }

            .table-container {
                overflow-x: auto;
            }

            .btn-sm {
                padding: 4px 8px;
                font-size: 11px;
            }
        }

        /* Container Styling */
        .main-container {
            background-color: #f8f9fa;
            padding: 30px 50px;
        }

        @media (max-width: 768px) {
            .main-container {
                padding: 20px;
            }
        }
    </style>

<body onload="logoBeat()" style="font-family: 'Sora', sans-serif;">

    <?php
    include 'navBar.php';

    ?>
    <!-- Main Container -->
    <div class="main-container">
        <?php
        include 'connect.php';

        $sqlA = "select * from admin where id = '$aid' ;";

        $resultA = $conn->query($sqlA);
        if ($resultA->num_rows > 0) {
            if ($rowA = $resultA->fetch_assoc()) {
                $name =  $rowA["name"];
                $email =  $rowA["email"];
                $fileName = $rowA["logo"];
            }
        }
        ?>

        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-content">
                <div class="profile-image-container">
                    <img src="img/2.png" class="profile-image" alt="Admin Profile">
                </div>
                <div class="profile-info">
                    <div class="profile-field">
                        <div class="profile-field-label">User Name</div>
                        <div class="profile-field-value"><?php echo htmlspecialchars($name); ?></div>
                    </div>
                    <div class="profile-field">
                        <div class="profile-field-label">Email Address</div>
                        <div class="profile-field-value"><?php echo htmlspecialchars($email); ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Payments Section -->
        <div class="section-header">
            <h3>Pending Payment Confirmations</h3>
        </div>
        <div class="table-container">
            <table class="table table-hover" id='paymentTable'>
                <thead>
                    <tr>
                        <th>Post ID</th>
                        <th>Employer</th>
                        <th>Job Title</th>
                        <th>Job Type</th>
                        <th>Amount (Taka)</th>
                        <th>Payment Status</th>
                        <th>Transaction ID</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT jp.id as jp_id, p.id as post_id, p.name as job_title, jp.job_type, jp.amount, p.eid, 
                                   e.name as employer_name, pay.transaction_id, jp.payment_status, jp.admin_status
                            FROM job_payments jp
                            JOIN payments pay ON jp.payment_id = pay.id
                            JOIN post p ON jp.pid = p.id
                            JOIN employer e ON jp.eid = e.id
                            WHERE jp.payment_status = 'confirmed' AND jp.admin_status = 'pending'
                            ORDER BY jp.created_date DESC";
                    $result = $conn->query($sql);
                    
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $jp_id = $row['jp_id'];
                            $post_id = $row['post_id'];
                            $job_title = $row['job_title'];
                            $job_type = $row['job_type'] === 'blue_collar' ? 'Blue Collar' : 'White Collar';
                            $amount = $row['amount'];
                            $employer_name = $row['employer_name'];
                            $transaction_id = $row['transaction_id'];
                            $payment_status = $row['payment_status'];
                    ?>
                        <tr>
                            <td><?php echo $post_id; ?></td>
                            <td><?php echo htmlspecialchars($employer_name); ?></td>
                            <td><?php echo htmlspecialchars($job_title); ?></td>
                            <td><span class="badge" style="background-color: <?php echo $row['job_type'] === 'blue_collar' ? '#ff6b6b' : '#4ecdc4'; ?>;"><?php echo $job_type; ?></span></td>
                            <td><strong><?php echo $amount; ?> ৳</strong></td>
                            <td><span class="badge badge-success">Confirmed</span></td>
                            <td><code><?php echo htmlspecialchars(substr($transaction_id, 0, 15)) . '...'; ?></code></td>
                            <td>
                                <a href="admin_confirm_payment.php?action=accept&jp_id=<?php echo $jp_id; ?>&post_id=<?php echo $post_id; ?>" 
                                   class="btn btn-sm btn-success" title="Accept Payment">
                                    <span class="glyphicon glyphicon-ok"></span> Accept
                                </a>
                                <a href="admin_confirm_payment.php?action=reject&jp_id=<?php echo $jp_id; ?>&post_id=<?php echo $post_id; ?>" 
                                   class="btn btn-sm btn-danger" title="Reject Payment">
                                    <span class="glyphicon glyphicon-remove"></span> Reject
                                </a>
                            </td>
                        </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='8' class='empty-state'>No pending payments for confirmation</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <hr class="divider">

        <!-- Posted Jobs Section -->
        <div class="section-header">
            <h3>All Posted Jobs</h3>
        </div>
        <div class="table-container">
            <table class="table table-hover" id='postTable'>
                <thead>
                    <tr>
                        <th>Post ID</th>
                        <th>Employer</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Min Experience</th>
                        <th>Salary</th>
                        <th>Status</th>
                        <th>Payment Status</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT p.*, e.name as employer_name FROM post p LEFT JOIN employer e ON p.eid = e.id ORDER BY p.id DESC";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $id = $row['id'];
                            $employer_name = $row['employer_name'];
                            $title = $row['name'];
                            $category = $row['category'];
                            $minexp = $row['minexp'];
                            $salary = $row['salary'];
                            $industry = $row['industry'];
                            $desc = $row['desc'];
                            $role = $row['role'];
                            $status = $row['status'];
                            $payment_status = isset($row['payment_status']) ? $row['payment_status'] : 'unpaid';
                    ?>
                        <tr>
                            <td><?php echo $id; ?></td>
                            <td><?php echo htmlspecialchars($employer_name); ?></td>
                            <td><strong><?php echo htmlspecialchars($title); ?></strong></td>
                            <td><small><?php echo htmlspecialchars(substr($desc, 0, 35)) . (strlen($desc) > 35 ? '...' : ''); ?></small></td>
                            <td><?php echo $minexp; ?></td>
                            <td><?php echo htmlspecialchars($salary); ?></td>
                            <td><span class="badge badge-info"><?php echo ucfirst($status); ?></span></td>
                            <td>
                                <?php if ($payment_status === 'confirmed'): ?>
                                    <span class="badge badge-success">Paid</span>
                                <?php else: ?>
                                    <span class="badge badge-danger">Unpaid</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="deletePost.php?id=<?php echo $id; ?>" class="btn btn-sm btn-danger" title="Delete Post" onclick="return confirm('Are you sure you want to delete this post? This action cannot be undone.');"> 
                                    <span class="glyphicon glyphicon-trash"></span> Delete
                                </a>
                            </td>
                        </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        </div>
    </div>

    <script src="js/tilt.jquery.min.js"></script>
    <script src="js/signinModal.js"></script>
    <script>
        $(document).ready(function() {
            $('#paymentTable').DataTable({
                "order": [[0, "desc"]],
                "pageLength": 10,
                "responsive": true
            });
            $('#postTable').DataTable({
                "order": [[0, "desc"]],
                "pageLength": 15,
                "responsive": true
            });
        });
    </script>

    <!-- Chatbot Widget -->
    <?php include 'chatbot_widget.php'; ?>
</body>

</html>