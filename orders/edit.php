<?php include_once 'views/layouts/header.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - Edit Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-warning">
                    <h4 class="mb-0">Form Edit Pesanan</h4>
                </div>
                <div class="card-body">
                    <!-- Form action mengarah ke method updateOrder -->
                    <form action="?c=admin&m=updateOrder" method="POST">
                        <!-- Hidden input untuk menyimpan order_code -->
                        <input type="hidden" name="order_code" value="<?php echo htmlspecialchars($order['order_code']); ?>">

                        <div class="mb-3">
                            <label class="form-label">ID Pesanan (Full)</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($order['full_order_id']); ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="order_title" class="form-label">Judul Pesanan</label>
                            <input type="text" class="form-control" id="order_title" name="order_title" value="<?php echo htmlspecialchars($order['order_title']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Kategori</label>
                            <input type="text" class="form-control" id="category" name="category" value="<?php echo htmlspecialchars($order['category']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="detail" class="form-label">Detail Pesanan</label>
                            <textarea class="form-control" id="detail" name="detail" rows="3"><?php echo htmlspecialchars($order['detail']); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="total_price" class="form-label">Total Harga</label>
                            <input type="text" class="form-control" id="total_price" name="total_price" value="<?php echo htmlspecialchars($order['total_price']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="Menunggu Pembayaran" <?php if($order['status'] == 'Menunggu Pembayaran') echo 'selected'; ?>>Menunggu Pembayaran</option>
                                <option value="Sudah Dibayar" <?php if($order['status'] == 'Sudah Selesai') echo 'selected'; ?>>Sudah Selesai</option>
                                <option value="Pesanan Dibatalkan" <?php if($order['status'] == 'Pesanan Dibatalkan') echo 'selected'; ?>>Pesanan Dibatalkan</option>
                            </select>
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <a href="?c=admin&m=manageOrders" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-warning">Update Pesanan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
