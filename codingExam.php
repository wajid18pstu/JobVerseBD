<?php
session_start();
if (!isset($_SESSION['sid'])) {
    header("Location: signin.php");
    exit();
}

include 'connect.php';

// Get exam info
$sql = "SELECT * FROM exams WHERE exam_id = 5";
$result = $conn->query($sql);
$exam = $result->fetch_assoc();

if (!$exam) {
    // Create exam if doesn't exist
    $sql = "INSERT INTO exams (exam_name, exam_description, exam_category, exam_type, total_questions, total_marks, passing_marks, duration_minutes, status) 
            VALUES ('Coding Challenge', 'Solve programming problems like on Codeforces. Solve real-world coding challenges with multiple test cases.', 'coding', 'Coding Problems', 5, 100, 50, 180, 1)";
    $conn->query($sql);
}

// Get all coding problems
$sql = "SELECT * FROM coding_problems";
$problems_result = $conn->query($sql);
$problems = [];
while ($row = $problems_result->fetch_assoc()) {
    $problems[] = $row;
}

if (count($problems) == 0) {
    // Sample problems not created yet
    $sample_problems = [
        [
            'title' => 'Sum of Two Numbers',
            'description' => 'Given two integers A and B, find their sum.

Input Format:
First line contains two space-separated integers A and B

Output Format:
Print the sum of A and B

Constraints:
1 ≤ A, B ≤ 10^9',
            'difficulty' => 'easy',
            'sample_input' => '5 10',
            'sample_output' => '15',
            'explanation' => 'Simply add A and B and print the result.',
            'points' => 10
        ],
        [
            'title' => 'Reverse a String',
            'description' => 'Given a string S, reverse it and print it.

Input Format:
First line contains a string S

Output Format:
Print the reversed string

Constraints:
1 ≤ length of S ≤ 1000',
            'difficulty' => 'easy',
            'sample_input' => 'hello',
            'sample_output' => 'olleh',
            'explanation' => 'Use string reversal operations to reverse the input string.',
            'points' => 10
        ],
        [
            'title' => 'Count Vowels',
            'description' => 'Given a string S, count the number of vowels in it.

Input Format:
First line contains a string S

Output Format:
Print the count of vowels (a, e, i, o, u)

Constraints:
1 ≤ length of S ≤ 10000',
            'difficulty' => 'easy',
            'sample_input' => 'programming',
            'sample_output' => '3',
            'explanation' => 'Iterate through each character and count vowels.',
            'points' => 10
        ],
        [
            'title' => 'Fibonacci Series',
            'description' => 'Given N, print the first N Fibonacci numbers.

Input Format:
First line contains integer N

Output Format:
Print N Fibonacci numbers separated by space

Constraints:
1 ≤ N ≤ 50',
            'difficulty' => 'medium',
            'sample_input' => '7',
            'sample_output' => '0 1 1 2 3 5 8',
            'explanation' => 'Use the Fibonacci formula where F(n) = F(n-1) + F(n-2), with F(0)=0 and F(1)=1.',
            'points' => 15
        ],
        [
            'title' => 'Find Largest Element',
            'description' => 'Given an array of N integers, find the largest element.

Input Format:
First line contains N
Second line contains N space-separated integers

Output Format:
Print the largest element

Constraints:
1 ≤ N ≤ 10^5
-10^9 ≤ elements ≤ 10^9',
            'difficulty' => 'easy',
            'sample_input' => "5\n3 7 2 9 1",
            'sample_output' => '9',
            'explanation' => 'Compare all elements and find the maximum value.',
            'points' => 15
        ]
    ];
    
    foreach ($sample_problems as $prob) {
        $stmt = $conn->prepare("INSERT INTO coding_problems (exam_id, title, description, difficulty, sample_input, sample_output, explanation, points) VALUES (5, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('ssssssi', $prob['title'], $prob['description'], $prob['difficulty'], $prob['sample_input'], $prob['sample_output'], $prob['explanation'], $prob['points']);
        $stmt->execute();
        $stmt->close();
        
        $problem_id = $conn->insert_id;
        
        // Insert sample test cases
        if ($problem_id == 1) {
            $test_data = [
                ['5 10', '15', 1],
                ['100 200', '300', 0],
                ['-5 5', '0', 0]
            ];
        } elseif ($problem_id == 2) {
            $test_data = [
                ['hello', 'olleh', 1],
                ['world', 'dlrow', 0],
                ['coding', 'gnidoc', 0]
            ];
        } elseif ($problem_id == 3) {
            $test_data = [
                ['programming', '3', 1],
                ['hello', '2', 0],
                ['aeiou', '5', 0]
            ];
        } elseif ($problem_id == 4) {
            $test_data = [
                ['7', '0 1 1 2 3 5 8', 1],
                ['1', '0', 0],
                ['10', '0 1 1 2 3 5 8 13 21 34', 0]
            ];
        } else {
            $test_data = [
                ["5\n3 7 2 9 1", '9', 1],
                ["3\n-5 -2 -10", '-2', 0],
                ["1\n42", '42', 0]
            ];
        }
        
        foreach ($test_data as $tc) {
            $stmt2 = $conn->prepare("INSERT INTO test_cases (problem_id, input, expected_output, is_sample) VALUES (?, ?, ?, ?)");
            $stmt2->bind_param('issi', $problem_id, $tc[0], $tc[1], $tc[2]);
            $stmt2->execute();
            $stmt2->close();
        }
    }
    
    // Reload problems
    $sql = "SELECT * FROM coding_problems";
    $problems_result = $conn->query($sql);
    $problems = [];
    while ($row = $problems_result->fetch_assoc()) {
        $problems[] = $row;
    }
}

// Check if problem_id is passed to show specific problem
$current_problem = null;
$test_cases = [];
if (isset($_GET['problem_id'])) {
    $problem_id = (int)$_GET['problem_id'];
    $sql = "SELECT * FROM coding_problems WHERE problem_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $problem_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $current_problem = $result->fetch_assoc();
    $stmt->close();
    
    // Get test cases for this problem
    $sql = "SELECT * FROM test_cases WHERE problem_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $problem_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $test_cases[] = $row;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Coding Exam - JobVerse</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body { background-color: #f5f5f5; padding: 10px; }
        .coding-container { max-width: 1400px; margin: 0 auto; }
        .problem-card { 
            background: white; 
            padding: 15px; 
            margin: 10px 0; 
            border-radius: 8px; 
            box-shadow: 0 2px 4px rgba(0,0,0,0.1); 
            cursor: pointer;
            transition: all 0.3s ease;
            border-left: 5px solid #007bff;
        }
        .problem-card:hover { 
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
            transform: translateY(-2px);
        }
        .problem-card.easy { border-left-color: #28a745; }
        .problem-card.medium { border-left-color: #ffc107; }
        .problem-card.hard { border-left-color: #dc3545; }
        .difficulty-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        .difficulty-badge.easy { background-color: #d4edda; color: #155724; }
        .difficulty-badge.medium { background-color: #fff3cd; color: #856404; }
        .difficulty-badge.hard { background-color: #f8d7da; color: #721c24; }
        .problem-title { font-size: 18px; font-weight: bold; margin-bottom: 5px; }
        .problem-points { color: #666; font-size: 14px; }
        .editor-section { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .code-editor { 
            width: 100%; 
            min-height: 400px; 
            font-family: 'Courier New', monospace; 
            padding: 10px; 
            border: 1px solid #ddd; 
            border-radius: 4px;
        }
        .problem-details { background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
        .sample-io { background: #f8f9fa; padding: 10px; border-radius: 4px; margin: 10px 0; border-left: 3px solid #007bff; }
        .sample-label { font-weight: bold; color: #007bff; }
        .btn-submit { width: 100%; margin-top: 15px; }
        .result-section { margin-top: 20px; }
        .test-case-result { padding: 10px; border-radius: 4px; margin: 5px 0; }
        .test-passed { background-color: #d4edda; border-left: 3px solid #28a745; }
        .test-failed { background-color: #f8d7da; border-left: 3px solid #dc3545; }
        .problems-list { max-height: 600px; overflow-y: auto; }
        .row-equal-height { display: flex; }
        .row-equal-height > [class*='col-'] { display: flex; flex-direction: column; }
    </style>
</head>
<body>
    
    
    <div class="coding-container">
        <h1 style="color: #333; margin-bottom: 30px;">
            <i class="fa fa-code"></i> Coding Challenge Exam
        </h1>
        
        <div class="row row-equal-height">
            <!-- Problems List -->
            <div class="col-md-4">
                <div class="editor-section">
                    <h4 style="margin-bottom: 20px;">
                        <i class="fa fa-list"></i> Problems (<?php echo count($problems); ?>)
                    </h4>
                    <div class="problems-list">
                        <?php foreach ($problems as $problem): ?>
                            <a href="codingExam.php?problem_id=<?php echo $problem['problem_id']; ?>" style="text-decoration: none; color: inherit;">
                                <div class="problem-card <?php echo $problem['difficulty']; ?>">
                                    <div class="problem-title"><?php echo htmlspecialchars($problem['title']); ?></div>
                                    <div style="margin-top: 8px;">
                                        <span class="difficulty-badge <?php echo $problem['difficulty']; ?>">
                                            <?php echo ucfirst($problem['difficulty']); ?>
                                        </span>
                                        <span class="problem-points">• <?php echo $problem['points']; ?> Points</span>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            
            <!-- Problem Editor Section -->
            <div class="col-md-8">
                <?php if ($current_problem): ?>
                    <!-- Problem Statement -->
                    <div class="problem-details">
                        <h3><?php echo htmlspecialchars($current_problem['title']); ?></h3>
                        <span class="difficulty-badge <?php echo $current_problem['difficulty']; ?>" style="margin-bottom: 15px; display: inline-block;">
                            <?php echo ucfirst($current_problem['difficulty']); ?>
                        </span>
                        
                        <hr>
                        
                        <h5>Problem Statement:</h5>
                        <p style="white-space: pre-wrap; line-height: 1.6;">
                            <?php echo htmlspecialchars($current_problem['description']); ?>
                        </p>
                        
                        <?php if ($current_problem['explanation']): ?>
                            <h5 style="margin-top: 20px;">Explanation:</h5>
                            <p><?php echo htmlspecialchars($current_problem['explanation']); ?></p>
                        <?php endif; ?>
                        
                        <h5 style="margin-top: 20px;">Sample Input:</h5>
                        <div class="sample-io">
                            <pre><?php echo htmlspecialchars($current_problem['sample_input']); ?></pre>
                        </div>
                        
                        <h5>Sample Output:</h5>
                        <div class="sample-io">
                            <pre><?php echo htmlspecialchars($current_problem['sample_output']); ?></pre>
                        </div>
                    </div>
                    
                    <!-- Code Editor -->
                    <div class="editor-section">
                        <form id="submitForm" method="POST" action="submitCodingExam.php">
                            <input type="hidden" name="problem_id" value="<?php echo $current_problem['problem_id']; ?>">
                            
                            <div class="form-group">
                                <label>Select Language:</label>
                                <select name="language" class="form-control" required>
                                    <option value="">-- Choose Language --</option>
                                    <option value="python">Python 3</option>
                                    <option value="cpp">C++</option>
                                    <option value="java">Java</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Write Your Code:</label>
                                <textarea name="code" class="code-editor" placeholder="Write your solution here..." required></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-success btn-submit">
                                <i class="fa fa-paper-plane"></i> Submit & Test Code
                            </button>
                        </form>
                    </div>
                    
                    <!-- Result Section (populated by JavaScript/AJAX) -->
                    <div class="result-section" id="resultSection" style="display:none;">
                        <div class="editor-section">
                            <h5>Test Results:</h5>
                            <div id="resultContent"></div>
                        </div>
                    </div>
                    
                <?php else: ?>
                    <div class="editor-section" style="text-align: center; padding: 40px;">
                        <p style="font-size: 18px; color: #666;">
                            <i class="fa fa-arrow-left"></i> Select a problem to start coding
                        </p>
                        <?php if (isset($_GET['problem_id'])): ?>
                            <p style="color: red; margin-top: 20px;">
                                <strong>Debug:</strong> Problem ID <?php echo htmlspecialchars($_GET['problem_id']); ?> not found. 
                                Available problems: <?php echo implode(', ', array_column($problems, 'problem_id')); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <script src="js/jquery-1.11.3.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        $('#submitForm').on('submit', function(e) {
            e.preventDefault();
            
            var formData = new FormData(this);
            var btn = $(this).find('button[type="submit"]');
            var originalText = btn.html();
            btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Testing...');
            
            $.ajax({
                type: 'POST',
                url: 'submitCodingExam.php',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        $('#resultContent').html('<div class="alert alert-danger">' + response.error + '</div>');
                        $('#resultSection').show();
                        return;
                    }
                    var html = '<div class="alert alert-' + (response.status === 'accepted' ? 'success' : 'danger') + '">';
                    html += '<strong>Status: ' + response.status.toUpperCase() + '</strong><br>';
                    html += 'Test Cases: ' + response.test_cases_passed + '/' + response.test_cases_total + '<br>';
                    html += '</div>';
                    
                    if (response.results) {
                        response.results.forEach(function(result, index) {
                            var cssClass = result.passed ? 'test-passed' : 'test-failed';
                            html += '<div class="test-case-result ' + cssClass + '">';
                            html += '<strong>Test Case ' + (index + 1) + ': ' + (result.passed ? '✓ PASSED' : '✗ FAILED') + '</strong><br>';
                            html += 'Input: <pre>' + result.input + '</pre>';
                            html += 'Expected: <pre>' + result.expected + '</pre>';
                            if (result.actual) html += 'Got: <pre>' + result.actual + '</pre>';
                            if (result.error) html += 'Error: <pre>' + result.error + '</pre>';
                            html += '</div>';
                        });
                    }
                    
                    $('#resultContent').html(html);
                    $('#resultSection').show();
                },
                error: function(err) {
                    console.error('AJAX Error:', err);
                    var errorMsg = 'Error submitting code. Please try again.';
                    if (err.responseText) {
                        errorMsg += '<br><small>' + err.responseText + '</small>';
                    }
                    $('#resultContent').html('<div class="alert alert-danger">' + errorMsg + '</div>');
                    $('#resultSection').show();
                },
                complete: function() {
                    btn.prop('disabled', false).html(originalText);
                }
            });
        });
    </script>
</body>
</html>
<?php $conn->close(); ?>
