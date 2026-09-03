<?php
include('../config/conection.php');
if (isset($_POST["create"])) {
    $nama = mysqli_real_escape_string($conn, $_POST["nama_turnamen"]);
    $mulai = mysqli_real_escape_string($conn, $_POST["tanggal_mulai"]);
    $selesai = mysqli_real_escape_string($conn, $_POST["tanggal_selesai"]);
    $sqlInsert = "INSERT INTO turnamen(nama_turnamen , tanggal_mulai , tanggal_selesai ) VALUES ('$nama','$mulai','$selesai')";
    if(mysqli_query($conn,$sqlInsert)){
        session_start();
        $_SESSION["create"] = "Book Added Successfully!";
        header("Location:turnamen.php");
    }else{
        die("Something went wrong");
    }
}
if (isset($_POST["edit"])) {
    $nama = mysqli_real_escape_string($conn, $_POST["nama_turnamen"]);
    $mulai= mysqli_real_escape_string($conn, $_POST["tanggal_mulai"]);
    $selesai = mysqli_real_escape_string($conn, $_POST["tanggal_selesai"]);
    $id = mysqli_real_escape_string($conn, $_POST["id"]);
    $sqlUpdate = "UPDATE turnamen SET nama_turnamen = '$nama', tanggal_mulai = '$mulai', tanggal_selesai = '$selesai' WHERE id_tur='$id'";
    if(mysqli_query($conn,$sqlUpdate)){
        session_start();
        $_SESSION["update"] = "Book Updated Successfully!";
        header("Location:turnamen.php");
    }else{
        die("Something went wrong");
    }
}
?>