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
    $namaTurnamen = trim((string) ($_POST['nama_turnamen'] ?? ''));
    $tanggalMulai = trim((string) ($_POST['tanggal_mulai'] ?? ''));
    $tanggalSelesai = trim((string) ($_POST['tanggal_selesai'] ?? ''));

    if ($action === 'create' && $namaTurnamen !== '') {
        $stmt = $conn->prepare('INSERT INTO turnamen (nama_turnamen, tanggal_mulai, tanggal_selesai) VALUES (:nama_turnamen, :tanggal_mulai, :tanggal_selesai)');
        $stmt->execute([
            ':nama_turnamen' => $namaTurnamen,
            ':tanggal_mulai' => $tanggalMulai,
            ':tanggal_selesai' => $tanggalSelesai,
        ]);
        $_SESSION['flash'] = 'Turnamen berhasil ditambahkan.';
        header('Location: turnamen.php');
        exit;
    }

    if ($action === 'update' && $id > 0) {
        $stmt = $conn->prepare('UPDATE turnamen SET nama_turnamen = :nama_turnamen, tanggal_mulai = :tanggal_mulai, tanggal_selesai = :tanggal_selesai WHERE id_tur = :id');
        $stmt->execute([
            ':nama_turnamen' => $namaTurnamen,
            ':tanggal_mulai' => $tanggalMulai,
            ':tanggal_selesai' => $tanggalSelesai,
            ':id' => $id,
        ]);
        $_SESSION['flash'] = 'Turnamen berhasil diperbarui.';
        header('Location: turnamen.php');
        exit;
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?: 0;
    if ($id > 0) {
        $stmt = $conn->prepare('DELETE FROM turnamen WHERE id_tur = :id');
        $stmt->execute([':id' => $id]);
        $_SESSION['flash'] = 'Turnamen berhasil dihapus.';
    }
    header('Location: turnamen.php');
    exit;
}

$mode = $_GET['action'] ?? 'list';
$selectedTurnamen = null;
if (($mode === 'edit' || $mode === 'view') && isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?: 0;
    if ($id > 0) {
        $stmt = $conn->prepare('SELECT * FROM turnamen WHERE id_tur = :id LIMIT 1');
        $stmt->execute([':id' => $id]);
        $selectedTurnamen = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

$turnamenList = $conn->query('SELECT * FROM turnamen ORDER BY id_tur DESC')->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Turnamen</title>
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
            <h1 class="mb-1">Kelola Turnamen</h1>
            <p class="text-muted mb-0">CRUD turnamen dalam satu file</p>
        </div>
        <div>
            <a href="index_admin.php" class="btn btn-outline-secondary me-2">Dashboard</a>
            <a href="turnamen.php?action=create" class="btn btn-primary">Tambah Turnamen</a>
        </div>
    </div>

    <?php if ($flashMessage !== ''): ?>
        <div class="alert alert-success"><?= htmlspecialchars($flashMessage) ?></div>
    <?php endif; ?>

    <?php if ($mode === 'create' || $mode === 'edit'): ?>
        <?php
        $formData = ['id' => '', 'nama_turnamen' => '', 'tanggal_mulai' => '', 'tanggal_selesai' => ''];
        if ($mode === 'edit' && $selectedTurnamen) {
            $formData = [
                'id' => (string) ($selectedTurnamen['id_tur'] ?? ''),
                'nama_turnamen' => (string) ($selectedTurnamen['nama_turnamen'] ?? ''),
                'tanggal_mulai' => (string) ($selectedTurnamen['tanggal_mulai'] ?? ''),
                'tanggal_selesai' => (string) ($selectedTurnamen['tanggal_selesai'] ?? ''),
            ];
        }
        ?>
        <div class="panel p-4">
            <h3 class="mb-4"><?= $mode === 'edit' ? 'Edit Turnamen' : 'Tambah Turnamen' ?></h3>
            <form method="post" action="turnamen.php">
                <input type="hidden" name="action" value="<?= $mode === 'edit' ? 'update' : 'create' ?>">
                <?php if ($mode === 'edit'): ?>
                    <input type="hidden" name="id" value="<?= htmlspecialchars($formData['id']) ?>">
                <?php endif; ?>

                <div class="mb-3">
                    <label class="form-label">Nama Turnamen</label>
                    <input type="text" class="form-control" name="nama_turnamen" value="<?= htmlspecialchars($formData['nama_turnamen']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" class="form-control" name="tanggal_mulai" value="<?= htmlspecialchars($formData['tanggal_mulai']) ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Selesai</label>
                    <input type="date" class="form-control" name="tanggal_selesai" value="<?= htmlspecialchars($formData['tanggal_selesai']) ?>">
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><?= $mode === 'edit' ? 'Simpan Perubahan' : 'Tambah Turnamen' ?></button>
                    <a href="turnamen.php" class="btn btn-outline-secondary">Batal</a>
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
                            <th>Nama Turnamen</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($turnamenList)): ?>
                            <?php foreach ($turnamenList as $index => $item): ?>
                                <tr>
                                    <td><?= (int) ($index + 1) ?></td>
                                    <td><?= htmlspecialchars((string) ($item['nama_turnamen'] ?? '-')) ?></td>
                                    <td><?= htmlspecialchars((string) ($item['tanggal_mulai'] ?? '-')) ?></td>
                                    <td><?= htmlspecialchars((string) ($item['tanggal_selesai'] ?? '-')) ?></td>
                                    <td>
                                        <a href="turnamen.php?action=view&id=<?= (int) ($item['id_tur'] ?? 0) ?>" class="btn btn-sm btn-info text-white">Detail</a>
                                        <a href="turnamen.php?action=edit&id=<?= (int) ($item['id_tur'] ?? 0) ?>" class="btn btn-sm btn-warning">Ubah</a>
                                        <a href="turnamen.php?action=delete&id=<?= (int) ($item['id_tur'] ?? 0) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin menghapus turnamen ini?');">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Belum ada data turnamen.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($mode === 'view' && $selectedTurnamen): ?>
        <div class="panel p-4 mt-4">
            <h3 class="mb-3">Detail Turnamen</h3>
            <div class="row g-3">
                <div class="col-md-4">
                    <strong>Nama Turnamen</strong>
                    <p class="mb-0"><?= htmlspecialchars((string) ($selectedTurnamen['nama_turnamen'] ?? '-')) ?></p>
                </div>
                <div class="col-md-4">
                    <strong>Tanggal Mulai</strong>
                    <p class="mb-0"><?= htmlspecialchars((string) ($selectedTurnamen['tanggal_mulai'] ?? '-')) ?></p>
                </div>
                <div class="col-md-4">
                    <strong>Tanggal Selesai</strong>
                    <p class="mb-0"><?= htmlspecialchars((string) ($selectedTurnamen['tanggal_selesai'] ?? '-')) ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
