<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Report Lost Item</title>
</head>
<body>
    <h1>Report a Lost Item</h1>
    <form action="report_item.php" method="post" enctype="multipart/form-data">
        <label for="name">Your Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label for="item_name">Item Name:</label><br>
        <input type="text" name="item_name" required><br><br>

        <label for="description">Description:</label><br>
        <textarea name="description" required></textarea><br><br>

        <label for="lost_date">Date Lost:</label><br>
        <input type="date" name="lost_date" required><br><br>

        <label for="location">Location:</label><br>
        <input type="text" name="location" required><br><br>

        <label for="item_image">Upload Image:</label><br>
        <input type="file" name="item_image" accept="image/*" required><br><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
