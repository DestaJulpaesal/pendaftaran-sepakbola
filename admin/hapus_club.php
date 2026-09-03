<div class="box-title">
    <p>Barang / <b>Manajemen Barang Jualan</b></p>
</div>
<div id="box">
<h1>Barang Jualan Hapus</h1>

<!-- code by muh iriansyah putra pratama -->
<?php
include('../config/koneksii.php');

		$ID = $_GET['ID'];

    $query = $conn->prepare("SELECT * FROM team WHERE id_team =:id");
    $query->bindparam(':id', $id);
    $query->execute();
    $row=$query->fetch(PDO::FETCH_OBJ);

      unlink("../images/$row->nama_image");
// code by muh iriansyah putra pratama
		try {
			$conn ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$pdo = $conn->prepare("DELETE FROM team WHERE id_team = :id");
			$deletedata = array(':id' => $id);

			$pdo->execute($deletedata);
// code by muh iriansyah putra pratama
      echo "<center><img src='img/icons/ceklist.png' width='60'></center>";
			echo "<center><b>data barang berhasil dihapus</b></center>";
      echo "</br>";
      echo"<meta http-equiv='refresh' content='1;
      url=club.php'>";
// code by muh iriansyah putra pratama
		} catch (PDOexception $e) {
			print "hapus berita gagal: " . $e->getMessage() . "<br/>";
		   die();
		}
?>
<!-- code by muh iriansyah putra pratama -->
</div>
