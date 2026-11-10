<?php
session_start();
require_once __DIR__ . '/../config/database.php';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        $loginError = 'Sesi login tidak valid. Silakan coba lagi.';
    } else {
        $username = trim((string) ($_POST['username'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');

        if ($username === '' || $password === '') {
            $loginError = 'Username dan password wajib diisi.';
        } else {
            $stmt = $conn->prepare('SELECT * FROM tbl_users WHERE username = :username LIMIT 1');
            $stmt->execute([':username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'] ?? '')) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = (int) ($user['user_id'] ?? $user['id'] ?? 0);
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = strtolower((string) ($user['role'] ?? 'user'));

                $redirectTo = ($_SESSION['role'] === 'admin') ? '../admin/index_admin.php' : 'index.php';
                header('Location: ' . $redirectTo);
                exit;
            }

            $loginError = 'Login gagal. Username atau password salah.';
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>Login</title>
  <link rel="stylesheet" type="text/css" href="../css/loginstyle.css">
</head>

<body>
  <div class="login">
    <h2 class="login-header">LOGIN</h2>
    <form class="login-container" action="" method="post">
      <?php if (!empty($loginError)): ?>
        <p style="color: #b42318; text-align: center; font-weight: 600;"><?= htmlspecialchars($loginError) ?></p>
      <?php endif; ?>

      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

      <p>
        <input type="text" name="username" placeholder="Username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
      </p>
      <p>
        <input type="password" name="password" placeholder="Password" required>
      </p>
      <p>
        <input type="submit" name="submit" value="Masuk">
      </p>
      <p align="center"><a href="index.php">kembali</a></p>
      <br>
    </form>
  </div>
</body>

</html>
