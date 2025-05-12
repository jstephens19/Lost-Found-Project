<?php
// public/login.php
session_start();
require_once __DIR__ . '/../src/db.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $errors[] = 'Please enter both email and password.';
    } else {
        // Fetch user
        $stmt = $pdo->prepare("SELECT id, password_hash FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            // Successful login
            $_SESSION['user_id'] = $user['id'];
            header('Location: lost.php');
            exit;
        } else {
            $errors[] = 'Email or password is incorrect.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <h1>Login</h1>
  <?php if ($errors): ?>
    <ul class="errors">
      <?php foreach ($errors as $e): ?>
        <li><?php echo htmlspecialchars($e); ?></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <form action="login.php" method="post">
    <label>
      Email Address:<br>
      <input type="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
    </label><br><br>

    <label>
      Password:<br>
      <input type="password" name="password" required>
    </label><br><br>

    <button type="submit">Log In</button>
  </form>

  <p>New here? <a href="signup.php">Create an account</a>.</p>
</body>
</html>
