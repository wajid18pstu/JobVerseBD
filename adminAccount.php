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

    <!--FONTS-->
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@200&display=swap" rel="stylesheet">
    <style>
        .tiltContain {
            margin-top: 0%;
        }

        .btnTilt {
            height: 75px;
            background: rgba(225, 225, 225, 0.2);
            color: white;
            font-family: Comfortaa;
        }

        .textDarkShadow {
            text-shadow: 0px 0px 3px #000, 3px 3px 5px #003333;
        }

        .pc {
            animation-name: pc;
            animation-duration: 3s;
            animation-iteration-count: infinite;
            animation-timing-function: ease-in-out;
            margin-left: 30px;
            margin-top: 5px;
        }

        @keyframes pc {
            0% {
                transform: translate(0, 0px);
            }

            50% {
                transform: translate(0, 15px);
            }

            100% {
                transform: translate(0, -0px);
            }
        }
    </style>

<body onload="logoBeat()" style="font-family: 'Sora', sans-serif;">

    <?php
    include 'navBar.php';

    ?>
    <!-- Main Container -->
    <div class="container-fluid" style="background-color: #d6d6d6ff; padding-right: 50px; padding-left: 50px;">
        <?php
        include 'connect.php';

        $sqlA = "select * from admin where id = '$aid' ;";



        $resultA = $conn->query($sqlA);
        if ($resultA->num_rows > 0) {
            // output data of each row
            if ($rowA = $resultA->fetch_assoc()) {
                $name =  $rowA["name"];
                $email =  $rowA["email"];
                $fileName = $rowA["logo"];
            }
        }

        ?>


        <div class="hero">
            <div style="width: 100%; padding-left: 50px; padding-right: 50px; " class="row">
                <div class="col">
                    <div class="col-md-6" style="padding-top:50px;">
                        <img src="img/2.png" class="img-circle pc" width="200" style="margin: 20%; box-shadow: 0px 0px 20px #1e1e1e;">
                    </div>
                    <div style="padding-left: 500px; padding-top: 90px;">

                        <div>
                            <h4 style="margin-top:100px;">User Name</h4>
                            <h3><b><?php echo $name; ?></b></h3>
                        </div>

                        <div style="padding-top: 30px;">
                            <h4>Email</h4>
                            <h3><strong><?php echo $email; ?></strong></h3>
                        </div>

                    </div>
                </div>

                <div style=" height: 100vh; margin-top:0px;" class="col-md-12">
                    <div>
                        <h3 style="padding-bottom:30px;">Pending Payment Confirmations:</h3>
                    </div>
                    <table class="table table-hover table-responsive table-striped" id='paymentTable'>
                        <thead>
                            <th>Post ID</th>
                            <th>Employer</th>
                            <th>Job Title</th>
                            <th>Job Type</th>
                            <th>Amount (Taka)</th>
                            <th>Payment Status</th>
                            <th>Transaction ID</th>
                            <th>Actions</th>
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
                                        <td><?php echo $amount; ?> ৳</td>
                                        <td><span class="badge" style="background-color: #28a745;">Confirmed</span></td>
                                        <td><?php echo htmlspecialchars(substr($transaction_id, 0, 15)) . '...'; ?></td>
                                        <td>
                                            <a href="admin_confirm_payment.php?action=accept&jp_id=<?php echo $jp_id; ?>&post_id=<?php echo $post_id; ?>" 
                                               class="btn btn-success btn-sm" title="Accept Payment">
                                                <span class="glyphicon glyphicon-ok"></span> Accept
                                            </a>
                                            <a href="admin_confirm_payment.php?action=reject&jp_id=<?php echo $jp_id; ?>&post_id=<?php echo $post_id; ?>" 
                                               class="btn btn-danger btn-sm" title="Reject Payment">
                                                <span class="glyphicon glyphicon-remove"></span> Reject
                                            </a>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='8' style='text-align: center; color: #999;'>No pending payments for confirmation</td></tr>";
                            }
                            ?>

                        </tbody>
                    </table>
                    
                    <hr style="margin-top: 50px; margin-bottom: 50px;">

                    <div>
                        <h3 style="padding-bottom:30px;">All Posted Jobs:</h3>
                    </div>
                    <table class="table table-hover table-responsive table-striped" id='postTable'>
                        <thead>
                            <th>Post Id</th>
                            <th>Employer</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Min Experience</th>
                            <th>Salary</th>
                            <th>Status</th>
                            <th>Payment Status</th>
                            <th>Delete</th>
                        </thead>
                        <tbody>

                            <?php
                            $sql = "SELECT p.*, e.name as employer_name FROM post p LEFT JOIN employer e ON p.eid = e.id ORDER BY p.id DESC";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                // output data of each row
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
                                        <td><?php echo htmlspecialchars($title); ?></td>
                                        <td><?php echo htmlspecialchars(substr($desc, 0, 30)) . '...'; ?></td>
                                        <td><?php echo $minexp; ?></td>
                                        <td><?php echo $salary; ?></td>
                                        <td><?php echo $status; ?></td>
                                        <td>
                                            <?php if ($payment_status === 'confirmed'): ?>
                                                <span class="badge" style="background-color: #28a745;">Paid</span>
                                            <?php else: ?>
                                                <span class="badge" style="background-color: #dc3545;">Unpaid</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="deletePost.php?id=<?php echo $id; ?>"> <span class="glyphicon glyphicon-trash"></span></a>
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

    </div>


    <!--first row -->

    <script src="js/tilt.jquery.min.js"></script>
    <script src="js/signinModal.js"></script>
    <script>
        $(document).ready(function() {
            $('#paymentTable').DataTable({
                "order": [[0, "desc"]],
                "pageLength": 10
            });
            $('#postTable').DataTable({
                "order": [[0, "desc"]],
                "pageLength": 15
            });
        });
    </script>
</body>

</html>