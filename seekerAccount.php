<?php include 'authorizeSeeker.php'; ?>
<?php require_once __DIR__ . '/lang.php'; ?>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="img/jobsConnect.svg" type="image/x-icon">
    <title><?php echo t('account_seeker_title'); ?></title>

    <link href="css/simpleGridTemplate.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/Animate.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="css/Animate.css" rel="stylesheet" type="text/css">
    <link href="css/animate.min.css" rel="stylesheet" type="text/css">
    
    <!-- Font Awesome for Chatbot Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

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
            font-family: Sora;
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
    include 'signinEmployerModals.php';
    ?>
    <!-- Main Container -->
    <div class="container" style="background-color: #fff; padding-top: 100px;  padding-bottom: 50px;">
        <?php
        include 'connect.php';
        if (!isset($conn) || !$conn || !($conn instanceof mysqli)) {
            die('<div class="alert alert-danger">Database connection not established. Please check connect.php.</div>');
        }
        if ($conn->connect_error) {
            die('<div class="alert alert-danger">Database connection failed: ' . htmlspecialchars($conn->connect_error) . '</div>');
        }
        $sid = $_SESSION["sid"];

        // Handle image upload
        if (isset($_POST['upload_image']) && isset($_FILES['profile_image'])) {
            $target_dir = "img/";
            $imageFileType = strtolower(pathinfo(basename($_FILES["profile_image"]["name"]), PATHINFO_EXTENSION));
            $newFileName = "seeker_" . $sid . "_" . time() . "." . $imageFileType;
            $target_file = $target_dir . $newFileName;
            $uploadOk = 1;

            $check = getimagesize($_FILES["profile_image"]["tmp_name"]);
            if ($check === false) {
                $uploadOk = 0;
                echo "<div class='alert alert-danger'>File is not an image.</div>";
            }

            // Check file size (limit: 2MB)
            if ($_FILES["profile_image"]["size"] > 2 * 1024 * 1024) {
                $uploadOk = 0;
                echo "<div class='alert alert-danger'>Sorry, your file is too large (max 2MB).</div>";
            }

            // Allow certain file formats
            if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
                $uploadOk = 0;
                echo "<div class='alert alert-danger'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</div>";
            }

            if ($uploadOk) {
                if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
                    // Update seeker profile_image in DB
                    $sqlUpdate = "UPDATE seeker SET profile_image='$newFileName' WHERE id='$sid'";
                    if ($conn->query($sqlUpdate) === TRUE) {
                        echo "<script>
                            alert('Profile image updated successfully');
                            window.location.href = 'seekerAccount.php';
                        </script>";
                        exit();
                    } else {
                        echo "<div class='alert alert-danger'>Database update failed.</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>Sorry, there was an error uploading your file.</div>";
                }
            }
        }

        $sqlE = "select * from seeker where id = '$sid' ;";
        $resultE = $conn->query($sqlE);
        // Handle professional profile updates
        if (isset($_POST['update_profile'])) {
            $linkedin_profile = $conn->real_escape_string($_POST['linkedin_profile']);
            $update_fields = ["linkedin_profile='$linkedin_profile'"];
            
            // Handle CV upload
            if (isset($_FILES['cv_file']) && $_FILES['cv_file']['size'] > 0) {
                $cv_dir = "uploads/cv/";
                if (!file_exists($cv_dir)) {
                    mkdir($cv_dir, 0777, true);
                }
                
                $cv_file = $_FILES['cv_file'];
                $cv_name = "cv_" . $sid . "_" . time() . ".pdf";
                $cv_path = $cv_dir . $cv_name;
                
                if ($cv_file['type'] === 'application/pdf' && $cv_file['size'] <= 5 * 1024 * 1024) {
                    if (move_uploaded_file($cv_file['tmp_name'], $cv_path)) {
                        $update_fields[] = "cv_file='$cv_name'";
                    }
                }
            }
            
            // Handle certificates upload
            if (isset($_FILES['certificates'])) {
                $cert_dir = "uploads/certificates/";
                if (!file_exists($cert_dir)) {
                    mkdir($cert_dir, 0777, true);
                }
                
                $uploaded_certs = [];
                foreach ($_FILES['certificates']['tmp_name'] as $key => $tmp_name) {
                    if ($_FILES['certificates']['size'][$key] > 0) {
                        $cert_name = "cert_" . $sid . "_" . time() . "_" . $key . ".pdf";
                        $cert_path = $cert_dir . $cert_name;
                        
                        if ($_FILES['certificates']['type'][$key] === 'application/pdf' && 
                            $_FILES['certificates']['size'][$key] <= 2 * 1024 * 1024) {
                            if (move_uploaded_file($tmp_name, $cert_path)) {
                                $uploaded_certs[] = $cert_name;
                            }
                        }
                    }
                }
                
                if (!empty($uploaded_certs)) {
                    $certs_json = $conn->real_escape_string(json_encode($uploaded_certs));
                    $update_fields[] = "certificates='$certs_json'";
                }
            }
            
            if (!empty($update_fields)) {
                $sql_update = "UPDATE seeker SET " . implode(", ", $update_fields) . " WHERE id='$sid'";
                if ($conn->query($sql_update) === TRUE) {
                    echo "<div class='alert alert-success'>Profile updated successfully!</div>";
                    echo "<script>window.location.href = 'seekerAccount.php';</script>";
                    exit();
                } else {
                    echo "<div class='alert alert-danger'>Error updating profile: " . $conn->error . "</div>";
                }
            }
        }

        if ($resultE->num_rows > 0) {
            // output data of each row
            if ($rowE = $resultE->fetch_assoc()) {
                $name =  $rowE["name"];
                $email =  $rowE["email"];
                $qlf =  $rowE["qualification"];
                $skills =  $rowE["skills"];
            }
        }

        ?>


        <div class="row">
                        <!-- Left Column - Profile Image -->
                        <div class="col-md-4">
                            <div class="panel panel-default" style="padding-top:10px;padding-bottom:300px;  background: #fff; border-radius: 16px; text-align: center;">
                                <img src="img/<?php echo htmlspecialchars($rowE["profile_image"] ? $rowE["profile_image"] : '1.jpg'); ?>" class="img-circle" width="150" height="150" style="object-fit:cover; margin-bottom: 20px;">
                                <form method="post" enctype="multipart/form-data">
                                    <label for="profile_image"><?php echo t('change_profile_image'); ?></label>
                                    <input type="file" name="profile_image" id="profile_image" class="form-control" accept="image/*">
                                    <input type="submit" name="upload_image" value="<?php echo t('upload_image'); ?>" class="btn btn-primary" style="margin-top: 10px;">
                                </form>
                            </div>
                        </div>

                        <!-- Right Column - User Info -->
                        <div class="col-md-8">
                            <div class="panel panel-default" style="padding-top:10px; padding-bottom:300px; background: #fff; border-radius: 16px;">
                                <h3 style="color: #333; margin-bottom: 25px;"><?php echo t('user_information'); ?></h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label style="font-size: 16px; color: #666;"><?php echo t('name_label'); ?></label>
                                            <h4 style="color: #333; margin-top: 5px;"><?php echo htmlspecialchars($name); ?></h4>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label style="font-size: 16px; color: #666;"><?php echo t('email_label'); ?></label>
                                            <h4 style="color: #333; margin-top: 5px;"><?php echo htmlspecialchars($email); ?></h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 20px;">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label style="font-size: 16px; color: #666;">Qualification</label>
                                            <h4 style="color: #333; margin-top: 5px;"><?php echo htmlspecialchars($qlf); ?></h4>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label style="font-size: 16px; color: #666;">Skills</label>
                                            <h4 style="color: #333; margin-top: 5px;"><?php echo htmlspecialchars($skills); ?></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Exam Section -->
                    <div class="row" style="margin-top: 30px;">
                        <div class="col-md-12">
                            <div class="panel panel-default" style="padding-top: 20px; padding-bottom: 3500px; background: #fff; border-radius: 16px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                                <h2 style="color: #333; margin-bottom: 10px;">🎓 Professional Certification Exams</h2>
                                <p style="color: #666; margin-bottom: 30px; font-size: 16px;">Choose a category that matches your career field and prepare for specialized assessments.</p>
                                
                                <!-- Category 1: IT, Engineering, Technical & Software -->
                                <div style="margin-bottom: 30px; padding: 20px; background: #f0f8ff; border-left: 5px solid #0066cc; border-radius: 8px;">
                                    <h3 style="color: #0066cc; margin-top: 0; margin-bottom: 15px;">💻 IT, Engineering, Technical & Software Sector</h3>
                                    <div style="margin-bottom: 15px;">
                                        <p style="color: #333; font-weight: bold; margin-bottom: 10px;">📋 Exam Format:</p>
                                        <p style="color: #666;">MCQ + Short Questions + Coding Test</p>
                                    </div>
                                    <div style="margin-bottom: 15px;">
                                        <p style="color: #333; font-weight: bold; margin-bottom: 10px;">📚 Subjects May Include:</p>
                                        <ul style="color: #666; margin-bottom: 0;">
                                            <li>Programming (C, C++, Java, Python, PHP)</li>
                                            <li>Data Structures & Algorithms</li>
                                            <li>Database (SQL, DBMS)</li>
                                            <li>Computer Networks</li>
                                            <li>Operating Systems</li>
                                            <li>Software Engineering</li>
                                            <li>Web Technologies</li>
                                            <li>ERP basics (SAP/Oracle)</li>
                                            <li>Telecom & Networking basics</li>
                                            <li>Electronics (for VLSI, Hardware)</li>
                                            <li>Mathematics, Physics</li>
                                            <li>Electrical / Mechanical basics</li>
                                            <li>Maintenance & Site Management</li>
                                        </ul>
                                    </div>
                                   
                                    <a href="examInstructions.php?exam_id=1" class="btn btn-info" style="padding: 12px 25px; font-size: 15px;">
                                        🎯 Start IT & Tech Exam
                                    </a>
                                </div>

                                <!-- Category 2: Banking, Finance & Corporate -->
                                <div style="margin-bottom: 30px; padding: 20px; background: #f0fff0; border-left: 5px solid #009900; border-radius: 8px;">
                                    <h3 style="color: #009900; margin-top: 0; margin-bottom: 15px;">🏦 Banking, Finance & Corporate Sector</h3>
                                    <div style="margin-bottom: 15px;">
                                        <p style="color: #333; font-weight: bold; margin-bottom: 10px;">📋 Exam Format:</p>
                                        <p style="color: #666;">MCQ</p>
                                    </div>
                                    <div style="margin-bottom: 15px;">
                                        <p style="color: #333; font-weight: bold; margin-bottom: 10px;">📚 Subjects Include:</p>
                                        <ul style="color: #666; margin-bottom: 0;">
                                            <li>General Banking</li>
                                            <li>Accounting Principles</li>
                                            <li>Financial Management</li>
                                            <li>Economics (Basic)</li>
                                            <li>Bangladesh Banking System</li>
                                            <li>Corporate Governance</li>
                                            <li>HR Management</li>
                                            <li>Office Management</li>
                                            <li>Corporate Planning</li>
                                            <li>Business Communication</li>
                                            <li>Organizational Behavior</li>
                                            <li>Quantitative Aptitude</li>
                                            <li>Data Interpretation</li>
                                            <li>Analytical Reasoning</li>
                                            <li>English Grammar & Comprehension</li>
                                            <li>MS Word, Excel, PowerPoint</li>
                                            <li>Email & Office Etiquette</li>
                                            <li>Basic IT Knowledge</li>
                                        </ul>
                                    </div>
                                    <a href="examInstructions.php?exam_id=2" class="btn btn-success" style="padding: 12px 25px; font-size: 15px;">
                                        🎯 Start Finance & Banking Exam
                                    </a>
                                </div>

                                <!-- Category 3: Education & Training -->
                                <div style="margin-bottom: 30px; padding: 20px; background: #fffef0; border-left: 5px solid #ff9900; border-radius: 8px;">
                                    <h3 style="color: #ff9900; margin-top: 0; margin-bottom: 15px;">📖 Education & Training Sector</h3>
                                    <div style="margin-bottom: 15px;">
                                        <p style="color: #333; font-weight: bold; margin-bottom: 10px;">📋 Exam Format:</p>
                                        <p style="color: #666;">MCQ + Short Answer</p>
                                    </div>
                                    <div style="margin-bottom: 15px;">
                                        <p style="color: #333; font-weight: bold; margin-bottom: 10px;">📚 Based On:</p>
                                        <ul style="color: #666; margin-bottom: 0;">
                                            <li>School-level subjects (Bangla, English, Math, Science)</li>
                                            <li>HSC / Degree-level subjects</li>
                                            <li>Islamic Studies / ICT</li>
                                            <li>Teaching Methodology</li>
                                            <li>Classroom Management</li>
                                            <li>Child Psychology</li>
                                            <li>Assessment & Evaluation</li>
                                            <li>Curriculum Knowledge (NCTB)</li>
                                            <li>Bangladesh Affairs</li>
                                            <li>Education Policy</li>
                                            <li>English Language Skills</li>
                                        </ul>
                                    </div>
                                    <a href="examInstructions.php?exam_id=3" class="btn btn-warning" style="padding: 12px 25px; font-size: 15px; color: #fff;">
                                        🎯 Start Education & Training Exam
                                    </a>
                                </div>

                                <!-- Category 4: General Jobs -->
                                <div style="margin-bottom: 30px; padding: 20px; background: #fff0f6; border-left: 5px solid #cc0066; border-radius: 8px;">
                                    <h3 style="color: #cc0066; margin-top: 0; margin-bottom: 15px;">🌐 General Jobs Category</h3>
                                    <p style="color: #666; font-size: 14px; margin-bottom: 15px;"><em>Sales, Marketing, Security, Hotel, Logistics, etc.</em></p>
                                    <div style="margin-bottom: 15px;">
                                        <p style="color: #333; font-weight: bold; margin-bottom: 10px;">📋 Exam Format:</p>
                                        <p style="color: #666;">MCQ</p>
                                    </div>
                                    <div style="margin-bottom: 15px;">
                                        <p style="color: #333; font-weight: bold; margin-bottom: 10px;">📚 Subjects Include:</p>
                                        <ul style="color: #666; margin-bottom: 0;">
                                            <li>Bangladesh & World Affairs</li>
                                            <li>Current Affairs</li>
                                            <li>Basic ICT</li>
                                            <li>Everyday Science</li>
                                            <li>Logical Reasoning</li>
                                            <li>Numerical Ability</li>
                                            <li>Situation-based Questions</li>
                                            <li>Sales Scenario Questions</li>
                                            <li>Customer Handling MCQs</li>
                                            <li>Safety & Security Rules</li>
                                            <li>Hospitality Etiquette</li>
                                            <li>Spoken English Basics</li>
                                            <li>Email Writing</li>
                                            <li>Comprehension</li>
                                        </ul>
                                    </div>
                                    <a href="examInstructions.php?exam_id=4" class="btn btn-danger" style="padding: 12px 25px; font-size: 15px;">
                                        🎯 Start General Jobs Exam
                                    </a>
                                </div>

                                <!-- Category 5: Coding Challenge -->
                                <div style="margin-bottom: 30px; padding: 20px; background: #f5f0ff; border-left: 5px solid #6f42c1; border-radius: 8px;">
                                    <h3 style="color: #6f42c1; margin-top: 0; margin-bottom: 15px;">⚡ Coding Challenge Exam (Advanced)</h3>
                                    <p style="color: #666; font-size: 14px; margin-bottom: 15px;"><em>For IT, Engineering & Technical roles</em></p>
                                    <div style="margin-bottom: 15px;">
                                        <p style="color: #333; font-weight: bold; margin-bottom: 10px;">📋 Exam Format:</p>
                                        <p style="color: #666;">Practical Coding Problems (Like Codeforces)</p>
                                    </div>
                                    <div style="margin-bottom: 15px;">
                                        <p style="color: #333; font-weight: bold; margin-bottom: 10px;">📝 What You'll Do:</p>
                                        <ul style="color: #666; margin-bottom: 0;">
                                            <li>Solve 5 real-world programming problems</li>
                                            <li>Write code in Python, C++, or Java</li>
                                            <li>Test your code against multiple test cases</li>
                                            <li>Get instant feedback on correctness</li>
                                            <li>Total Duration: 3 hours</li>
                                            <li>Total Points: 100 (varying difficulty levels)</li>
                                        </ul>
                                    </div>
                                    <div style="margin-bottom: 15px;">
                                        <p style="color: #333; font-weight: bold; margin-bottom: 10px;">🎯 Problem Categories:</p>
                                        <ul style="color: #666; margin-bottom: 0;">
                                            <li>Basic String/Array Manipulation</li>
                                            <li>Mathematical Algorithms</li>
                                            <li>Data Structure Operations</li>
                                            <li>Logical Problem Solving</li>
                                            <li>Complex Algorithm Implementation</li>
                                        </ul>
                                    </div>
                                    <a href="codingExamTimed.php" class="btn btn-primary" style="padding: 12px 25px; font-size: 15px; background-color: #6f42c1; border-color: #6f42c1;">
                                        💻 Start Coding Challenge Exam
                                    </a>
                                </div>

                                <!-- Exam Results Section -->
                                <div id="examResults" style="margin-top: 40px; border-top: 2px solid #ddd; padding-top: 20px;">
                                    <h4 style="color: #333; margin-bottom: 15px;">📊 Your Exam Results</h4>
                                    <div id="resultsContainer">
                                        <p style="color: #666;">Loading exam results...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Professional Profile Section -->
                    <div class="row" style="margin-top: 30px;">
                        <div class="col-md-12">
                            <div class="panel panel-default" style="padding-top:20px;padding-bottom:650px;  background: #fff; border-radius: 16px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                                <h3 style="color: #333; margin-bottom: 30px;"><?php echo t('professional_profile'); ?></h3>
                                <form method="post" enctype="multipart/form-data">
                                    
                                    <div class="form-group" style="margin-bottom: 30px;">
                                        <label for="linkedin_profile" style="font-size: 16px; margin-bottom: 10px; color: #555;"><?php echo t('linkedin_profile_label'); ?></label>
                                        <input type="url" name="linkedin_profile" id="linkedin_profile" class="form-control input-lg" 
                                            value="<?php echo htmlspecialchars($rowE['linkedin_profile'] ?? ''); ?>" 
                                            placeholder="https://www.linkedin.com/in/yourprofile"
                                            style="height: 50px; font-size: 16px;">
                                    </div>
                                    
                                    <div class="form-group" style="margin-bottom: 30px;">
                                        <label for="cv_file" style="font-size: 16px; margin-bottom: 10px; color: #555;"><?php echo t('upload_cv'); ?></label>
                                        <input type="file" name="cv_file" id="cv_file" class="form-control input-lg" accept=".pdf" style="height: 50px; padding: 10px;">
                                        <?php if(!empty($rowE['cv_file'])): ?>
                                            <div class="alert alert-info" style="margin-top: 10px;">
                                                <i class="glyphicon glyphicon-file"></i>
                                                Current CV: <?php echo htmlspecialchars($rowE['cv_file']); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="form-group" style="margin-bottom: 30px;">
                                        <label for="certificates" style="font-size: 16px; margin-bottom: 10px; color: #555;"><?php echo t('upload_certificates'); ?></label>
                                        <input type="file" name="certificates[]" id="certificates" class="form-control input-lg" accept=".pdf" multiple style="height: 50px; padding: 10px;">
                                        <?php if(!empty($rowE['certificates'])): ?>
                                            <div class="alert alert-info" style="margin-top: 10px;">
                                                <i class="glyphicon glyphicon-certificate"></i>
                                                <strong>Current Certificates:</strong>
                                                <ul style="margin-top: 10px; margin-bottom: 0;">
                                                    <?php foreach(json_decode($rowE['certificates']) as $cert): ?>
                                                        <li><?php echo htmlspecialchars($cert); ?></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <input type="submit" name="update_profile" value="<?php echo t('update_professional_profile'); ?>" 
                                        class="btn btn-primary btn-lg" 
                                        style="width: 100%; margin-top: 20px; padding: 15px; font-size: 16px;">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/tilt.jquery.min.js"></script>
    <script src="js/signinModal.js"></script>
    
    <script>
        // Fetch and display exam results
        $(document).ready(function() {
            $.ajax({
                url: 'getExamResults.php',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success && response.results.length > 0) {
                        var html = '<table class="table table-striped table-hover" style="margin-top: 15px;">';
                        html += '<thead style="background-color: #f5f5f5;">';
                        html += '<tr>';
                        html += '<th>Exam Name</th>';
                        html += '<th>Score</th>';
                        html += '<th>Percentage</th>';
                        html += '<th>Status</th>';
                        html += '<th>Date Submitted</th>';
                        html += '<th>Time Taken</th>';
                        html += '</tr>';
                        html += '</thead>';
                        html += '<tbody>';
                        
                        response.results.forEach(function(result) {
                            var statusBadgeClass = result.status === 'passed' ? 'badge-success' : (result.status === 'failed' ? 'badge-danger' : 'badge-warning');
                            var statusBadge = '<span class="badge ' + statusBadgeClass + '" style="padding: 8px 12px; font-size: 12px;">' + result.status.toUpperCase() + '</span>';
                            
                            var submittedDate = new Date(result.submitted_at).toLocaleDateString('en-US', {
                                year: 'numeric',
                                month: 'short',
                                day: 'numeric'
                            });
                            
                            var minutes = Math.floor(result.time_taken_seconds / 60);
                            var seconds = result.time_taken_seconds % 60;
                            var timeStr = minutes + 'm ' + seconds + 's';
                            
                            html += '<tr>';
                            html += '<td><strong>' + result.exam_name + '</strong></td>';
                            html += '<td><strong style="color: #007bff;">' + result.total_marks_obtained + ' / ' + result.total_marks_possible + '</strong></td>';
                            html += '<td><strong>' + parseFloat(result.percentage).toFixed(2) + '%</strong></td>';
                            html += '<td>' + statusBadge + '</td>';
                            html += '<td>' + submittedDate + '</td>';
                            if (response.results[i].is_coding) {
                                // For coding exams, show problems solved
                                var codingTimeStr = '';
                                if (response.results[i].time_taken_seconds) {
                                    var hours = Math.floor(response.results[i].time_taken_seconds / 3600);
                                    var minutes = Math.floor((response.results[i].time_taken_seconds % 3600) / 60);
                                    var seconds = response.results[i].time_taken_seconds % 60;
                                    codingTimeStr = (hours > 0 ? hours + 'h ' : '') + minutes + 'm ' + seconds + 's';
                                }
                                html += '<td>' + codingTimeStr + '</td>';
                                html += '</tr><tr style="font-size: 12px; color: #999;">';
                                html += '<td colspan="6"><small>Problems Solved: ' + response.results[i].problems_solved + ' / ' + response.results[i].total_problems + '</small></td>';
                            } else {
                                html += '<td>' + timeStr + '</td>';
                            }
                            html += '</tr>';
                        });
                        
                        html += '</tbody>';
                        html += '</table>';
                        $('#resultsContainer').html(html);
                    } else {
                        $('#resultsContainer').html('<p style="color: #666;">No exam results yet. Take the exam to see your scores.</p>');
                    }
                },
                error: function() {
                    $('#resultsContainer').html('<p style="color: #999;">Failed to load exam results.</p>');
                }
            });
        });
    </script>
</body>
</html>
                                </form>
                            </div>
                            </div>
                        </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--first row -->

    <script src="js/tilt.jquery.min.js"></script>
    <script src="js/signinModal.js"></script>

    <!-- Chatbot Widget -->
    <?php include 'chatbot_widget.php'; ?>
</body>

</html>