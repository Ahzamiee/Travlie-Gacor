<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($data['title']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style/css/style-rent.css"> 
</head>
<body>

<?php 
    include_once 'views/layouts/header.php'; 
    
    $vehicle = $data['vehicle'];
    $filter = $data['filterData'];
    $durasi = $data['durasiHari'];
    $total = $data['hargaTotal'];
    $jumlahKursi = $data['jumlahKursi'];
    $tanggalMulaiFormatted = $data['tanggalMulaiFormatted'];
    $tanggalSelesaiFormatted = $data['tanggalSelesaiFormatted'];
?>

<div class="container my-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0">
                <div class="card-body">

                    <div class="row g-4 mb-4">
                        <div class="col-md-5">
                            <img src="<?= htmlspecialchars($vehicle['gambar_url']) ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($vehicle['merk']) ?>">
                        </div>
                        <div class="col-md-7">
                            <h2 class="card-title"><?= htmlspecialchars($vehicle['merk']) ?></h2>
                            <p class="text-muted">Disediakan oleh Partner Rental</p>
                            <div class="d-flex flex-wrap text-muted mt-3">
                            <div class="me-4 mb-2"><i class="bi bi-card-text me-2"></i><?= htmlspecialchars($vehicle['detail_kendaraan']) ?></div>

                            <?php if (!empty($vehicle['transmisi'])): ?>
                                <div class="mb-2"><i class="bi bi-gear-wide-connected me-2"></i><?= htmlspecialchars(ucfirst($vehicle['transmisi'])) ?></div>
                            <?php endif; ?>
                        </div>
                        </div>
                    </div>
                    
                    <hr>

                    <h4 class="mb-3">Kebijakan Rental</h4>
                    <ul>
                        <li>Penggunaan hingga 24 jam per mulai sewa.</li>
                        <li>Setelah pembayaran selesai, vendor akan melakukan verifikasi.</li>
                        <li>Kembalikan bensin seperti semula saat pengambilan.</li>
                    </ul>

                    <hr>

                    <h4 class="mb-3">Informasi Penting</h4>
                    <h6>Sebelum Anda Pesan</h6>
                    <ul>
                        <li>Baca syarat dan kebijakan rental.</li>
                    </ul>
                    <h6>Setelah Anda pesan</h6>
                    <ul>
                        <li>Penyedia akan menghubungi Anda melalui WhatsApp untuk meminta foto beberapa dokumen wajib.</li>
                    </ul>
                    <h6>Saat pengambilan</h6>
                    <ul>
                        <li>Bawa KTP/Paspor, SIM A/SIM C/SIM internasional, dan dokumen lain yang dibutuhkan.</li>
                        <li>Saat bertemu dengan staf rental, cek kondisi mobil dengan staf.</li>
                        <li>Setelah itu, baca dan tanda tangan perjanjian rental.</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card sticky-top" style="top: 20px; z-index: 1;">
                <div class="card-body">
                    <h5 class="card-title mb-3">Detail Rental Anda</h5>
                    <div class="mb-2">
                        <p class="mb-0 text-muted"><i class="bi bi-geo-alt-fill me-2"></i>Lokasi Pengambilan</p>
                        <p class="fw-bold"><?= htmlspecialchars(ucfirst($filter['kota'])) ?></p>
                    </div>
                    <div class="mb-2">
                        <p class="mb-0 text-muted"><i class="bi bi-calendar-check-fill me-2"></i>Mulai Rental</p>
                        <p class="fw-bold"><?= htmlspecialchars($tanggalMulaiFormatted) ?> • Pukul <?= htmlspecialchars($filter['waktuMulai']) ?></p>
                    </div>
                    <div class="mb-3">
                        <p class="mb-0 text-muted"><i class="bi bi-calendar-x-fill me-2"></i>Selesai Rental</p>
                        <p class="fw-bold"><?= htmlspecialchars($tanggalSelesaiFormatted) ?> • Pukul <?= htmlspecialchars($filter['waktuSelesai']) ?></p>
                    </div>
                    <hr>

                    <h5 class="card-title mb-3">Rincian Harga</h5>
                    <div class="d-flex justify-content-between">
                        <span>Rental Mobil (<?= htmlspecialchars($durasi) ?> hari)</span>
                        <span>IDR <?= number_format($total, 0, ',', '.') ?></span>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>Harga Total</span>
                        <span>IDR <?= number_format($total, 0, ',', '.') ?></span>
                    </div>
                    
                    <div class="d-grid mt-4">
                        <button class="btn btn-primary btn-lg">Lanjutkan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once 'views/layouts/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
