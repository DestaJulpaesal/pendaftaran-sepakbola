<div class="box-title">
    <p>Barang / <b>Manajemen Barang Jualan</b></p>
</div>
<div id="box">

<h1>Barang Jualan Ubah</h1>
<!-- code by muh iriansyah putra pratama -->
<?php

  include '../config/koneksii.php';

$id = $_POST['id'];
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

if ($loc_image != ""){

      if (in_array($extension, $cek) === TRUE){
        if ($size_image < 5044070){
// code by muh iriansyah putra pratama
          $query = $conn->prepare("SELECT * FROM peserta WHERE id  =:id ");
          $query->bindparam(':id', $id);
          $query->execute();
          $row=$query->fetch(PDO::FETCH_OBJ);

          if ($row->image)
            unlink("image$row->image");

            move_uploaded_file($loc_image,"image$image");
// code by muh iriansyah putra pratama
          try {
      			$conn ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      			$pdo = $conn->prepare('UPDATE peserta SET
                                  nama = :nama,
                                  tanggal_lahir = :tanggal_lahir,
                                  id_team = :id_team,
                                  posisi = :posisi,
                        
                                  image = :image,
                                  type_image = :type_image,
                                  size_image = :size_image
                                  WHERE id = :id');

      			$updatedata = array(':nama' => $nama, ':tanggal_lahir' => $tanggal, ':id_team' => $team, ':posisi' => $posisi,  ':image' => $image,
      						              ':type_image' => $type_image, ':size_image' => $size_image, ':id' => $id);
// code by muh iriansyah putra pratama
      			$pdo->execute($updatedata);

						echo "<center><img src='img/icons/ceklist.png' width='60'></center>";
      			echo "<center><b>data barang berhasil diubah</b></center>";
            echo "</br>";
						echo"<meta http-equiv='refresh' content='1;
				    url=players.php'>";

      		} catch (PDOexception $e) {
      			print "Insert data gagal: " . $e->getMessage() . "<br/>";
      		   die();
      		}
			}else{
				echo "<center><img src='img/icons/cancel.png' width='60'></center>";
			  echo "<center><b>ukuran file gambar terlalu besar</b></center>";
				echo "<center><a href='players.php'>back</a></center>";
        echo "</br>";
      }
			}else {
				echo "<center><img src='img/icons/cancel.png' width='60'></center>";
			  echo"<center><b>ekstensi file tidak sesuai</b></center>";
				echo "<center><a href='players.php'>back</a></center>";
        echo "</br>";
			}
		}else{
// code by muh iriansyah putra pratama
			try {
				$conn ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$pdo = $conn->prepare('UPDATE team SET
												 nama = :nama,
                                  tanggal_lahir = :tanggal_lahir,
                                  id_team = :id_team,
                                  posisi = :posisi,
                        
															WHERE id = :id');

				$updatedata = array(':nama' => $nama, ':tanggal_lahir' => $tanggal, ':id_team' => $team, ':posisi' => $posisi, ':id' => $id);
				$pdo->execute($updatedata);

				echo "<center><img src='img/icons/ceklist.png' width='60'></center>";
				echo "<center><b>data barang berhasil diubah</b></center>";
        echo "</br>";
				echo"<meta http-equiv='refresh' content='1;
		    url=players.php'>";


			} catch (PDOexception $e) {
				print "Insert data gagal: " . $e->getMessage() . "<br/>";
				 die();
			}
// code by muh iriansyah putra pratama
		}

 ?>
<!-- code by muh iriansyah putra pratama -->

</div>
