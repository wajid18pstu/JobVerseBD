<?php include 'authorizeSeeker.php'; ?>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="img/jobsConnect.svg" type="image/x-icon">
    <title> Account | Job Seeker</title>

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
    <div class="container-fluid" style="background-color: #ffffffff;">
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


        <div class="hero">
            <div style="width: 100%; padding-left: 50px; padding-right: 50px;" class="row">
                <div class="col">
                    <div class="row" style="padding-top:100px; display: flex; align-items: center; min-height:320px;">
                        <div class="col-md-5" style="text-align:center;">
                            <div class="panel panel-default" style="padding: 40px 20px;  background: #fff; border-radius: 16px; min-height: 300px;">
                                <img src="img/<?php echo htmlspecialchars($rowE["profile_image"] ? $rowE["profile_image"] : '1.jpg'); ?>" class="img-circle pc" width="120" height="120" style="object-fit:cover; margin-bottom: 20px;">
                                <form method="post" enctype="multipart/form-data">
                                    <label for="profile_image">Change Profile Image</label>
                                    <input type="file" name="profile_image" id="profile_image" accept="image/*" required class="form-control" style="margin-bottom:15px;">
                                    <button type="submit" name="upload_image" class="btn btn-primary btn-md">Upload</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-7" style="padding-left:90px;">
                            <div class="panel panel-default" style="padding: 10px 40px; background: #fff; border-radius: 16px; min-height: 300px; display: flex; flex-direction: column; justify-content: center;">
                                <h3 style="margin-bottom: 10px;">User Name</h3>
                    <h4><?php echo $name; ?></h4>
                    <br><br>
                    <h2>Email</h2>
                    <h4><?php echo $email; ?></h4>
                    <br><br>
                    <h2>Qualification</h2>
                    <h4><?php echo $qlf; ?></h4>
                    <br><br>
                    <h2>Skills</h2>
                    <h4><?php echo $skills; ?></h4>
                    <br><br>
                </div>
            </div>
        </div>
    </div>

    <!--first row -->

    <script src="js/tilt.jquery.min.js"></script>
    <script src="js/signinModal.js"></script>
</body>

</html>