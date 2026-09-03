<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Edit Book</title>
</head>
<body>
    <div class="container my-5">
    <header class="d-flex justify-content-between my-4">
            <h1>Edit Pendaftaran</h1>
            <div>
            <a href="pendaftaran.php" class="btn btn-primary">Back</a>
            </div>
        </header>
        <form action="pendaftaran3.php" method="post">
            <?php 
            
            if (isset($_GET['id'])) {
                include("../config/conection.php");
                $id = $_GET['id'];
                $sql = "SELECT * FROM pendaptaran WHERE id=$id";
                $result = mysqli_query($conn,$sql);
                $row = mysqli_fetch_array($result);
                ?>
                     <div class="form-elemnt my-4">
                     <select class="form-control" name="nama_turnamen" id="nama_turnamen">
        <option value="">Turnamen</option>
        <?php foreach ($options as $option) { ?>
            <option><?php echo $option['nama_turnamen']; ?> </option>
        </option>
        <?php } ?>
    </select>
                <input type="number" class="form-control" name="nama_turnamen" placeholder="Nama Turnamen:" value="<?php echo $row["nama_turnamen"]; ?>">
            </div>
            <div class="form-elemnt my-4">
                <input type="text" class="form-control" name="nama_team" placeholder="Nama Team:" value="<?php echo $row["nama_team"]; ?>">
            </div>
         
        
            
           
            <input type="hidden" value="<?php echo $id; ?>" name="id">
            <div class="form-element my-4">
                <input type="submit" name="edit" value="E" class="btn btn-primary">
            </div>
                <?php
            }else{
                echo "<h3>Book Does Not Exist</h3>";
            }
            ?>
           
        </form>
        
        
    </div>
</body>
</html>