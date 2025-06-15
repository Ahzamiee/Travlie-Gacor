<?php if (isset($_GET['error'])): ?>
  <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
<?php endif; ?>

<?php
$pageTitle = $pageTitle ?? 'Promo | Travlie';

$categories = [
  'All' => 'Semua',
  'Flight' => 'Flight',
  'Accommodation' => 'Accommodation',
  'Vehicle Rent' => 'Vehicle Rent'
];

$activeCategory = $activeCategory ?? 'All'; 

$isAdmin = isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($pageTitle) ?></title>
  <link rel="shortcut icon" href="favicon.ico" type="x-icon">
  <link href="https://fonts.googleapis.com/css2?family=Crimson+Pro:wght@200..900&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="style/promo-style.css">
</head>

<body>

  <?php include_once 'views/layouts/header.php'; ?>

  <div class="container my-4">
    <h2 class="mb-3"><?= htmlspecialchars($pageTitle) ?></h2>

    <!-- Filter kategori -->
    <div class="mb-4">
      <?php foreach ($categories as $catKey => $catValue): ?>
        <?php
        $isActiveBtn = $catKey === $activeCategory ? 'btn-primary' : 'btn-outline-primary';
        $link = "index.php?c=promo&m=index&category=" . urlencode($catKey);
        ?>
        <a href="<?= $link ?>" class="btn <?= $isActiveBtn ?> me-1"><?= $catValue ?></a>
      <?php endforeach; ?>
    </div>

    <!-- Daftar promo -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
      <?php if (!empty($promos)): ?>
        <?php foreach ($promos as $promo): ?>
          <div class="col">
            <div class="card h-100">
              <img src="<?= htmlspecialchars($promo->image_url) ?>" class="card-img-top" alt="<?= htmlspecialchars($promo->title) ?>">
              <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($promo->title) ?></h5>
                <p class="card-text"><?= htmlspecialchars($promo->description) ?></p>
              </div>
              <div class="card-footer d-flex justify-content-between align-items-start">
                <div>
                  <small>Kategori: <?= htmlspecialchars($promo->category) ?></small><br>
                  <small>
                  Diskon:
                  <?php if ($promo->discount_type === 'Percentage'): ?>
                  <?= htmlspecialchars($promo->discount_value) ?>%
                  <?php else: ?>
                  Rp <?= htmlspecialchars(number_format($promo->discount_value, 0, ',', '.')) ?>
                  <?php endif; ?>
                  </small><br>
                  <small>Periode: <?= $promo->start_date ?> – <?= $promo->end_date ?></small>
                </div>
                <?php if ($isAdmin): ?>
                  <div class="d-flex flex-column gap-1">
                    <a href="index.php?c=adminPromo&m=edit&id=<?= $promo->promo_id ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="index.php?c=adminPromo&m=delete&id=<?= $promo->promo_id ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus promo ini?')">Hapus</a>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="col-12">
          <div class="alert alert-warning text-center">
            Maaf, tidak ada promo tersedia untuk kategori ini.
          </div>
        </div>
      <?php endif; ?>
    </div>

    <!-- Tombol Tambah Promo (admin) -->
    <?php if ($isAdmin): ?>
      <div class="mb-3 text-end">
        <a href="?c=adminPromo&m=createform" class="btn btn-success">+ Tambah Promo</a>
      </div>
    <?php endif; ?>

  </div>

  <?php include_once 'views/layouts/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</body>

</html>
