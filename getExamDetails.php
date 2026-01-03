<?php
// Get exam details and questions for taking exam
session_start();
include 'connect.php';

if (!isset($_SESSION['sid'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

$exam_id = isset($_GET['exam_id']) ? (int)$_GET['exam_id'] : 1;
$seeker_id = $_SESSION['sid'];

// Get exam details
$exam_query = "SELECT * FROM exams WHERE exam_id = $exam_id AND is_active = 1";
$exam_result = mysqli_query($conn, $exam_query);

if (!$exam_result || mysqli_num_rows($exam_result) == 0) {
    echo json_encode(['success' => false, 'message' => 'Exam not found']);
    exit;
}

$exam = mysqli_fetch_assoc($exam_result);

// Get all questions with randomized options
$questions_query = "SELECT * FROM exam_questions WHERE exam_id = $exam_id ORDER BY RAND()";
$questions_result = mysqli_query($conn, $questions_query);

if (!$questions_result) {
    echo json_encode(['success' => false, 'message' => 'Failed to fetch questions']);
    exit;
}

$questions = [];
while ($q = mysqli_fetch_assoc($questions_result)) {
    $questions[] = [
        'question_id' => $q['question_id'],
        'question_text' => $q['question_text'],
        'options' => [
            'A' => $q['option_a'],
            'B' => $q['option_b'],
            'C' => $q['option_c'],
            'D' => $q['option_d']
        ],
        'marks' => $q['marks']
    ];
}

echo json_encode([
    'success' => true,
    'exam' => [
        'exam_id' => $exam['exam_id'],
        'exam_name' => $exam['exam_name'],
        'description' => $exam['description'],
        'total_questions' => $exam['total_questions'],
        'total_marks' => $exam['total_marks'],
        'passing_marks' => $exam['passing_marks'],
        'duration_minutes' => $exam['duration_minutes']
    ],
    'questions' => $questions
]);
?>
