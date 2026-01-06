<?php
include 'connect.php';

// Create coding_problems table
$sql1 = "CREATE TABLE IF NOT EXISTS coding_problems (
  problem_id int(11) NOT NULL AUTO_INCREMENT,
  exam_id int(11) NOT NULL,
  title varchar(255) NOT NULL,
  description longtext NOT NULL,
  difficulty varchar(50) NOT NULL DEFAULT 'medium',
  time_limit int(11) NOT NULL DEFAULT 2,
  memory_limit int(11) NOT NULL DEFAULT 256,
  sample_input longtext NOT NULL,
  sample_output longtext NOT NULL,
  explanation longtext,
  language_support varchar(255) NOT NULL DEFAULT 'python,cpp,java',
  points int(11) NOT NULL DEFAULT 10,
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (problem_id),
  KEY exam_id (exam_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

// Create test_cases table
$sql2 = "CREATE TABLE IF NOT EXISTS test_cases (
  test_case_id int(11) NOT NULL AUTO_INCREMENT,
  problem_id int(11) NOT NULL,
  input longtext NOT NULL,
  expected_output longtext NOT NULL,
  is_sample tinyint(1) NOT NULL DEFAULT 0,
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (test_case_id),
  KEY problem_id (problem_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

// Create coding_submissions table
$sql3 = "CREATE TABLE IF NOT EXISTS coding_submissions (
  submission_id int(11) NOT NULL AUTO_INCREMENT,
  seeker_id int(11) NOT NULL,
  problem_id int(11) NOT NULL,
  exam_id int(11) NOT NULL,
  code longtext NOT NULL,
  language varchar(50) NOT NULL,
  status varchar(50) NOT NULL DEFAULT 'pending',
  test_cases_passed int(11) NOT NULL DEFAULT 0,
  test_cases_total int(11) NOT NULL DEFAULT 0,
  execution_time float,
  memory_used int(11),
  error_message longtext,
  points_earned int(11) DEFAULT 0,
  submitted_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (submission_id),
  KEY seeker_id (seeker_id),
  KEY problem_id (problem_id),
  KEY exam_id (exam_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

// Execute table creation
if ($conn->query($sql1) === TRUE) {
    echo "coding_problems table created successfully<br>";
} else {
    echo "Error creating coding_problems table: " . $conn->error . "<br>";
}

if ($conn->query($sql2) === TRUE) {
    echo "test_cases table created successfully<br>";
} else {
    echo "Error creating test_cases table: " . $conn->error . "<br>";
}

if ($conn->query($sql3) === TRUE) {
    echo "coding_submissions table created successfully<br>";
} else {
    echo "Error creating coding_submissions table: " . $conn->error . "<br>";
}

// Add coding exam to exams table if not exists
$sql4 = "INSERT IGNORE INTO exams (exam_name, exam_description, exam_category, exam_type, total_questions, total_marks, passing_marks, duration_minutes, status) 
VALUES ('Coding Challenge', 'Solve programming problems like on Codeforces. Solve real-world coding challenges with multiple test cases.', 'coding', 'Coding Problems', 5, 100, 50, 180, 1)";

if ($conn->query($sql4) === TRUE) {
    echo "Coding exam added to exams table<br>";
} else {
    echo "Error adding coding exam: " . $conn->error . "<br>";
}

// Insert sample coding problems
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

$problem_ids = [];
foreach ($problems as $index => $problem) {
    $sql = "INSERT INTO coding_problems (exam_id, title, description, difficulty, sample_input, sample_output, explanation, points) 
            VALUES (5, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssssi', 
        $problem['title'],
        $problem['description'],
        $problem['difficulty'],
        $problem['sample_input'],
        $problem['sample_output'],
        $problem['explanation'],
        $problem['points']
    );
    
    if ($stmt->execute()) {
        $problem_ids[$index] = $conn->insert_id;
        echo "Problem added: " . $problem['title'] . "<br>";
    } else {
        echo "Error adding problem: " . $conn->error . "<br>";
    }
}

// Insert test cases
$test_cases = [
    // Problem 1: Sum of Two Numbers
    ['problem_id' => 1, 'input' => '5 10', 'expected_output' => '15', 'is_sample' => 1],
    ['problem_id' => 1, 'input' => '100 200', 'expected_output' => '300', 'is_sample' => 0],
    ['problem_id' => 1, 'input' => '-5 5', 'expected_output' => '0', 'is_sample' => 0],
    ['problem_id' => 1, 'input' => '1000000000 1000000000', 'expected_output' => '2000000000', 'is_sample' => 0],
    
    // Problem 2: Reverse a String
    ['problem_id' => 2, 'input' => 'hello', 'expected_output' => 'olleh', 'is_sample' => 1],
    ['problem_id' => 2, 'input' => 'world', 'expected_output' => 'dlrow', 'is_sample' => 0],
    ['problem_id' => 2, 'input' => 'a', 'expected_output' => 'a', 'is_sample' => 0],
    ['problem_id' => 2, 'input' => 'coding', 'expected_output' => 'gnidoc', 'is_sample' => 0],
    
    // Problem 3: Count Vowels
    ['problem_id' => 3, 'input' => 'programming', 'expected_output' => '3', 'is_sample' => 1],
    ['problem_id' => 3, 'input' => 'hello', 'expected_output' => '2', 'is_sample' => 0],
    ['problem_id' => 3, 'input' => 'aeiou', 'expected_output' => '5', 'is_sample' => 0],
    ['problem_id' => 3, 'input' => 'bcdfg', 'expected_output' => '0', 'is_sample' => 0],
    
    // Problem 4: Fibonacci Series
    ['problem_id' => 4, 'input' => '7', 'expected_output' => '0 1 1 2 3 5 8', 'is_sample' => 1],
    ['problem_id' => 4, 'input' => '1', 'expected_output' => '0', 'is_sample' => 0],
    ['problem_id' => 4, 'input' => '10', 'expected_output' => '0 1 1 2 3 5 8 13 21 34', 'is_sample' => 0],
    
    // Problem 5: Find Largest Element
    ['problem_id' => 5, 'input' => "5\n3 7 2 9 1", 'expected_output' => '9', 'is_sample' => 1],
    ['problem_id' => 5, 'input' => "3\n-5 -2 -10", 'expected_output' => '-2', 'is_sample' => 0],
    ['problem_id' => 5, 'input' => "1\n42", 'expected_output' => '42', 'is_sample' => 0],
    ['problem_id' => 5, 'input' => "4\n100 50 75 80", 'expected_output' => '100', 'is_sample' => 0],
];

foreach ($test_cases as $tc) {
    $sql = "INSERT INTO test_cases (problem_id, input, expected_output, is_sample) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('issi', $tc['problem_id'], $tc['input'], $tc['expected_output'], $tc['is_sample']);
    
    if ($stmt->execute()) {
        echo "Test case added for problem " . $tc['problem_id'] . "<br>";
    } else {
        echo "Error adding test case: " . $conn->error . "<br>";
    }
}

echo "<hr><h3>All tables and sample data created successfully!</h3>";
$conn->close();
?>
