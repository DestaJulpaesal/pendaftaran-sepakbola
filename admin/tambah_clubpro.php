<!-- code by muh iriansyah putra pratama -->
<div class="box-title">
    <p>Team / <b>Team</b></p>
</div>
<div id="box">

<h1>Team Tambah</h1>
<?php

	include '../config/koneksi.php';

$nama = $_POST['Nama_Club'];
$alamat = $_POST['Alamat'];
$tahun = $_POST['Tahun_Kelahiran'];

$name_image = $_FILES['Logo']['name'];
$loc_image = $_FILES['Logo']['tmp_name'];
$type_image = $_FILES['Logo']['type'];

$date = date('Ymd');

$cek         = array('png','jpg','jpeg','gif');
$x           = explode('.',$name_image);
$extension   = strtolower(end($x));
$size_image  = $_FILES['Logo']['size'];
// code by muh iriansyah putra pratama

if (in_array($extension, $cek) === TRUE){
  if ($size_image < 5044070){
// code by muh iriansyah putra pratama
    move_uploaded_file($loc_image,"images$name_image");

    try {
			$conn ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$pdo = $conn->prepare('INSERT INTO team (Nama_Club, Alamat, Tahun_Kelahiran, name_image, type_image, size_image)
									values (:Nama_Club, :Alamat, :Tahun_Kelahiran, :name_image, :type_image, :size_image)');

			$insertdata = array(':Nama_Club' => $nama, ':Alamat' => $alamat, ':Tahun_Kelahiran' => $tahun, 
						              ':name_image' => $name_image, ':type_image' => $type_image, ':size_image' => $size_image);
// code by muh iriansyah putra pratama
			$pdo->execute($insertdata);

			echo "<center><img src='img/icons/ceklist.png' width='60'></center>";
			echo "<center><b>barang berhasil ditambahkan</b></center>";
      echo "</br>";
			echo"<meta http-equiv='refresh' content='1;
			url=club.php'>";

		} catch (PDOexception $e) {
			print "tambah barang gagal: " . $e->getMessage() . "<br/>";
		   die();
		}

// code by muh iriansyah putra pratama

}else{
	echo "<center><img src='img/icons/cancel.png' width='60'></center>";
	echo "<center><b>ukuran file gambar terlalu besar</b></center>";
	echo "<center><a href='tambah_club'>back</a></center>";
  echo "</br>";
}
}else {
	echo "<center><img src='img/icons/cancel.png' width='60'></center>";
	echo"<center><b>ekstensi file tidak sesuai</b></center>";
	echo "<center><a href='tambah_club'>back</a></center>";
  echo "</br>";
}

 ?>
<!-- code by muh iriansyah putra pratama -->
</div>
