<?php

include 'authorizeEmployer.php';
include 'sslcommerz_config.php';

$id = 0;
$name = $category = $minexp = $salary = $industry = $desc = $role = $eType = $status = $msg = "";
$jobType = "white_collar";
$paymentFee = 0;

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
        // This will now trigger payment instead of direct posting
        // Store form data in session temporarily for use after payment
        $id = $_POST['id'];
        $name = $_POST['name'];
        
        // Determine category based on job type
        if (isset($_POST['blueCollarCategory']) && $_POST['blueCollarCategory'] !== '') {
            if ($_POST['blueCollarCategory'] === 'Other' && isset($_POST['customCategory'])) {
                $category = $_POST['customCategory'];
            } else {
                $category = $_POST['blueCollarCategory'];
            }
            $jobType = 'blue_collar';
        } elseif (isset($_POST['whitCollarCategory']) && $_POST['whitCollarCategory'] !== '') {
            $category = $_POST['whitCollarCategory'];
            $jobType = 'white_collar';
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
        
        // Get payment fee based on job type
        $paymentFee = getJobPostingFee($jobType);
        
        // Store form data in session for payment completion
        $_SESSION['job_form_data'] = array(
            'id' => $id,
            'name' => $name,
            'category' => $category,
            'minexp' => $minexp,
            'salary' => $salary,
            'industry' => $industry,
            'desc' => $desc,
            'role' => $role,
            'employmentType' => $eType,
            'status' => $status,
            'job_type' => $jobType
        );
        
        // Set flag to show payment modal
        $_SESSION['show_payment_modal'] = true;
        $_SESSION['payment_fee'] = $paymentFee;
        
        $msg = "PAYMENT_REQUIRED"; // Signal to show payment modal
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

            <div class="container contact-form" style=" background-color: #e0e0e0ff; width: 700px;border-radius: 20px; height: 1100px; box-shadow: 0px 0px 25px #000000ff; 
                 align-items: center; justify-content: center; display: flex; padding: 0px; ">
                <form method="post" onsubmit="return validateJobForm()">

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

                                <button type="submit" name="submitPost" class="btn" style="background-color: #4352d8ff; color: #ffffffff;
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
    
    <!-- Payment Modal -->
    <div id="paymentModal" class="modal fade" role="dialog" style="z-index: 10000;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #001219; color: white;">
                    <button type="button" class="close" data-dismiss="modal" style="color: white;">&times;</button>
                    <h4 class="modal-title">Job Posting Payment</h4>
                </div>
                <div class="modal-body">
                    <div id="paymentDetails">
                        <h5>Payment Summary</h5>
                        <table class="table table-bordered">
                            <tr>
                                <td><strong>Job Type:</strong></td>
                                <td><span id="jobTypeDisplay"></span></td>
                            </tr>
                            <tr>
                                <td><strong>Amount:</strong></td>
                                <td><span id="amountDisplay"></span> Taka</td>
                            </tr>
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td>Pending Admin Confirmation</td>
                            </tr>
                        </table>
                        <p style="color: #666; font-size: 14px;">
                            Your job posting will be submitted for admin review after payment confirmation.
                        </p>
                    </div>
                    <div id="paymentProcessing" style="display: none; text-align: center;">
                        <p>Processing payment...</p>
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="cancelPaymentBtn">Cancel</button>
                    <button type="button" class="btn btn-primary" style="background-color: #001219; border-color: #001219;" id="proceedPaymentBtn">Proceed to Payment</button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        let currentJobType = '<?php echo isset($_SESSION['show_payment_modal']) ? (isset($_SESSION['job_form_data']['job_type']) ? $_SESSION['job_form_data']['job_type'] : 'white_collar') : 'white_collar'; ?>';
        let currentPaymentFee = <?php echo isset($_SESSION['payment_fee']) ? $_SESSION['payment_fee'] : 0; ?>;
        
        // Show payment modal if flag is set
        <?php if (isset($_SESSION['show_payment_modal']) && $_SESSION['show_payment_modal']): ?>
        $(document).ready(function() {
            updatePaymentModal(currentJobType, currentPaymentFee);
            $('#paymentModal').modal('show');
            // Clear the session flags after modal is shown
            <?php 
            unset($_SESSION['show_payment_modal']);
            unset($_SESSION['payment_fee']);
            ?>
        });
        <?php endif; ?>
        
        function updatePaymentModal(jobType, fee) {
            let displayType = jobType === 'blue_collar' ? 'Blue Collar' : 'White Collar';
            $('#jobTypeDisplay').text(displayType);
            $('#amountDisplay').text(fee);
            currentJobType = jobType;
            currentPaymentFee = fee;
        }
        
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
        
        // Payment modal handlers
        $('#proceedPaymentBtn').click(function() {
            $('#paymentProcessing').show();
            $('#paymentDetails').hide();
            $(this).prop('disabled', true);
            
            // Get the job data from form
            let jobData = {
                name: $('input[name="name"]').val(),
                category: getCurrentCategory(),
                minexp: $('input[name="minexp"]').val(),
                salary: $('input[name="salary"]').val(),
                industry: $('select[name="industry"]').val(),
                desc: $('input[name="desc"]').val(),
                role: $('input[name="role"]').val(),
                eType: $('select[name="eType"]').val(),
                status: $('select[name="status"]').val()
            };
            
            // Use test endpoint for localhost, production for live domain
            let endpoint = 'initiate_payment.php';
            <?php if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false || strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false): ?>
            endpoint = 'initiate_payment_test.php';
            <?php endif; ?>
            
            // Send to payment initiation
            $.ajax({
                url: endpoint,
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    job_type: currentJobType,
                    job_data: jobData
                }),
                success: function(response) {
                    if (response.success) {
                        // Redirect to SSLCommerz gateway or test success page
                        window.location.href = response.gateway_url;
                    } else {
                        alert('Error: ' + response.message);
                        location.reload();
                    }
                },
                error: function() {
                    alert('Error initiating payment. Please try again.');
                    location.reload();
                }
            });
        });
        
        $('#cancelPaymentBtn').click(function() {
            $('#paymentModal').modal('hide');
            $('#paymentDetails').show();
            $('#paymentProcessing').hide();
            $('#proceedPaymentBtn').prop('disabled', false);
        });
        
        function getCurrentCategory() {
            let categorySelect = document.getElementById('categorySelect').value;
            
            if (categorySelect === 'blue_collar') {
                let bcCategory = document.getElementById('blueCollarCategory').value;
                if (bcCategory === 'Other') {
                    return document.getElementById('customCategory').value;
                }
                return bcCategory;
            } else if (categorySelect === 'white_collar') {
                return document.getElementById('whitCollarCategory').value;
            }
            return categorySelect;
        }
        
        function validateJobForm() {
            const categorySelect = document.getElementById('categorySelect').value;
            
            if (!categorySelect) {
                alert('Please select a job type (White Collar or Blue Collar).');
                return false;
            }
            
            if (categorySelect === 'blue_collar') {
                const blueCollarCategory = document.getElementById('blueCollarCategory').value;
                if (!blueCollarCategory) {
                    alert('Please select a Blue Collar job category.');
                    return false;
                }
                if (blueCollarCategory === 'Other') {
                    const customCategory = document.getElementById('customCategory').value.trim();
                    if (!customCategory) {
                        alert('Please enter a custom job category.');
                        return false;
                    }
                }
            } else if (categorySelect === 'white_collar') {
                const whitCollarCategory = document.getElementById('whitCollarCategory').value;
                if (!whitCollarCategory) {
                    alert('Please select a White Collar job category.');
                    return false;
                }
            }
            
            return true;
        }
    </script>
