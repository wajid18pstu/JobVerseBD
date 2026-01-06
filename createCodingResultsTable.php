<?php
include 'connect.php';

$sql = "CREATE TABLE IF NOT EXISTS coding_exam_results (
  result_id int(11) NOT NULL AUTO_INCREMENT,
  seeker_id int(11) NOT NULL,
  exam_id int(11) NOT NULL,
  total_score int(11) NOT NULL DEFAULT 0,
  max_score int(11) NOT NULL DEFAULT 100,
  problems_solved int(11) NOT NULL DEFAULT 0,
  total_problems int(11) NOT NULL DEFAULT 5,
  time_taken_seconds int(11),
  completed_at timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (result_id),
  KEY seeker_id (seeker_id),
  KEY exam_id (exam_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if ($conn->query($sql) === TRUE) {
    echo "Table created successfully!";
} else {
    echo "Error creating table: " . $conn->error;
}
?>
