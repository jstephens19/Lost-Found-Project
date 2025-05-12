<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $item_name = $_POST['item_name'];
    $description = $_POST['description'];
    $lost_date = $_POST['lost_date'];
    $location = $_POST['location'];

    // Handle file upload
    if (isset($_FILES['item_image']) && $_FILES['item_image']['error'] == 0) {
        $upload_dir = 'uploads/';
        $uploaded_file = $upload_dir . basename($_FILES['item_image']['name']);
        move_uploaded_file($_FILES['item_image']['tmp_name'], $uploaded_file);
    }

    // Here, you would typically insert the data into a database
    // For demonstration, we'll just display the submitted information
    echo "<h2>Lost Item Report Submitted</h2>";
    echo "<p>Name: $name</p>";
    echo "<p>Email: $email</p>";
    echo "<p>Item Name: $item_name</p>";
    echo "<p>Description: $description</p>";
    echo "<p>Date Lost: $lost_date</p>";
    echo "<p>Location: $location</p>";
    if (isset($uploaded_file)) {
        echo "<p>Image Uploaded: <a href='$uploaded_file'>View Image</a></p>";
    }
} else {
    echo "Invalid request.";
}
?>
