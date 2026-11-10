<div class="box-title">
    <p>Barang / <b>Manajemen Barang Jualan</b></p>
</div>
<div id="box">

<!-- code by muh iriansyah putra pratama -->
<?php
  include "../config/koneksii.php";

    $id = $_GET['id'];
    $result = $conn->prepare("SELECT * FROM team WHERE id_Team =:id");
    $result->bindparam(':id', $id);
    $result->execute();
    $row=$result->fetch(PDO::FETCH_OBJ);
 ?>

<h1>Barang Jualan Ubah</h1>
<!-- code by muh iriansyah putra pratama -->
<form name="edit" method="post" action="edit_teampro" enctype="multipart/form-data">

<table class="article">

<tr>
  <td>Logo</td>
  <td>
    <input type="file" name="Logo" required>                                                                                                                                                                                                

</tr>
<!-- code by muh iriansyah putra pratama -->
<tr>
  <td>Nama</td>
  <td>
    <input type="text" name="Nama_Club" size="50" placeholder="ex: Nama" required>
  </td>
</tr>
<!-- code by muh iriansyah putra pratama -->
<tr>
  <td>Alamat</td>
  <td>
    <input type="text" name="Alamat" size="50" placeholder="ex: 130000" required>
  </td>
</tr>
<!-- code by muh iriansyah putra pratama -->
<tr>
  <td>Tahun kelahiran</td>
  <td>
    <input type="date" name="Tahun_Kelahiran" size="50" placeholder="ex: 100" required>
  </td>
</tr>
<!-- code by muh iriansyah putra pratama -->
<tr>
  <td></td>
  <td>
    <input class="tombol-biru" type="submit" name="add" value="Tambah & Simpan">
    <a class="tombol-merah" href="?page=club">Tutup</a>
  </td>
</tr>
</table>
<!-- code by muh iriansyah putra pratama -->
</form>
<!-- code by muh iriansyah putra pratama -->
</div>
