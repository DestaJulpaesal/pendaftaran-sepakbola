<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['user_id']) || (strtolower((string) ($_SESSION['role'] ?? '')) !== 'admin')) {
    header('Location: ../user/Login.php');
    exit;
}
