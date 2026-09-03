<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "turnamen_sepakbola";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $database);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
<?php
// Query SQL untuk mengambil data
$sql = "SELECT * FROM team";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="item">';
        echo '<img src="../images/' . $row["image"] . '" alt="' . $row["alamat"] . '">';
        echo '<p>Nama: ' . $row["tahun_berdiri"] . '</p>';
      
        // Anda dapat menambahkan kolom lainnya sesuai dengan kebutuhan
        echo '</div>';
    }
} else {
    echo "Tidak ada data yang ditemukan.";
    echo "Error: " . $conn->error; // Menampilkan pesan kesalahan
}

// Menutup koneksi
$conn->close();
?>
