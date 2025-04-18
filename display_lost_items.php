<?php
//db connection
$con = new mysqli("localhost", "root", "Sp0ngebob41913!?", "lost_found");

//check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

//get lost items
$result = $con->query("SELECT item_name, description, lost_date, location, image_path FROM lost_items");

while ($row = $result->fetch_assoc()) {
    echo "<div style='padding: 10px; border: 1px solid #ccc; margin-bottom: 15px;'>";
    echo "<h2>" . htmlspecialchars($row['item_name']) . "</h2>";
    echo "<p><strong>Description:</strong> " . htmlspecialchars($row['description']) . "</p>";
    echo "<p><strong>Date Lost:</strong> " . htmlspecialchars($row['lost_date']) . "</p>";
    echo "<p><strong>Location:</strong> " . htmlspecialchars($row['location']) . "</p>";
    if (!empty($row['image_path'])) {
        echo "<img src='" . htmlspecialchars($row['image_path']) . "' alt='Item Image' style='max-width:200px;'><br>";
    }
    echo "</div><hr>";
}

$con->close();
?>
