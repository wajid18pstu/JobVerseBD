<?php
session_start();
require_once 'connect.php';

// Get result ID from request
$result_id = isset($_GET['result_id']) ? intval($_GET['result_id']) : 0;

if (!$result_id) {
    die('Invalid result ID');
}

// Fetch result data
$query = "SELECT er.*, eq.exam_title, s.name, s.email 
          FROM exam_results er 
          LEFT JOIN exams eq ON er.exam_id = eq.exam_id 
          LEFT JOIN seeker s ON er.seeker_id = s.id 
          WHERE er.result_id = ?
          LIMIT 1";

$stmt = $conn->prepare($query);
$stmt->bind_param('i', $result_id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

if (!$result) {
    die('Result not found');
}

// Check if passed
if ($result['status'] !== 'passed') {
    die('Certificate can only be generated for passed exams');
}

// Get correct count
$query = "SELECT COUNT(*) as correct_count FROM exam_answers WHERE result_id = ? AND is_correct = 1";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $result_id);
$stmt->execute();
$correct = $stmt->get_result()->fetch_assoc();

// Get total questions
$query = "SELECT COUNT(*) as total FROM exam_answers WHERE result_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $result_id);
$stmt->execute();
$total = $stmt->get_result()->fetch_assoc();

// Return certificate data as JSON
header('Content-Type: application/json');
echo json_encode([
    'success' => true,
    'certificate_data' => [
        'candidate_name' => $result['name'],
        'exam_title' => $result['exam_title'],
        'exam_date' => date('F j, Y', strtotime($result['created_at'])),
        'percentage' => $result['percentage'],
        'marks_obtained' => $result['total_marks_obtained'],
        'marks_possible' => $result['total_marks_possible'],
        'correct_answers' => $correct['correct_count'],
        'total_questions' => $total['total'],
        'passing_marks' => $result['passing_marks']
    ]
]);
?>
