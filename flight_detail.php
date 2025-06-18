<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Penerbangan - Travlie</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style/style-flight-detail.css"> </head>
<body>

    <?php include_once ('views/layouts/header.php'); ?>

    <div class="flight-container">
        <div class="detail-container">
            <?php if ($flight): ?>
                <h2 class="detail-header">Detail Penerbangan</h2>
                <div class="detail-card">
                    <div class="detail-image" style="background-image: url('<?php echo htmlspecialchars($flight['image_url']); ?>');"></div>
                    <div class="detail-content">
                        <h4><?php echo htmlspecialchars($flight['departure_city_name'] . ' (' . $flight['departure_city_code'] . ') → ' . $flight['arrival_city_name'] . ' (' . $flight['arrival_city_code'] . ')'); ?></h4>
                        <p><strong>Maskapai:</strong> <?php echo htmlspecialchars($flight['airline']); ?></p>
                        <p><strong>Nomor Penerbangan:</strong> <?php echo htmlspecialchars($flight['flight_number']); ?></p>
                        <p><strong>Tanggal Keberangkatan:</strong> <?php echo htmlspecialchars(date('d M Y', strtotime($flight['departure_date']))); ?></p>
                        <p><strong>Waktu Keberangkatan:</strong> <?php echo htmlspecialchars(date('H:i', strtotime($flight['departure_time']))); ?></p>
                        <p><strong>Waktu Kedatangan:</strong> <?php echo htmlspecialchars(date('H:i', strtotime($flight['arrival_time']))); ?></p>
                        <p><strong>Durasi:</strong> <?php
                            $dep_datetime = new DateTime($flight['departure_date'] . ' ' . $flight['departure_time']);
                            $arr_datetime = new DateTime($flight['arrival_date'] . ' ' . $flight['arrival_time']); // Asumsi ada arrival_date di DB
                            if (isset($flight['arrival_date'])) { // Pastikan ada arrival_date jika dihitung lintas hari
                                $arr_datetime = new DateTime($flight['arrival_date'] . ' ' . $flight['arrival_time']);
                            } else {
                                $arr_datetime = new DateTime($flight['departure_date'] . ' ' . $flight['arrival_time']); // Jika hanya waktu di hari yang sama
                                if ($arr_datetime < $dep_datetime) { // Jika kedatangan di hari berikutnya
                                    $arr_datetime->modify('+1 day');
                                }
                            }
                            $interval = $dep_datetime->diff($arr_datetime);
                            echo $interval->format('%h jam %i menit');
                        ?></p>
                        <p><strong>Kelas:</strong> <?php echo htmlspecialchars($flight['flight_class']); ?></p>
                        <p class="price">Harga: Rp <?php echo number_format($flight['price'], 0, ',', '.'); ?></p>
                    </div>
                </div>
                <div class="detail-actions">
                    <button class="btn-pesan-sekarang">Pesan Sekarang</button>
                    <a href="index.php?c=flight&m=index" class="btn-back">Kembali</a>
                </div>
            <?php else: ?>
                <h2 class="detail-header">Penerbangan Tidak Ditemukan</h2>
                <p class="error-message">Maaf, detail penerbangan yang Anda cari tidak tersedia.</p>
                <div class="detail-actions">
                    <a href="index.php?c=flight&m=index" class="btn-back">Kembali ke Pencarian</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include_once ('views/layouts/footer.php'); ?>

</body>
</html>