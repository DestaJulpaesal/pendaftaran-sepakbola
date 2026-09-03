<!DOCTYPE html>
<html>

<head>
  <title>Login</title>
  <link rel="stylesheet" type="text/css" href="../css/loginstyle.css">
  <!-- code by muh iriansyah putra pratama -->
</head>

<body>
  <div class="login">
    <h2 class="login-header">LOGIN</h2>
    <form class="login-container" action="../admin/index_admin.php" method="post">

      <?php

     
session_start();
include "../config/koneksii.php";

if (isset($_POST['submit'])) {
  $user = $_POST['username'];
  $pwd = $_POST['password'];
  
  $pdo = $conn->prepare("SELECT * FROM tbl_users WHERE username=:a");
  $pdo->execute(array(':a' => $user));
  $row = $pdo->fetch(PDO::FETCH_ASSOC);
  
  if (!$row || !password_verify($pwd, $row['password'])) {
    echo "<center><a class='tombol-merah'>Login Gagal</a></center>";
  } else {
    $_SESSION['username'] = $user;
    $_SESSION['password'] = $pwd;
    header("Location: ../admin/index_admin.php");
    exit();
  }
}
?>

      <p>
        <input type="text" name="username" placeholder="Username" required>
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


