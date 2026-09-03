<?php
include('../config/conection.php');
if (isset($_POST["create"])) {
    $nama = mysqli_real_escape_string($conn, $_POST["nama_club"]);
    $mulai = mysqli_real_escape_string($conn, $_POST["alamat"]);
    $selesai = mysqli_real_escape_string($conn, $_POST["tahun_berdiri"]);
    $sqlInsert = "INSERT INTO team(nama_club, alamat , tahun_berdiri) VALUES ('$nama','$mulai','$selesai')";
    if(mysqli_query($conn,$sqlInsert)){
        session_start();
        $_SESSION["create"] = "Book Added Successfully!";
        header("Location:club.php");
    }else{
        die("Something went wrong");
    }
}
if (isset($_POST["edit"])) {
    $nama = mysqli_real_escape_string($conn, $_POST["nama_club"]);
    $mulai= mysqli_real_escape_string($conn, $_POST["alamat"]);
    $selesai = mysqli_real_escape_string($conn, $_POST["tahun_berdiri"]);
    $id = mysqli_real_escape_string($conn, $_POST["id"]);
    $sqlUpdate = "UPDATE team SET nama_club = '$nama', alamat = '$mulai',tahun_berdiri = '$selesai' WHERE id='$id'";
    if(mysqli_query($conn,$sqlUpdate)){
        session_start();
        $_SESSION["update"] = "Book Updated Successfully!";
        header("Location:club.php");
    }else{
        die("Something went wrong");
    }
}
?>