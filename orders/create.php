<?php

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - Tambah Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Form Tambah Pesanan Baru</h4>
                </div>
                <div class="card-body p-4">

                    
                    <?php if (isset($error) && $error): ?>
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <div>
                                <?php echo htmlspecialchars($error); ?>
                            </div>
                        </div>
                    <?php endif; ?>
            
                    <form action="?c=admin&m=storeOrder" method="POST">
                        
                        <div class="mb-3">
                            <label for="user_id" class="form-label">User ID</label>
                            <input type="number" class="form-control" id="user_id" name="user_id" placeholder="Masukkan ID pengguna yang valid" required>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="order_name" class="form-label">ID Pesanan (Awalan)</label>
                                <input type="text" class="form-control" id="order_name" name="order_name" value="TRVL-" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="category" class="form-label">Kategori</label>
                                <input type="text" class="form-control" id="category" name="category" placeholder="Contoh: Accomodation" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="order_title" class="form-label">Judul Pesanan</label>
                            <input type="text" class="form-control" id="order_title" name="order_title" placeholder="Contoh: Hotel Montana Dua - Malang" required>
                        </div>

                        <div class="mb-3">
                            <label for="detail" class="form-label">Detail Pesanan</label>
                            <textarea class="form-control" id="detail" name="detail" rows="3" placeholder="Masukkan detail seperti tanggal check-in, jumlah orang, dll."></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="total_price" class="form-label">Total Harga</label>
                            <input type="text" class="form-control" id="total_price" name="total_price" placeholder="Contoh: Rp 750.000" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="Menunggu Pembayaran" selected>Menunggu Pembayaran</option>
                                <option value="Sudah Selesai">Sudah Selesai</option>
                                <option value="Pesanan Dibatalkan">Pesanan Dibatalkan</option>
                            </select>
                        </div>
                        
                        <hr class="my-4">

                        <div class="d-flex justify-content-end">
                            <a href="?c=admin&m=manageOrders" class="btn btn-secondary me-2">
                                <i class="fas fa-times"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Pesanan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
