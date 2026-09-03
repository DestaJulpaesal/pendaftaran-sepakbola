<?php
include('../config/conection.php');
if (isset($_POST["create"])) {
    $turnamen = mysqli_real_escape_string($conn, $_POST["id_tur"]);
    $team = mysqli_real_escape_string($conn, $_POST["id_team"]);
    $tim = mysqli_real_escape_string($conn, $_POST["id_tim"]);
    $tangga = mysqli_real_escape_string($conn, $_POST["tanggal"]);
    $tempat = mysqli_real_escape_string($conn, $_POST["tempat"]);
    $sqlInsert = "INSERT INTO jadwal(id_tur , id_team,id_tim,tanggal,tempat ) VALUES ('$turnamen','$team','$tim','$tangga','$tempat')";
    if(mysqli_query($conn,$sqlInsert)){
        session_start();
        $_SESSION["create"] = "Book Added Successfully!";
        header("Location:matches.php");
    }else{
        die("Something went wrong");
    }
}
if (isset($_POST["edit"])) {
    $turnamen = mysqli_real_escape_string($conn, $_POST["id_tur"]);
    $team= mysqli_real_escape_string($conn, $_POST["id_team"]);
    $tim = mysqli_real_escape_string($conn, $_POST["id_tim"]);
    $tangga = mysqli_real_escape_string($conn, $_POST["tanggal"]);
    $tempat = mysqli_real_escape_string($conn, $_POST["tempat"]);
    $id = mysqli_real_escape_string($conn, $_POST["id"]);
    $sqlUpdate = "UPDATE jadwal SET id_tur= '$turnamen', id_team = '$team', id_tim = '$tim' ,tanggal ='$tangga' ,tempat = '$tempat' WHERE id='$id'";
    if(mysqli_query($conn,$sqlUpdate)){
        session_start();
        $_SESSION["update"] = "Book Updated Successfully!";
        header("Location:matches.php");
    }else{
        die("Something went wrong");
    }
}
?>