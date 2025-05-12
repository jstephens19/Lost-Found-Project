<?php
require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method Not Allowed');
}

$title       = trim($_POST['title']       ?? '');
$description = trim($_POST['description'] ?? '');
$status      = $_POST['status']           ?? '';
$image       = $_FILES['image']           ?? null;

if (!$title || !$status || !$image) {
    exit('Missing title, status or image.');
}

if ($image['error'] !== UPLOAD_ERR_OK) {
    exit('Upload error code: ' . $image['error']);
}

// Validate image
$info = getimagesize($image['tmp_name']);
if ($info === false) {
    exit('Uploaded file is not a valid image.');
}

$ext = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
$allowed = ['jpg','jpeg','png','gif'];
if (!in_array($ext, $allowed, true)) {
    exit('Unsupported image format.');
}

// Make uploads directory under project root
$targetDir = __DIR__ . '/uploads/';
if (!is_dir($targetDir) && !mkdir($targetDir, 0755, true)) {
    exit('Failed to create uploads directory.');
}

$filename   = uniqid('img_', true) . '.' . $ext;
$targetPath = $targetDir . $filename;
$publicPath = 'uploads/' . $filename;  // relative to project root

if (!move_uploaded_file($image['tmp_name'], $targetPath)) {
    exit('Failed to move uploaded file.');
}

// Insert into database
$sql = "INSERT INTO items (title, description, status, image_path, created_at)
        VALUES (:title, :description, :status, :image, NOW())";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':title'       => $title,
    ':description' => $description,
    ':status'      => $status,
    ':image'       => $publicPath,
]);

// Redirect
header("Location: {$status}.php");
exit;
