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
    $turnamen = trim((string) ($_POST['id_tur'] ?? ''));
    $team = trim((string) ($_POST['id_team'] ?? ''));
    $tim = trim((string) ($_POST['id_tim'] ?? ''));
    $tanggal = trim((string) ($_POST['tanggal'] ?? ''));
    $tempat = trim((string) ($_POST['tempat'] ?? ''));

    if ($action === 'create') {
        $stmt = $conn->prepare('INSERT INTO jadwal (id_tur, id_team, id_tim, tanggal, tempat) VALUES (:id_tur, :id_team, :id_tim, :tanggal, :tempat)');
        $stmt->execute([
            ':id_tur' => $turnamen,
            ':id_team' => $team,
            ':id_tim' => $tim,
            ':tanggal' => $tanggal,
            ':tempat' => $tempat,
        ]);
        $_SESSION['flash'] = 'Jadwal berhasil ditambahkan.';
        header('Location: matches.php');
        exit;
    }

    if ($action === 'update' && $id > 0) {
        $stmt = $conn->prepare('UPDATE jadwal SET id_tur = :id_tur, id_team = :id_team, id_tim = :id_tim, tanggal = :tanggal, tempat = :tempat WHERE id = :id');
        $stmt->execute([
            ':id_tur' => $turnamen,
            ':id_team' => $team,
            ':id_tim' => $tim,
            ':tanggal' => $tanggal,
            ':tempat' => $tempat,
            ':id' => $id,
        ]);
        $_SESSION['flash'] = 'Jadwal berhasil diperbarui.';
        header('Location: matches.php');
        exit;
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?: 0;
    if ($id > 0) {
        $stmt = $conn->prepare('DELETE FROM jadwal WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $_SESSION['flash'] = 'Jadwal berhasil dihapus.';
    }
    header('Location: matches.php');
    exit;
}

$mode = $_GET['action'] ?? 'list';
$selectedMatch = null;
if (($mode === 'edit' || $mode === 'view') && isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?: 0;
    if ($id > 0) {
        $stmt = $conn->prepare('SELECT * FROM jadwal WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $id]);
        $selectedMatch = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

$matches = $conn->query('SELECT * FROM jadwal ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Jadwal</title>
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
            <h1 class="mb-1">Kelola Jadwal</h1>
            <p class="text-muted mb-0">CRUD jadwal dalam satu file</p>
        </div>
        <div>
            <a href="index_admin.php" class="btn btn-outline-secondary me-2">Dashboard</a>
            <a href="matches.php?action=create" class="btn btn-primary">Tambah Jadwal</a>
        </div>
    </div>

    <?php if ($flashMessage !== ''): ?>
        <div class="alert alert-success"><?= htmlspecialchars($flashMessage) ?></div>
    <?php endif; ?>

    <?php if ($mode === 'create' || $mode === 'edit'): ?>
        <?php
        $formData = ['id' => '', 'id_tur' => '', 'id_team' => '', 'id_tim' => '', 'tanggal' => '', 'tempat' => ''];
        if ($mode === 'edit' && $selectedMatch) {
            $formData = [
                'id' => (string) ($selectedMatch['id'] ?? ''),
                'id_tur' => (string) ($selectedMatch['id_tur'] ?? ''),
                'id_team' => (string) ($selectedMatch['id_team'] ?? ''),
                'id_tim' => (string) ($selectedMatch['id_tim'] ?? ''),
                'tanggal' => (string) ($selectedMatch['tanggal'] ?? ''),
                'tempat' => (string) ($selectedMatch['tempat'] ?? ''),
            ];
        }
        ?>
        <div class="panel p-4">
            <h3 class="mb-4"><?= $mode === 'edit' ? 'Edit Jadwal' : 'Tambah Jadwal' ?></h3>
            <form method="post" action="matches.php">
                <input type="hidden" name="action" value="<?= $mode === 'edit' ? 'update' : 'create' ?>">
                <?php if ($mode === 'edit'): ?>
                    <input type="hidden" name="id" value="<?= htmlspecialchars($formData['id']) ?>">
                <?php endif; ?>

                <div class="mb-3">
                    <label class="form-label">ID Turnamen</label>
                    <input type="number" class="form-control" name="id_tur" value="<?= htmlspecialchars($formData['id_tur']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">ID Team</label>
                    <input type="number" class="form-control" name="id_team" value="<?= htmlspecialchars($formData['id_team']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">ID Tim</label>
                    <input type="number" class="form-control" name="id_tim" value="<?= htmlspecialchars($formData['id_tim']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" class="form-control" name="tanggal" value="<?= htmlspecialchars($formData['tanggal']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tempat</label>
                    <input type="text" class="form-control" name="tempat" value="<?= htmlspecialchars($formData['tempat']) ?>" required>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><?= $mode === 'edit' ? 'Simpan Perubahan' : 'Tambah Jadwal' ?></button>
                    <a href="matches.php" class="btn btn-outline-secondary">Batal</a>
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
                            <th>ID Turnamen</th>
                            <th>ID Team</th>
                            <th>ID Tim</th>
                            <th>Tanggal</th>
                            <th>Tempat</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($matches)): ?>
                            <?php foreach ($matches as $index => $match): ?>
                                <tr>
                                    <td><?= (int) ($index + 1) ?></td>
                                    <td><?= htmlspecialchars((string) ($match['id_tur'] ?? '-')) ?></td>
                                    <td><?= htmlspecialchars((string) ($match['id_team'] ?? '-')) ?></td>
                                    <td><?= htmlspecialchars((string) ($match['id_tim'] ?? '-')) ?></td>
                                    <td><?= htmlspecialchars((string) ($match['tanggal'] ?? '-')) ?></td>
                                    <td><?= htmlspecialchars((string) ($match['tempat'] ?? '-')) ?></td>
                                    <td>
                                        <a href="matches.php?action=view&id=<?= (int) ($match['id'] ?? 0) ?>" class="btn btn-sm btn-info text-white">Detail</a>
                                        <a href="matches.php?action=edit&id=<?= (int) ($match['id'] ?? 0) ?>" class="btn btn-sm btn-warning">Ubah</a>
                                        <a href="matches.php?action=delete&id=<?= (int) ($match['id'] ?? 0) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin menghapus jadwal ini?');">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">Belum ada data jadwal.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($mode === 'view' && $selectedMatch): ?>
        <div class="panel p-4 mt-4">
            <h3 class="mb-3">Detail Jadwal</h3>
            <div class="row g-3">
                <div class="col-md-2"><strong>ID Turnamen</strong><p class="mb-0"><?= htmlspecialchars((string) ($selectedMatch['id_tur'] ?? '-')) ?></p></div>
                <div class="col-md-2"><strong>ID Team</strong><p class="mb-0"><?= htmlspecialchars((string) ($selectedMatch['id_team'] ?? '-')) ?></p></div>
                <div class="col-md-2"><strong>ID Tim</strong><p class="mb-0"><?= htmlspecialchars((string) ($selectedMatch['id_tim'] ?? '-')) ?></p></div>
                <div class="col-md-3"><strong>Tanggal</strong><p class="mb-0"><?= htmlspecialchars((string) ($selectedMatch['tanggal'] ?? '-')) ?></p></div>
                <div class="col-md-3"><strong>Tempat</strong><p class="mb-0"><?= htmlspecialchars((string) ($selectedMatch['tempat'] ?? '-')) ?></p></div>
            </div>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
