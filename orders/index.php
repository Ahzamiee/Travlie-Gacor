<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - Kelola Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Kelola Pesanan</h3>
        <div>
            <a href="?c=order&m=index" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Judul Pesanan</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($all_orders)): ?>
                            <?php foreach ($all_orders as $order): ?>
                                <tr>
                                    <td class="text-center"><?php echo htmlspecialchars($order['full_order_id']); ?></td>
                                    <td><?php echo htmlspecialchars($order['order_title']); ?></td>
                                    <td><?php echo htmlspecialchars($order['total_price']); ?></td>
                                    <td class="text-center">
                                        <span class="badge 
                                            <?php 
                                               switch (strtoupper($order['status'])) { // Gunakan strtoupper()
                                                    case 'MENUNGGU PEMBAYARAN': 
                                                        echo 'bg-warning text-dark'; 
                                                        break;
                                                    case 'SUDAH SELESAI': // Cocokkan dengan "SUDAH SELESAI"
                                                        echo 'bg-success'; 
                                                        break;
                                                    case 'PESANAN DIBATALKAN': 
                                                        echo 'bg-danger'; 
                                                        break;
                                                    default: 
                                                        echo 'bg-secondary';
                                                }
                                            ?>">
                                            <?php echo htmlspecialchars($order['status']); ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <!-- TOMBOL AKSI UNTUK UBAH DAN HAPUS -->
                                        <a href="?c=admin&m=editOrderForm&id=<?php echo $order['order_code']; ?>" class="btn btn-sm btn-warning" title="Ubah">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="?c=admin&m=deleteOrder&id=<?php echo $order['order_code']; ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Anda yakin ingin menghapus pesanan ini?');">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data pesanan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
