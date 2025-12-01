<?php
/**
 * List All Employers - Find correct ID for testing
 */

include 'connect.php';

echo "<h2>👥 All Employers in Database</h2>";

$sql = "SELECT id, name, email FROM employer ORDER BY id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
    echo "<tr style='background: #f0f0f0;'><th>ID</th><th>Name</th><th>Email</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<br><br>";
    echo "👉 <strong>Use one of these IDs in the debug_payment.php file</strong>";
} else {
    echo "<strong>❌ No employers found in database!</strong>";
    echo "<br>You need to create an employer account first.";
}

?>
