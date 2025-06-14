<?php
include_once 'views/layouts/header.php';

// Biaya tambahan tetap
$admin_fee = 2500;
$total_clean = (int) str_replace(['Rp ', '.'], '', $order['total_price']);
$total_payment = $total_clean + $admin_fee;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout Pesanan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.ico" type="x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="style/style-dashboard.css">
</head>
<body>

<section class="container my-5">
    <h3 class="fw-bold mb-4">Checkout</h3>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card p-4 shadow-sm">
                <h5 class="mb-3">Detail Pesanan Anda</h5>

                <div class="d-flex align-items-center mb-4 border-bottom pb-3">
                    <div class="flex-grow-1">
                        <h6 class="mb-1"><?= htmlspecialchars($order['order_title']) ?></h6>
                        <small class="text-muted">Kategori: <?= htmlspecialchars($order['category']) ?></small>
                        <p class="mt-2 mb-0"><?= nl2br(htmlspecialchars($order['detail'])) ?></p>
                        <div class="text-danger mt-2 fw-semibold"><?= htmlspecialchars($order['total_price']) ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card p-4 shadow-sm">
                <h5 class="mb-3">Ringkasan Pembayaran</h5>
                <div class="d-flex justify-content-between mb-2">
                    <span>Total Harga</span>
                    <span><?= htmlspecialchars($order['total_price']) ?></span>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span>Biaya Admin</span>
                    <span>Rp <?= number_format($admin_fee, 0, ',', '.') ?></span>
                </div>
                <hr>
                <div class="d-flex justify-content-between fw-bold mb-4">
                    <span>Total Pembayaran</span>
                    <span>Rp <?= number_format($total_payment, 0, ',', '.') ?></span>
                </div>
              <a href="#" class="btn btn-primary w-100">
                   Bayar Sekarang 
                </a>
                <a href="?c=order&m=index" class="btn btn-secondary mt-2">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</section>

<?php include_once 'views/layouts/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>
