<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Pesan Bus & Travel | Travlie</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
  <link rel="stylesheet" href="style/style-bus.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="page-bus">

<?php include_once('views/layouts/header.php'); ?>


<section class="hero-bus py-5 bg-dark text-center">
  <div class="container-lg">

    <div class="d-flex flex-column flex-lg-row justify-content-lg-between align-items-lg-center mb-4">
        <div class="text-white text-center text-md-start">
            <h1 class="fw-bold">Pesan Tiket Bus & Travel</h1>
            <p class="mb-0 lead fs-6">Perjalanan Antarkota, Antarprovinsi, hingga Sewa untuk Rombongan.</p>
        </div>
        
        <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
            <div class="mt-3 mt-md-0">
                <a href="?c=admin&m=manageSchedules" class="btn btn-outline-light flex-shrink-0">
                    <i class="bi bi-gear-fill"></i> Kelola Jadwal
                </a>
            </div>
        <?php endif; ?>
    </div>

    <ul class="nav nav-tabs nav-justified" id="bookingTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="ticket-tab" data-bs-toggle="tab" data-bs-target="#ticket-pane" type="button" role="tab" aria-controls="ticket-pane" aria-selected="true">
            <i class="bi bi-ticket-perforated-fill"></i> Pesan Tiket
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="charter-tab" data-bs-toggle="tab" data-bs-target="#charter-pane" type="button" role="tab" aria-controls="charter-pane" aria-selected="false">
            <i class="bi bi-people-fill"></i> Sewa Rombongan
        </button>
      </li>
    </ul>

    <div class="tab-content bg-light p-4 rounded-bottom" id="bookingTabContent">
      <div class="tab-pane fade show active" id="ticket-pane" role="tabpanel" aria-labelledby="ticket-tab" tabindex="0">
        <form action="?c=bus&m=index" method="post" class="row g-3 justify-content-center align-items-end text-start">
            <div class="col-12 d-flex flex-wrap justify-content-center gap-3 mb-2">
                <div class="btn-group" role="group">
                    <input type="radio" class="btn-check" name="vehicleType" id="vehicleBus" value="Bus" autocomplete="off" checked>
                    <label class="btn btn-outline-primary" for="vehicleBus"><i class="bi bi-bus-front"></i> Bus</label>
                    <input type="radio" class="btn-check" name="vehicleType" id="vehicleTravel" value="Travel" autocomplete="off">
                    <label class="btn btn-outline-primary" for="vehicleTravel"><i class="bi bi-car-front-fill"></i> Travel</label>
                </div>
            </div>
            <div class="col-md-6">
              <label for="departureCity" class="form-label">Kota Keberangkatan</label>
              <select id="departureCity" name="kota_keberangkatan" class="form-select" required>
                <option value="">Pilih Kota Asal</option>
                <?php foreach ($locations as $location): ?>
                  <option value="<?= $location['id'] ?>"><?= htmlspecialchars($location['location_name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-6">
              <label for="arrivalCity" class="form-label">Kota Tujuan</label>
              <select id="arrivalCity" name="kota_tujuan" class="form-select" required>
                <option value="">Pilih Kota Tujuan</option>
                <?php foreach ($locations as $location): ?>
                  <option value="<?= $location['id'] ?>"><?= htmlspecialchars($location['location_name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-4">
              <label for="departureDate" class="form-label">Tanggal Berangkat</label>
              <input type="date" class="form-control" id="departureDate" name="tanggal_keberangkatan" required>
            </div>
            <div class="col-md-4" id="returnDateWrapper" style="display: none;">
              <label for="returnDate" class="form-label">Tanggal Pulang</label>
              <input type="date" class="form-control" id="returnDate">
            </div>
            <div class="col-md-2">
              <label for="passengers" class="form-label">Penumpang</label>
              <input type="number" class="form-control" id="passengers" value="1" min="1">
            </div>
            <div class="col-md-2">
              <button type="submit" name="cari_tiket" class="btn btn-primary w-100">Cari Tiket</button>
            </div>
        </form>
      </div>
      <div class="tab-pane fade" id="charter-pane" role="tabpanel" aria-labelledby="charter-tab" tabindex="0">
         <form action="?c=bus&m=index" method="post" class="row g-3 justify-content-center align-items-end text-start">
             <div class="col-12 d-flex flex-wrap justify-content-center gap-3 mb-2">
                <div class="btn-group" role="group">
                    <input type="radio" class="btn-check" name="charterVehicleType" id="charterBus" value="Bus" autocomplete="off" checked>
                    <label class="btn btn-outline-primary" for="charterBus"><i class="bi bi-bus-front"></i> Sewa Bus</label>
                    <input type="radio" class="btn-check" name="charterVehicleType" id="charterTravel" value="Travel" autocomplete="off">
                    <label class="btn btn-outline-primary" for="charterTravel"><i class="bi bi-car-front-fill"></i> Sewa Travel</label>
                </div>
            </div>
             <div class="col-md-6">
                <label for="pickupLocation" class="form-label">Lokasi Penjemputan</label>
                <input type="text" class="form-control" id="pickupLocation" placeholder="Alamat lengkap atau nama lokasi">
             </div>
             <div class="col-md-6">
                <label for="charterDestination" class="form-label">Tujuan Utama Rombongan</label>
                <input type="text" class="form-control" id="charterDestination" placeholder="Contoh: Wisata Bromo, Yogyakarta">
             </div>
             <div class="col-md-4">
                <label for="charterStartDate" class="form-label">Tanggal Mulai Sewa</label>
                <input type="date" class="form-control" id="charterStartDate">
             </div>
             <div class="col-md-4">
                <label for="charterDuration" class="form-label">Durasi Sewa (hari)</label>
                <input type="number" class="form-control" id="charterDuration" value="1" min="1">
             </div>
             <div class="col-md-4">
                <button type="submit" name="cari_kendaraan" class="btn btn-primary w-100">Cari Kendaraan</button>
             </div>
         </form>
      </div>
    </div>
  </div> 
</section> 
    
  <?php if (isset($_POST['cari_tiket'])): ?>
    <div class="container mb-5">
      <div id="ticket-results">
        <h3 class="mb-3">Hasil Pencarian</h3>

        <?php if (!empty($schedules)): ?>
          <div class="row row-cols-1 row-cols-md-1 g-4">
              <?php foreach ($schedules as $schedule): ?>
                  <div class="col">
                      <div class="card bus-card h-100">
                          <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-center">
                              <div class="me-md-4 mb-3 mb-md-0 text-center">
                                  <h6 class="mt-2 mb-0"><?= htmlspecialchars($schedule->operator_name) ?></h6>
                                  <small class="text-muted"><?= htmlspecialchars($schedule->vehicle_class) ?></small>
                              </div>
                              <div class="text-center">
                                  <h5 class="fw-bold mb-0"><?= date("H:i", strtotime($schedule->departure_time)) ?></h5>
                                  <p class="text-muted mb-0"><?= htmlspecialchars($schedule->origin_name) ?></p>
                              </div>
                              <div class="text-center my-3 my-md-0">
                                  <i class="bi bi-arrow-right-circle fs-4 text-primary"></i>
                              </div>
                              <div class="text-center">
                                  <h5 class="fw-bold mb-0"><?= date("H:i", strtotime($schedule->arrival_time_estimation)) ?></h5>
                                  <p class="text-muted mb-0"><?= htmlspecialchars($schedule->destination_name) ?></p>
                              </div>
                              <div class="ms-md-5 text-center mt-3 mt-md-0">
                                  <h5 class="fw-bold text-danger">Rp <?= number_format($schedule->price, 0, ',', '.') ?></h5>
                                  <p class="text-muted mb-2">/kursi</p>
                                  <a href="#" class="btn btn-primary w-100">Pesan Sekarang</a>
                              </div>
                          </div>
                      </div>
                  </div>
              <?php endforeach; ?>
          </div>
        <?php elseif (isset($_POST['cari_tiket'])): ?>
            <p class="text-center text-muted">Maaf, tidak ada jadwal yang ditemukan untuk rute tersebut.</p>
        <?php endif; ?>
      </div>
    </div>
  <?php endif; ?>

  <?php if (isset($_POST['cari_kendaraan'])): ?>
    <div class="container mb-5">
      <div id="charter-results" class="mt-4">
      <?php if (!empty($charters)): ?>
          <h3 class="mb-3">Pilihan Kendaraan untuk Rombongan</h3>
      <?php endif; ?>

      <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 justify-content-center">
          <?php foreach ($charters as $charter): ?>
              <div class="col">
                  <div class="card h-100 shadow-sm">
                      <div class="card-body">
                          <h5 class="card-title"><?= htmlspecialchars($charter->service_name) ?></h5>
                          <h6 class="card-subtitle mb-2 text-muted"><?= htmlspecialchars($charter->operator_name) ?></h6>
                          <p class="card-text">
                              <strong>Tipe Armada:</strong> <?= htmlspecialchars($charter->vehicle_class) ?><br>
                              <strong>Kapasitas:</strong> <?= $charter->vehicle_capacity ?> orang<br>
                              <strong>Area Layanan:</strong> <?= htmlspecialchars($charter->service_area) ?>
                          </p>
                      </div>
                      <div class="card-footer bg-light">
                          <small class="text-muted">Mulai dari</small>
                          <p class="fs-5 fw-bold text-danger mb-0">Rp <?= number_format($charter->base_price, 0, ',', '.') ?></p>
                          <small class="text-muted"><?= htmlspecialchars($charter->price_description) ?></small>
                      </div>
                  </div>
              </div>
          <?php endforeach; ?>
      </div>
    </div>
  <?php endif; ?>
  
  <?php if (isset($_POST['cari_tiket']) || isset($_POST['cari_kendaraan'])): ?>
    <div class="d-flex justify-content-center mb-5">
      <nav>
        <ul class="pagination">
          <li class="page-item disabled"><a class="page-link" href="#">«</a></li>
          <li class="page-item active"><a class="page-link" href="#">1</a></li>
          <li class="page-item"><a class="page-link" href="#">2</a></li>
          <li class="page-item"><a class="page-link" href="#">3</a></li>
          <li class="page-item"><a class="page-link" href="#">»</a></li>
        </ul>
      </nav>
    </div>
  <?php endif; ?>

<?php include_once('views/layouts/footer.php'); ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const tripTypeRadios = document.querySelectorAll('input[name="tripType"]');
    const returnDateWrapper = document.getElementById('returnDateWrapper');

    tripTypeRadios.forEach(radio => {
        radio.addEventListener('change', function () {
            if (this.value === 'roundTrip') {
                returnDateWrapper.style.display = 'block';
            } else {
                returnDateWrapper.style.display = 'none';
            }
        });
    });
});
</script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // Menunggu seluruh dokumen siap sebelum menjalankan JavaScript
  $(document).ready(function() {
    // Mengubah dropdown Kota Keberangkatan
    $('#departureCity').select2({
      theme: "bootstrap-5" // Menggunakan tema Bootstrap 5
    });

    // Mengubah dropdown Kota Tujuan
    $('#arrivalCity').select2({
      theme: "bootstrap-5" // Menggunakan tema Bootstrap 5
    });
  });
</script>
</body>
</html>