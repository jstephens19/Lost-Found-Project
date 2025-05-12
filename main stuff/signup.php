<?php
// public/signup.php
require_once __DIR__ . '/../src/db.php';
session_start();

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pass1 = $_POST['password'] ?? '';
    $pass2 = $_POST['password_confirm'] ?? '';

    if (!$name || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid name & email.';
    }
    if ($pass1 === '' || $pass1 !== $pass2) {
        $errors[] = 'Passwords must match and not be empty.';
    }

    if (empty($errors)) {
        // Check for existing email
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors[] = 'Email already registered.';
        } else {
            // Insert new user
            $hash = password_hash($pass1, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare(
              "INSERT INTO users (name, email, password_hash)
               VALUES (:name, :email, :ph)"
            );
            $stmt->execute([
              ':name' => $name,
              ':email'=> $email,
              ':ph'   => $hash
            ]);
            // Log them in
            $_SESSION['user_id'] = $pdo->lastInsertId();
            header('Location: lost.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Sign Up</title></head>
<body>
  <h1>Sign Up</h1>
  <?php if ($errors): ?>
    <ul style="color:red;">
      <?php foreach($errors as $e) echo "<li>" .htmlspecialchars($e)."</li>"; ?>
    </ul>
  <?php endif; ?>

  <form method="post">
    <label>Name:<br>
      <input type="text" name="name" required>
    </label><br><br>
    <label>Email:<br>
      <input type="email" name="email" required>
    </label><br><br>
    <label>Password:<br>
      <input type="password" name="password" required>
    </label><br><br>
    <label>Confirm Password:<br>
      <input type="password" name="password_confirm" required>
    </label><br><br>
    <button type="submit">Sign Up</button>
  </form>
  <p>Already have an account? <a href="login.php">Login here</a>.</p>
</body>
</html>
