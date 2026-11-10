


            <?php
	include '../config/koneksi.php';
	// Initialize the notification message variables
$notificationMessage = "";
$notificationType = "";
	
	if( isset($_POST['ubah_ID']) ){
		$ID = $_POST['ID'];
		$ID_Team = $_POST['ID_Team'];
		$ID_Turnamen = $_POST['ID_Turnamen'];
		$Tanggal = $_POST['Tanggal'];

		$sql = "INSERT INTO pendaptaran (ID, ID_Team, ID_Turnamen, Tanggal) VALUES ( '$ID','$ID_Team', '$ID_Turnamen', '$Tanggal')";
		$result = mysqli_query($koneksi, $sql);
        
		
    if (!$result) {
        // If the query fails, set an error notification message
        $notificationMessage = "Query gagal dijalankan: " . mysqli_errno($koneksi) . " - " . mysqli_error($koneksi);
        $notificationType = "danger";
    } else {
        // If the query succeeds, set a success notification message
        $notificationMessage = "Data berhasil disimpan!";
        $notificationType = "success";
        header("Location: index_admin.php");
        exit();
    }
}
$currentDate = date('Y-m-d');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa SMK </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../css/style3.css">
</head>
<body>
	
<div class="mx-auto">
        <!-- untuk memasukkan data -->
        <div class="card">
            <div class="card-header">
                Create
            </div>

            <div class="card-body">
            <?php if (!empty($notificationMessage)) : ?>
                <div class="alert alert-<?php echo $notificationType; ?>" role="alert">
                    <?php echo $notificationMessage; ?>
                    </div>
            <?php endif; ?>
            <form action="" method="POST">
                <div class="form-group">
                    <input type="number" class="form-control" name="ID" placeholder="Masukkan ID ">
</div>
                <div class="form-group">
                    <input type="number" class="form-control" name="ID_Team" placeholder="Masukkan ID Team">
                </div>
                <div class="form-group">
                    <input type="number" class="form-control" name="ID_Turnamen" placeholder="Masukkan ID Turnamen">
                </div>
                <div class="form-group">
                <input type="date" class="form-control" name="Tanggal" placeholder="Masukkan Tanggal" value="<?php echo $currentDate; ?>">

                   
                </div>
                <button name="ubah_ID" type="submit" class="btn btn-primary">Simpan</button>
            </form>
    </div>
    <script src="../js/js.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>