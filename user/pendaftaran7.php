<?php
include('../config/conection.php');
if (isset($_POST["create"])) {
    $turnamen = mysqli_real_escape_string($conn, $_POST["kampung"]);
    $team = mysqli_real_escape_string($conn, $_POST["nama_team"]);
   
   
    $sqlInsert = "INSERT INTO pendaptaran(kampung , nama_team) VALUES ('$turnamen','$team')";
    if(mysqli_query($conn,$sqlInsert)){
        session_start();
        $_SESSION["create"] = "Book Added Successfully!";
        header("Location:index.php");
    }else{
        die("Something went wrong");
    }
}
?>