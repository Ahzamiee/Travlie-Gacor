<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buat Pesanan Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Form Buat Pesanan Baru</h4>
                </div>
                <div class="card-body">
                    <form action="?c=order&m=store" method="POST">
                        <!-- Order Name (default TRVL-) -->
                        <input type="hidden" name="order_name" value="TRVL-">

                        <div class="mb-3">
                            <label for="order_title" class="form-label">Judul Pesanan</label>
                            <input type="text" class="form-control" id="order_title" name="order_title" placeholder="Contoh: Hotel InterContinental" required>
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">Kategori</label>
                            <select class="form-select" id="category" name="category" required>
                                <option value="" disabled selected>Pilih kategori</option>
                                <option value="Flight">Flight</option>
                                <option value="Accomodation">Accomodation</option>
                                <option value="Vehicle Rent">Vehicle Rent</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="detail" class="form-label">Detail Pesanan</label>
                            <textarea class="form-control" id="detail" name="detail" rows="3" placeholder="Contoh: Tanggal Keberangkatan = 15 Juni 2025, Maskapai = Citilink" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="total_price" class="form-label">Total Harga</label>
                            <input type="text" class="form-control" id="total_price" name="total_price" placeholder="Contoh: Rp 4.000.000" required>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="?c=order&m=index" class="btn btn-secondary me-2">
                                <i class="fas fa-arrow-left"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-success">
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
