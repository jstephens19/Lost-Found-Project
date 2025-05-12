<?php
// public/signup.php
session_start();
require_once __DIR__ . '/db.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name            = trim($_POST['name'] ?? '');
    $email           = trim($_POST['email'] ?? '');
    $password        = $_POST['password'] ?? '';
    $passwordConfirm = $_POST['password_confirm'] ?? '';

    // Basic validation
    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid name and email.';
    }
    if ($password === '' || $password !== $passwordConfirm) {
        $errors[] = 'Passwords must be non-empty and match.';
    }

    if (empty($errors)) {
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors[] = 'That email is already registered.';
        } else {
            // Insert new user
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("
                INSERT INTO users (name, email, password_hash)
                VALUES (:name, :email, :hash)
            ");
            $stmt->execute([
                ':name'  => $name,
                ':email' => $email,
                ':hash'  => $hash,
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
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sign Up</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <h1>Create an Account</h1>
  <?php if ($errors): ?>
    <ul class="errors">
      <?php foreach ($errors as $e): ?>
        <li><?php echo htmlspecialchars($e); ?></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <form action="signup.php" method="post">
    <label>
      Full Name:<br>
      <input type="text" name="name" value="<?php echo htmlspecialchars($name ?? ''); ?>" required>
    </label><br><br>

    <label>
      Email Address:<br>
      <input type="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
    </label><br><br>

    <label>
      Password:<br>
      <input type="password" name="password" required>
    </label><br><br>

    <label>
      Confirm Password:<br>
      <input type="password" name="password_confirm" required>
    </label><br><br>

    <button type="submit">Sign Up</button>
  </form>

  <p>Already have an account? <a href="login.php">Log in here</a>.</p>
</body>
</html>
