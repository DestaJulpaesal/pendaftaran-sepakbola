<!-- code by muh iriansyah putra pratama -->
<div class="box-title">
    <p>Barang / <b>Manajemen Barang Jualan</b></p>
</div>
<div id="box">

<h1>Barang Jualan Tambah</h1>
<?php

	include '../config/koneksii.php';

$nama = $_POST['nama'];
$tanggal = $_POST['tanggal_lahir'];
$team = $_POST['id_team'];
$posisi = $_POST['posisi'];

$image = $_FILES['image']['name'];
$loc_image = $_FILES['image']['tmp_name'];
$type_image = $_FILES['image']['type'];

$date = date('Ymd');

$cek         = array('png','jpg','jpeg','gif');
$x           = explode('.',$image);
$extension   = strtolower(end($x));
$size_image  = $_FILES['image']['size'];
// code by muh iriansyah putra pratama

if (in_array($extension, $cek) === TRUE){
  if ($size_image < 5044070){
// code by muh iriansyah putra pratama
    move_uploaded_file($loc_image,"images$image");

    try {
			$conn ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$pdo = $conn->prepare('INSERT INTO peserta (nama, tanggal_lahir, id_team,posisi, image, type_image, size_image)
									values (:nama, :tanggal_lahir, :id_team,:posisi,  :image, :type_image, :size_image)');
echo $pdo->queryString;

$insertdata = array(':nama' => $nama, ':tanggal_lahir' => $tanggal, ':id_team' => $team,  ':posisi' => $posisi,
':image' => $image, ':type_image' => $type_image, ':size_image' => $size_image);

// code by muh iriansyah putra pratama
			$pdo->execute($insertdata);

			echo "<center><img src='img/icons/ceklist.png' width='60'></center>";
			echo "<center><b>barang berhasil ditambahkan</b></center>";
      echo "</br>";
			echo"<meta http-equiv='refresh' content='1;
			url=players.php'>";

		} catch (PDOexception $e) {
			print "tambah barang gagal: " . $e->getMessage() . "<br/>";
		   die();
		}

// code by muh iriansyah putra pratama

}else{
	echo "<center><img src='img/icons/cancel.png' width='60'></center>";
	echo "<center><b>ukuran file gambar terlalu besar</b></center>";
	echo "<center><a href='players2.php'>back</a></center>";
  echo "</br>";
}
}else {
	echo "<center><img src='img/icons/cancel.png' width='60'></center>";
	echo"<center><b>ekstensi file tidak sesuai</b></center>";
	echo "<center><a href='players2.php'>back</a></center>";
  echo "</br>";
}

 ?>
<!-- code by muh iriansyah putra pratama -->
</div>
