<?php
include('../config/conection.php');
if (isset($_POST["create"])) {
    $nama = mysqli_real_escape_string($conn, $_POST["nama"]);
    $komentar = mysqli_real_escape_string($conn, $_POST["komentar"]);
    $sqlInsert = "INSERT INTO contact(nama , email,komentar) VALUES ('$nama','$email','$komentar')";
    if(mysqli_query($conn,$sqlInsert)){
        session_start();
        $_SESSION["create"] = "Book Added Successfully!";
        header("Location:contact.php");
    }else{
        die("Something went wrong");
    }
}
?>