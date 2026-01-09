<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
require_once __DIR__ . '/lang.php';
?>
<!doctype html>


<html>

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="img/jobsConnect.svg" type="image/x-icon">

  <title> JobVerseBD | Job Listings </title>

  <link href="css/simpleGridTemplate.css" rel="stylesheet" type="text/css">
  <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
  <link href="css/Animate.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <link href="css/Animate.css" rel="stylesheet" type="text/css">
  <link href="css/animate.min.css" rel="stylesheet" type="text/css">


  <!--FONTS-->
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@200&display=swap" rel="stylesheet">

  <style>
    * {
      margin: 0;
      padding: 0;
    }

    body {
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
      min-height: 100vh;
    }

    .hero {
      background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
      padding-bottom: 50px !important;
    }

    /* Search Section */
    .search-section {
      margin-top: 40px;
      margin-bottom: 40px;
      padding: 0 20px;
    }

    .search-section h1 {
      font-size: 2.8rem;
      font-weight: 700;
      color: #1a1a1a;
      margin-bottom: 25px;
      letter-spacing: -0.5px;
    }

    .search-form {
      display: flex;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
      border-radius: 50px;
      overflow: hidden;
      background: white;
    }

    .search-form input {
      flex: 1;
      padding: 15px 30px;
      border: none;
      font-size: 1rem;
      color: #333;
    }

    .search-form input::placeholder {
      color: #999;
    }

    .search-form button {
      padding: 0 40px;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border: none;
      color: white;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .search-form button:hover {
      box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
    }

    /* Stats Section */
    .stats-section {
      display: flex;
      gap: 30px;
      margin-bottom: 50px;
      padding: 0 20px;
    }

    .stat-card {
      flex: 1;
      background: white;
      padding: 25px 30px;
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
      transition: all 0.3s ease;
    }

    .stat-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }

    .stat-number {
      font-size: 2.5rem;
      font-weight: 700;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      margin-bottom: 8px;
    }

    .stat-label {
      font-size: 0.95rem;
      color: #666;
      font-weight: 500;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    /* Job Cards */
    .jobs-container {
      padding: 0 20px;
    }

    .job-card {
      background: white;
      border-radius: 12px;
      padding: 28px;
      margin-bottom: 25px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      border-left: 5px solid #667eea;
      position: relative;
      overflow: hidden;
    }

    .job-card::before {
      content: '';
      position: absolute;
      top: 0;
      right: 0;
      width: 100px;
      height: 100px;
      background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
      border-radius: 50%;
      transform: translate(30px, -30px);
    }

    .job-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
      border-left-color: #764ba2;
    }

    .job-title {
      font-size: 1.5rem;
      font-weight: 700;
      color: #1a1a1a;
      margin-bottom: 8px;
      word-break: break-word;
    }

    .company-name {
      font-size: 0.95rem;
      color: #667eea;
      font-weight: 600;
      margin-bottom: 15px;
      display: flex;
      align-items: center;
    }

    .company-name::before {
      content: '';
      display: inline-block;
      width: 6px;
      height: 6px;
      background: #667eea;
      border-radius: 50%;
      margin-right: 8px;
    }

    .job-description {
      font-size: 0.95rem;
      color: #555;
      line-height: 1.6;
      margin: 18px 0;
      display: -webkit-box;
      -webkit-line-clamp: 3;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    .job-details {
      display: flex;
      gap: 25px;
      margin: 20px 0;
      flex-wrap: wrap;
      padding: 15px 0;
      border-top: 1px solid #f0f0f0;
      border-bottom: 1px solid #f0f0f0;
    }

    .detail-item {
      display: flex;
      flex-direction: column;
    }

    .detail-label {
      font-size: 0.8rem;
      color: #999;
      text-transform: uppercase;
      font-weight: 600;
      letter-spacing: 0.5px;
      margin-bottom: 5px;
    }

    .detail-value {
      font-size: 1.1rem;
      color: #1a1a1a;
      font-weight: 600;
    }

    .apply-btn {
      display: inline-block;
      margin-top: 15px;
      padding: 12px 28px;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      text-decoration: none;
      border-radius: 8px;
      font-weight: 600;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
      border: none;
      cursor: pointer;
      font-size: 0.95rem;
    }

    .apply-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
      text-decoration: none;
      color: white;
    }

    /* Sidebar */
    .sidebar {
      padding: 30px 0;
    }

    .filter-section {
      background: linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%);
      padding: 28px;
      border-radius: 15px;
      margin-bottom: 28px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
      border: 1px solid rgba(102, 126, 234, 0.2);
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .filter-section:hover {
      box-shadow: 0 12px 35px rgba(102, 126, 234, 0.25);
      transform: translateY(-3px);
      border-color: rgba(102, 126, 234, 0.4);
    }

    .filter-section h3 {
      font-size: 1.25rem;
      font-weight: 700;
      color: #1a1a1a;
      margin-bottom: 18px;
      display: flex;
      align-items: center;
      letter-spacing: -0.3px;
    }

    .filter-section h3::before {
      content: '';
      display: inline-block;
      width: 4px;
      height: 24px;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border-radius: 2px;
      margin-right: 12px;
    }

    .filter-section select {
      width: 100%;
      padding: 14px 16px;
      border: 2px solid #e8e8e8;
      border-radius: 10px;
      font-size: 0.95rem;
      background-color: white;
      cursor: pointer;
      transition: all 0.3s ease;
      color: #1a1a1a;
      font-weight: 500;
      appearance: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23667eea' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 12px center;
      padding-right: 38px;
    }

    .filter-section select:hover {
      border-color: #667eea;
      box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
    }

    .filter-section select:focus {
      outline: none;
      border-color: #667eea;
      box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.15);
    }

    .filter-btn {
      width: 100%;
      padding: 14px 25px;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      border: none;
      border-radius: 10px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      margin-top: 16px;
      font-size: 0.95rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
    }

    .filter-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
    }

    .filter-btn:active {
      transform: translateY(-1px);
    }

    /* Illustration */
    .illustration-section {
      text-align: center;
      padding: 30px 0;
    }

    .floating {
      animation: floating 3s ease-in-out infinite;
    }

    @keyframes floating {
      0%, 100% {
        transform: translateY(0px);
      }
      50% {
        transform: translateY(15px);
      }
    }

    /* No results */
    .no-results {
      text-align: center;
      padding: 60px 20px;
    }

    .no-results img {
      max-width: 100%;
      height: auto;
      margin-bottom: 20px;
    }

    /* Left Sidebar */
    .left-sidebar {
      position: fixed;
      left: 0;
      top: 60px;
      width: 280px;
      height: calc(100vh - 70px);
      background: white;
      padding: 20px;
      overflow-y: auto;
      box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
      z-index: 100;
    }

    .left-sidebar .logo-section {
      text-align: center;
      margin-bottom: 30px;
      padding: 10px 0;
      border-bottom: 2px solid #f0f0f0;
    }

    .left-sidebar .logo-section img {
      width: 150px;
      height: auto;
      margin-bottom: 10px;
    }

    .main-content {
      margin-left: 310px;
      margin-top: 25px;
      margin-right: 20px;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .left-sidebar {
        position: relative;
        width: 100%;
        height: auto;
        top: 0;
        box-shadow: none;
        padding: 15px;
      }

      .main-content {
        margin-left: 0;
      }

      .search-section h1 {
        font-size: 2rem;
      }

      .search-form {
        flex-direction: column;
      }

      .search-form button {
        padding: 15px;
      }

      .stats-section {
        flex-direction: column;
        gap: 15px;
      }

      .job-card {
        margin-left: 0;
        margin-right: 0;
      }

      .job-details {
        flex-direction: column;
        gap: 15px;
      }
    }
  </style>


<body onload="logoBeat()" style="font-family: 'Sora', sans-serif;">

  <?php
  include 'navBar.php';
  include 'signinEmployerModals.php';
  ?>

  <!-- Main Container -->
  <div class="container-fluid hero">
    <!-- Left Sidebar -->
    <div class="left-sidebar">
      <div class="logo-section">
        <img src="img/jobsConnect.svg" alt="JobVerseBD Logo" />
      </div>

      <div class="filter-section">
        <h3><?php echo t('jobs_by_category'); ?></h3>
        <form>
          <select class="form-control" name='category'>
            <?php include "categoryOptions.php"; ?>
          </select>
          <input class="filter-btn" type="submit" value="<?php echo t('search'); ?>" />
        </form>
      </div>

      <div class="filter-section">
        <h3>Jobs By Industry</h3>
        <form>
          <select class="form-control" name='industry'>
            <?php include "industryOptions.php"; ?>
          </select>
          <input class="filter-btn" type="submit" value="Search" />
        </form>
      </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
      <div class="row">
        <div class="col-md-12">
          <div class="search-section">
            <h1 id="jbs"><?php echo t('find_jobs'); ?></h1>
            <form class="search-form" action="jobs.php">
              <input type="text" placeholder="<?php echo t('search_for_jobs'); ?>" name="q">
              <button type="submit"><i class="fa fa-search"></i></button>
            </form>
          </div>
          <div class="jobs-container">
          <!----------------------SUM OF POSTS & ACTIVE USERS USING REAL COUNTS--------------------------->
          <div class="stats-section">
            <!-- sum of posts -->
            <?php
            include 'connect.php';
            $sql = "SELECT COUNT(*) as total_posts FROM `post`";
            $totalresult = $conn->query($sql);
            if ($totalresult) {
              $row = $totalresult->fetch_assoc();
              $numberofposts = $row['total_posts'];
            ?>
                <div class="stat-card">
                  <div class="stat-number"><?php echo $numberofposts; ?></div>
                  <div class="stat-label"><?php echo t('total_job_posts'); ?></div>
                </div>
            <?php } ?>

            <!-- active users -->
            <?php
            $sql_seekers = "SELECT COUNT(*) as seeker_count FROM `seeker`";
            $sql_employers = "SELECT COUNT(*) as employer_count FROM `employer`";
            $seekers_result = $conn->query($sql_seekers);
            $employers_result = $conn->query($sql_employers);
            
            $seeker_count = 0;
            $employer_count = 0;
            
            if ($seekers_result) {
              $row = $seekers_result->fetch_assoc();
              $seeker_count = $row['seeker_count'];
            }
            if ($employers_result) {
              $row = $employers_result->fetch_assoc();
              $employer_count = $row['employer_count'];
            }
            
            $totalusers = $seeker_count + $employer_count;
            ?>
                <div class="stat-card">
                  <div class="stat-number"><?php echo $totalusers; ?></div>
                  <div class="stat-label"><?php echo t('active_users'); ?></div>
                </div>
          </div>

          <!-- Job Listings -->
          <?php $name = $category = $minexp = $salary = $industry = $desc = $role = $eType = $status = "";

          include 'connect.php';
          $sql = "select *,(select name from employer where id=post.eid)as ename from post  order by date";
          if (isset($_GET['q'])) {
            $sql = "select *,(select name from employer where id=post.eid)as ename from post where name LIKE '%" . $_GET['q'] . "%' order by date";
          }
          if (isset($_GET['industry'])) {
            $sql = "select *,(select name from employer where id=post.eid)as ename from post where industry='" . $_GET['industry'] . "' order by date";
          }
          if (isset($_GET['category'])) {
            $sql = "select *,(select name from employer where id=post.eid)as ename from post where category='" . $_GET['category'] . "' order by date";
          }

          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              $pid = $row['id'];
              $jobtitle = $row['name'];
              $category = $row['category'];
              $minexp = $row['minexp'];
              $salary = $row['salary'];
              $industry = $row['industry'];
              $desc = $row['desc'];
              $role = $row['role'];
              $ename = $row['ename'];
              $status = $row['status'];
          ?>
              <div class="job-card">
                <h2 class="job-title"><?php echo htmlspecialchars($jobtitle); ?></h2>
                <div class="company-name"><?php echo htmlspecialchars($ename); ?></div>

                <p class="job-description"><?php echo htmlspecialchars($desc); ?></p>

                <div class="job-details">
                  <div class="detail-item">
                    <span class="detail-label"><?php echo t('experience_required'); ?></span>
                    <span class="detail-value"><?php echo $minexp; ?> years</span>
                  </div>
                  <div class="detail-item">
                    <span class="detail-label"><?php echo t('salary'); ?></span>
                    <span class="detail-value"><?php echo htmlspecialchars($salary); ?></span>
                  </div>
                  <div class="detail-item">
                    <span class="detail-label">Category</span>
                    <span class="detail-value"><?php echo htmlspecialchars($category); ?></span>
                  </div>
                  <div class="detail-item">
                    <span class="detail-label">Industry</span>
                    <span class="detail-value"><?php echo htmlspecialchars($industry); ?></span>
                  </div>
                </div>

                <a href="applyJob.php?id=<?php echo $pid; ?>" class="apply-btn"><?php echo t('apply'); ?></a>
              </div>

          <?php }
          } else {
            echo '<div class="no-results">';
            echo ' <img src="img/err.svg" alt="No results" /> ';
            echo '</div>';
          } ?>
        </div>
        </div>
      </div>
    </div>
  </div>


  <!--first row -->
  <script src="js/tilt.jquery.min.js"></script>
  <script src="js/signinModal.js"></script>

  <button style="display:none;" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#msgModal" id="msgModalBtn">Open Modal</button>

  <!-- Modal -->
  <div id="msgModal" class="modal fade" role="dialog">

    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <?php if (isset($_GET['msg'])) {
            $msg = $_GET['msg'];
            if ($msg == 'success') {
              echo  "<h4 class='modal-title'>Job Applied Successfully!</h4>";
            } else if ($msg == 'error') {
              echo  "<h4 class='modal-title'>Some Error occured Pls try again later!</h4>";
            } else if ($msg == 'dup') {
              echo "<h4 class='modal-title'>You have already applied for this job.\n "
                . "Check your application status in 'Jobs Applied' section</h4>";
            }
          } ?>
        </div>
      </div>
    </div>
  </div>


  <?php
  if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'login') {
  ?>

      <script>
        $('#loginAnchor').trigger("click");
      </script>
    <?php } else {
    ?>
      <script>
        $('#msgModalBtn').trigger("click");
      </script>
  <?php
    }
  } ?>
</body>

</html>