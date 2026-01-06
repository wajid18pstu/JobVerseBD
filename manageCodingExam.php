<?php
session_start();
// Only admins can access this
if (!isset($_SESSION['aid'])) {
    header("Location: signin.php");
    exit();
}

include 'connect.php';

// Handle delete problem
if (isset($_GET['delete']) && isset($_SESSION['aid'])) {
    $problem_id = (int)$_GET['delete'];
    $conn->query("DELETE FROM test_cases WHERE problem_id = $problem_id");
    $conn->query("DELETE FROM coding_problems WHERE problem_id = $problem_id");
    header("Location: manageCodingExam.php");
    exit();
}

// Get all coding problems
$sql = "SELECT cp.*, COUNT(tc.test_case_id) as test_case_count 
        FROM coding_problems cp 
        LEFT JOIN test_cases tc ON cp.problem_id = tc.problem_id 
        GROUP BY cp.problem_id 
        ORDER BY cp.created_at DESC";
$result = $conn->query($sql);
$problems = [];
while ($row = $result->fetch_assoc()) {
    $problems[] = $row;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Coding Exam</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body { padding: 20px; background-color: #f5f5f5; }
        .container { max-width: 1200px; }
        .problem-card {
            background: white;
            padding: 20px;
            margin: 15px 0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border-left: 5px solid #007bff;
        }
        .problem-card.easy { border-left-color: #28a745; }
        .problem-card.medium { border-left-color: #ffc107; }
        .problem-card.hard { border-left-color: #dc3545; }
        .difficulty-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            margin-right: 10px;
        }
        .difficulty-badge.easy { background-color: #d4edda; color: #155724; }
        .difficulty-badge.medium { background-color: #fff3cd; color: #856404; }
        .difficulty-badge.hard { background-color: #f8d7da; color: #721c24; }
        .action-buttons { text-align: right; }
        .info-text { color: #666; font-size: 14px; }
        h1 { color: #333; margin-bottom: 30px; }
    </style>
</head>
<body>
    <?php include 'mainNavbar.php'; ?>
    
    <div class="container">
        <h1><i class="fa fa-code"></i> Manage Coding Exam Problems</h1>
        
        <div class="alert alert-info">
            <strong>Total Problems:</strong> <?php echo count($problems); ?> 
            | <strong>Total Test Cases:</strong> <?php 
                $total = 0;
                foreach ($problems as $p) $total += $p['test_case_count'];
                echo $total;
            ?>
        </div>
        
        <a href="#addProblem" class="btn btn-success btn-lg" style="margin-bottom: 30px;">
            <i class="fa fa-plus"></i> Add New Problem
        </a>
        
        <?php if (count($problems) > 0): ?>
            <?php foreach ($problems as $problem): ?>
                <div class="problem-card <?php echo $problem['difficulty']; ?>">
                    <div class="row">
                        <div class="col-md-8">
                            <h3><?php echo htmlspecialchars($problem['title']); ?></h3>
                            <div style="margin: 10px 0;">
                                <span class="difficulty-badge <?php echo $problem['difficulty']; ?>">
                                    <?php echo ucfirst($problem['difficulty']); ?>
                                </span>
                                <span class="info-text">
                                    <i class="fa fa-star"></i> <?php echo $problem['points']; ?> Points
                                    | <i class="fa fa-list"></i> <?php echo $problem['test_case_count']; ?> Test Cases
                                </span>
                            </div>
                            <p style="margin-top: 10px; color: #666;">
                                <?php echo substr(htmlspecialchars($problem['description']), 0, 150); ?>...
                            </p>
                            <p class="info-text">
                                <strong>Languages:</strong> <?php echo htmlspecialchars($problem['language_support']); ?>
                            </p>
                        </div>
                        <div class="col-md-4 action-buttons">
                            <a href="editCodingProblem.php?id=<?php echo $problem['problem_id']; ?>" 
                               class="btn btn-warning btn-sm" style="margin-bottom: 5px;">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <a href="viewCodingTestCases.php?id=<?php echo $problem['problem_id']; ?>" 
                               class="btn btn-info btn-sm" style="margin-bottom: 5px;">
                                <i class="fa fa-list"></i> Test Cases
                            </a>
                            <a href="manageCodingExam.php?delete=<?php echo $problem['problem_id']; ?>" 
                               class="btn btn-danger btn-sm" 
                               onclick="return confirm('Delete this problem and all its test cases?');">
                                <i class="fa fa-trash"></i> Delete
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-warning">
                No problems found. <a href="initCodingExam.php">Click here to initialize sample problems</a>
            </div>
        <?php endif; ?>
    </div>
    
    <script src="js/jquery-1.11.3.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>
