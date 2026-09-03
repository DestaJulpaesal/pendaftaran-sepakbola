<?php
include('../config/conection.php');
include("../user/user_player.php");
include("../user/user_club.php");
if (isset($_POST["create"])) {
    $turnamen = mysqli_real_escape_string($conn, $_POST["kampung"]);
    $team = mysqli_real_escape_string($conn, $_POST["nama_team"]);
   
   
    
   
    $sqlInsert = "INSERT INTO pendaptaran(kampung , nama_team) VALUES ('$turnamen','$team')";
    if(mysqli_query($conn,$sqlInsert)){
        session_start();
        $_SESSION["create"] = "Book Added Successfully!";
        header("Location:pendaftaran.php");
    }else{
        die("Something went wrong");
    }
}
if (isset($_POST["edit"])) {
    $turnamen = mysqli_real_escape_string($conn, $_POST["id_turnamen"]);
    $team= mysqli_real_escape_string($conn, $_POST["nama_team"]);
    
   
    $id = mysqli_real_escape_string($conn, $_POST["id"]);
    $sqlUpdate = "UPDATE pendaptaran SET id_turnamen= '$turnamen', nama_team = '$team'  WHERE id='$id'";
    if(mysqli_query($conn,$sqlUpdate)){
        session_start();
        $_SESSION["update"] = "Book Updated Successfully!";
        header("Location:pendaftaran.php");
    }else{
        die("Something went wrong");
    }
}
?>