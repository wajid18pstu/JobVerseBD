<?php
// Get exam result history for a seeker
session_start();
include 'connect.php';

if (!isset($_SESSION['sid'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

$seeker_id = $_SESSION['sid'];

// Get traditional exam results
$results_query = "SELECT er.result_id, er.exam_id, e.exam_name, er.total_marks_obtained, er.total_marks_possible, 
                         er.percentage, er.status, er.submitted_at, er.time_taken_seconds
                  FROM exam_results er
                  JOIN exams e ON er.exam_id = e.exam_id
                  WHERE er.seeker_id = $seeker_id
                  ORDER BY er.submitted_at DESC";

$results = mysqli_query($conn, $results_query);

if (!$results) {
    echo json_encode(['success' => false, 'message' => 'Failed to fetch results']);
    exit;
}

$result_list = [];
while ($row = mysqli_fetch_assoc($results)) {
    $result_list[] = $row;
}

// Get coding exam results
$coding_query = "SELECT result_id, exam_id, total_score, max_score, problems_solved, total_problems, 
                        time_taken_seconds, completed_at
                 FROM coding_exam_results
                 WHERE seeker_id = $seeker_id
                 ORDER BY completed_at DESC";

$coding_results = mysqli_query($conn, $coding_query);

if ($coding_results) {
    while ($row = mysqli_fetch_assoc($coding_results)) {
        // Format coding results to match traditional exam results format
        $result_list[] = [
            'result_id' => $row['result_id'],
            'exam_id' => $row['exam_id'],
            'exam_name' => 'Coding Challenge Exam',
            'total_marks_obtained' => $row['total_score'],
            'total_marks_possible' => $row['max_score'],
            'percentage' => ($row['max_score'] > 0) ? ($row['total_score'] / $row['max_score'] * 100) : 0,
            'status' => ($row['total_score'] >= 50) ? 'passed' : 'failed',
            'submitted_at' => $row['completed_at'],
            'time_taken_seconds' => $row['time_taken_seconds'],
            'problems_solved' => $row['problems_solved'],
            'total_problems' => $row['total_problems'],
            'is_coding' => true
        ];
    }
}

// Sort by submitted_at date
usort($result_list, function($a, $b) {
    return strtotime($b['submitted_at']) - strtotime($a['submitted_at']);
});

echo json_encode([
    'success' => true,
    'results' => $result_list
]);
?>

