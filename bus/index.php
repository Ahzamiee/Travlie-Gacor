<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?? 'Manajemen Jadwal' ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body>

<main class="container mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Manajemen Jadwal Tiket</h3>
        <div>
            <a href="?c=dashboard&m=bus" class="btn btn-outline-secondary me-2">
                <i class="bi bi-box-arrow-left"></i> Keluar
            </a>
            <a href="?c=admin&m=createScheduleForm" class="btn btn-primary">
                <i class="bi bi-plus-circle-fill"></i> Tambah Jadwal
            </a>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="text" id="searchInput" class="form-control" placeholder="Ketik untuk mencari armada, rute, atau tanggal...">
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>ID</th>
                            <th>Armada</th>
                            <th>Rute</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="scheduleTableBody">
                        <?php if (!empty($schedules)): ?>
                            <?php foreach ($schedules as $schedule): ?>
                            <tr>
                                <td class="text-center"><?= $schedule['id'] ?></td>
                                <td><?= htmlspecialchars($schedule['class_name']) ?> <br> <small class="text-muted"><?= htmlspecialchars($schedule['operator_name']) ?></small></td>
                                <td><?= htmlspecialchars($schedule['origin']) ?> → <?= htmlspecialchars($schedule['destination']) ?></td>
                                <td class="text-center"><?= date('d M Y', strtotime($schedule['schedule_date'])) ?></td>
                                <td class="text-center"><?= date('H:i', strtotime($schedule['departure_time'])) ?></td>
                                <td class="text-end">Rp <?= number_format($schedule['price']) ?></td>
                                <td class="text-center">
                                    <a href="?c=admin&m=editScheduleForm&id=<?= $schedule['id'] ?>" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="?c=admin&m=deleteSchedule&id=<?= $schedule['id'] ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">
                                        <i class="bi bi-trash-fill"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted">Tidak ada data jadwal yang tersedia.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const tableBody = document.getElementById('scheduleTableBody');
    const rows = tableBody.getElementsByTagName('tr');

    searchInput.addEventListener('keyup', function () {
        const filter = searchInput.value.toUpperCase();

        for (let i = 0; i < rows.length; i++) {
            let row = rows[i];
            let cells = row.getElementsByTagName('td');
            let found = false;
            for (let j = 0; j < cells.length; j++) {
                // Abaikan kolom aksi saat mencari
                if (j < cells.length - 1) { 
                    let cell = cells[j];
                    if (cell) {
                        if (cell.textContent.toUpperCase().indexOf(filter) > -1) {
                            found = true;
                            break;
                        }
                    }
                }
            }
            if (found) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        }
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>