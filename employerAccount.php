<?php include 'authorizeEmployer.php'; ?>
<?php require_once __DIR__ . '/lang.php'; ?>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="img/jobsConnect.svg" type="image/x-icon">
    <title><?php echo t('account_employer_title'); ?></title>

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


    <div class="container-fluid" style="background-color: #ecececff; padding-right: 50px; padding-left: 50px;">
        <?php
        include 'connect.php';
        if (!isset($conn) || !$conn || !($conn instanceof mysqli)) {
            die('<div class="alert alert-danger">Database connection not established. Please check connect.php.</div>');
        }
        if ($conn->connect_error) {
            die('<div class="alert alert-danger">Database connection failed: ' . htmlspecialchars($conn->connect_error) . '</div>');
        }
        // Ensure $eid is set from session if not already
        if (!isset($eid)) {
            session_start();
            if (isset($_SESSION['eid'])) {
                $eid = $_SESSION['eid'];
            } else {
                die('<div class="alert alert-danger">Employer ID not found in session.</div>');
            }
        }
        // Handle image upload
        if (isset($_POST['upload_image']) && isset($_FILES['profile_image'])) {
            // DEBUG: Output state before query
            echo '<pre style="background:#fff;color:#000;padding:10px;">';
            echo 'DEBUG: $conn type: ' . (is_object($conn) ? get_class($conn) : gettype($conn)) . "\n";
            echo 'DEBUG: $eid: ' . (isset($eid) ? $eid : 'NOT SET') . "\n";
            echo '</pre>';
            $target_dir = "img/";
            $imageFileType = strtolower(pathinfo(basename($_FILES["profile_image"]["name"]), PATHINFO_EXTENSION));
            $newFileName = "employer_" . $eid . "_" . time() . "." . $imageFileType;
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
                    // Update employer logo in DB
                    $sqlUpdate = "UPDATE employer SET logo='$newFileName' WHERE id='$eid'";
                    if ($conn->query($sqlUpdate) === TRUE) {
                        $fileName = $newFileName;
                        echo "<script>
                            alert('Profile image updated successfully');
                            window.location.href = 'employerAccount.php';
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

        $sqlE = "select * from employer where id = '$eid' ;";



        $resultE = $conn->query($sqlE);
        if ($resultE->num_rows > 0) {
            // output data of each row
            if ($rowE = $resultE->fetch_assoc()) {
                $name =  $rowE["name"];
                $email =  $rowE["email"];
                $fileName = $rowE["logo"];
            }
        }

        ?>


        <div class="hero">
            <div style="width: 100%; padding-left: 50px; padding-right: 50px; " class="row">

                <div class="col">
                    <div class="row" style="padding-top:100px; display: flex; align-items: center; min-height:320px;">
                        <div class="col-md-5" style="text-align:center;">
                            <div class="panel panel-default" style="padding: 40px 20px;  background: #fff; border-radius: 16px; min-height: 300px;">
                                <img src="img/<?php echo htmlspecialchars($fileName ? $fileName : '2.jpg'); ?>" class="img-circle pc" width="120" height="120" style="object-fit:cover; margin-bottom: 20px;">
                                <form method="post" enctype="multipart/form-data">
                                    <label for="profile_image"><?php echo t('change_profile_image'); ?></label>
                                    <input type="file" name="profile_image" id="profile_image" accept="image/*" required class="form-control" style="margin-bottom:15px;">
                                    <button type="submit" name="upload_image" class="btn btn-primary btn-md"><?php echo t('upload'); ?></button>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-7" style="padding-left:90px;">
                            <div class="panel panel-default" style="padding: 10px 40px; background: #fff; border-radius: 16px; min-height: 300px; display: flex; flex-direction: column; justify-content: center;">
                                <h3 style="margin-bottom: 10px;"><?php echo t('user_name'); ?> :</h3>
                                <h2 style="margin-bottom: 10px;"><b><?php echo htmlspecialchars($name); ?></b></h2>
                                <div>
                                    <h3><?php echo t('email_label'); ?> :</h3>
                                    <h2><strong><?php echo htmlspecialchars($email); ?></strong></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div style=" height: 100vh; margin-top:0px;" class="col-md-12">
                    <div>
                            <h3 style="padding-bottom:30px;"><?php echo t('jobs_posted'); ?></h3>
                        </div>
                    <table class="table table-hover table-responsive table-striped" id='postTable'>
                        <thead>
                                <th><?php echo t('post_id'); ?></th>
                                <th><?php echo t('job_title'); ?></th>
                                <th><?php echo t('job_description'); ?></th>
                                <th><?php echo t('min_experience'); ?></th>
                                <th><?php echo t('salary'); ?></th>
                                <th><?php echo t('status'); ?></th>
                                <th><?php echo t('update'); ?></th>
                                <th><?php echo t('delete'); ?></th>
                        </thead>
                        <tbody>

                            <?php
                            $sql = "select * from post where eid=$eid";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                // output data of each row
                                while ($row = $result->fetch_assoc()) {
                                    $id = $row['id'];
                                    $title = $row['name'];
                                    $category = $row['category'];
                                    $minexp = $row['minexp'];
                                    $salary = $row['salary'];
                                    $industry = $row['industry'];
                                    $desc = $row['desc'];
                                    $role = $row['role'];

                                    $status = $row['status'];

                            ?>
                                    <tr>
                                        <td><?php echo $id; ?></td>
                                        <td><?php echo $title; ?></td>
                                        <td><?php echo $desc; ?></td>
                                        <td><?php echo $minexp; ?></td>
                                        <td><?php echo $salary; ?></td>
                                        <td><?php echo $status; ?></td>
                                        <td>
                                            <a href="postjob.php?update=true&id=<?php echo $id; ?>"> <span class="glyphicon glyphicon-pencil"></span></a>
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
            $('#postTable').DataTable();
        });
    </script>
</body>

</html>