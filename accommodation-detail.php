<?php
$accommodation = $data['accommodation'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= htmlspecialchars($accommodation->nama_akomodasi) ?> | Travlie</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="style/css/style-accomodation.css">
</head>
<body>

<?php include_once('views/layouts/header.php'); ?>
<style>
    .detail-hero {
      position: relative;
      background-image: url('<?= htmlspecialchars($accommodation->url_gambar_utama) ?>');
      background-size: cover;
      background-position: center;
      height: 300px;
    }
</style>

<div class="detail-hero mb-4">
  <div class="hero-text">
    <h2><?= htmlspecialchars($accommodation->nama_akomodasi) ?></h2>
    <p><i class="bi bi-geo-alt-fill"></i> <?= htmlspecialchars($accommodation->kota) ?>, <?= htmlspecialchars($accommodation->provinsi) ?></p>
  </div>
</div>

<div class="container">
  <div class="row mb-4">
    <div class="col-md-8">
      <h4>Deskripsi</h4>
      <p><?= nl2br(htmlspecialchars($accommodation->deskripsi_lengkap)) ?></p>

      <h5 class="mt-4">Fasilitas</h5>
      <?php
      $fasilitas = explode(',', $accommodation->list_fasilitas ?? '');
      foreach ($fasilitas as $fas) {
        echo '<span class="facility-badge">' . htmlspecialchars(trim($fas)) . '</span>';
      }
      ?>

      <h5 class="mt-4">Informasi Kontak</h5>
      <ul class="list-unstyled">
        <li><i class="bi bi-telephone-fill"></i> <?= htmlspecialchars($accommodation->telepon_kontak) ?></li>
        <li><i class="bi bi-envelope-fill"></i> <?= htmlspecialchars($accommodation->email_kontak) ?></li>
        <li><i class="bi bi-globe2"></i> <a href="<?= htmlspecialchars($accommodation->website_url) ?>" target="_blank"><?= htmlspecialchars($accommodation->website_url) ?></a></li>
      </ul>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title text-primary">Harga</h5>
          <?php if ($accommodation->harga_diskon && $accommodation->harga_diskon > 0) : ?>
            <p class="text-muted text-decoration-line-through">IDR <?= number_format($accommodation->harga_standard, 0, ',', '.') ?></p>
            <h4 class="text-danger">IDR <?= number_format($accommodation->harga_diskon, 0, ',', '.') ?></h4>
          <?php else : ?>
            <h4 class="text-dark">IDR <?= number_format($accommodation->harga_standard, 0, ',', '.') ?></h4>
          <?php endif; ?>
          <small class="text-muted">Belum termasuk pajak</small>

          <hr>
          <p><strong>Check-in:</strong> <?= htmlspecialchars($accommodation->check_in_standar) ?></p>
          <p><strong>Check-out:</strong> <?= htmlspecialchars($accommodation->check_out_standar) ?></p>
          <p><strong>Kapasitas:</strong> <?= htmlspecialchars($accommodation->kapasitas_default_tamu) ?> tamu</p>

          <a href="?c=order&m=index" class="btn btn-primary w-100 mt-3">Pesan Sekarang</a>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once('views/layouts/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
