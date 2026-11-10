# Prompt: Upgrade Sistem Pendaftaran & Turnamen Sepak Bola

## Tujuan Utama
Anda adalah AI engineer yang ditugaskan untuk memperbaiki dan mengembangkan aplikasi web PHP native untuk sistem pendaftaran tim/pemain sepak bola dan manajemen turnamen. Tujuan utama: membuat sistem ini layak dipakai untuk turnamen nyata, bukan sekadar demo tugas kuliah.

Project ini tetap harus memakai teknologi yang sudah ada:
- PHP native (tanpa framework)
- MySQL
- Bootstrap 5 + jQuery
- arsitektur modular sederhana di folder `admin/`, `user/`, dan `config/`

Anda harus menjaga stack teknologi tersebut, kecuali ada kebutuhan yang jelas untuk menambah library kecil yang aman dan relevan.

## Konteks Aplikasi
Aplikasi memiliki dua sisi utama:
- User: halaman home, jadwal, daftar tim, daftar pemain, kontak, login, form pendaftaran tim & pemain, dan halaman cetak/print.
- Admin: kelola klub, pemain, pertandingan, turnamen, approval pendaftaran, pencarian, dan profil admin.

Project saat ini sudah menunjukkan masalah umum pada codebase PHP lama:
- banyak file koneksi database yang tumpang tindih (`conection.php`, `config.php`, `confiq1.php`, `db_connection.php`, `koneksi.php`, `koneksii.php`)
- beberapa file memakai `mysqli_connect` dan yang lain memakai PDO
- kredensial database hardcoded di banyak tempat
- query SQL sering menggabungkan variabel `$_POST`/`$_GET` langsung tanpa prepared statement
- file admin duplikat seperti `players.php` sampai `players7.php`, `turnamen.php` sampai `turnamen10.php`, dan seterusnya
- penggunaan session dan role check tidak konsisten
- banyak form belum punya CSRF protection dan validasi server-side yang memadai

## Prinsip Kerja
Ikuti prinsip berikut selama proses upgrade:

1. Prioritaskan keamanan dan stabilitas sebelum fitur baru.
2. Jangan mengubah teknologi inti jika tidak perlu.
3. Fokus pada perbaikan yang bersifat "surgical": perbaiki bug dan struktur yang benar, bukan rewrite besar-besaran tanpa alasan.
4. Saat ada duplikasi file, gabungkan ke struktur yang jelas, lalu hapus file lama yang tidak lagi dipakai.
5. Jelaskan setiap perubahan besar sebelum menimpa file yang sudah ada.
6. Jangan langsung mengubah semua modul sekaligus. Kerjakan secara bertahap.
7. Jika ada keputusan penting yang masih ambigu, buat asumsi yang masuk akal, jelaskan asumsi tersebut, lalu lanjutkan.

---

## BAGIAN 1 — Perbaikan Struktur & Keamanan (wajib dikerjakan lebih dulu)

Lakukan urutan berikut dari paling awal sampai selesai sebelum mulai fitur besar.

### 1.1 Satukan koneksi database
Gabungkan semua file koneksi database yang tumpang tindih menjadi satu file tunggal: `config/database.php`.

Kriteria yang harus dipenuhi:
- satu sumber kredensial database saja
- file tersebut harus bisa menyediakan koneksi `mysqli` dan `PDO` dari satu konfigurasi
- tidak boleh ada file konfigurasi ganda yang bisa berbeda saat di-update
- hindari hardcoded credential di banyak file

### 1.2 Pindahkan konfigurasi ke `.env`
- Pindahkan semua kredensial database ke file `.env`
- Gunakan pendekatan ringan seperti `parse_ini_file` atau library kecil seperti `vlucas/phpdotenv`
- Tambahkan `.env` ke `.gitignore`
- Pastikan tidak ada lagi `root` / password hardcoded di source code

### 1.3 Konsistenkan akses database ke PDO + prepared statement
Semua query database di seluruh project harus memakai PDO dengan prepared statement.

Harus diubah:
- semua `mysqli_query` yang masih menerima variabel `$_POST`, `$_GET`, atau input user tanpa prepared statement
- semua operasi CRUD yang berpotensi SQL injection
- semua file yang melakukan query insert/update/delete/select yang tidak aman

Tujuan:
- aman dari SQL Injection
- struktur kode lebih konsisten
- lebih mudah dipelihara saat nanti proyek diperluas

### 1.4 Rapikan duplikasi file admin
File seperti:
- `players.php` sampai `players7.php`
- `turnamen.php` sampai `turnamen10.php`
- `matches.php` sampai `matches6.php`
- `pendaftaran.php` sampai `pendaftaran6.php`

terlihat seperti hasil save-as berulang kali. Audit file-file tersebut dan gabungkan ke struktur yang lebih bersih, misalnya:
- `index.php`
- `create.php`
- `edit.php`
- `delete.php`
- atau satu file dengan parameter `?action=` jika memang lebih cocok

Setelah digabung:
- hapus file duplikat yang tidak dipakai lagi
- pastikan URL dan include tidak rusak
- jangan menghapus fitur yang masih relevan

### 1.5 Perbaiki sesi login
Pada `Login.php` atau file autentikasi yang relevan:
- jangan simpan password mentah ke `$_SESSION['password']`
- tidak perlu menyimpan password di session karena verifikasi sudah dilakukan dengan `password_verify()`
- simpan hanya data minimal seperti `user_id` dan `role`
- setelah login berhasil, panggil `session_regenerate_id(true)` untuk mencegah session fixation

### 1.6 Tambahkan CSRF protection
Semua form POST harus punya token CSRF yang aman, termasuk:
- login
- pendaftaran
- insert/update/delete admin
- semua form CRUD yang mengubah data

Prinsip:
- token harus disimpan di session
- token harus divalidasi saat submit form
- form yang tidak valid harus ditolak

### 1.7 Validasi input server-side
Validasi di server harus dilakukan secara eksplisit, bukan hanya bergantung pada `required` di HTML.

Validasi yang harus diterapkan minimal:
- nama pemain/tim
- nomor HP / email
- tanggal lahir
- format file foto
- ukuran file foto dan dokumen
- tipe file yang diizinkan

Jika format tidak valid, tolak request dengan pesan yang jelas dan tanpa menyimpan data yang buruk.

### 1.8 Middleware / role check konsisten
Semua halaman di folder `/admin` harus mengecek role di awal file secara konsisten, misalnya:
- `$_SESSION['role'] === 'admin'`

Fungsi ini harus dijalankan di baris paling atas sebelum output HTML dibuka, supaya halaman admin tidak bisa diakses oleh user biasa melalui URL langsung.

---

## BAGIAN 2 — Fitur yang Harus Ditambahkan

### Prioritas Tinggi (wajib diimplementasikan)
Fitur berikut adalah inti agar sistem benar-benar bisa dipakai untuk turnamen sungguhan.

#### 2.1 Status pendaftaran otomatis
Implementasikan alur status yang jelas:
- Pending
- Diverifikasi
- Diterima
- Ditolak

Admin harus bisa mengubah status dan menambahkan alasan penolakan jika ditolak.

#### 2.2 Notifikasi ke pendaftar
Saat status berubah, kirim notifikasi ke pendaftar.

Pilihan yang bisa dipakai:
- email via PHPMailer (prioritas utama)
- atau link WhatsApp otomatis (`wa.me`) jika belum ingin pakai API berbayar

Notifikasi harus mencakup status baru dan alasan penolakan bila ada.

#### 2.3 Dashboard admin
Buat dashboard admin yang menampilkan angka ringkas seperti:
- jumlah tim terdaftar
- jumlah pemain
- pertandingan mendatang
- status pendaftaran (pending / diterima / ditolak)

Gunakan chart sederhana, seperti Chart.js.

#### 2.4 Upload dokumen wajib turnamen
Tambahkan upload dokumen penting, misalnya:
- foto pemain
- scan KTP / kartu pelajar
- surat izin orang tua untuk pemain di bawah umur

Setiap file harus divalidasi:
- tipe file
- ukuran file
- ekstensi yang diizinkan
- lokasi penyimpanan aman

#### 2.5 Bracket / jadwal otomatis
Buat generator jadwal dan bracket turnamen otomatis berdasarkan tim yang sudah diterima.

Fitur ini harus membuat jadwal turnamen secara otomatis, bukan input manual satu-satu untuk tiap pertandingan.

Rekomendasi format awal:
- single elimination
- atau group stage

#### 2.6 Live score sederhana
Admin harus bisa update skor pertandingan secara real time.

Minimal ada dua opsi:
- polling AJAX tiap beberapa detik untuk halaman user
- atau tombol refresh manual dengan tampilan skor yang diperbarui

Tujuannya: user bisa melihat skor terbaru tanpa reload seluruh halaman.

### Prioritas Menengah
Setelah fitur prioritas tinggi stabil, lanjutkan ke fitur ini.

- Pembayaran biaya pendaftaran dengan bukti transfer manual + verifikasi admin
- Klasemen otomatis berbasis hasil pertandingan (menang/seri/kalah → poin)
- Pencarian dan filter di daftar tim/pemain (nama, klub, kategori umur)
- Riwayat aktivitas admin untuk akuntabilitas
- Export data ke Excel/PDF untuk daftar peserta, jadwal, dan hasil pertandingan

### Nice-to-have
- Multi-turnamen dalam satu sistem
- Galeri foto / dokumentasi pertandingan
- Statistik pemain otomatis (gol, kartu, jumlah pertandingan)
- SweetAlert2 untuk feedback form secara konsisten
- Dark mode sederhana
- Skeleton loading untuk tabel besar

---

## BAGIAN 3 — Workflow Eksekusi AI

Kerjakan secara bertahap. Jangan langsung mengubah semuanya sekaligus.

### Urutan yang disarankan
1. Mulai dari Bagian 1: struktur dan keamanan.
2. Setelah foundation selesai, pilih 2-3 fitur prioritas tinggi.
3. Rekomendasi awal: status pendaftaran otomatis + notifikasi + dashboard admin.
4. Setelah itu lanjut ke fitur lain seperti bracket, live score, dan upload dokumen.
5. Baru kemudian lakukan modernisasi UI/UX dan optimasi lanjutan.

### Ketentuan per perubahan file
Sebelum menimpa file lama:
- jelaskan dulu apa yang akan diubah
- jelaskan alasan perubahan tersebut
- pastikan perubahan yang Anda lakukan tidak merusak flow aplikasi yang sudah ada

### Dokumentasi database
Wajib dokumen skema database. Buat file `docs/struktur_database.sql` atau `database/schema.sql` yang berisi:
- `CREATE TABLE` untuk semua tabel utama
- foreign key yang relevan
- struktur data yang jelas
- beberapa data contoh bila perlu

Tujuan:
- mudah di-restore di laptop lain
- mudah dilakukan setup ulang
- memudahkan tracking progress

### Checklist testing manual
Setelah tiap modul selesai, buat manual testing checklist sebelum lanjut ke modul berikutnya.

Contoh:
- login admin berhasil dan gagal
- tambah/edit/hapus klub
- submit pendaftaran tim baru sampai masuk admin
- approve/reject pendaftaran
- tambah pertandingan dan update skor
- generate bracket dari tim yang diterima
- cek halaman admin tanpa login harus ditolak

---

## BAGIAN 4 — Modernisasi UI/UX

### 4.1 Konsistenkan tampilan frontend
Saat ini banyak halaman macam `admin/turnamen.php`, `admin/matches.php`, `user/team.php`, dll. kemungkinan memuat kombinasi library yang tumpang tindih:
- Bootstrap 5
- Bootstrap 4
- Font Awesome versi lama
- file CSS lokal yang double

Tugas Anda:
- pakai satu versi Bootstrap saja (rekomendasi: Bootstrap 5)
- Hindari campur CDN dan lokal jika tidak perlu
- buat `header.php` / `footer.php` untuk menampung asset CSS/JS agar tidak duplikat

### 4.2 Navigasi berbasis role
User dan admin harus memiliki menu yang terpisah jelas.

- user biasa tidak boleh melihat link admin
- halaman admin harus disembunyikan dari tampilan user
- menu sidebar/header harus disesuaikan berdasarkan `role`

### 4.3 Form pendaftaran yang lebih manusiawi
Ubah form pendaftaran menjadi flow multi-step yang lebih rapi:
- data tim
- data pemain satu per satu
- upload dokumen
- review & submit

Tambahkan:
- progress bar
- validasi real-time (misalnya nomor HP, email)
- preview foto sebelum upload

### 4.4 Tabel data besar harus bisa sort, filter, dan pagination
Untuk data yang banyak seperti daftar tim, pemain, dan pertandingan:
- aktifkan sort
- aktifkan filter
- aktifkan pagination

Library seperti DataTables sangat cocok.

### 4.5 Responsif di mobile
Project harus dibuka dengan nyaman di HP, bukan hanya desktop.

Pastikan:
- tabel bisa di-scroll horizontal di perangkat kecil
- form input nyaman untuk mobile
- sidebar tidak menabrak layout kecil
- tombol utama cukup besar untuk tap

### 4.6 Feedback aksi yang jelas
Semua aksi seperti tambah, edit, hapus, approve, reject, dan upload harus memberi feedback jelas.

Prioritaskan:
- SweetAlert2 untuk notifikasi interaktif
- tidak hanya alert bawaan browser
- tidak hanya reload halaman tanpa status yang jelas

---

## BAGIAN 5 — Testing, Deployment & Maintenance

### 5.1 Susun skema database resmi
Buat file struktur database yang rapi dan siap digunakan untuk setup ulang.

Format yang disarankan:
- `database/schema.sql` atau `docs/struktur_database.sql`
- isi lengkap `CREATE TABLE` beserta relasi yang dibutuhkan
- valid untuk setup baru di komputer lain

### 5.2 Checklist testing manual sebelum dianggap selesai
Sebelum menyimpulkan pekerjaan selesai, lakukan testing manual pada modul utama.

Checklist minimal:
- login admin berhasil
- login user biasa berhasil
- login gagal dengan kredensial salah
- tambah/edit/hapus klub
- daftarkan tim baru
- approve/reject pendaftaran
- tambah pertandingan dan update skor
- generate bracket dari tim yang diterima
- akses halaman admin tanpa login harus ditolak
- akses halaman admin dengan role user harus ditolak

### 5.3 Environment development vs production
Siapkan pengaturan environment yang terpisah:
- file `.env` lokal untuk development
- file `.env` production untuk hosting
- `display_errors` harus dimatikan di production

Tujuannya:
- menjaga keamanan
- menghindari leak informasi sensitif
- memudahkan deployment ke hosting

### 5.4 Strategi backup
Karena aplikasi menyimpan data orang dan dokumen pendaftaran, pastikan ada rencana backup database.

Minimal:
- backup database secara berkala
- simpan hasil backup di lokasi aman
- pastikan data penting tidak hanya ada di satu komputer

### 5.5 Rencana hosting
Jika nanti dipakai publik, aplikasi PHP + MySQL native cocok untuk hosting shared seperti cPanel.

Pastikan:
- PHP minimal versi 8
- direktori upload gambar/dokumen dipisahkan dari folder publik yang bisa diakses langsung
- folder dokumen sensitif tidak dibuka sebagai URL publik

---

## Target Output yang Diharapkan
Anda harus menghasilkan perubahan yang berkualitas, bukan hanya list ide. Hasil akhir yang diharapkan adalah project yang:
- aman dari celah umum web app
- lebih rapi secara struktur kode
- lebih siap dipakai untuk turnamen sungguhan
- konsisten dari sisi database, autentikasi, role access, dan UI
- punya dokumentasi dasar untuk setup dan testing

## Instruksi Terakhir untuk AI
Kerjakan dengan pendekatan berikut:

1. Mulai dari struktur dan keamanan.
2. Lakukan perubahan secara bertahap, bukan satu sweep besar.
3. Validasi setiap modul setelah selesai.
4. Setelah finish, sertakan ringkasan perubahan dan checklist testing yang sudah dijalankan.
5. Jika proses terhambat oleh ketidakjelasan, buat asumsi yang masuk akal dan jelaskan alasan asumsi tersebut.

Copy seluruh isi prompt ini ke AI coding assistant yang Anda pakai (Claude Code, Cursor, Codex, atau tools sejenis). Minta AI mulai dari Bagian 1, konfirmasi setiap langkah besar, dan lanjut ke Bagian 2 hanya setelah fondasi sudah aman.
