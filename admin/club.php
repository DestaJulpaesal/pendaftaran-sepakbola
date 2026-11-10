<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../config/database.php';

$flashMessage = '';
if (!empty($_SESSION['flash'])) {
    $flashMessage = (string) $_SESSION['flash'];
    unset($_SESSION['flash']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT) ?: 0;
    $namaClub = trim((string) ($_POST['nama_club'] ?? ''));
    $alamat = trim((string) ($_POST['alamat'] ?? ''));
    $tahunBerdiri = trim((string) ($_POST['tahun_berdiri'] ?? ''));

    if ($action === 'create' && $namaClub !== '' && $alamat !== '') {
        $stmt = $conn->prepare('INSERT INTO team (nama_club, alamat, tahun_berdiri) VALUES (:nama_club, :alamat, :tahun_berdiri)');
        $stmt->execute([
            ':nama_club' => $namaClub,
            ':alamat' => $alamat,
            ':tahun_berdiri' => $tahunBerdiri,
        ]);
        $_SESSION['flash'] = 'Club berhasil ditambahkan.';
        header('Location: club.php');
        exit;
    }

    if ($action === 'update' && $id > 0) {
        $stmt = $conn->prepare('UPDATE team SET nama_club = :nama_club, alamat = :alamat, tahun_berdiri = :tahun_berdiri WHERE id = :id');
        $stmt->execute([
            ':nama_club' => $namaClub,
            ':alamat' => $alamat,
            ':tahun_berdiri' => $tahunBerdiri,
            ':id' => $id,
        ]);
        $_SESSION['flash'] = 'Club berhasil diperbarui.';
        header('Location: club.php');
        exit;
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?: 0;
    if ($id > 0) {
        $stmt = $conn->prepare('DELETE FROM team WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $_SESSION['flash'] = 'Club berhasil dihapus.';
    }
    header('Location: club.php');
    exit;
}

$mode = $_GET['action'] ?? 'list';
$selectedClub = null;
if (($mode === 'edit' || $mode === 'view') && isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?: 0;
    if ($id > 0) {
        $stmt = $conn->prepare('SELECT * FROM team WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $id]);
        $selectedClub = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

$clubs = $conn->query('SELECT * FROM team ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Club</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <style>
        body { background: #f4f7fb; }
        .panel { background: #fff; border-radius: 16px; box-shadow: 0 8px 28px rgba(15, 23, 42, 0.08); }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="mb-1">Kelola Club</h1>
            <p class="text-muted mb-0">CRUD club dalam satu file</p>
        </div>
        <div>
            <a href="index_admin.php" class="btn btn-outline-secondary me-2">Dashboard</a>
            <a href="club.php?action=create" class="btn btn-primary">Tambah Club</a>
        </div>
    </div>

    <?php if ($flashMessage !== ''): ?>
        <div class="alert alert-success"><?= htmlspecialchars($flashMessage) ?></div>
    <?php endif; ?>

    <?php if ($mode === 'create' || $mode === 'edit'): ?>
        <?php
        $formAction = 'club.php';
        $formButton = 'Tambah Club';
        $formData = [
            'id' => '',
            'nama_club' => '',
            'alamat' => '',
            'tahun_berdiri' => '',
        ];
        if ($mode === 'edit' && $selectedClub) {
            $formAction = 'club.php?action=edit&id=' . (int) ($selectedClub['id'] ?? 0);
            $formButton = 'Simpan Perubahan';
            $formData = [
                'id' => (string) ($selectedClub['id'] ?? ''),
                'nama_club' => (string) ($selectedClub['nama_club'] ?? ''),
                'alamat' => (string) ($selectedClub['alamat'] ?? ''),
                'tahun_berdiri' => (string) ($selectedClub['tahun_berdiri'] ?? ''),
            ];
        }
        ?>
        <div class="panel p-4">
            <h3 class="mb-4"><?= $mode === 'edit' ? 'Edit Club' : 'Tambah Club' ?></h3>
            <form method="post" action="<?= htmlspecialchars($formAction) ?>">
                <input type="hidden" name="action" value="<?= $mode === 'edit' ? 'update' : 'create' ?>">
                <?php if ($mode === 'edit'): ?>
                    <input type="hidden" name="id" value="<?= htmlspecialchars($formData['id']) ?>">
                <?php endif; ?>

                <div class="mb-3">
                    <label class="form-label">Nama Club</label>
                    <input type="text" class="form-control" name="nama_club" value="<?= htmlspecialchars($formData['nama_club']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <input type="text" class="form-control" name="alamat" value="<?= htmlspecialchars($formData['alamat']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tahun Berdiri</label>
                    <input type="date" class="form-control" name="tahun_berdiri" value="<?= htmlspecialchars($formData['tahun_berdiri']) ?>">
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><?= $formButton ?></button>
                    <a href="club.php" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    <?php else: ?>
        <div class="panel p-4">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Club</th>
                            <th>Alamat</th>
                            <th>Tahun Berdiri</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($clubs)): ?>
                            <?php foreach ($clubs as $index => $club): ?>
                                <tr>
                                    <td><?= (int) ($index + 1) ?></td>
                                    <td><?= htmlspecialchars((string) ($club['nama_club'] ?? '-')) ?></td>
                                    <td><?= htmlspecialchars((string) ($club['alamat'] ?? '-')) ?></td>
                                    <td><?= htmlspecialchars((string) ($club['tahun_berdiri'] ?? '-')) ?></td>
                                    <td>
                                        <a href="club.php?action=view&id=<?= (int) ($club['id'] ?? 0) ?>" class="btn btn-sm btn-info text-white">Detail</a>
                                        <a href="club.php?action=edit&id=<?= (int) ($club['id'] ?? 0) ?>" class="btn btn-sm btn-warning">Ubah</a>
                                        <a href="club.php?action=delete&id=<?= (int) ($club['id'] ?? 0) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin menghapus club ini?');">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Belum ada data club.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($mode === 'view' && $selectedClub): ?>
        <div class="panel p-4 mt-4">
            <h3 class="mb-3">Detail Club</h3>
            <div class="row g-3">
                <div class="col-md-4">
                    <strong>Nama Club</strong>
                    <p class="mb-0"><?= htmlspecialchars((string) ($selectedClub['nama_club'] ?? '-')) ?></p>
                </div>
                <div class="col-md-4">
                    <strong>Alamat</strong>
                    <p class="mb-0"><?= htmlspecialchars((string) ($selectedClub['alamat'] ?? '-')) ?></p>
                </div>
                <div class="col-md-4">
                    <strong>Tahun Berdiri</strong>
                    <p class="mb-0"><?= htmlspecialchars((string) ($selectedClub['tahun_berdiri'] ?? '-')) ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
