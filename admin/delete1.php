<?php
include '../config/koneksii.php';

$id = $_GET['id'];
$result = mysqli_query($koneksi, "SELECT id FROM jadwal WHERE id='$id'");
$row = mysqli_fetch_assoc($result);
$namajadwal = $row['id'];

if (mysqli_query($koneksi, "DELETE FROM jadwal WHERE id='$id'")) {
    echo "<script>alert('Data $namajadwal berhasil dihapus.'); window.location.href = 'dashbord.php';</script>";
} else {
    echo "<script>alert('Error: " . mysqli_error($koneksi) . "'); window.location.href = 'dashbord.php';</script>";
}

mysqli_close($koneksi);
?>