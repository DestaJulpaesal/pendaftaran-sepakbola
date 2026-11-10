<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../config/database.php';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?: 0;
$registration = null;

if (!($conn instanceof PDO)) {
    $statusMessage = 'Database belum tersedia. Silakan cek koneksi database.';
} elseif ($id > 0) {
    $stmt = $conn->prepare('SELECT * FROM pendaptaran WHERE id_pendaftaran = :id LIMIT 1');
    $stmt->execute([':id' => $id]);
    $registration = $stmt->fetch(PDO::FETCH_ASSOC);
}

$statusMessage = $_SESSION['status_update'] ?? '';
unset($_SESSION['status_update']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pendaftaran</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <style>
        body { background: #f7f9fc; }
        .panel { background: #fff; border-radius: 12px; box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08); }
    </style>
</head>
<body>
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Detail Pendaftaran</h1>
        <a href="pendaftaran.php" class="btn btn-primary">Kembali</a>
    </div>

    <?php if ($statusMessage !== ''): ?>
        <div class="alert alert-success"><?= htmlspecialchars($statusMessage) ?></div>
    <?php endif; ?>

    <?php if ($registration): ?>
        <div class="panel p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <h5>Nama Team</h5>
                    <p class="mb-0"><?= htmlspecialchars($registration['nama_team'] ?? '-') ?></p>
                </div>
                <div class="col-md-6">
                    <h5>Alamat / Kampung</h5>
                    <p class="mb-0"><?= htmlspecialchars($registration['kampung'] ?? '-') ?></p>
                </div>
                <div class="col-md-6">
                    <h5>Status Saat Ini</h5>
                    <p class="mb-0 text-capitalize"><?= htmlspecialchars((string) ($registration['status'] ?? 'pending')) ?></p>
                </div>
                <div class="col-md-6">
                    <h5>Alasan Penolakan</h5>
                    <p class="mb-0"><?= htmlspecialchars((string) ($registration['alasan_penolakan'] ?? '-')) ?: '-' ?></p>
                </div>
            </div>

            <hr>

            <form action="pendaftaran_status.php" method="post" class="row g-3 mt-2">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                <input type="hidden" name="id" value="<?= (int) ($registration['id_pendaftaran'] ?? 0) ?>">

                <div class="col-md-6">
                    <label for="status" class="form-label">Ubah Status</label>
                    <select class="form-select" id="status" name="status">
                        <?php $currentStatus = strtolower((string) ($registration['status'] ?? 'pending')); ?>
                        <?php foreach (['pending', 'diverifikasi', 'diterima', 'ditolak'] as $statusValue): ?>
                            <option value="<?= $statusValue ?>" <?= $currentStatus === $statusValue ? 'selected' : '' ?>><?= ucfirst($statusValue) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-12" id="rejectionReasonGroup" style="display: none;">
                    <label for="alasan_penolakan" class="form-label">Alasan Penolakan</label>
                    <textarea class="form-control" id="alasan_penolakan" name="alasan_penolakan" rows="4"><?= htmlspecialchars((string) ($registration['alasan_penolakan'] ?? '')) ?></textarea>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-success">Simpan Status</button>
                </div>
            </form>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">Data pendaftaran tidak ditemukan.</div>
    <?php endif; ?>
</div>

<script>
    const statusSelect = document.getElementById('status');
    const rejectionReasonGroup = document.getElementById('rejectionReasonGroup');

    function toggleReasonField() {
        rejectionReasonGroup.style.display = statusSelect.value === 'ditolak' ? 'block' : 'none';
    }

    statusSelect.addEventListener('change', toggleReasonField);
    toggleReasonField();
</script>
</body>
</html>
