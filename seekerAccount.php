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
</body>

</html>