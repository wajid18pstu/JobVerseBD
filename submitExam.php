<?php
// Submit exam answers and calculate result
session_start();
include 'connect.php';

if (!isset($_SESSION['sid'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

$exam_id = isset($data['exam_id']) ? (int)$data['exam_id'] : 0;
$seeker_id = $_SESSION['sid'];
$answers = isset($data['answers']) ? $data['answers'] : [];
$time_taken = isset($data['time_taken']) ? (int)$data['time_taken'] : 0;

if (!$exam_id || empty($answers)) {
    echo json_encode(['success' => false, 'message' => 'Invalid exam or no answers']);
    exit;
}

// Get exam details
$exam_query = "SELECT * FROM exams WHERE exam_id = $exam_id";
$exam_result = mysqli_query($conn, $exam_query);
$exam = mysqli_fetch_assoc($exam_result);

// Create exam result entry
$started_at = date('Y-m-d H:i:s', strtotime('-' . $time_taken . ' seconds'));
$submitted_at = date('Y-m-d H:i:s');

$result_insert = "INSERT INTO exam_results (exam_id, seeker_id, started_at, submitted_at, time_taken_seconds)
                  VALUES ($exam_id, $seeker_id, '$started_at', '$submitted_at', $time_taken)";

if (!mysqli_query($conn, $result_insert)) {
    echo json_encode(['success' => false, 'message' => 'Failed to save result']);
    exit;
}

$result_id = mysqli_insert_id($conn);

// Calculate marks and store answers
$total_marks = 0;
$correct_count = 0;

foreach ($answers as $question_id => $selected_option) {
    $question_id = (int)$question_id;
    
    // Get correct answer
    $q_query = "SELECT correct_option, marks FROM exam_questions WHERE question_id = $question_id";
    $q_result = mysqli_query($conn, $q_query);
    $question = mysqli_fetch_assoc($q_result);
    
    $is_correct = ($selected_option === $question['correct_option']) ? 1 : 0;
    $marks_obtained = $is_correct ? $question['marks'] : 0;
    
    if ($is_correct) {
        $correct_count++;
        $total_marks += $question['marks'];
    }
    
    // Store answer
    $answer_insert = "INSERT INTO exam_answers (result_id, question_id, selected_option, is_correct, marks_obtained, answered_at)
                      VALUES ($result_id, $question_id, '$selected_option', $is_correct, $marks_obtained, NOW())";
    mysqli_query($conn, $answer_insert);
}

// Update result with total marks and status
$percentage = ($total_marks / $exam['total_marks']) * 100;
$status = $total_marks >= $exam['passing_marks'] ? 'passed' : 'failed';

$update_query = "UPDATE exam_results 
                 SET total_marks_obtained = $total_marks, 
                     percentage = $percentage, 
                     status = '$status'
                 WHERE result_id = $result_id";

mysqli_query($conn, $update_query);

// Get all answers for display
$answers_query = "SELECT ea.answer_id, ea.question_id, ea.selected_option, ea.is_correct, ea.marks_obtained,
                         eq.question_text, eq.option_a, eq.option_b, eq.option_c, eq.option_d, eq.correct_option, eq.marks
                  FROM exam_answers ea
                  JOIN exam_questions eq ON ea.question_id = eq.question_id
                  WHERE ea.result_id = $result_id";

$answers_result = mysqli_query($conn, $answers_query);
$detailed_answers = [];

while ($ans = mysqli_fetch_assoc($answers_result)) {
    $detailed_answers[] = $ans;
}

echo json_encode([
    'success' => true,
    'result_id' => $result_id,
    'total_marks' => $total_marks,
    'total_possible' => $exam['total_marks'],
    'percentage' => round($percentage, 2),
    'status' => $status,
    'correct_count' => $correct_count,
    'total_questions' => $exam['total_questions'],
    'passing_marks' => $exam['passing_marks'],
    'answers' => $detailed_answers
]);
?>
