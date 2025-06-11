<?php
$pageTitle = $pageTitle ?? 'Promo | Travlie';

$categories = [
  'All' => 'Semua',
  'Flight' => 'Flight',
  'Accommodation' => 'Accommodation',
  'Vehicle Rent' => 'Vehicle Rent'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($pageTitle) ?></title>
  <link rel="shortcut icon" href="favicon.ico" type="x-icon">
  <link href="https://fonts.googleapis.com/css2?family=Crimson+Pro:wght@200..900&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                $isActive = $catKey === $activeCategory ? 'btn-primary' : 'btn-outline-primary';
                $link = "index.php?c=promo&m=index&category=" . urlencode($catKey);
            ?>
            <a href="<?= $link ?>" class="btn <?= $isActive ?> me-1"><?= $catValue ?></a>
        <?php endforeach; ?>
    </div>

    <div class="mb-5">
      <form class="d-flex gap-2" action="index.php?c=promo&m=checkCode" method="post">
        <input type="text" name="promo_code" class="form-control" placeholder="Masukkan kode promo..." required>
        <button type="submit" class="btn btn-success">Cek Promo</button>
      </form>

      <?php if (!empty($promoMessage)): ?>
        <div class="alert alert-<?= $promoSuccess ? 'success' : 'danger' ?> mt-3">
            <?= htmlspecialchars($promoMessage) ?>
        </div>
      <?php endif; ?>
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
                            <small>Diskon: <?= htmlspecialchars($promo->discount_value) ?> <?= $promo->discount_type === 'Percentage' ? '%' : 'Rp' ?></small><br>
                            <small>Periode: <?= $promo->start_date ?> – <?= $promo->end_date ?></small>
                          </div>
                          <div>
                            <a href="index.php?c=promo&m=delete&id=<?= $promo->promo_id ?>"
                              class="btn btn-sm btn-danger"
                              onclick="return confirm('Yakin ingin menghapus promo ini?')">
                              Hapus
                            </a>
                          </div>
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

    <!-- Navigasi halaman -->
    <?php if (($totalPages ?? 1) > 1): ?>
        <nav>
            <ul class="pagination justify-content-center mt-4">
                <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                    <?php
                        $isActive = ($p === $currentPage) ? 'active' : '';
                        $url = "index.php?c=promo&m=index&category=" . urlencode($activeCategory) . "&page=$p";
                    ?>
                    <li class="page-item <?= $isActive ?>">
                        <a class="page-link" href="<?= $url ?>"><?= $p ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif; ?>

</div>

<?php include_once('views/layouts/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>
