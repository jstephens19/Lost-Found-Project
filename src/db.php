<?php
// src/db.php

// XAMPP default MySQL credentials
$dbHost = '127.0.0.1';
$dbName = 'campus_lost_found';
$dbUser = 'root';
$dbPass = 'bjfischer'; // default XAMPP root password is empty

try {
    $pdo = new PDO(
        "mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4",
        $dbUser,
        $dbPass,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    // In production, log rather than echo
    die("Database connection failed: " . $e->getMessage());
}
