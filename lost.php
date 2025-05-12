<?php
// Database connection
$con = new mysqli("localhost", "root", "bjfischer", "campus_lost_found");

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Retrieve lost items from the database
$sql = "SELECT li.item_name, li.description, li.lost_date, li.location, li.image_path, u.name, u.email
        FROM lost_items li
        JOIN users u ON li.user_id = u.id
        ORDER BY li.lost_date DESC";

$result = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lost Items - SIMPLICITY</title>
    <style>
        /* Your existing CSS styles */
        html {
            scroll-behavior: smooth;
        }

        nav {
            background-color: #00008B;
            padding: 10px;
            text-align: center;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        nav ul li {
            display: inline;
            margin: 0 15px;
        }

        nav ul li a {
            text-decoration: none;
            color: white;
            font-size: 18px;
            padding: 8px 12px;
        }

        nav ul li a:hover {
            background-color: #007BFF;
            border-radius: 5px;
        }

        .items-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
        }

        .item {
            background-color: #f9f9f9;
            margin-bottom: 25px;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }

        .item img {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
            border-radius: 8px;
        }

        .item h3 {
            color: #0056b3;
        }
    </style>
</head>
<body>

    <!-- Navigation Menu -->
    <nav>
        <ul>
            <li><a href="lostsimplicityfound.html">Home</a></li>
            <li><a href="lost.php">Lost Items</a></li>
            <li><a href="found.html">Found Items</a></li>
            <li><a href="contact.html">Contact</a></li>
            <li><a href="report.html">Report</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="#" onclick="toggleForm()">Sign Up / Login</a></li>
        </ul>
    </nav>

    <!-- Lost Items Display -->
    <div class="items-container">
        <h2 style="text-align:center;">Recently Reported Lost Items</h2>

        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="item">
                    <h3><?php echo htmlspecialchars($row['item_name']); ?></h3>
                    <p><strong>Description:</strong> <?php echo htmlspecialchars($row['description']); ?></p>
                    <p><strong>Date Lost:</strong> <?php echo htmlspecialchars($row['lost_date']); ?></p>
                    <p><strong>Location:</strong> <?php echo htmlspecialchars($row['location']); ?></p>
                    <?php if (!empty($row['image_path'])): ?>
                        <img src="<?php echo htmlspecialchars($row['image_path']); ?>" alt="Item Image">
                    <?php else: ?>
                        <p>No image available.</p>
                    <?php endif; ?>
                    <p><strong>Reported By:</strong> <?php echo htmlspecialchars($row['name']); ?> (<?php echo htmlspecialchars($row['email']); ?>)</p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style='text-align:center;'>No lost items have been reported yet.</p>
        <?php endif; ?>
    </div>

</body>
</html>

<?php
// Close the database connection
$con->close();
?>
