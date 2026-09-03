<?php
include("user_player.php");
include("user.php");
?>
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
</head>
<body>
    <!-- sidebar -->
		<input type="checkbox" id="check">
		<div class="sidebar">
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="jadwal.php">Jadwal</a></li>
				<li><a href="team.php">Tim</a></li>
				<li><a href="../admin/pemain.php">Pemain</a></li>
				<li><a href="Kontak.php">Kontak</a></li>
				<li><a href="Login.php">Login</a></li>
			</ul>
			
		</div>

		<!-- bagian header -->
		<header>
			<div class="container">
				<h1><a href="">Desta </a></h1>
				<ul>
				
				<li><a href="index.php">Home</a></li>
				<li><a href="jadwal.php">Jadwal</a></li>
				<li><a href="team.php">Tim</a></li>
				<li><a href="../admin/pemain.php">Pemain</a></li>
				<li><a href="Kontak.php">Kontak</a></li>
				<li><a href="Login.php">Login</a></li>
				</ul>

				<!-- menu mobile -->
				<label for="check" class="mobile-menu"><i class="fas fa-bars fa-2x"></i></label>
			</div>
</div>
</header>

    <div class="container my-5">
    <header class="d-flex justify-content-between my-4">
            <h1> Daftar</h1>
            <div>
            <a href="grup1.php" class="btn btn-primary">Kembali</a>
            </div>
        </header>
        
        <form action="turnamen12.php" method="post">
            
        <div class="form-group my-4">
 
 <select class="form-control" name="id_pendaftaran" id="id_pendaftaran">
<option value="">ID Pendaftaran</option>
<?php foreach ($options as $option) { ?>
 <option><?php echo $option['id_pendaftaran']; ?> </option>
</option>
<?php } ?>
</select>
</div>

 
<div class="form-elemnt my-4">
                <input type="text" class="form-control" name="id_tur" placeholder="ID Turnamen:">
            </div>
           
           
 
          

           
    
            
            <div class="form-element my-4">
                <input type="submit" name="create" value="Daftar" class="btn btn-primary">
            </div>
            
        </form>
        
        
    </div>
</body>
</html>