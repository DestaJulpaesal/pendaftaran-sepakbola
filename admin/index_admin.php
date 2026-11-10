<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../config/database.php';

function safeCount(PDO $pdo, string $table, string $where = '', array $params = []): int
{
  try {
      $sql = 'SELECT COUNT(*) FROM ' . $table;
      if ($where !== '') {
          $sql .= ' WHERE ' . $where;
      }

      $stmt = $pdo->prepare($sql);
      $stmt->execute($params);

      return (int) $stmt->fetchColumn();
  } catch (Throwable $exception) {
      return 0;
  }
}

$totalPendaftaran = 0;
$totalPemain = 0;
$totalJadwal = 0;
$pending = 0;
$diverifikasi = 0;
$diterima = 0;
$ditolak = 0;
$recentRegistrations = [];

if ($conn instanceof PDO) {
  $totalPendaftaran = safeCount($conn, 'pendaptaran');
  $totalPemain = safeCount($conn, 'tbl_pemain');
  $totalJadwal = safeCount($conn, 'tbl_match');
  $pending = safeCount($conn, 'pendaptaran', 'status = :status', [':status' => 'pending']);
  $diverifikasi = safeCount($conn, 'pendaptaran', 'status = :status', [':status' => 'diverifikasi']);
  $diterima = safeCount($conn, 'pendaptaran', 'status = :status', [':status' => 'diterima']);
  $ditolak = safeCount($conn, 'pendaptaran', 'status = :status', [':status' => 'ditolak']);

  try {
      $recentRegistrations = $conn->query('SELECT * FROM pendaptaran ORDER BY id_pendaftaran DESC LIMIT 5')->fetchAll(PDO::FETCH_ASSOC);
  } catch (Throwable $exception) {
      $recentRegistrations = [];
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" crossorigin="anonymous">
  <style>
      body { background: #f4f7fb; }
      .card { border: none; border-radius: 16px; box-shadow: 0 8px 24px rgba(31, 41, 55, 0.08); }
      .stat-icon { width: 48px; height: 48px; border-radius: 14px; display: grid; place-items: center; font-size: 1.2rem; }
      .progress { height: 12px; border-radius: 999px; }
      .progress-bar { border-radius: 999px; }
  </style>
</head>
<body>
<div class="container py-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
          <h1 class="mb-1">Dashboard Admin</h1>
          <p class="text-muted mb-0">Ringkasan sistem pendaftaran dan turnamen</p>
      </div>
      <a href="logout.php" class="btn btn-outline-danger">Logout</a>
  </div>

  <div class="row g-4 mb-4">
      <div class="col-md-3">
          <div class="card p-3">
              <div class="d-flex justify-content-between align-items-center">
                  <div>
                      <div class="text-muted small">Total Pendaftaran</div>
                      <h3 class="mb-0"><?= number_format($totalPendaftaran, 0, ',', '.') ?></h3>
                  </div>
                  <div class="stat-icon bg-primary-subtle text-primary"><i class="fa-solid fa-clipboard-list"></i></div>
              </div>
          </div>
      </div>
      <div class="col-md-3">
          <div class="card p-3">
              <div class="d-flex justify-content-between align-items-center">
                  <div>
                      <div class="text-muted small">Total Pemain</div>
                      <h3 class="mb-0"><?= number_format($totalPemain, 0, ',', '.') ?></h3>
                  </div>
                  <div class="stat-icon bg-success-subtle text-success"><i class="fa-solid fa-user"></i></div>
              </div>
          </div>
      </div>
      <div class="col-md-3">
          <div class="card p-3">
              <div class="d-flex justify-content-between align-items-center">
                  <div>
                      <div class="text-muted small">Jadwal / Match</div>
                      <h3 class="mb-0"><?= number_format($totalJadwal, 0, ',', '.') ?></h3>
                  </div>
                  <div class="stat-icon bg-warning-subtle text-warning"><i class="fa-solid fa-calendar-days"></i></div>
              </div>
          </div>
      </div>
      <div class="col-md-3">
          <div class="card p-3">
              <div class="d-flex justify-content-between align-items-center">
                  <div>
                      <div class="text-muted small">Diterima</div>
                      <h3 class="mb-0"><?= number_format($diterima, 0, ',', '.') ?></h3>
                  </div>
                  <div class="stat-icon bg-info-subtle text-info"><i class="fa-solid fa-circle-check"></i></div>
              </div>
          </div>
      </div>
  </div>

  <div class="row g-4 mb-4">
      <div class="col-lg-7">
          <div class="card p-4">
              <h4 class="mb-3">Status Pendaftaran</h4>
              <div class="mb-3">
                  <div class="d-flex justify-content-between small text-muted mb-1"><span>Pending</span><span><?= $pending ?></span></div>
                  <div class="progress"><div class="progress-bar bg-secondary" style="width: <?= $totalPendaftaran > 0 ? ($pending / $totalPendaftaran) * 100 : 0 ?>%"></div></div>
              </div>
              <div class="mb-3">
                  <div class="d-flex justify-content-between small text-muted mb-1"><span>Diverifikasi</span><span><?= $diverifikasi ?></span></div>
                  <div class="progress"><div class="progress-bar bg-primary" style="width: <?= $totalPendaftaran > 0 ? ($diverifikasi / $totalPendaftaran) * 100 : 0 ?>%"></div></div>
              </div>
              <div class="mb-3">
                  <div class="d-flex justify-content-between small text-muted mb-1"><span>Diterima</span><span><?= $diterima ?></span></div>
                  <div class="progress"><div class="progress-bar bg-success" style="width: <?= $totalPendaftaran > 0 ? ($diterima / $totalPendaftaran) * 100 : 0 ?>%"></div></div>
              </div>
              <div class="mb-0">
                  <div class="d-flex justify-content-between small text-muted mb-1"><span>Ditolak</span><span><?= $ditolak ?></span></div>
                  <div class="progress"><div class="progress-bar bg-danger" style="width: <?= $totalPendaftaran > 0 ? ($ditolak / $totalPendaftaran) * 100 : 0 ?>%"></div></div>
              </div>
          </div>
      </div>

      <div class="col-lg-5">
          <div class="card p-4 h-100">
              <h4 class="mb-3">Aksi Cepat</h4>
              <div class="d-grid gap-2">
                  <a href="pendaftaran.php" class="btn btn-primary">Kelola Pendaftaran</a>
                  <a href="matches.php" class="btn btn-outline-primary">Kelola Jadwal</a>
                  <a href="turnamen.php" class="btn btn-outline-primary">Kelola Turnamen</a>
              </div>
          </div>
      </div>
  </div>

  <div class="card p-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
          <h4 class="mb-0">Pendaftaran Terbaru</h4>
          <a href="pendaftaran.php" class="btn btn-sm btn-outline-secondary">Lihat Semua</a>
      </div>

      <div class="table-responsive">
          <table class="table table-striped table-hover align-middle mb-0">
              <thead>
                  <tr>
                      <th>#</th>
                      <th>Nama Team</th>
                      <th>Alamat</th>
                      <th>Status</th>
                      <th>Detail</th>
                  </tr>
              </thead>
              <tbody>
                  <?php if (!empty($recentRegistrations)): ?>
                      <?php foreach ($recentRegistrations as $index => $item): ?>
                          <tr>
                              <td><?= (int) ($index + 1) ?></td>
                              <td><?= htmlspecialchars((string) ($item['nama_team'] ?? '-')) ?></td>
                              <td><?= htmlspecialchars((string) ($item['kampung'] ?? '-')) ?></td>
                              <td><span class="badge text-bg-light text-capitalize"><?= htmlspecialchars((string) ($item['status'] ?? 'pending')) ?></span></td>
                              <td><a href="pendaftaran4.php?id=<?= (int) ($item['id_pendaftaran'] ?? 0) ?>" class="btn btn-sm btn-outline-primary">Open</a></td>
                          </tr>
                      <?php endforeach; ?>
                  <?php else: ?>
                      <tr>
                          <td colspan="5" class="text-center text-muted py-4">Belum ada data pendaftaran.</td>
                      </tr>
                  <?php endif; ?>
              </tbody>
          </table>
      </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</body>
</html>