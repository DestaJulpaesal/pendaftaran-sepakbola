
        <?php 
	include '../config/koneksi.php';
	?>
 
	<table border="1" style="width: 100%">
		<tr>
			<th width="1%">No</th>
			<th>ID Turnamen</th>
			<th>ID Team</th>
            <th>ID Team</th>
            <th>Tanggal</th>
           
            
			<th width="5%">Tempat</th>
		</tr>
		<?php 
		$no = 1;
		$sql = mysqli_query($koneksi,"select * from jadwal");
		while($data = mysqli_fetch_array($sql)){
		?>
		<tr>
        <td><?php echo $no++; ?></td>
                <td><?php echo $data['id_turnamen']; ?></td>
                <td><?php echo $data['id_team']; ?></td>
                <td><?php echo $data['id_tim']; ?></td>
                <td><?php echo $data['tanggal']; ?></td>
                <td><?php echo $data['tempat']; ?></td>
		</tr>
       
		<?php 
		}
		?>
	</table>
 
	<script>
		window.print();
	</script>
     
    



    