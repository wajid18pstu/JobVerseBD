<?php


// Create connection

include 'authorizeEmployer.php';
$id = 0;
$name = $category = $minexp = $salary = $industry = $desc = $role = $eType = $status = $msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET') {
    include 'connect.php';
    if (isset($_GET['update']) && isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "select * from post where eid=$eid and id=$id";
        $result = $conn->query($sql);
        if ($row = $result->fetch_assoc()) {
            $name = $row['name'];
            $category = $row['category'];
            $minexp = $row['minexp'];
            $salary = $row['salary'];
            $industry = $row['industry'];
            $desc = $row['desc'];
            $role = $row['role'];
            $eType = $row['eType'];
            $status = $row['status'];
        }
    }

    if (isset($_POST['submitPost'])) {

        $id = $_POST['id'];
        $name = $_POST['name'];
        
        // Determine category based on job type
        if (isset($_POST['blueCollarCategory']) && $_POST['blueCollarCategory'] !== '') {
            if ($_POST['blueCollarCategory'] === 'Other' && isset($_POST['customCategory'])) {
                $category = $_POST['customCategory'];
            } else {
                $category = $_POST['blueCollarCategory'];
            }
        } elseif (isset($_POST['whitCollarCategory']) && $_POST['whitCollarCategory'] !== '') {
            $category = $_POST['whitCollarCategory'];
        } else {
            $category = $_POST['category'];
        }
        
        $minexp = $_POST['minexp'];
        $salary = $_POST['salary'];
        $industry = $_POST['industry'];
        $desc = $_POST['desc'];
        $role = $_POST['role'];
        $eType = $_POST['eType'];
        $status = $_POST['status'];

        if ($id > 0) {
            $sql = "Update `post` set `date`=CURRENT_DATE(),"
                . "`name`='$name', "
                . "`category`='$category', "
                . "`minexp`='$minexp', "
                . "`desc`='$desc', "
                . "`salary`='$salary', "
                . "`industry`='$industry', "
                . "`role`='$role', "
                . "`employmentType`='$eType', "
                . "`status`= '$status' "
                . "where id=$id and eid=$eid;";
        } else {
            $sql = "INSERT INTO `post` (`id`, `date`, `eid`, `name`, `category`, `minexp`, `desc`, `salary`, `industry`, `role`, `employmentType`, `status`) "
                . "VALUES (NULL, CURRENT_DATE(), '$eid', '$name', '$category', '$minexp', '$desc', '$salary', '$industry', '$role', '$eType', '$status');";
        }

        if ($conn->query($sql) === TRUE) {
            if ($_GET['update']) {
                header('location: employerAccount.php');
            } else {
                $msg = "New Post has been created successfully";
            }
        } else {
            $msg = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>


<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="img/jobsConnect.svg" type="image/x-icon">
    <title> Post A Job | Employer</title>

    <link href="css/simpleGridTemplate.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/Animate.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="css/Animate.css" rel="stylesheet" type="text/css">
    <link href="css/animate.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Kodchasan" rel="stylesheet">
    <!--FONTS-->
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@200&display=swap" rel="stylesheet">


    <style>
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

        .pstjb {
            width: 400px;
        }

        .bbb {
            padding-top: 30px;
        }
    </style>

<body onload="logoBeat()" style="font-family: 'Sora', sans-serif;">

    <?php
    include 'navBar.php';

    ?>
    <!-- Main Container -->
    <div class="container-fluid" style="background-color: #ffffffff;">
        <!--background-image: url('img/4.png');-->
        <?php
        include 'connect.php';
        $eid = $_SESSION["eid"];
        $sqlE = "select * from employer where id = '$eid' ;";



        $resultE = $conn->query($sqlE);
        if ($resultE->num_rows > 0) {
            // output data of each row
            if ($rowE = $resultE->fetch_assoc()) {
                $ename =  $rowE["name"];
                $email =  $rowE["email"];
            }
        }


        ?>


        <div class="hero">

            <h3 class="pc" style="padding-top: 120px; font-size: 90px; text-align: center;"><b><?php echo t('post_job_heading'); ?></b></h3>

            <div class="container contact-form" style=" background-color: #cececeff; width: 700px;border-radius: 20px; height: 1100px; box-shadow: 0px 0px 25px #000000ff; 
                 align-items: center; justify-content: center; display: flex; padding: 0px; ">
                <form method="post">

                    <div class="row">

                        <div class="col">


                            <input type='hidden' value="<?php echo $id; ?>" name='id' />

                            <div class="form-group">
                                <label for="name"><?php echo t('job_title_label'); ?></label>
                                <input type="text" name="name" class="form-control" style="border-radius:0px; height: 50px;" placeholder="<?php echo t('enter_job_title'); ?>" value="<?php echo $name; ?>" />
                            </div>

                            <div class="form-group">
                                <label for="category"><?php echo t('job_category_label'); ?></label>
                                <select type="text" name="category" id="categorySelect" class="form-control" style="border-radius:0px; height: 50px;" placeholder="Category" onchange="handleCategoryChange()">
                                    <option value="">- Select Category -</option>
                                    <option value="white_collar">White Collar Jobs</option>
                                    <option value="blue_collar">Blue Collar Jobs</option>
                                </select>
                            </div>

                            <!-- Blue Collar Jobs Section -->
                            <div id="blueCollarSection" style="display:none;">
                                <div class="form-group">
                                    <label for="blueCollarCategory">Blue Collar Job Category</label>
                                    <select type="text" name="blueCollarCategory" id="blueCollarCategory" class="form-control" style="border-radius:0px; height: 50px;" onchange="handleBlueCollarCategoryChange()">
                                        <option value="">- Select Job Category -</option>
                                        <option value="Caregiver/Nanny">Caregiver/Nanny</option>
                                        <option value="Beautician/Salon">Beautician/Salon</option>
                                        <option value="Sewing machine operator">Sewing machine operator</option>
                                        <option value="Carpenter">Carpenter</option>
                                        <option value="Plumber/Pipe fitting">Plumber/Pipe fitting</option>
                                        <option value="Welder">Welder</option>
                                        <option value="Boiler Operator">Boiler Operator</option>
                                        <option value="Gym/Fitness Trainer">Gym/Fitness Trainer</option>
                                        <option value="Interpreter">Interpreter</option>
                                        <option value="Imam/Khatib/Muezzin">Imam/Khatib/Muezzin</option>
                                        <option value="Mason/Construction worker">Mason/Construction worker</option>
                                        <option value="Nurse">Nurse</option>
                                        <option value="Deliveryman">Deliveryman</option>
                                        <option value="Pathologist">Pathologist</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>

                                <!-- Custom Category Input -->
                                <div class="form-group" id="customCategoryDiv" style="display:none;">
                                    <label for="customCategory">Enter Custom Category</label>
                                    <input type="text" name="customCategory" id="customCategory" class="form-control" style="border-radius:0px; height: 50px;" placeholder="Enter your job category" />
                                </div>
                            </div>

                            <!-- White Collar Jobs Section -->
                            <div id="whitCollarSection" style="display:none;">
                                <div class="form-group">
                                    <label for="whitCollarCategory">White Collar Job Category</label>
                                    <select type="text" name="whitCollarCategory" id="whitCollarCategory" class="form-control" style="border-radius:0px; height: 50px;">
                                        <?php include 'categoryOptions.php'; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="minexp"><?php echo t('minimum_experience_label'); ?></label>
                                <input type="text" name="minexp" class="form-control" style="border-radius:0px; height: 50px;" placeholder="<?php echo t('enter_min_experience'); ?>" value="<?php echo $minexp; ?>" />
                            </div>

                            <div class="form-group">
                                <label for="salary"><?php echo t('salary_budget_label'); ?></label>
                                <input type="text" name="salary" class="form-control" style="border-radius:0px; height: 50px;" placeholder="<?php echo t('enter_salary'); ?>" value="<?php echo $salary; ?>" />
                            </div>

                            <div class="form-group">
                                <label for="industry"><?php echo t('job_industry_label'); ?></label>
                                <select type="text" name="industry" class="form-control" style="border-radius:0px; height: 50px;" placeholder="Industry"> <?php include 'industryOptions.php'; ?>
                                </select>
                            </div>


                            <div class="form-group">
                                <label for="desc"><?php echo t('job_requirements_label'); ?></label>
                                <input type="text" name="desc" class="form-control" style="border-radius:0px; height: 50px;" placeholder="<?php echo t('description_placeholder'); ?>" value="<?php echo $desc; ?>" />
                            </div>

                            <div class="form-group">
                                <label for="role"><?php echo t('role_label'); ?></label>
                                <input type="text" name="role" class="form-control" style="border-radius:0px; height: 50px;" placeholder="<?php echo t('enter_role'); ?>" value="<?php echo $role; ?>" />
                            </div>

                            <div class="form-group">
                                <label for="eType"><?php echo t('employment_type_label'); ?></label>
                                <select type="text" name="eType" class="form-control" style="border-radius:0px; height: 50px;">
                                    <option><?php echo t('permanent'); ?></option>
                                    <option><?php echo t('part_time'); ?></option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="eType"><?php echo t('status_label'); ?></label>
                                <select type="text" name="status" class="form-control" style="border-radius:0px; height: 50px;">
                                    <option><?php echo t('open_label'); ?> <?php if ($status == 'open') {
                                                        echo "checked='true'";
                                                    } ?> </option>
                                    <option><?php echo t('close_label'); ?> <?php if ($status == 'closed') {
                                                        echo "checked='true'";
                                                    } ?> </option>
                                </select>
                            </div>

                            <div class="form-group bbb">

                                <button type="submit" name="submitPost" class="btn" style="background-color: #001219; color: #ffffffff;
                            box-shadow: none; border-radius: 0px; height: 50px; width: 500px;"> <b> <?php echo t('post_submit'); ?> </b> </button>

                                <!--display message-->
                                <div style="font-family: Sora; font-size: 15px; color: #000000ff; padding-top: 15px;">
                                    <b><?php echo $msg; ?></b>
                                </div>

                            </div>

                        </div>
                    </div>
                </form>
            </div>






        </div>



    </div>




    <!--first row -->

    <script src="js/tilt.jquery.min.js"></script>
    <script src="js/signinModal.js"></script>
    
    <script>
        function handleCategoryChange() {
            const categorySelect = document.getElementById('categorySelect').value;
            const blueCollarSection = document.getElementById('blueCollarSection');
            const whitCollarSection = document.getElementById('whitCollarSection');
            
            if (categorySelect === 'blue_collar') {
                blueCollarSection.style.display = 'block';
                whitCollarSection.style.display = 'none';
            } else if (categorySelect === 'white_collar') {
                blueCollarSection.style.display = 'none';
                whitCollarSection.style.display = 'block';
            } else {
                blueCollarSection.style.display = 'none';
                whitCollarSection.style.display = 'none';
            }
        }
        
        function handleBlueCollarCategoryChange() {
            const blueCollarSelect = document.getElementById('blueCollarCategory').value;
            const customCategoryDiv = document.getElementById('customCategoryDiv');
            
            if (blueCollarSelect === 'Other') {
                customCategoryDiv.style.display = 'block';
            } else {
                customCategoryDiv.style.display = 'none';
            }
        }
    </script>

</html>