<?php
include("user_player.php");
include("user_club.php");
?>

<select name="id">
   <option>Select Course</option>
  <?php 
  foreach ($options as $option) {
  ?>
    <option><?php echo $option['id']; ?> </option>
    <?php 
    }
   ?>
</select>