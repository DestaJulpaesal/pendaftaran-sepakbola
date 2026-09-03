
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
    <title>Detail Jadwal</title>
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
    <div class="container my-4">
        <header class="d-flex justify-content-between my-4">
            <h1>Detail Jadwal</h1>
            <div>
            <a href="matches.php" class="btn btn-primary">Kembali</a>
            </div>
        </header>`
        <div class="book-details p-5 my-4">
            <?php
            include("../config/conection.php");
            $id = $_GET['id'];
            if ($id) {
                $sql = "SELECT * FROM jadwal WHERE id = $id";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_array($result)) {
                 ?>
                 <h3>ID Turnamen :</h3>
                 <p><?php echo $row["id_turnamen"]; ?></p>
                 <h3>ID Team :</h3>
                 <p><?php echo $row["id_team"]; ?></p>
                 <h3>ID Team :</h3>
                 <p><?php echo $row["id_tim"]; ?></p>
                 <h3>Tanggal :</h3>
                 <p><?php echo $row["tanggal"]; ?></p>
                 <h3>Tempat :</h3>
                 <p><?php echo $row["tempat"]; ?></p>
                 <?php
                }
            }
            else{
                echo "<h3>No books found</h3>";
            }
            ?>
            
        </div>
    </div>
</body>
</html>