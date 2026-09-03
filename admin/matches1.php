<!DOCTYPE html>
<html lang="en">

<head>
  <title>Soccer &mdash;</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="../fonts/icomoon/style.css">

  <link rel="stylesheet" href="../css/bootstrap/bootstrap.css">
  <link rel="stylesheet" href="../css/jquery-ui.css">
  <link rel="stylesheet" href="../css/owl.carousel.min.css">
  <link rel="stylesheet" href="../css/owl.theme.default.min.css">
  <link rel="stylesheet" href="../css/owl.theme.default.min.css">

  <link rel="stylesheet" href="../css/jquery.fancybox.min.css">

  <link rel="stylesheet" href="../css/bootstrap-datepicker.css">

  <link rel="stylesheet" href="../fonts/flaticon/font/flaticon.css">

  <link rel="stylesheet" href="../css/aos.css">

  <link rel="stylesheet" href="../css/style.css">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
   table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
<div class="site-wrap">

    <div class="site-mobile-menu site-navbar-target">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div>


    <header class="site-navbar py-4" role="banner">
    <div class="container">
        <div class="d-flex align-items-center">
          <div class="site-logo">
            <a href="index.html">
              <img src="../images/brand.png" alt="Logo">
            </a>
          </div>
          <div class="ml-auto">
            <nav class="site-navigation position-relative text-right" role="navigation">
              <ul class="site-menu main-menu js-clone-nav mr-auto d-none d-lg-block">
                <li class="active"><a href="../user/index.php" class="nav-link">Home</a></li>
                <li><a href="matches1.php" class="nav-link">Matches</a></li>
                <li>
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="turnamen.php" role="button" aria-haspopup="true" aria-expanded="false">Turnamen</a>
  <div class="dropdown-menu" aria-labelledby="Preview">
    <a class="dropdown-item" href="turnamen1.php">U12</a>
    <a class="dropdown-item" href="turnamen2.php">U17</a>
    <a class="dropdown-item" href="turnamen3.php">U23</a>
    <a class="dropdown-item" href="turnamen4.php">U40</a>
  </div>
                  <li>
  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="../user/team.php" role="button" aria-haspopup="true" aria-expanded="false">Team</a>
  <div class="dropdown-menu" aria-labelledby="Preview">
  <a class="dropdown-item" href="../user/user_club.php">Club</a>
    <a class="dropdown-item" href="players.php">Player</a>
 
  </div>
</li>
<li><a href="contact1.php" class="nav-link">Contact</a></li>
                <li class="nav-item dropdown">
              </ul>
            </nav>
      
          

            <a href="#" class="d-inline-block d-lg-none site-menu-toggle js-menu-toggle text-black float-right text-white"><span
                class="icon-menu h3 text-white"></span></a>
          </div>
        </div>
      </div>

        <a href="#" class="d-inline-block d-lg-none site-menu-toggle js-menu-toggle text-black float-right text-white"><span
            class="icon-menu h3 text-white"></span></a>
      </div>
    </div>
  </div>

    </header>

    <div class="hero overlay" style="background-image: url('../images/bg_3.jpg');">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-5 mx-auto text-center">
            <h1 class="text-white">Matches</h1>
          </div>
        </div>
      </div>
    </div>
    <div class="container mt-5">
    <br/>
	<br/>
	<br/>
  <table class="table table-striped table-bordered">
		<tr>
        <div class="container mt-4">
        <h2 class="text-center">Daftar Jadwal</h2>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
  
            
			<th>ID</th>
      <th>ID Turnamen</th>
			<th>Nama Team</th>
      <th>Nama Team</th>
			<th>Tanggal</th>
			<th>Tempat</th>
     
		</tr>
		<?php 
		include '../config/koneksi.php';
		$no = 1;
		$data = mysqli_query($koneksi,"select * from jadwal");
		while($d = mysqli_fetch_array($data)){
			?>
			<tr>
				
				<td><?php echo $d['id']; ?></td>
        <td><?php echo $d['id_turnamen']; ?></td>
				<td><?php echo $d['id_team']; ?></td>
        <td><?php echo $d['id_tim']; ?></td>
				<td><?php echo $d['tanggal']; ?></td>
                <td><?php echo $d['tempat']; ?></td>
				
			</tr>
			<?php 
		}
		?>
	</table>
  </div>
    
   

    
   

    <footer class="footer-section">
      <div class="container">
        <div class="row">
          <div class="col-lg-3">
            <div class="widget mb-3">
              <h3>News</h3>
              <ul class="list-unstyled links">
                <li><a href="#">All</a></li>
                <li><a href="#">Club News</a></li>
                <li><a href="#">Media Center</a></li>
                <li><a href="#">Video</a></li>
                <li><a href="#">RSS</a></li>
              </ul>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="widget mb-3">
              <h3>Tickets</h3>
              <ul class="list-unstyled links">
                <li><a href="#">Online Ticket</a></li>
                <li><a href="#">Payment and Prices</a></li>
                <li><a href="#">Contact &amp; Booking</a></li>
                <li><a href="#">Tickets</a></li>
                <li><a href="#">Coupon</a></li>
              </ul>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="widget mb-3">
              <h3>Matches</h3>
              <ul class="list-unstyled links">
                <li><a href="#">Standings</a></li>
                <li><a href="#">World Cup</a></li>
                <li><a href="#">La Lega</a></li>
                <li><a href="#">Hyper Cup</a></li>
                <li><a href="#">World League</a></li>
              </ul>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="widget mb-3">
              <h3>Social</h3>
              <ul class="list-unstyled links">
                <li><a href="#">Twitter</a></li>
                <li><a href="#">Facebook</a></li>
                <li><a href="#">Instagram</a></li>
                <li><a href="#">Youtube</a></li>
              </ul>
            </div>
          </div>

        </div>


        </div>
      </div>
    </footer>



  </div>
  <!-- .site-wrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script src="../js/jquery-3.3.1.min.js"></script>
  <script src="../js/jquery-migrate-3.0.1.min.js"></script>
  <script src="../js/jquery-ui.js"></script>
  <script src="../js/popper.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/owl.carousel.min.js"></script>
  <script src="../js/jquery.stellar.min.js"></script>
  <script src="../js/jquery.countdown.min.js"></script>
  <script src="../js/bootstrap-datepicker.min.js"></script>
  <script src="../js/jquery.easing.1.3.js"></script>
  <script src="../js/aos.js"></script>
  <script src="../js/jquery.fancybox.min.js"></script>
  <script src="../js/jquery.sticky.js"></script>
  <script src="../js/jquery.mb.YTPlayer.min.js"></script>


  <script src="../js/main.js"></script>

</body>

</html>
