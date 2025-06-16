<?php
include_once ('views/layouts/header.php');

$accommodations = $data['accommodations'] ?? [];
$filters = $data['filters'] ?? [];

$isAdmin = isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Accomodation | Travlie</title> <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Pro:wght@200..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style/css/style-accomodation.css">
    </head>
<body>

<!-- Admin Panel (only visible for admin) -->
<?php if ($isAdmin): ?>
<div class="container mt-3">
    <div class="admin-panel">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start"> <h5 class="mb-0"><i class="bi bi-shield-check text-primary"></i> Admin Panel</h5>
                <small class="text-muted">Manage accommodations</small>
            </div>
            <div class="col-md-6 text-end d-flex flex-column flex-md-row justify-content-md-end mt-3 mt-md-0">
                <a href="?c=admin&m=createAccommodation" class="btn btn-success me-md-2 mb-2 mb-md-0">
                    <i class="bi bi-plus-lg"></i> Add New Accommodation
                </a>
                <a href="?c=admin&m=manageAccommodations" class="btn btn-primary">
                    <i class="bi bi-list-ul"></i> Manage All
                </a>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Hero Section -->
<section class="py-5 text-center hero-section">
    <div class="overlay"></div>
    <div class="hero-content fw-bold p-4 rounded"> 
      <h1 class="text-on-image">Temukan Penginapan Impianmu</h1>
    <p class="text-on-image">Cari penginapan terbaik dengan harga termurah hanya di Travlie</p>
        <form class="row g-2 justify-content-center">
            <div class="col-12 col-md-4"> <input type="text" class="form-control" placeholder="Masukkan lokasi">
            </div>
            <div class="col-12 col-md-4"> <input type="date" class="form-control">
            </div>
            <div class="col-12 col-md-2"> <button class="btn btn-primary w-100">Cari</button>
            </div>
        </form>
    </div>
</section>

<!-- Container untuk Filter dan Accommodation List -->
<div class="container">
    <div class="row">
        <!-- Filter Section -->
        <div class="col-lg-3 col-md-4 mb-3">
            <h4 class="mb-3">Filter</h4>
            <form action="?c=accommodation&m=index" method="GET"> 
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        Rating
                        <button class="btn btn-link btn-sm p-0 text-decoration-none text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#ratingFilterBody" aria-expanded="true" aria-controls="ratingFilterBody">
                            <i class="bi bi-chevron-down ms-auto"></i>
                        </button>
                    </div>
                    <div class="collapse show" id="ratingFilterBody">
                        <div class="card-body">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="rating" id="rating5" value="5" <?php echo (isset($filters['rating']) && $filters['rating'] == '5') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="rating5">
                                    <i class="bi bi-star-fill text-warning"></i> 
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>    
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="rating" id="rating4" value="4" <?php echo (isset($filters['rating']) && $filters['rating'] == '4') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="rating4">
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="rating" id="rating3" value="3" <?php echo (isset($filters['rating']) && $filters['rating'] == '3') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="rating3">
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>    
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="rating" id="rating2" value="2" <?php echo (isset($filters['rating']) && $filters['rating'] == '2') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="rating2">
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="rating" id="rating1" value="1" <?php echo (isset($filters['rating']) && $filters['rating'] == '1') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="rating1">
                                    <i class="bi bi-star-fill text-warning"></i>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        Harga
                        <button class="btn btn-link btn-sm p-0 text-decoration-none text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#priceFilterBody" aria-expanded="true" aria-controls="priceFilterBody">
                            <i class="bi bi-chevron-down"></i>
                        </button>
                    </div>
                    <div class="collapse show" id="priceFilterBody">
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="price-input-range d-flex align-items-center gap-2">
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="text" class="form-control price-input" name="price_min" id="price-min" placeholder="Minimum" value="<?php echo htmlspecialchars($filters['price_min'] ?? ''); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control price-input" name="price_max" id="price-max" placeholder="Maksimum" value="<?php echo htmlspecialchars($filters['price_max'] ?? ''); ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        Tipe
                        <button class="btn btn-link btn-sm p-0 text-decoration-none text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#tipeFilterBody" aria-expanded="true" aria-controls="tipeFilterBody">
                            <i class="bi bi-chevron-down"></i>
                        </button>
                    </div>
                    <div class="collapse show" id="tipeFilterBody">
                        <div class="card-body">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="type[]" value="Hotel" id="typeHotel" <?php echo (isset($filters['type']) && in_array('Hotel', $filters['type'])) ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="typeHotel">Hotel</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="type[]" value="Villa" id="typeVilla" <?php echo (isset($filters['type']) && in_array('Villa', $filters['type'])) ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="typeVilla">Villa</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="type[]" value="Apartment" id="typeApt" <?php echo (isset($filters['type']) && in_array('Apartment', $filters['type'])) ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="typeApt">Appartment</label>
                            </div>
                        </div>
                    </div>
                </div>

                 <!-- Admin Filter for showing inactive accommodations -->
                <?php if ($isAdmin): ?>
                    <form method="GET" action="?c=accommodation&m=index" id="filterForm">
                        <input type="hidden" name="c" value="accommodation">
                        <input type="hidden" name="m" value="index">
                        <div class="card mb-3">
                            <div class="card-header">
                                <i class="bi bi-shield-check text-primary"></i> Admin Options
                            </div>
                            <div class="card-body">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="show_inactive" id="showInactive" value="1" <?php echo (isset($filters['show_inactive']) && $filters['show_inactive'] == '1') ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="showInactive">Show Inactive Accommodations</label>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php endif; ?>


                <button type="submit" class="btn btn-primary w-100 mb-2">Terapkan Filter</button>
                <a href="?c=accommodation&m=index" class="btn btn-outline-secondary w-100">Reset Filter</a>
            </form>
        </div>

        <!-- Accommodation List -->
        <div class="col-lg-9 col-md-8 col-sm-12">
            <div class="row">
                <?php if (!empty($accommodations)) : ?>
                    <?php foreach($accommodations as $accommodation) : ?> 
                        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                            <div class="card h-100 accommodation-card <?php echo (!$accommodation->is_aktif) ? 'status-inactive' : ''; ?>" data-id="<?= $accommodation->id_akomodasi ?>">                          

                                <img src="<?php echo htmlspecialchars($accommodation->url_gambar_utama ?? ''); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($accommodation->nama_akomodasi); ?>">
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="card-subtitle text-dark fw-bold mb-1"><?php echo htmlspecialchars($accommodation->nama_akomodasi); ?></h6>
                                        <?php if ($isAdmin): ?>
                                        <span class="badge bg-<?php echo $accommodation->is_aktif ? 'success' : 'secondary'; ?> ms-2">
                                            <?php echo $accommodation->is_aktif ? 'Active' : 'Inactive'; ?>
                                        </span>
                                        <?php endif; ?>
                                    </div>

                                    <div class="d-flex align-items-center flex-wrap mb-1">
                                        <span class="text-warning d-inline-flex me-1">
                                            <?php
                                            // RATING BINTANG
                                            $fullStars = floor($accommodation->rating_bintang ?? 0);
                                            $halfStar = (($accommodation->rating_bintang ??0) - $fullStars >= 0.5) ? true : false;
                                            for ($i = 0; $i < $fullStars; $i++) {
                                             echo '<i class="bi bi-star-fill"></i>';
                                            }
                                            if ($halfStar) {
                                                echo '<i class="bi bi-star-half"></i>';
                                            }
                                            ?>
                                        </span>
                                        <span class="text-muted small"><?php echo htmlspecialchars($accommodation->skor_ulasan_rata ?? $accommodation->rating_bintang); ?>/5</span> 
                                        <span class="text-muted small ms-1">(<?php echo number_format($accommodation->jumlah_ulasan ?? 0, 0, ',', '.'); ?>)</span>
                                    </div>
                                    <p class="card-text text-muted small mb-2">
                                        <i class="bi bi-geo-alt-fill"></i> <?php echo htmlspecialchars($accommodation->kota ?? ''); ?>
                                    </p>

                                    <!-- Admin Info -->
                                    <?php if ($isAdmin): ?>
                                    <div class="small text-muted mb-2">
                                        <div><strong>ID:</strong> <?= $accommodation->id_akomodasi ?></div>
                                        <div><strong>Type:</strong> <?= htmlspecialchars($accommodation->tipe_akomodasi ?? '') ?></div>
                                        <div><strong>Created:</strong> <?= date('d/m/Y', strtotime($accommodation->created_at)) ?></div>
                                    </div>
                                    <?php endif; ?>

                                    <div class="mt-auto pt-2">
                                        <?php 
                                        // HARGA DISKON vs HARGA STANDARD
                                        if (isset($accommodation->harga_diskon) && ($accommodation->harga_diskon ?? 0) > 0) : ?>
                                            <p class="text-muted text-decoration-line-through mb-0 original-price">IDR <?php echo number_format($accommodation->harga_standard ?? 0, 0, ',', '.'); ?></p>
                                            <h5 class="fw-bold mb-0 discounted-price">IDR <?php echo number_format($accommodation->harga_diskon ?? 0, 0, ',', '.'); ?></h5>
                                        <?php else : ?>
                                            <h5 class="fw-bold mb-0 discounted-price">IDR <?php echo number_format($accommodation->harga_standard ?? 0, 0, ',', '.'); ?></h5>
                                        <?php endif; ?>
                                        <p class="text-muted small mb-0">Belum termasuk pajak</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="col-12">
                        <p class="text-center fw-bold">Tidak ada akomodasi yang ditemukan.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center mb-5">
    <ul class="pagination">
      <li class="page-item disabled"><a class="page-link">«</a></li>
      <li class="page-item active"><a class="page-link">1</a></li>
      <li class="page-item"><a class="page-link">2</a></li>
      <li class="page-item"><a class="page-link">3</a></li>
      <li class="page-item"><a class="page-link">»</a></li>
    </ul>
</div>

<?php include_once ('views/layouts/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="style/js/accomodation.js"></script>

