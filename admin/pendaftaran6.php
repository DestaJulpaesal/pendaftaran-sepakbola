<?php
if (isset($_GET['id'])) {
include("../config/conection.php");
$id = $_GET['id'];
$sql = "DELETE FROM pendaptaran WHERE id_pendaftaran='$id'";
if(mysqli_query($conn,$sql)){
    session_start();
    $_SESSION["delete"] = "Book Deleted Successfully!";
    header("Location:pendaftaran.php");
}else{
    die("Something went wrong");
}
}else{
    echo "Book does not exist";
}
?>