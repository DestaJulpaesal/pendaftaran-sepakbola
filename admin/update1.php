<!DOCTYPE html>
<html>
<head>
  <style>
    body {
      background-image: url("d.jpg");
      background-repeat: no-repeat;
      background-size:cover;
    }
    </style>
<style>
ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: #333;
}

li {
  float: left;
}

li a {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

li a:hover:not(.active) {
  background-color: #111;
}

.active {
  background-color: #04AA6D;
}
</style>
</head>
<body>

<ul>
  <li><a class="active" href="index.html">Home</a></li>
  <li><a href="syarat.html">syarat</a></li>
  <li><a href="hubungiSaya.html">Hubungi saya</a></li>
  <div class="dropdown">

</ul>


</body>

<?php
    include '../config/koneksi.php';

    if (isset($_POST['ubah_id'])) {
        $id = $_POST['ubah_id'];
        $QuerynameUbah = mysqli_real_escape_string($koneksi, $_POST['ubah_ID']);
        $QueryroleUbah = mysqli_real_escape_string($koneksi, $_POST['ubah_ID_Team']);
        $QueryTeamsUbah = mysqli_real_escape_string($koneksi, $_POST['ubah_ID_Turnamen']);
       

        $query = "UPDATE pendaptaran SET ID ='$QueryIDUbah', ID_Team='$QueryTeamUbah', ID_Turnamen='$QueryTurnamenUbah' ,Tanggal='$QueryTanggalUbah 'WHERE id = '$id'";
        $result = mysqli_query($koneksi, $query);
        if (!$result) {
            die("Gagal Di Ubah " . mysqli_errno($koneksi) . "-" . mysqli_error($koneksi));
        } else {
            header('Location: index_admin.php');
            exit();
        }
    }
    $currentDate = date('Y-m-d');

    $id = $_GET['id'];
    $data = mysqli_query($koneksi, "SELECT * FROM pendaptaran WHERE id='$id'");
    while ($tampil = mysqli_fetch_array($data)) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | web </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/style3.css">
</head>
<body>
<div class="container-fluid">
    <form method="post" action="">
        <div class="mb-3">
            <label class="form-label">ID</label>
            
            <input name="ubah_ID" type="number" class="form-control" value="<?php echo $tampil["ID"]; ?>">
           
           
        </div>
        <div class="mb-3">
            <label class="form-label">ID Team</label>
        
            <input name="ubah_ID_Team" type="number" class="form-control" value="<?php echo $tampil["ID_Team"]; ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">ID Turnamen</label>
            <input name="ubah_ID_Turnamen" type="number" class="form-control" value="<?php echo $tampil["ID_Turnamen"]; ?>">

           
        </div>
        <div class="mb-3">
            <label class="form-label">Tanggal</label>
            
            <input type="Date" class="form-control" name="Tanggal" placeholder="Masukkan Tanggal" value="<?php echo $currentDate; ?>">


        </div>

        <button name="ubah_id" type="submit" class="btn btn-sm btn-primary">Simpan</button>
    </form>
</div>
<script src="../js/js.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php } ?>