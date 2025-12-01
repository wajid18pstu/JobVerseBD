<?php
/**
 * Debug Job Posts
 * Check what jobs are in the database
 */

include 'connect.php';

// Get all posts
$sql = "SELECT id, eid, name, status FROM post ORDER BY id DESC LIMIT 10";
$result = $conn->query($sql);

echo "<h2>Recent Posts in Database:</h2>";
echo "<table border='1' cellpadding='10'>";
echo "<tr><th>ID</th><th>Employer ID</th><th>Name</th><th>Status</th></tr>";

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['eid'] . "</td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . $row['status'] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>No posts found</td></tr>";
}

echo "</table>";

// Get all jobsapplied
echo "<br><h2>Applications in Database:</h2>";
$applySql = "SELECT id, pid, sid, status FROM jobsapplied ORDER BY id DESC LIMIT 10";
$applyResult = $conn->query($applySql);

echo "<table border='1' cellpadding='10'>";
echo "<tr><th>ID</th><th>Post ID</th><th>Seeker ID</th><th>Status</th></tr>";

if ($applyResult->num_rows > 0) {
    while($row = $applyResult->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['pid'] . "</td>";
        echo "<td>" . $row['sid'] . "</td>";
        echo "<td>" . $row['status'] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>No applications found</td></tr>";
}

echo "</table>";

?>
