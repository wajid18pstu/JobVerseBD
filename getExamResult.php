<?php
// Get specific exam result
session_start();
include 'connect.php';

if (!isset($_SESSION['sid'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

$result_id = isset($_GET['result_id']) ? (int)$_GET['result_id'] : 0;

if (!$result_id) {
    echo json_encode(['success' => false, 'message' => 'No result ID provided']);
    exit;
}

// Get result details
$result_query = "SELECT er.*, e.exam_name, e.passing_marks
                 FROM exam_results er
                 JOIN exams e ON er.exam_id = e.exam_id
                 WHERE er.result_id = $result_id AND er.seeker_id = " . $_SESSION['sid'];

$result = mysqli_query($conn, $result_query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo json_encode(['success' => false, 'message' => 'Result not found']);
    exit;
}

$result_data = mysqli_fetch_assoc($result);

// Get all answers
$answers_query = "SELECT ea.*, eq.question_text, eq.option_a, eq.option_b, eq.option_c, eq.option_d, eq.correct_option, eq.marks
                  FROM exam_answers ea
                  JOIN exam_questions eq ON ea.question_id = eq.question_id
                  WHERE ea.result_id = $result_id
                  ORDER BY ea.answer_id ASC";

$answers = mysqli_query($conn, $answers_query);
$answers_list = [];

while ($ans = mysqli_fetch_assoc($answers)) {
    $answers_list[] = $ans;
}

echo json_encode([
    'success' => true,
    'result' => $result_data,
    'answers' => $answers_list
]);
?>
