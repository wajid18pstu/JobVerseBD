<?php
include 'authorizeSeeker.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/lang.php';
include 'connect.php';

$sid = $_SESSION['sid'];
$qualification = '';
$skills = '';

$seekerStmt = $conn->prepare("SELECT qualification, skills FROM seeker WHERE id = ? LIMIT 1");
$seekerStmt->bind_param('i', $sid);
$seekerStmt->execute();
$seekerResult = $seekerStmt->get_result();
if ($seekerRow = $seekerResult->fetch_assoc()) {
    $qualification = trim((string)$seekerRow['qualification']);
    $skills = trim((string)$seekerRow['skills']);
}
$seekerStmt->close();

$rawText = strtolower($qualification . ' ' . str_replace(',', ' ', $skills));
$parts = preg_split('/[^a-z0-9\+\#]+/i', $rawText);
$keywords = [];
$stopWords = [
    'and', 'or', 'the', 'with', 'for', 'from', 'in', 'on', 'at', 'to', 'of',
    'a', 'an', 'as', 'is', 'are', 'be', 'by', 'this', 'that', 'job', 'work'
];

if (is_array($parts)) {
    foreach ($parts as $part) {
        $word = trim($part);
        if ($word === '' || strlen($word) < 3) {
            continue;
        }
        if (in_array($word, $stopWords, true)) {
            continue;
        }
        $keywords[$word] = true;
    }
}

$keywords = array_keys($keywords);
$keywords = array_slice($keywords, 0, 15);

$searchQ = isset($_GET['q']) ? trim($_GET['q']) : '';
$filterIndustry = isset($_GET['industry']) ? trim($_GET['industry']) : '';
$filterCategory = isset($_GET['category']) ? trim($_GET['category']) : '';

$sql = "SELECT post.*, (SELECT name FROM employer WHERE id = post.eid) AS ename FROM post WHERE status='open'";
$types = '';
$params = [];

if ($searchQ !== '') {
    $sql .= " AND name LIKE ?";
    $types .= 's';
    $params[] = '%' . $searchQ . '%';
}

if ($filterIndustry !== '') {
    $sql .= " AND industry = ?";
    $types .= 's';
    $params[] = $filterIndustry;
}

if ($filterCategory !== '') {
    $sql .= " AND category = ?";
    $types .= 's';
    $params[] = $filterCategory;
}

if (!empty($keywords)) {
    $eligibilityClauses = [];
    foreach ($keywords as $kw) {
    $eligibilityClauses[] = "(LOWER(`desc`) LIKE ? OR LOWER(role) LIKE ? OR LOWER(category) LIKE ? OR LOWER(name) LIKE ?)";
        $likeKw = '%' . $kw . '%';
        $types .= 'ssss';
        $params[] = $likeKw;
        $params[] = $likeKw;
        $params[] = $likeKw;
        $params[] = $likeKw;
    }
    $sql .= ' AND (' . implode(' OR ', $eligibilityClauses) . ')';
} else {
    $sql .= ' AND 1=0';
}

$sql .= ' ORDER BY date DESC';

$stmt = $conn->prepare($sql);
if ($stmt && $types !== '') {
    $stmt->bind_param($types, ...$params);
}

$eligibleJobs = [];
if ($stmt) {
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $eligibleJobs[] = $row;
    }
    $stmt->close();
}

$eligibleCount = count($eligibleJobs);
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="img/jobsConnect.svg" type="image/x-icon">
  <title>JobVerseBD | Eligible Jobs</title>
  <link href="css/simpleGridTemplate.css" rel="stylesheet" type="text/css">
  <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
  <link href="css/Animate.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
    body {
      background: linear-gradient(135deg, #f5f7fa 0%, #dbe4f3 100%);
      min-height: 100vh;
      font-family: 'Sora', sans-serif;
    }
    .main-wrap {
      max-width: 1100px;
      margin: 110px auto 40px;
      padding: 0 15px;
    }
    .title-box {
      background: #ffffff;
      border-radius: 14px;
      padding: 18px 22px;
      margin-bottom: 20px;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
    }
    .title-box h2 {
      margin: 0;
      color: #222;
      font-weight: 700;
    }
    .title-box p {
      margin: 8px 0 0;
      color: #5c5c5c;
    }
    .search-form {
      display: flex;
      gap: 8px;
      margin-top: 12px;
    }
    .search-form input {
      flex: 1;
      border: 1px solid #d8d8d8;
      border-radius: 8px;
      padding: 10px 12px;
    }
    .search-form button {
      border: none;
      border-radius: 8px;
      padding: 10px 16px;
      background: #2f63d6;
      color: #fff;
      font-weight: 600;
    }
    .job-card {
      background: #fff;
      border-radius: 12px;
      margin-bottom: 16px;
      padding: 18px;
      box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
      border-left: 4px solid #2f63d6;
    }
    .job-title {
      margin: 0;
      font-size: 24px;
      color: #111;
      font-weight: 700;
    }
    .company {
      margin-top: 4px;
      color: #2f63d6;
      font-weight: 600;
    }
    .job-desc {
      margin-top: 12px;
      color: #444;
      line-height: 1.6;
    }
    .meta {
      margin-top: 12px;
      color: #2d2d2d;
    }
    .meta span {
      display: inline-block;
      margin-right: 14px;
      margin-bottom: 6px;
    }
    .apply-btn {
      display: inline-block;
      margin-top: 12px;
      padding: 10px 16px;
      border-radius: 8px;
      background: #2f63d6;
      color: #fff;
      text-decoration: none;
      font-weight: 600;
    }
    .hint {
      background: #fff8e6;
      border: 1px solid #f1d490;
      border-radius: 10px;
      padding: 12px;
      margin-bottom: 15px;
      color: #7b5a1b;
    }
    .empty {
      text-align: center;
      background: #fff;
      border-radius: 12px;
      padding: 24px;
      box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
    }
  </style>
</head>
<body>
  <?php include 'navBar.php'; ?>

  <div class="main-wrap">
    <?php if (isset($_GET['msg'])) { ?>
      <?php if ($_GET['msg'] === 'success') { ?>
        <div class="alert alert-success">Job applied successfully.</div>
      <?php } elseif ($_GET['msg'] === 'dup') { ?>
        <div class="alert alert-warning">You have already applied for this job.</div>
      <?php } elseif ($_GET['msg'] === 'failed') { ?>
        <div class="alert alert-danger">Could not apply for this job. Please try again.</div>
      <?php } elseif ($_GET['msg'] === 'login') { ?>
        <div class="alert alert-info">Please sign in as a job seeker to apply.</div>
      <?php } ?>
    <?php } ?>

    <div class="title-box">
      <h2>Eligible Jobs</h2>
      <p><?php echo $eligibleCount; ?> matched jobs based on your qualification and skills.</p>
      <form class="search-form" method="get" action="eligibleJobs.php">
        <input type="text" name="q" value="<?php echo htmlspecialchars($searchQ); ?>" placeholder="Search inside eligible jobs">
        <button type="submit"><i class="fa fa-search"></i> Search</button>
      </form>
    </div>

    <?php if (empty($keywords)) { ?>
      <div class="hint">Please update your qualification and skills in your account to get eligibility-based job matches.</div>
    <?php } ?>

    <?php
    if (!empty($eligibleJobs)) {
        foreach ($eligibleJobs as $job) {
            $pid = (int)$job['id'];
    ?>
      <div class="job-card">
        <h3 class="job-title"><?php echo htmlspecialchars($job['name']); ?></h3>
        <div class="company"><?php echo htmlspecialchars($job['ename']); ?></div>
        <p class="job-desc"><?php echo htmlspecialchars($job['desc']); ?></p>
        <div class="meta">
          <span><strong>Experience:</strong> <?php echo htmlspecialchars($job['minexp']); ?> years</span>
          <span><strong>Salary:</strong> <?php echo htmlspecialchars($job['salary']); ?></span>
          <span><strong>Category:</strong> <?php echo htmlspecialchars($job['category']); ?></span>
          <span><strong>Industry:</strong> <?php echo htmlspecialchars($job['industry']); ?></span>
        </div>
        <a class="apply-btn" href="applyJob.php?id=<?php echo $pid; ?>&redirect=eligibleJobs.php"><?php echo t('apply'); ?></a>
      </div>
    <?php
        }
    } else {
        echo '<div class="empty">No eligible jobs found right now. Try updating your skills or check back later.</div>';
    }
    ?>
  </div>
</body>
</html>
