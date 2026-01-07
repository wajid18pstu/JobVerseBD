<?php
session_start();
if (!isset($_SESSION['sid'])) {
    header("Location: signin.php");
    exit();
}

include 'connect.php';

$seeker_id = $_SESSION['sid'];

// Initialize exam session
if (!isset($_SESSION['coding_exam_started'])) {
    $_SESSION['coding_exam_started'] = time();
    $_SESSION['coding_exam_problems'] = [];
    $_SESSION['coding_exam_scores'] = [];
    $_SESSION['coding_current_problem'] = 1;
}

// Get all coding problems
$sql = "SELECT * FROM coding_problems ORDER BY problem_id";
$problems_result = $conn->query($sql);
$problems = [];
while ($row = $problems_result->fetch_assoc()) {
    $problems[] = $row;
}

// Get current problem
$current_problem_index = isset($_GET['prob_index']) ? (int)$_GET['prob_index'] : 0;
if ($current_problem_index < 0) $current_problem_index = 0;
if ($current_problem_index >= count($problems)) {
    // Exam completed - show results
    $total_score = array_sum($_SESSION['coding_exam_scores']);
    $time_taken = time() - $_SESSION['coding_exam_started'];
    
    // Save exam result
    $sql = "INSERT INTO coding_exam_results (seeker_id, exam_id, total_score, max_score, problems_solved, time_taken_seconds) 
            VALUES (?, 5, ?, 60, ?, ?)";
    $stmt = $conn->prepare($sql);
    $problems_solved = count(array_filter($_SESSION['coding_exam_scores'], function($s) { return $s > 0; }));
    $stmt->bind_param('iiii', $seeker_id, $total_score, $problems_solved, $time_taken);
    $stmt->execute();
    $stmt->close();
    
    // Clear session
    unset($_SESSION['coding_exam_started']);
    unset($_SESSION['coding_exam_problems']);
    unset($_SESSION['coding_exam_scores']);
    unset($_SESSION['coding_current_problem']);
    
    // Show results page
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Exam Results - JobVerse</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
            body {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }
            .results-container {
                background: white;
                padding: 40px;
                border-radius: 15px;
                box-shadow: 0 10px 40px rgba(0,0,0,0.2);
                max-width: 600px;
                width: 100%;
                text-align: center;
            }
            .results-container h1 {
                color: #667eea;
                margin-bottom: 30px;
                font-size: 32px;
                font-weight: 700;
            }
            .score-circle {
                width: 150px;
                height: 150px;
                margin: 0 auto 30px;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 48px;
                font-weight: 700;
            }
            .result-stats {
                margin: 30px 0;
            }
            .stat-item {
                padding: 15px;
                margin: 10px 0;
                background: #f8f9fa;
                border-radius: 8px;
                border-left: 4px solid #667eea;
            }
            .stat-label {
                color: #666;
                font-size: 14px;
                margin-bottom: 5px;
            }
            .stat-value {
                color: #333;
                font-size: 24px;
                font-weight: 600;
            }
            .btn-back {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                border: none;
                padding: 12px 30px;
                border-radius: 6px;
                font-weight: 600;
                cursor: pointer;
                text-decoration: none;
                display: inline-block;
                margin-top: 20px;
            }
            .btn-back:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            }
        </style>
    </head>
    <body>
        <div class="results-container">
            <h1><i class="fa fa-trophy"></i> Exam Completed!</h1>
            
            <div class="score-circle">
                <?php echo $total_score; ?>/60
            </div>
            
            <div class="result-stats">
                <div class="stat-item">
                    <div class="stat-label">Problems Solved</div>
                    <div class="stat-value"><?php echo $problems_solved; ?> / 5</div>
                </div>
                
                <div class="stat-item">
                    <div class="stat-label">Time Taken</div>
                    <div class="stat-value"><?php echo gmdate('H:i:s', $time_taken); ?></div>
                </div>
                
                <div class="stat-item">
                    <div class="stat-label">Score Status</div>
                    <div class="stat-value">
                        <?php 
                        if ($total_score >= 30) {
                            echo '<span style="color: #28a745;">✓ PASSED</span>';
                        } else {
                            echo '<span style="color: #dc3545;">✗ FAILED</span>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            
            <a href="seekerAccount.php" class="btn-back">Back to Dashboard</a>
        </div>
    </body>
    </html>
    <?php
    exit();
}

$current_problem = $problems[$current_problem_index];
$test_cases = [];

// Get test cases for current problem
$sql = "SELECT * FROM test_cases WHERE problem_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $current_problem['problem_id']);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $test_cases[] = $row;
}
$stmt->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Coding Exam - JobVerse</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            background: linear-gradient(135deg, #ffffffff 0%, #ffffffff 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-top: 40px;
        }
        .coding-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .exam-header {
            background:linear-gradient(135deg, #667eea 0%, #764ba2 100%);;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .progress-info {
            padding: 2px 400px;
            display: flex;
            gap: 70px;
            align-items: center;
        }
        .progress-item {
            text-align: center;
        }
        .progress-item label {
            display: block;
            color: #666;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .progress-item .value {
            font-size: 24px;
            font-weight: 700;
            color: #ffffffff;
        }
        .timer {
            font-size: 32px;
            font-weight: 700;
            padding: 15px 20px;
            border-radius: 8px;
            background: #f8f9fa;
            min-width: 120px;
            text-align: center;
        }
        .timer.warning {
            color: #ffc107;
            background: #fff3cd;
        }
        .timer.danger {
            color: #dc3545;
            background: #f8d7da;
            animation: pulse 1s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        .content-wrapper {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        .problems-panel {
            flex: 0 0 320px;
        }
        .editor-panel {
            flex: 1;
            min-width: 300px;
        }
        .problem-card {
            background: white;
            padding: 12px;
            margin: 8px 0;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            border-left: 4px solid #ddd;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            color: inherit;
        }
        .problem-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        }
        .problem-card.active {
            border-left-color: #667eea;
            background: #f8f9fa;
            font-weight: 600;
        }
        .problem-card.solved {
            border-left-color: #28a745;
            background: #d4edda;
        }
        .problem-number {
            font-size: 12px;
            color: #999;
            margin-bottom: 5px;
        }
        .problem-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }
        .problem-points {
            font-size: 12px;
            color: #667eea;
        }
        .editor-section {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .editor-section h4 {
            color: #333;
            margin-bottom: 15px;
            font-weight: 600;
        }
        .editor-section h5 {
            color: #333;
            margin-top: 20px;
            margin-bottom: 10px;
            font-weight: 600;
        }
        .code-editor {
            width: 100%;
            min-height: 350px;
            font-family: 'Courier New', monospace;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            font-size: 14px;
            resize: vertical;
            transition: border-color 0.3s;
        }
        .code-editor:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        .btn-submit {
            width: 100%;
            margin-top: 15px;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            font-weight: 600;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }
        .sample-io {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            margin: 12px 0;
            border-left: 4px solid #667eea;
        }
        .sample-io pre {
            margin: 0;
            font-family: 'Courier New', monospace;
            font-size: 12px;
        }
        .alert {
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 15px;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .test-case-result {
            padding: 14px;
            border-radius: 6px;
            margin: 10px 0;
            border-left: 4px solid;
            animation: slideIn 0.3s ease-out;
        }
        .test-case-result code {
            background: rgba(0,0,0,0.08);
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 12px;
            word-break: break-all;
        }
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        #resultSection {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
        @media (max-width: 768px) {
            body { padding-top: 60px; }
            .content-wrapper { flex-direction: column; }
            .problems-panel { flex: 0 0 100%; }
            .exam-header { flex-direction: column; gap: 15px; }
        }
    </style>
</head>
<body>
    

    <div class="coding-container">
        <div class="exam-header">
            <div class="progress-info">
                <div class="progress-item">
                    <label>Problem</label>
                    <div class="value"><?php echo ($current_problem_index + 1); ?> / 5</div>
                </div>
                <div class="progress-item">
                    <label>Score</label>
                    <div class="value"><?php echo array_sum($_SESSION['coding_exam_scores'] ?? []); ?> / 60</div>
                </div>
            </div>
            <div class="timer" id="timer">5:00</div>
        </div>

        <div class="content-wrapper">
            <!-- Problems Panel -->
            <div class="problems-panel">
                <div class="editor-section">
                    <h4><i class="fa fa-list"></i> Problems</h4>
                    <?php for ($i = 0; $i < count($problems); $i++): ?>
                        <a href="codingExamTimed.php?prob_index=<?php echo $i; ?>" 
                           class="problem-card <?php echo $i == $current_problem_index ? 'active' : ''; ?> <?php echo isset($_SESSION['coding_exam_scores'][$i]) && $_SESSION['coding_exam_scores'][$i] > 0 ? 'solved' : ''; ?>">
                            <div class="problem-number">Problem <?php echo ($i + 1); ?></div>
                            <div class="problem-title"><?php echo htmlspecialchars(substr($problems[$i]['title'], 0, 25)); ?></div>
                            <div class="problem-points">
                                <?php 
                                if (isset($_SESSION['coding_exam_scores'][$i])) {
                                    echo '✓ ' . $_SESSION['coding_exam_scores'][$i] . 'pts';
                                } else {
                                    echo $problems[$i]['points'] . ' pts';
                                }
                                ?>
                            </div>
                        </a>
                    <?php endfor; ?>
                </div>
            </div>

            <!-- Editor Panel -->
            <div class="editor-panel">
                <div class="editor-section">
                    <h4><?php echo htmlspecialchars($current_problem['title']); ?></h4>
                    <p style="color: #666; font-size: 13px; margin-bottom: 10px;">
                        <span style="display: inline-block; background: #e8f0ff; color: #667eea; padding: 4px 12px; border-radius: 4px;">
                            <?php echo ucfirst($current_problem['difficulty']); ?> • <?php echo $current_problem['points']; ?> points
                        </span>
                    </p>

                    <h5>Problem Statement:</h5>
                    <p style="white-space: pre-wrap; line-height: 1.6; color: #555;">
                        <?php echo htmlspecialchars($current_problem['description']); ?>
                    </p>

                    <h5>Sample Input:</h5>
                    <div class="sample-io">
                        <pre><?php echo htmlspecialchars($current_problem['sample_input']); ?></pre>
                    </div>

                    <h5>Sample Output:</h5>
                    <div class="sample-io">
                        <pre><?php echo htmlspecialchars($current_problem['sample_output']); ?></pre>
                    </div>

                    <form id="submitForm" method="POST" action="submitCodingExamTimed.php">
                        <input type="hidden" name="problem_id" value="<?php echo $current_problem['problem_id']; ?>">
                        <input type="hidden" name="problem_index" value="<?php echo $current_problem_index; ?>">

                        <div class="form-group" style="margin-top: 20px;">
                            <label style="display: block; margin-bottom: 8px; color: #333; font-weight: 600;">Select Language:</label>
                            <select name="language" class="form-control" required style="padding: 5px; border: 2px solid #e0e0e0; border-radius: 6px;">
                                <option value="">-- Choose Language --</option>
                                <option value="python">Python 3</option>
                                <option value="cpp">C++</option>
                                <option value="java">Java</option>
                            </select>
                        </div>

                        <label style="display: block; margin: 20px 0 8px 0; color: #333; font-weight: 600;">Write Your Code:</label>
                        <textarea name="code" class="code-editor" placeholder="Write your solution here..." required></textarea>

                        <button type="submit" class="btn-submit">
                            <i class="fa fa-paper-plane"></i> Submit & Test Code
                        </button>
                    </form>

                    <div id="resultSection" style="display:none; margin-top: 20px;">
                        <div id="resultContent"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery-1.11.3.min.js"></script>
    <script>
        // Timer functionality
        const TIMER_DURATION = 300; // 5 minutes in seconds
        let timeRemaining = TIMER_DURATION;
        const startTime = <?php echo json_encode(time()); ?>;

        function updateTimer() {
            const elapsed = Math.floor((new Date().getTime() / 1000) - startTime);
            timeRemaining = TIMER_DURATION - elapsed;

            if (timeRemaining <= 0) {
                timeRemaining = 0;
                clearInterval(timerInterval);
                autoAdvanceProblem();
                return;
            }

            const minutes = Math.floor(timeRemaining / 60);
            const seconds = timeRemaining % 60;
            const display = minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
            
            const timerEl = document.getElementById('timer');
            timerEl.textContent = display;

            if (timeRemaining <= 60) {
                timerEl.classList.add('warning');
            }
            if (timeRemaining <= 30) {
                timerEl.classList.add('danger');
                timerEl.classList.remove('warning');
            }
        }

        updateTimer();
        const timerInterval = setInterval(updateTimer, 1000);

        function autoAdvanceProblem() {
            const currentIndex = <?php echo json_encode($current_problem_index); ?>;
            const nextIndex = currentIndex + 1;
            window.location.href = 'codingExamTimed.php?prob_index=' + nextIndex;
        }

        // Form submission
        $('#submitForm').on('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const btn = $(this).find('button[type="submit"]');
            const originalText = btn.html();
            btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Testing...');
            
            $.ajax({
                type: 'POST',
                url: 'submitCodingExamTimed.php',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        $('#resultContent').html('<div class="alert alert-danger"><strong>Error:</strong> ' + response.error + '</div>');
                        $('#resultSection').show();
                        btn.prop('disabled', false).html(originalText);
                        return;
                    }
                    
                    // Build results HTML with detailed test case info
                    let html = '<div class="alert alert-' + (response.status === 'accepted' ? 'success' : 'danger') + '">';
                    html += '<strong>Status: ' + response.status.toUpperCase() + '</strong><br>';
                    html += 'Test Cases: ' + response.test_cases_passed + '/' + response.test_cases_total;
                    html += '</div>';

                    if (response.results) {
                        response.results.forEach(function(result, index) {
                            const passed = result.passed;
                            const bgColor = passed ? '#d4edda' : '#f8d7da';
                            const borderColor = passed ? '#28a745' : '#dc3545';
                            
                            html += '<div style="padding: 12px; border-radius: 6px; margin: 10px 0; background: ' + bgColor + '; border-left: 4px solid ' + borderColor + ';">';
                            html += '<strong>' + (passed ? '✓ PASSED' : '✗ FAILED') + ' - Test Case ' + (index + 1) + '</strong><br>';
                            html += '<small style="color: #555;"><strong>Input:</strong> <code style="background: rgba(0,0,0,0.05); padding: 2px 6px; border-radius: 3px;">' + escapeHtml(result.input) + '</code></small><br>';
                            html += '<small style="color: #555;"><strong>Expected:</strong> <code style="background: rgba(0,0,0,0.05); padding: 2px 6px; border-radius: 3px;">' + escapeHtml(result.expected) + '</code></small>';
                            
                            if (result.actual) {
                                html += '<br><small style="color: #555;"><strong>Got:</strong> <code style="background: rgba(0,0,0,0.05); padding: 2px 6px; border-radius: 3px;">' + escapeHtml(result.actual) + '</code></small>';
                            }
                            
                            if (result.error) {
                                html += '<br><small style="color: #d32f2f;"><strong>Error:</strong> ' + escapeHtml(result.error) + '</small>';
                            }
                            
                            html += '</div>';
                        });
                    }

                    $('#resultContent').html(html);
                    $('#resultSection').show();
                    
                    // Auto-advance to next problem after delay if all tests passed
                    if (response.auto_advance) {
                        setTimeout(function() {
                            autoAdvanceProblem();
                        }, 3000);
                    } else {
                        btn.prop('disabled', false).html(originalText);
                    }
                },
                error: function(err) {
                    $('#resultContent').html('<div class="alert alert-danger"><strong>Error:</strong> Failed to submit code. Please try again.</div>');
                    $('#resultSection').show();
                    btn.prop('disabled', false).html(originalText);
                }
            });
        });
        
        // Helper function to escape HTML
        function escapeHtml(text) {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, function(m) { return map[m]; });
        }
    </script>
</body>
</html>
<?php $conn->close(); ?>
