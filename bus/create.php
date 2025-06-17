<?php 
// Anda bisa menyertakan header layout admin di sini jika ada
// include_once('views/layouts/admin_header.php'); 
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Jadwal Baru</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<main class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="mb-0">Tambah Jadwal Baru</h3>
        </div>
        <div class="card-body">
            <form action="?c=admin&m=storeSchedule" method="post">
                <div class="mb-3">
                    <label for="vehicle_id" class="form-label fw-bold">Kendaraan</label>
                    <select id="vehicle_id" name="vehicle_id" class="form-select" required>
                        <option value="">-- Pilih Kendaraan --</option>
                        <?php foreach($vehicles as $vehicle): ?>
                        <option value="<?= $vehicle['id'] ?>"><?= htmlspecialchars($vehicle['class_name']) ?> (<?= htmlspecialchars($vehicle['operator_name']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="origin_id" class="form-label fw-bold">Kota Asal (Rute)</label>
                        <select id="origin_id" name="origin_id" class="form-select" required>
                            <option value="">-- Pilih Kota Asal --</option>
                            <?php foreach($locations as $loc): ?>
                            <option value="<?= $loc['id'] ?>"><?= htmlspecialchars($loc['location_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="destination_id" class="form-label fw-bold">Kota Tujuan (Rute)</label>
                        <select id="destination_id" name="destination_id" class="form-select" required>
                            <option value="">-- Pilih Kota Tujuan --</option>
                            <?php foreach($locations as $loc): ?>
                            <option value="<?= $loc['id'] ?>"><?= htmlspecialchars($loc['location_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="schedule_date" class="form-label fw-bold">Tanggal</label>
                    <input id="schedule_date" type="date" name="schedule_date" class="form-control" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="departure_time" class="form-label fw-bold">Jam Berangkat</label>
                        <input id="departure_time" type="time" name="departure_time" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="arrival_time_estimation" class="form-label fw-bold">Estimasi Tiba</label>
                        <input id="arrival_time_estimation" type="time" name="arrival_time_estimation" class="form-control" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="price" class="form-label fw-bold">Harga</label>
                        <input id="price" type="number" name="price" class="form-control" placeholder="Contoh: 150000" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="available_seats" class="form-label fw-bold">Jumlah Kursi</label>
                        <input id="available_seats" type="number" name="available_seats" class="form-control" placeholder="Contoh: 32" required>
                    </div>
                </div>

                <hr>
                <button type="submit" class="btn btn-primary">Simpan Jadwal</button>
                <a href="?c=admin&m=manageSchedules" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</main>
</body>
</html>
