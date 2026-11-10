<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: pendaftaran.php');
    exit;
}

if (!($conn instanceof PDO)) {
    $_SESSION['status_update'] = 'Database sedang tidak tersedia.';
    header('Location: pendaftaran.php');
    exit;
}

$token = $_POST['csrf_token'] ?? '';
if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
    $_SESSION['status_update'] = 'Token CSRF tidak valid. Silakan coba lagi.';
    header('Location: pendaftaran.php');
    exit;
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT) ?: 0;
$status = strtolower(trim((string) ($_POST['status'] ?? 'pending')));
$allowedStatus = ['pending', 'diverifikasi', 'diterima', 'ditolak'];
if (!in_array($status, $allowedStatus, true)) {
    $status = 'pending';
}

$alasanPenolakan = trim((string) ($_POST['alasan_penolakan'] ?? ''));
if ($status !== 'ditolak') {
    $alasanPenolakan = '';
} elseif ($alasanPenolakan === '') {
    $alasanPenolakan = 'Tidak memenuhi persyaratan pendaftaran.';
}

if ($id > 0) {
    $stmt = $conn->prepare('UPDATE pendaptaran SET status = :status, alasan_penolakan = :alasan WHERE id_pendaftaran = :id');
    $stmt->execute([
        ':status' => $status,
        ':alasan' => $alasanPenolakan,
        ':id' => $id,
    ]);
}

$_SESSION['status_update'] = 'Status pendaftaran berhasil diperbarui menjadi ' . ucfirst($status) . '.';
header('Location: pendaftaran4.php?id=' . $id);
exit;
