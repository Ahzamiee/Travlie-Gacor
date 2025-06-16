<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($data['title']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/css/style-rent.css">
</head>
<body>
    <?php include_once 'views/layouts/header.php'; ?>
    
    <div class="container form-container">
        <h2>Tambah Kendaraan Baru</h2>
        <form action="?c=vehicle&m=store" method="POST" class="row g-3">
            <div class="col-md-6">
                <label for="merk" class="form-label">Merk</label>
                <input type="text" class="form-control" id="merk" name="merk" required>
            </div>
            <div class="col-md-6">
                <label for="jenis_kendaraan" class="form-label">Jenis Kendaraan</label>
                <input type="text" class="form-control" id="jenis_kendaraan" name="jenis_kendaraan" placeholder="Contoh: Motor, Mobil" required>
            </div>
            <div class="col-12">
                <label for="detail_kendaraan" class="form-label">Detail (e.g., 3 koper, 4 Penumpang)</label>
                <input type="text" class="form-control" id="detail_kendaraan" name="detail_kendaraan" required>
            </div>
            <div class="col-md-4">
                <label for="kota" class="form-label">Kota</label>
                <input type="text" class="form-control" id="kota" name="kota" required>
            </div>
            <div class="col-md-4">
                <label for="harga_per_hari" class="form-label">Harga per Hari</label>
                <input type="number" class="form-control" id="harga_per_hari" name="harga_per_hari" required>
            </div>
            <div class="col-12">
                <label for="gambar_url" class="form-label">URL Gambar</label>
                <input type="text" class="form-control" id="gambar_url" name="gambar_url" placeholder="https://.../gambar.jpg">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="?c=vehicle&m=rent" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
    
    <?php include_once 'views/layouts/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
