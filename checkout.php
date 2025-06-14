<?php
// File: views/order/checkout.php

// Pastikan layout header di-include
include_once 'views/layouts/header.php';

// Atur biaya admin, bisa juga diambil dari database jika ada
$admin_fee = 5000;
$total_payment = (int) str_replace(['Rp ', '.'], '', $order['total_price']) + $admin_fee;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Pesanan</title>
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
                            <h6 class="mb-1"><?php echo htmlspecialchars($order['order_title']); ?></h6>
                            <small class="text-muted">Kategori: <?php echo htmlspecialchars($order['category']); ?></small>
                            <p class="mt-2 mb-0"><?php echo nl2br(htmlspecialchars($order['detail'])); ?></p>
                            <div class="text-danger mt-2 fw-semibold"><?php echo htmlspecialchars($order['total_price']); ?></div>
                        </div>
                        </div>
                    </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card p-4 shadow-sm">
                    <h5 class="mb-3">Ringkasan Pembayaran</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Total Harga</span>
                        <span><?php echo htmlspecialchars($order['total_price']); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Biaya Admin</span>
                        <span>Rp <?php echo number_format($admin_fee, 0, ',', '.'); ?></span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold mb-4">
                        <span>Total Pembayaran</span>
                        <span>Rp <?php echo number_format($total_payment, 0, ',', '.'); ?></span>
                    </div>
                    <button class="btn btn-primary w-100">Bayar Sekarang</button>
                </div>
            </div>
        </div>
    </section>

    <?php include_once 'views/layouts/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
