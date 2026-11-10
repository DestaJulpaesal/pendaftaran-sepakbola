<?php 
include '../config/confiq1.php';
?>
 
<h3>Form Pencarian</h3>
 
<form action="search.php" method="get">
 <label>Cari :</label>
 <input type="text" name="cari">
 <input type="submit" value="Cari">
</form>
 
<?php 
if(isset($_GET['cari'])){
 $cari = $_GET['cari'];
 echo "<b>Hasil pencarian : ".$cari."</b>";
}
?>
 
<table border="1">
 <tr>
  <th>No</th>
  <th>Nama</th>
  <th>Asal</th>
  <th>Tujuan</th>
  <th>Maskapai</th>
 </tr>
 <?php 
 if(isset($_GET['cari'])){
  $cari = $_GET['cari'];
  $data = mysqli_query($kon,"select * from jadwal where id_tim like '%".$cari."%'");    

 }else{
  $data = mysqli_query($kon,"select * from jadwal");  
 }
 $no = 1;
 while($d = mysqli_fetch_array($data)){
 ?>
 <tr>
  <td><?php echo $no++; ?></td>
  <td><?php echo $d['id_turnamen']; ?></td>
  <td><?php echo $d['id_team']; ?></td>
  <td><?php echo $d['id_tim']; ?></td>
  <td><?php echo $d['tempat']; ?></td>
 </tr>
 <?php } ?>
</table>