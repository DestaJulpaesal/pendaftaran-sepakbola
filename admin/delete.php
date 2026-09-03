<?php
include '../config/koneksi.php';

$id = $_GET['id'];
$result = mysqli_query($koneksi, "SELECT id FROM pendaptaran WHERE id='$id'");
$row = mysqli_fetch_assoc($result);
$namajadwal = $row['id'];

if (mysqli_query($koneksi, "DELETE FROM pendaptaran WHERE id='$id'")) {
    echo "<script>alert('Data $namajadwal berhasil dihapus.'); window.location.href = 'index_admin.php';</script>";
} else {
    echo "<script>alert('Error: " . mysqli_error($koneksi) . "'); window.location.href = 'index_admin.php';</script>";
}

mysqli_close($koneksi);
?>