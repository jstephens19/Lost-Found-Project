<?php
require_once __DIR__ . '/db.php';
$stmt = $pdo->prepare("SELECT * FROM items WHERE status = 'lost' ORDER BY created_at DESC");
$stmt->execute();
$items = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Lost Items</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <h1>Lost Items</h1>
  <nav>
    <a href="found.php">View Found Items</a> |
  </nav>
  <div class="grid">
    <?php if ($items): foreach ($items as $item): ?>
      <div class="card">
        <?php if ($item['image_path']): ?>
          <img src="<?php echo htmlspecialchars($item['image_path'], ENT_QUOTES); ?>" alt="">
        <?php endif; ?>
        <h3><?php echo htmlspecialchars($item['title'], ENT_QUOTES); ?></h3>
        <p><?php echo nl2br(htmlspecialchars($item['description'], ENT_QUOTES)); ?></p>
        <small>Reported on <?php echo date('M j, Y', strtotime($item['created_at'])); ?></small>
      </div>
    <?php endforeach; else: ?>
      <p>No lost items reported yet.</p>
    <?php endif; ?>
  </div>
</body>
</html>
