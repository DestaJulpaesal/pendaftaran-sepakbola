
<?php
// include db connection
include '../config/config.php';

if(isset($_POST['upload'])){
    $NAME = $_POST['nama_club'];
    $ALAMAT = $_POST['alamat'];
    $TAHUN = $_POST['tahun_berdiri'];
    $IMAGE = $_FILES['image'];

$loc_image = $_FILES['image']['tmp_name'];
$type_image = $_FILES['image']['type'];

$date = date('Ymd');

$cek         = array('png','jpg','jpeg','gif');
$x           = explode('.',$img_name);
$extension   = strtolower(end($x));
$size_image  = $_FILES['image']['size'];
    move_uploaded_file($img_loc,'../images/'.$img_name);

    // insert data

    mysqli_query($con,"INSERT INTO `team`( `nama_club`, `alamat`, `tahun_berdiri`, `image`,'type_image','size_image') VALUES ('$NAME','$ALAMAT','$TAHUN','$img_des','$type_image','$size_image')");
    header("location:club.php");

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/style-root.css">
   
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

  <style>
  input{
    margin: 10px;
}
            </style>

</head>
<body>
        <center>
        <div class="main">
        <form action="profil_ubah.php" method="POST" enctype="multipart/form-data" >
        <label for="">Name:</label>
        <input type="text" name="nama_club"><br>
        <label for="">Alamat :</label>
        <input type="text" name="alamat" id=""><br>
        <label for="">Tahun Berdiri :</label>
        <input type="date" name="tahun_berdiri" id=""><br>
        <label for="">Image:</label>
        <input type="file" name="image" id=""><br>
        <button type="submit" name="upload">Upload</button>

        </form>
    </div>
        </center>
        
        </body>
</html>