<?php
include('../config/conection.php');
if (isset($_POST["create"])) {
    $nama = mysqli_real_escape_string($conn, $_POST["id_pendaftaran"]);
    $mulai = mysqli_real_escape_string($conn, $_POST["id_tur"]);
    $sqlInsert = "INSERT INTO daftar_turnamen(id_pendaftaran , id_tur ) VALUES ('$nama','$mulai')";
    if(mysqli_query($conn,$sqlInsert)){
        session_start();
        $_SESSION["create"] = "Book Added Successfully!";
        header("Location:turnamen9.php");
    }else{
        die("Something went wrong");
    }
}
if (isset($_POST["edit"])) {
    $nama = mysqli_real_escape_string($conn, $_POST["id_pendaftaran"]);
    $mulai = mysqli_real_escape_string($conn, $_POST["id_tur"]);
    $id = mysqli_real_escape_string($conn, $_POST["id"]);
    $sqlUpdate = "UPDATE daftar_turnamen SET id_pendaftaran = '$nama', id_tur = '$mulai' WHERE id='$id'";
    if(mysqli_query($conn,$sqlUpdate)){
        session_start();
        $_SESSION["update"] = "Book Updated Successfully!";
        header("Location:turnamen9.php");
    }else{
        die("Something went wrong");
    }
}
?>