<?php
// Get exam result history for a seeker
session_start();
include 'connect.php';

if (!isset($_SESSION['sid'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

$seeker_id = $_SESSION['sid'];

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

echo json_encode([
    'success' => true,
    'results' => $result_list
]);
?>
