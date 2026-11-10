<?php
include('../config/conection.php');
if (isset($_POST["create"])) {
    $nama = mysqli_real_escape_string($conn, $_POST["id_pendaftaran"]);
    $mulai = mysqli_real_escape_string($conn, $_POST["id_tur"]);
    $sqlInsert = "INSERT INTO daftar_turnamen(id_pendaftaran , id_tur ) VALUES ('$nama','$mulai')";
    if(mysqli_query($conn,$sqlInsert)){
        session_start();
        $_SESSION["create"] = "Book Added Successfully!";
        header("Location:grup1.php");
    }else{
        die("Something went wrong");
    }
}