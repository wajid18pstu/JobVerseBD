<?php include 'authorizeEmployer.php'; ?>
<html>

<head>


    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="img/jobsConnect.svg" type="image/x-icon">
    <title> View Applicants | Employer</title>

    <link href="css/simpleGridTemplate.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/Animate.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
    <link href="css/Animate.css" rel="stylesheet" type="text/css">
    <link href="css/animate.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Kodchasan" rel="stylesheet">
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
    <div class="container-fluid" style="background-color: #ffffffff; padding-left: 50px; padding-right: 50px;">
        <?php
        include 'connect.php';

        $sql = "select * from employer where id = '$eid' ;";



        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row
            if ($row = $result->fetch_assoc()) {
                $name =  $row["name"];
                $email =  $row["email"];
            }
        }

        ?>


        <div class="hero">


            <div style="width: 100%; padding-left: 50px; padding-right: 50px; " class="row">

                <div class="col">
                    <div class="col-md-6" style="padding-top:0px;">
                        <img src="img/3.png" class=" pc" width="300" style="margin: 20%;">
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

                <div style=" height: 100vh; padding-top: 0px; " class="col-md-12">
                    <div>
                        <h3 style=" padding-bottom: 30px;">Applications Received:</h3>
                    </div>
                    <table class="table table-hover table-responsive table-striped" id='jobappliedTable'>
                        <thead>
                            <th>Post Id</th>
                            <th>Applicant's Name</th>
                            <th>Date Applied</th>
                            <th>Job Title</th>
                            <th>Applicant's Skills</th>
                            <th>Professional Profile</th>
                            <th>Application Status</th>
                            <th>Actions</th>
                        </thead>
                        <tbody>

                            <?php
                            $sql = "select id,sid,pid,(select name from seeker where id=j.sid)as sname,date,"
                                . "(select name from post where id=j.pid)as title,"
                                . "(select skills from seeker where id=j.sid)as skills,"
                                . "(select linkedin_profile from seeker where id=j.sid)as linkedin_profile,"
                                . "(select cv_file from seeker where id=j.sid)as cv_file,"
                                . "(select certificates from seeker where id=j.sid)as certificates,"
                                . "status from jobsapplied j where pid in (select id from post where eid=$eid);";

                            $appresult = $conn->query($sql);
                            // DEBUG: Check query results
                            // echo "<!-- DEBUG: Query returned " . $appresult->num_rows . " rows -->";
                            
                            if ($appresult->num_rows > 0) {
                                // output data of each row
                                while ($row = $appresult->fetch_assoc()) {
                                    $id = $row['id'];  //application id
                                    $pid = $row['pid'];
                                    $sname = $row['sname'];
                                    $title = $row['title'];
                                    $date = $row['date'];
                                    $skills = $row['skills'];
                                    $status = $row['status'];
                                    $resume = $row['resume'] ?? '';  // Set default empty string if not in query

                            ?>
                                    <tr>
                                        <td><?php echo $pid; ?></td>
                                        <td><?php echo $sname; ?></td>
                                        <td><?php echo $date; ?></td>
                                        <td><?php echo $title; ?></td>
                                        <td><?php echo $skills; ?></td>
                                        <td>
                                            <?php 
                                            $linkedin = $row['linkedin_profile'];
                                            $cv = $row['cv_file'];
                                            $certs = json_decode($row['certificates'], true);
                                            
                                            if (!empty($linkedin)) {
                                                echo "<a href='" . htmlspecialchars($linkedin) . "' target='_blank' class='btn btn-sm btn-primary'>LinkedIn</a> ";
                                            }
                                            if (!empty($cv)) {
                                                echo "<a href='uploads/cv/" . htmlspecialchars($cv) . "' target='_blank' class='btn btn-sm btn-success'>View CV</a> ";
                                            }
                                            if (!empty($certs)) {
                                                echo "<div class='dropdown' style='display: inline-block;'>";
                                                echo "<button class='btn btn-sm btn-info dropdown-toggle' type='button' data-toggle='dropdown'>Certificates";
                                                echo "<span class='caret'></span></button>";
                                                echo "<ul class='dropdown-menu'>";
                                                foreach ($certs as $cert) {
                                                    echo "<li><a href='uploads/certificates/" . htmlspecialchars($cert) . "' target='_blank'>" . htmlspecialchars($cert) . "</a></li>";
                                                }
                                                echo "</ul>";
                                                echo "</div>";
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $status; ?></td>
                                        <td>
                                            <?php
                                            $sid = $row['sid'];
                                            $sql_seeker = "SELECT email FROM seeker WHERE id = $sid";
                                            $seeker_result = $conn->query($sql_seeker);
                                            $seeker_email = $seeker_result->fetch_assoc()['email'];
                                            ?>
                                            <button class="btn btn-success btn-sm send-default-email" 
                                                data-email="<?php echo htmlspecialchars($seeker_email); ?>"
                                                data-name="<?php echo htmlspecialchars($sname); ?>"
                                                data-job="<?php echo htmlspecialchars($title); ?>">
                                                Send Interview Email
                                            </button>
                                            <button class="btn btn-primary btn-sm send-custom-email" 
                                                data-email="<?php echo htmlspecialchars($seeker_email); ?>"
                                                data-name="<?php echo htmlspecialchars($sname); ?>"
                                                data-job="<?php echo htmlspecialchars($title); ?>">
                                                Custom Email
                                            </button>
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
    <!-- Custom Email Modal -->
    <div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="emailModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="emailModalLabel">Send Custom Email</h4>
                </div>
                <div class="modal-body">
                    <form id="emailForm">
                        <div class="form-group">
                            <label for="emailSubject">Subject:</label>
                            <input type="text" class="form-control" id="emailSubject" required>
                        </div>
                        <div class="form-group">
                            <label for="emailMessage">Message:</label>
                            <textarea class="form-control" id="emailMessage" rows="6" required></textarea>
                        </div>
                        <input type="hidden" id="toEmail">
                        <input type="hidden" id="applicantName">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="sendCustomEmail">Send Email</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#jobappliedTable').DataTable();

            // Clear modal form when closed
            $('#emailModal').on('hidden.bs.modal', function () {
                $('#emailForm')[0].reset();
            });

            // Handle default email button click
            $('.send-default-email').click(function() {
                var email = $(this).data('email');
                var name = $(this).data('name');
                var job = $(this).data('job');

                $.ajax({
                    url: 'sendEmail.php',
                    method: 'POST',
                    data: {
                        send_default_email: true,
                        to_email: email,
                        applicant_name: name,
                        job_title: job
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            alert('Interview invitation email sent successfully!');
                        } else {
                            alert('Error sending email: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Ajax error:', error);
                        alert('Error sending email. Please try again.');
                    }
                });
            });

            // Handle custom email button click
            $(document).on('click', '.send-custom-email', function() {
                var email = $(this).data('email');
                var name = $(this).data('name');
                var job = $(this).data('job');
                
                // Set the values in the modal
                $('#toEmail').val(email);
                $('#applicantName').val(name);
                
                // Show the modal
                $('#emailModal').modal('show');
            });

            // Handle custom email send
            $('#sendCustomEmail').click(function(e) {
                e.preventDefault();
                
                var subject = $('#emailSubject').val();
                var message = $('#emailMessage').val();
                var email = $('#toEmail').val();
                var name = $('#applicantName').val();

                if (!subject || !message) {
                    alert('Please fill in all fields');
                    return;
                }

                $.ajax({
                    url: 'sendEmail.php',
                    method: 'POST',
                    data: {
                        send_email: true,
                        to_email: email,
                        subject: subject,
                        message: message,
                        applicant_name: name
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('#emailModal').modal('hide');
                        if (response.status === 'success') {
                            alert('Email sent successfully!');
                            $('#emailForm')[0].reset();
                        } else {
                            alert('Error sending email: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Ajax error:', error);
                        $('#emailModal').modal('hide');
                        alert('Error sending email. Please try again.');
                    }
                });
            });
        });
    </script>
</body>

</html>