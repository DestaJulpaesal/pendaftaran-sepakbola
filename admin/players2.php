<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" type="text/css" href="../css/style-root.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap" rel="stylesheet">
    
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Add Daftar</title>
    <style>
        .book-details{
            background-color:#f5f5f5;
        }
    </style>
</head>
<body>
    <!-- sidebar -->
		<input type="checkbox" id="check">
		<div class="sidebar">
			<ul>
				<li><a href="../user/index.php">Home</a></li>
				<li><a href="../user/jadwal.php">Jadwal</a></li>
				<li><a href="../user/team.php">Tim</a></li>
				<li><a href="pemain.php">Pemain</a></li>
				<li><a href="Kontak.php">Kontak</a></li>
				<li><a href="../user/Login.php">Login</a></li>
			</ul>
			
		</div>

		<!-- bagian header -->
		<header>
			<div class="container">
				<h1><a href="">Desta </a></h1>
				<ul>
				
				<li><a href="../user/index.php">Home</a></li>
				<li><a href="../user/jadwal.php">Jadwal</a></li>
				<li><a href="../user/team.php">Tim</a></li>
				<li><a href="pemain.php">Pemain</a></li>
				<li><a href="Kontak.php">Kontak</a></li>
				<li><a href="../user/Login.php">Login</a></li>
				</ul>

				<!-- menu mobile -->
				<label for="check" class="mobile-menu"><i class="fas fa-bars fa-2x"></i></label>
			</div>
</div>
</header>
    <div class="container my-5">
    <header class="d-flex justify-content-between my-4">
            <h1>Tambah Pemain</h1>
            <div>
            <a href="players.php" class="btn btn-primary">Kembali</a>
          
</div>
        </header>
 
        <form name="add" method="post" action="players3.php" enctype="multipart/form-data">
    <table class="article">

      <tr>
        <td>Foto</td>
        <td>
          <input type="file" name="image" required>
        </td>
      </tr>
  <!-- code by muh iriansyah putra pratama -->
      <tr>
        <td>Nama </td>
        <td>
          <input type="text" name="nama" size="50" placeholder="Nama: " required>
        </td>
      </tr>
  <!-- code by muh iriansyah putra pratama -->
      <tr>
        <td>Tanggal Lahir</td>
        <td>
          <input type="date" name="tanggal_lahir" size="50" placeholder="Tanggal Lahir: " required>
        </td>
      </tr>
  <!-- code by muh iriansyah putra pratama -->
      <tr>
        <td>ID Team</td>
        <td>
          <input type="number" name="id_team" size="50" placeholder="ID Team: " required>
        </td>
      </tr>
      <tr>
        <td>Posisi</td>
        <td>
          <input type="text" name="posisi" size="50" placeholder="Posisi: " required>
        </td>
  <!-- code by muh iriansyah putra pratama -->
      <tr>
        <td></td>
        <td>
          <input class="tombol-biru" type="submit" name="add" value="Tambah Pemain">
         
        </td>
      </tr>
    </table>
  <!-- code by muh iriansyah putra pratama -->
  </form>
  <!-- code by muh iriansyah putra pratama -->


</div>
