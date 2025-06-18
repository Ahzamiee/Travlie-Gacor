<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian Tiket Pesawat - Travlie</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style/style-flight.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <script src="js/flight-script.js"></script>
</head>
<body>

    <?php
    include_once ('views/layouts/header.php');

    // Pastikan session sudah dimulai di index.php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    ?>

    <div class="flight-container">
        <div class="search-hero" style="background-image: url('https://img.freepik.com/free-photo/place-flying-sunset-sky_1112-1132.jpg');">
            <div class="search-overlay"></div>
            <div class="search-box-wrapper">
                <h2>Temukan Penerbangan Impianmu</h2>
                
                <form action="index.php?c=flight&m=index" method="GET" class="flight-search-form">
                    <input type="hidden" name="c" value="flight">
                    <input type="hidden" name="m" value="index">
                    <div class="input-group">
                        <label for="dari">Dari Mana?</label>
                        <input type="text" id="dari" name="dari" placeholder="Kota Asal" class="transparent-input autocomplete-input" value="<?php echo htmlspecialchars($dari ?? ''); ?>">
                    </div>
                    <div class="input-group">
                        <label for="ke">Ke Mana?</label>
                        <input type="text" id="ke" name="ke" placeholder="Kota Tujuan" class="transparent-input autocomplete-input" value="<?php echo htmlspecialchars($ke ?? ''); ?>">
                    </div>
                    <div class="input-group">
                        <label for="tanggal">Tanggal</label>
                        <input type="text" id="tanggal" name="tanggal" placeholder="hh/bb/tttt" class="transparent-input datepicker-input" value="<?php echo htmlspecialchars($tanggal_input ?? ''); ?>">
                    </div>
                    <div class="input-group passenger-input-group">
                        <label for="penumpang">Penumpang</label>
                        <div class="passenger-dropdown">
                            <input type="text" id="penumpang" name="penumpang_display" class="transparent-input" readonly value="<?php echo htmlspecialchars(($dewasa ?? 1) . ' Dewasa, ' . ($anak ?? 0) . ' Anak'); ?>">
                            <div class="passenger-selector">
                                <div class="selector-item">
                                    <span>Dewasa</span>
                                    <button type="button" class="btn-minus" data-target="dewasa">-</button>
                                    <input type="number" id="dewasa" name="dewasa" value="<?php echo htmlspecialchars($dewasa ?? 1); ?>" min="1" readonly>
                                    <button type="button" class="btn-plus" data-target="dewasa">+</button>
                                </div>
                                <div class="selector-item">
                                    <span>Anak</span>
                                    <button type="button" class="btn-minus" data-target="anak">-</button>
                                    <input type="number" id="anak" name="anak" value="<?php echo htmlspecialchars($anak ?? 0); ?>" min="0" readonly>
                                    <button type="button" class="btn-plus" data-target="anak">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="input-group">
                        <label for="kelas">Kelas</label>
                        <select id="kelas" name="kelas" class="transparent-input">
                            <option value="Economy" <?php echo (($kelas ?? 'Economy') == 'Economy') ? 'selected' : ''; ?>>Ekonomi</option>
                            <option value="Business" <?php echo (($kelas ?? '') == 'Business') ? 'selected' : ''; ?>>Bisnis</option>
                            <option value="First" <?php echo (($kelas ?? '') == 'First') ? 'selected' : ''; ?>>First Class</option>
                        </select>
                    </div>

                    <div class="search-form-actions">
                        <button type="submit" class="search-button">Cari</button>
                        <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
                            <a href="index.php?c=admin&m=flights" class="btn-admin-manage-data">
                                <i class="fas fa-database"></i> Kelola Data
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <div class="search-results">
            <h3>Hasil Pencarian Penerbangan</h3>
            <?php if (empty($flights)): ?>
                <p>Tidak ada penerbangan yang ditemukan. Coba pencarian lain.</p>
            <?php else: ?>
                <div class="flight-list">
                    <?php foreach ($flights as $flight): ?>
                        <div class="flight-card">
                            <div class="flight-card-image" style="background-image: url('<?php echo htmlspecialchars($flight['image_url']); ?>');"></div>
                            <div class="flight-card-content">
                                <h4><?php echo htmlspecialchars($flight['departure_city_code'] . ' (' . $flight['departure_city_name'] . ') → ' . $flight['arrival_city_code'] . ' (' . $flight['arrival_city_name'] . ')'); ?></h4>
                                <p>Maskapai: <?php echo htmlspecialchars($flight['airline']); ?></p>
                                <p>Tanggal: <?php echo htmlspecialchars(date('d M Y', strtotime($flight['departure_date']))); ?></p>
                                <p>Kelas: <?php echo htmlspecialchars($flight['flight_class']); ?></p>
                                <p class="price">Mulai dari Rp <?php echo number_format($flight['price'], 0, ',', '.'); ?></p>
                                <a href="index.php?c=flight&m=detail&id=<?php echo htmlspecialchars($flight['id']); ?>" class="btn-detail-pesan">Lihat Detail & Pesan</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include_once ('views/layouts/footer.php'); ?>

</body>
</html>