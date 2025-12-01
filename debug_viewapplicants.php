<?php
/**
 * Debug ViewApplicants Query
 * Check what the ViewApplicants query returns
 */

include 'connect.php';
include 'authorizeEmployer.php';

$eid = $_SESSION['eid'];

echo "<h2>Employer ID: $eid</h2>";

// Get employer's posts
echo "<h3>Posts by this employer:</h3>";
$postSql = "SELECT id, name FROM post WHERE eid = $eid";
$postResult = $conn->query($postSql);

echo "<ul>";
if ($postResult->num_rows > 0) {
    while($post = $postResult->fetch_assoc()) {
        echo "<li>ID: " . $post['id'] . " - " . htmlspecialchars($post['name']) . "</li>";
    }
} else {
    echo "<li>No posts found</li>";
}
echo "</ul>";

// Get applications for this employer's posts
echo "<h3>Applications for your posts:</h3>";
$sql = "SELECT id, sid, pid, (SELECT name FROM seeker WHERE id=jobsapplied.sid) as sname, date, status 
        FROM jobsapplied 
        WHERE pid IN (SELECT id FROM post WHERE eid=$eid)
        ORDER BY date DESC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1' cellpadding='10'>";
    echo "<tr><th>App ID</th><th>Seeker ID</th><th>Seeker Name</th><th>Post ID</th><th>Date</th><th>Status</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['sid'] . "</td>";
        echo "<td>" . htmlspecialchars($row['sname']) . "</td>";
        echo "<td>" . $row['pid'] . "</td>";
        echo "<td>" . $row['date'] . "</td>";
        echo "<td>" . $row['status'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No applications found</p>";
}

?>
