<?php
include_once 'views/layouts/header.php'; 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link rel="shortcut icon" href="../../favicon.ico" type="x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Pro:wght@200..900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="style/style-order.css">
</head>
<body>
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="section-title mb-0">My Orders</h1>
            <div class="d-flex gap-2">
                <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'user'): ?>
                    <a href="?c=order&m=createForm" class="btn btn-success">
                        <i class="fas fa-plus-circle"></i> Buat Pesanan Baru
                    </a>
                <?php endif; ?>

                <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
                    <a href="?c=admin&m=manageOrders" class="btn btn-info">
                        <i class="fas fa-cogs"></i> Kelola Semua Pesanan
                    </a>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="row g-4" id="orderList">
            <?php 
            if (isset($all_orders) && !empty($all_orders)):
                foreach ($all_orders as $order): ?>
                <div class="col-md-6 col-lg-4 order-item" data-status="<?php echo htmlspecialchars($order['status']); ?>">
                    <div class="card order-card shadow-sm h-100"> 
                        <div class="card-body d-flex flex-column">
                            <span class="card-category"><i class="fas fa-tag me-2"></i><?php echo htmlspecialchars($order['category']); ?></span>
                            <h5 class="card-title"><?php echo htmlspecialchars($order['order_title']); ?></h5>
                            <div class="order-id-display">
                                <small>ID Pesanan: <strong><?php echo htmlspecialchars($order['full_order_id']); ?></strong></small>
                                <i class="far fa-copy ms-2 copy-icon" title="Salin ID Pesanan" style="cursor: pointer;"></i>
                            </div>
                            <p class="order-price">
                            Total: Rp <?php echo number_format((int) preg_replace('/\D/', '', $order['total_price']), 0, ',', '.'); ?>
                            </p>


                            <p class="card-text mt-2">
                                <span class="order-status-label">Status:</span> 
                                <span class="badge <?php echo htmlspecialchars($order['status_class']); ?>">
                                         <?php echo htmlspecialchars($order['status']); ?>
                                </span>

                            </p>

                            <div class="mt-auto"> 
                                <?php if (strtoupper(trim($order['status'])) === 'MENUNGGU PEMBAYARAN'): ?>
                                    <a href="index.php?c=order&m=checkout&id=<?php echo htmlspecialchars($order['order_code']); ?>" class="btn btn-primary mt-2 w-100">Lanjutkan Pembayaran</a>
                                <?php elseif (strtoupper(trim($order['status'])) === 'SUDAH DIBAYAR'): ?>
                                    <a href="index.php?c=order&m=detail&id=<?php echo htmlspecialchars($order['order_code']); ?>" class="btn btn-outline-info mt-2 w-100">Lihat Detail</a>
                                <?php elseif (strtoupper(trim($order['status'])) === 'SELESAI' || strtoupper(trim($order['status'])) === 'SUDAH SELESAI'): ?>
                                    <a href="index.php?c=order&m=invoice&id=<?php echo htmlspecialchars($order['order_code']); ?>" class="btn btn-outline-success mt-2 w-100">Lihat Invoice</a>
                                <?php else: ?>
                                    <button class="btn btn-outline-secondary mt-2 w-100" disabled><?php echo htmlspecialchars(empty(trim($order['status'])) ? 'Tidak Ada Status' : $order['status']);?></button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12" id="noOrdersAlert">
                    <div class="alert alert-info text-center" role="alert">
                        <i class="fas fa-info-circle me-2"></i> Anda belum memiliki pesanan.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include_once 'views/layouts/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>
