<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['sid'])) {
    echo json_encode(['error' => 'Not authenticated']);
    exit();
}

include 'connect.php';

$seeker_id = $_SESSION['sid'];
$problem_id = (int)$_POST['problem_id'];
$problem_index = (int)$_POST['problem_index'];
$code = $_POST['code'];
$language = $_POST['language'];

// Get problem details
$sql = "SELECT * FROM coding_problems WHERE problem_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $problem_id);
$stmt->execute();
$result = $stmt->get_result();
$problem = $result->fetch_assoc();
$stmt->close();

if (!$problem) {
    echo json_encode(['error' => 'Problem not found']);
    exit();
}

// Get all test cases
$sql = "SELECT * FROM test_cases WHERE problem_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $problem_id);
$stmt->execute();
$result = $stmt->get_result();
$test_cases = [];
while ($row = $result->fetch_assoc()) {
    $test_cases[] = $row;
}
$stmt->close();

// Execute code and test
$results = [];
$passed_count = 0;
$total_count = count($test_cases);
$status = 'accepted';
$error_message = '';

foreach ($test_cases as $test_case) {
    $result = executeCode($code, $language, $test_case['input'], $test_case['expected_output']);
    
    if ($result['error']) {
        $results[] = [
            'input' => $test_case['input'],
            'expected' => $test_case['expected_output'],
            'actual' => null,
            'passed' => false,
            'error' => $result['error']
        ];
        $status = 'compilation_error';
        $error_message = $result['error'];
        break;
    } else {
        $output = trim($result['output']);
        $expected = trim($test_case['expected_output']);
        $passed = ($output === $expected);
        
        if ($passed) {
            $passed_count++;
        } else {
            $status = 'wrong_answer';
        }
        
        $results[] = [
            'input' => $test_case['input'],
            'expected' => $expected,
            'actual' => $output,
            'passed' => $passed
        ];
    }
}

// Calculate points earned
$points_earned = 0;
if ($status === 'accepted') {
    $points_earned = $problem['points'];
}

// Store score in session
if (!isset($_SESSION['coding_exam_scores'])) {
    $_SESSION['coding_exam_scores'] = [];
}
$_SESSION['coding_exam_scores'][$problem_index] = $points_earned;

// Save submission to database
$sql = "INSERT INTO coding_submissions (seeker_id, problem_id, exam_id, code, language, status, test_cases_passed, test_cases_total, error_message, points_earned) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$exam_id = 5;
$stmt->bind_param('iiissiissi', $seeker_id, $problem_id, $exam_id, $code, $language, $status, $passed_count, $total_count, $error_message, $points_earned);
$stmt->execute();
$stmt->close();

// Determine if we should auto-advance
$auto_advance = ($status === 'accepted');

// Return response
echo json_encode([
    'status' => $status,
    'test_cases_passed' => $passed_count,
    'test_cases_total' => $total_count,
    'results' => $results,
    'auto_advance' => $auto_advance,
    'points_earned' => $points_earned
]);

function executeCode($code, $language, $input, $expected_output) {
    global $problem;
    
    $temp_dir = sys_get_temp_dir();
    $temp_file = tempnam($temp_dir, 'code_');
    
    if ($language === 'python') {
        $temp_file .= '.py';
        file_put_contents($temp_file, $code);
        
        $input_file = tempnam($temp_dir, 'input_');
        file_put_contents($input_file, $input);
        
        $cmd = "python \"$temp_file\" < \"$input_file\" 2>&1";
        $output = shell_exec($cmd);
        
        unlink($temp_file);
        unlink($input_file);
        
        if ($output === null) {
            return ['error' => 'Execution failed', 'output' => ''];
        }
        
        return ['error' => null, 'output' => $output];
        
    } elseif ($language === 'cpp') {
        $temp_file .= '.cpp';
        file_put_contents($temp_file, $code);
        
        $executable = str_replace('.cpp', '.exe', $temp_file);
        
        $compile_cmd = "g++ \"$temp_file\" -o \"$executable\" 2>&1";
        $compile_output = shell_exec($compile_cmd);
        
        if ($compile_output && strpos($compile_output, 'error') !== false) {
            unlink($temp_file);
            return ['error' => $compile_output, 'output' => ''];
        }
        
        $input_file = tempnam($temp_dir, 'input_');
        file_put_contents($input_file, $input);
        
        $run_cmd = "\"$executable\" < \"$input_file\" 2>&1";
        $output = shell_exec($run_cmd);
        
        unlink($temp_file);
        unlink($executable);
        unlink($input_file);
        
        if ($output === null) {
            return ['error' => 'Execution failed', 'output' => ''];
        }
        
        return ['error' => null, 'output' => $output];
        
    } elseif ($language === 'java') {
        $class_name = 'Solution';
        $java_file = $temp_dir . '/' . $class_name . '.java';
        
        if (strpos($code, 'class') === false) {
            $java_code = "public class $class_name { public static void main(String[] args) { " . $code . " } }";
        } else {
            $java_code = $code;
        }
        
        file_put_contents($java_file, $java_code);
        
        $compile_cmd = "javac \"$java_file\" 2>&1";
        $compile_output = shell_exec($compile_cmd);
        
        if ($compile_output && strpos($compile_output, 'error') !== false) {
            unlink($java_file);
            return ['error' => $compile_output, 'output' => ''];
        }
        
        $input_file = tempnam($temp_dir, 'input_');
        file_put_contents($input_file, $input);
        
        $run_cmd = "cd \"" . dirname($java_file) . "\" && java $class_name < \"$input_file\" 2>&1";
        $output = shell_exec($run_cmd);
        
        @unlink($java_file);
        @unlink(dirname($java_file) . '/' . $class_name . '.class');
        unlink($input_file);
        
        if ($output === null) {
            return ['error' => 'Execution failed', 'output' => ''];
        }
        
        return ['error' => null, 'output' => $output];
    }
    
    return ['error' => 'Invalid language', 'output' => ''];
}

$conn->close();
?>
