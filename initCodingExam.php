<?php
/**
 * Initialize Coding Exam Tables
 * Access this file via browser: http://localhost/JobVerseBD/initCodingExam.php
 */

include 'connect.php';

echo "<h2>Initializing Coding Exam System...</h2>";
echo "<hr>";

// Create coding_problems table
$sql = "CREATE TABLE IF NOT EXISTS coding_problems (
  problem_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  exam_id int(11) NOT NULL,
  title varchar(255) NOT NULL,
  description longtext NOT NULL,
  difficulty varchar(50) DEFAULT 'medium',
  time_limit int(11) DEFAULT 2,
  memory_limit int(11) DEFAULT 256,
  sample_input longtext NOT NULL,
  sample_output longtext NOT NULL,
  explanation longtext,
  language_support varchar(255) DEFAULT 'python,cpp,java',
  points int(11) DEFAULT 10,
  created_at timestamp DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql)) {
    echo "✓ coding_problems table created<br>";
} else {
    echo "✗ Error: " . $conn->error . "<br>";
}

// Create test_cases table
$sql = "CREATE TABLE IF NOT EXISTS test_cases (
  test_case_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  problem_id int(11) NOT NULL,
  input longtext NOT NULL,
  expected_output longtext NOT NULL,
  is_sample tinyint(1) DEFAULT 0,
  created_at timestamp DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql)) {
    echo "✓ test_cases table created<br>";
} else {
    echo "✗ Error: " . $conn->error . "<br>";
}

// Create coding_submissions table
$sql = "CREATE TABLE IF NOT EXISTS coding_submissions (
  submission_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  seeker_id int(11) NOT NULL,
  problem_id int(11) NOT NULL,
  exam_id int(11) NOT NULL,
  code longtext NOT NULL,
  language varchar(50) NOT NULL,
  status varchar(50) DEFAULT 'pending',
  test_cases_passed int(11) DEFAULT 0,
  test_cases_total int(11) DEFAULT 0,
  execution_time float,
  memory_used int(11),
  error_message longtext,
  points_earned int(11) DEFAULT 0,
  submitted_at timestamp DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql)) {
    echo "✓ coding_submissions table created<br>";
} else {
    echo "✗ Error: " . $conn->error . "<br>";
}

echo "<hr>";
echo "<h3>Adding Coding Exam...</h3>";

// Check if coding exam exists
$result = $conn->query("SELECT * FROM exams WHERE exam_category = 'coding'");
if ($result && $result->num_rows == 0) {
    $sql = "INSERT INTO exams (exam_name, exam_description, exam_category, exam_type, total_questions, total_marks, passing_marks, duration_minutes, status) 
            VALUES ('Coding Challenge', 'Solve programming problems like on Codeforces. Solve real-world coding challenges with multiple test cases.', 'coding', 'Coding Problems', 5, 100, 50, 180, 1)";
    
    if ($conn->query($sql)) {
        echo "✓ Coding exam added to exams table<br>";
        $exam_id = $conn->insert_id;
    } else {
        echo "✗ Error: " . $conn->error . "<br>";
        $exam_id = 5;
    }
} else {
    echo "✓ Coding exam already exists<br>";
    $exam_id = 5;
}

echo "<hr>";
echo "<h3>Adding Sample Problems...</h3>";

// Check if problems already exist
$result = $conn->query("SELECT COUNT(*) as count FROM coding_problems WHERE exam_id = 5");
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    $problems = [
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

    foreach ($problems as $prob) {
        $sql = "INSERT INTO coding_problems (exam_id, title, description, difficulty, sample_input, sample_output, explanation, points) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('issssssi', 
            $exam_id,
            $prob['title'],
            $prob['description'],
            $prob['difficulty'],
            $prob['sample_input'],
            $prob['sample_output'],
            $prob['explanation'],
            $prob['points']
        );
        
        if ($stmt->execute()) {
            $problem_id = $conn->insert_id;
            echo "✓ Added: " . $prob['title'] . " (Problem ID: " . $problem_id . ")<br>";
            
            // Add test cases
            $test_data = [];
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
                $tc_sql = "INSERT INTO test_cases (problem_id, input, expected_output, is_sample) VALUES (?, ?, ?, ?)";
                $tc_stmt = $conn->prepare($tc_sql);
                $tc_stmt->bind_param('issi', $problem_id, $tc[0], $tc[1], $tc[2]);
                $tc_stmt->execute();
            }
        } else {
            echo "✗ Error adding problem: " . $conn->error . "<br>";
        }
    }
} else {
    echo "✓ Sample problems already exist<br>";
}

echo "<hr>";
echo "<h3 style='color: green;'>✓ Coding Exam System Initialized Successfully!</h3>";
echo "<p><strong>Next Steps:</strong></p>";
echo "<ol>";
echo "<li>Go to <strong>Seeker Account</strong> page</li>";
echo "<li>Scroll to the <strong>Coding Challenge Exam</strong> section</li>";
echo "<li>Click <strong>Start Coding Challenge Exam</strong> button</li>";
echo "<li>Select a problem and start coding!</li>";
echo "</ol>";
echo "<p><a href='seekerAccount.php' class='btn btn-primary'>Go to Seeker Account →</a></p>";

$conn->close();
?>
