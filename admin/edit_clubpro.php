<div class="box-title">
    <p>Team / <b>Team</b></p>
</div>
<div id="box">

<h1>Team Ubah</h1>

<?php

  include '../config/koneksii.php';

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

if ($loc_image != ""){

      if (in_array($extension, $cek) === TRUE){
        if ($size_image < 5044070){

          $query = $conn->prepare("SELECT * FROM team WHERE id_Team =:id ");
          $query->bindparam(':id', $id);
          $query->execute();
          $row=$query->fetch(PDO::FETCH_OBJ);

          if ($row->nama_image)
            unlink("../images/$row->nama_image");

            move_uploaded_file($loc_image,"../images/$name_image");

          try {
      			$conn ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      			$pdo = $conn->prepare('UPDATE team SET
                                 Nama_Club = :Nama_Club,
                                  Alamat = :Alamat,
                                  Tahun_Kelahiran= :Tahun_Kelahiran,
                                  
                                  nama_image = :nama_image,
                                  type_image = :type_image,
                                  size_image = :size_image
                                  WHERE id_team = :id_team');

      		
			$updatedata = array(':Nama_Club' => $nama, ':Alamat' => $alamat, ':Tahun_Kelahiran' => $tahun, 
            ':name_image' => $name_image, ':type_image' => $type_image, ':size_image' => $size_image);
      			$pdo->execute($updatedata);

						echo "<center><img src='img/icons/ceklist.png' width='60'></center>";
      			echo "<center><b>data Team berhasil diubah</b></center>";
            echo "</br>";
						echo"<meta http-equiv='refresh' content='1;
				    url=club.php'>";

      		} catch (PDOexception $e) {
      			print "Insert data gagal: " . $e->getMessage() . "<br/>";
      		   die();
      		}
			}else{
				echo "<center><img src='img/icons/cancel.png' width='60'></center>";
			  echo "<center><b>ukuran file gambar terlalu besar</b></center>";
				echo "<center><a href='club.php'>back</a></center>";
        echo "</br>";
      }
			}else {
				echo "<center><img src='img/icons/cancel.png' width='60'></center>";
			  echo"<center><b>ekstensi file tidak sesuai</b></center>";
				echo "<center><a href='club.php
                '>back</a></center>";
        echo "</br>";
			}
		}else{

			try {
				$conn ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$pdo = $conn->prepare('UPDATE team SET
                    Nama_Club = :Nama_Club,
                                  Alamat = :Alamat,
                                  Tahun_Kelahiran= :Tahun_Kelahiran,
                                  WHERE id_team = :id_team');
														
				$updatedata = array(':Nama_Club' => $nama, ':Alamat' => $alamat, ':Tahun_Kelahiran' => $tahun, ':id_barang' => $id);
				$pdo->execute($updatedata);

				echo "<center><img src='img/icons/ceklist.png' width='60'></center>";
				echo "<center><b>data barang berhasil diubah</b></center>";
        echo "</br>";
				echo"<meta http-equiv='refresh' content='1;
		    url=clubb.php'>";


			} catch (PDOexception $e) {
				print "Insert data gagal: " . $e->getMessage() . "<br/>";
				 die();
			}

		}

 ?>


</div>
