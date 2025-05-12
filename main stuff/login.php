<?php
// public/login.php
require_once __DIR__ . '/db.php';
session_start();

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['password'] ?? '';

    if (filter_var($email, FILTER_VALIDATE_EMAIL) && $pass !== '') {
        $stmt = $pdo->prepare("SELECT id, password_hash FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($pass, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            header('Location: lost.php');
            exit;
        }
    }
    $errors[] = 'Invalid email or password.';
}
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Login</title></head>
<body>
  <h1>Login</h1>
  <?php if ($errors): ?>
    <p style="color:red;"><?php echo htmlspecialchars($errors[0]); ?></p>
  <?php endif; ?>

  <form method="post">
    <label>Email:<br>
      <input type="email" name="email" required>
    </label><br><br>
    <label>Password:<br>
      <input type="password" name="password" required>
    </label><br><br>
    <button type="submit">Login</button>
  </form>
  <p>New? <a href="signup.php">Sign up here</a>.</p>
</body>
</html>
