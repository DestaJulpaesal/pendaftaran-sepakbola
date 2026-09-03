<div class="box-title">
    <p>Barang / <b>Manajemen Barang Jualan</b></p>
</div>
<div id="box">

<!-- code by muh iriansyah putra pratama -->
<?php
  include "../config/koneksii.php";

    $id = $_GET['id'];
    $result = $conn->prepare("SELECT * FROM peserta WHERE id =:id");
    $result->bindparam(':id', $id);
    $result->execute();
    $row=$result->fetch(PDO::FETCH_OBJ);
 ?>

<h1>Barang Jualan Ubah</h1>
<!-- code by muh iriansyah putra pratama -->
<form name="edit" method="post" action="players7.php" enctype="multipart/form-data">

  <table class="table table-bordered table-striped">
    <tr>
      <td>Foto</td>
      <td>
        <input type="hidden" name="id" value="<?php echo $row->id ?>">
        <img src="images<?php echo $row->nama_image ?>" width="100"><br><br>
        <input type="file" name="image">
      </td>
    </tr>
<!-- code by muh iriansyah putra pratama -->
    <tr>
      <td>Nama</td>
      <td>
        <input type="text" name="nama" size="50" value="<?php echo $row->nama?>" required>
      </td>
    </tr>
<!-- code by muh iriansyah putra pratama -->
    <tr>
      <td>Tanggal Lahir</td>
      <td>
        <input type="date" name="tanggal_lahir" size="50" value="<?php echo $row->tanggal ?>" required>
      </td>
    </tr>
<!-- code by muh iriansyah putra pratama -->
    <tr>
      <td>ID Team </td>
      <td>
        <input type="number" name="id_team" size="50" value="<?php echo $row->team ?>" required>
      </td>
    </tr>
    <tr>
      <td>Posisi </td>
      <td>
        <input type="text" name="posisi" size="50" value="<?php echo $row->posisi ?>" required>
      </td>
    </tr>
<!-- code by muh iriansyah putra pratama -->
    <tr>
      <td></td>
      <td>
        <input class="tombol-biru" type="submit" name="edit" value="Ubah & Simpan">
        <a class="tombol-merah" href="?page=barang">Tutup</a>
      </td>
    </tr>
  </table>
<!-- code by muh iriansyah putra pratama -->
</form>
<!-- code by muh iriansyah putra pratama -->
</div>
