CREATE DATABASE IF NOT EXISTS turnamen_sepakbola CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE turnamen_sepakbola;

CREATE TABLE IF NOT EXISTS tbl_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    full_name VARCHAR(150) DEFAULT NULL,
    email VARCHAR(150) DEFAULT NULL,
    phone VARCHAR(30) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS tbl_club (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_club VARCHAR(150) NOT NULL,
    kota VARCHAR(100) DEFAULT NULL,
    pelatih VARCHAR(150) DEFAULT NULL,
    no_hp VARCHAR(30) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS tbl_pemain (
    id INT AUTO_INCREMENT PRIMARY KEY,
    club_id INT DEFAULT NULL,
    nama_pemain VARCHAR(150) NOT NULL,
    posisi VARCHAR(50) DEFAULT NULL,
    tanggal_lahir DATE DEFAULT NULL,
    no_hp VARCHAR(30) DEFAULT NULL,
    foto VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_pemain_club FOREIGN KEY (club_id) REFERENCES tbl_club(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS tbl_turnamen (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_turnamen VARCHAR(150) NOT NULL,
    deskripsi TEXT,
    tanggal_mulai DATE DEFAULT NULL,
    tanggal_selesai DATE DEFAULT NULL,
    status ENUM('draft', 'open', 'ongoing', 'closed') NOT NULL DEFAULT 'draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS tbl_pendaftaran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    club_id INT DEFAULT NULL,
    nama_ketua VARCHAR(150) DEFAULT NULL,
    email VARCHAR(150) DEFAULT NULL,
    no_hp VARCHAR(30) DEFAULT NULL,
    status ENUM('pending', 'diverifikasi', 'diterima', 'ditolak') NOT NULL DEFAULT 'pending',
    alasan_penolakan TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_pendaftaran_club FOREIGN KEY (club_id) REFERENCES tbl_club(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS tbl_match (
    id INT AUTO_INCREMENT PRIMARY KEY,
    turnamen_id INT DEFAULT NULL,
    team_a INT DEFAULT NULL,
    team_b INT DEFAULT NULL,
    skor_a INT NOT NULL DEFAULT 0,
    skor_b INT NOT NULL DEFAULT 0,
    status ENUM('scheduled', 'live', 'finished') NOT NULL DEFAULT 'scheduled',
    jadwal DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_match_turnamen FOREIGN KEY (turnamen_id) REFERENCES tbl_turnamen(id) ON DELETE SET NULL,
    CONSTRAINT fk_match_team_a FOREIGN KEY (team_a) REFERENCES tbl_club(id) ON DELETE SET NULL,
    CONSTRAINT fk_match_team_b FOREIGN KEY (team_b) REFERENCES tbl_club(id) ON DELETE SET NULL
) ENGINE=InnoDB;

INSERT INTO tbl_users (username, password, role, full_name, email)
VALUES (
    'admin',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.',
    'admin',
    'Administrator',
    'admin@example.com'
) ON DUPLICATE KEY UPDATE username = VALUES(username);
