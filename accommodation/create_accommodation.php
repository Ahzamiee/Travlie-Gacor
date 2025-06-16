<?php include_once ('views/layouts/header.php'); ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Akomodasi Baru | Admin Travlie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style/css/style-accomodation.css"> 
</head>
<body>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-plus-circle-fill text-success"></i> Tambah Akomodasi Baru</h2>
        <div class="d-flex gap-2"> 
          <a href="?c=admin&m=manageAccommodations" class="btn btn-secondary">
            <i class="bi bi-list-ul"></i> Daftar Akomodasi
          </a>

          <a href="?c=accommodation&m=index" class="btn btn-info"> 
            <i class="bi bi-house"></i> Halaman Akomodasi
          </a>
        </div>
    </div>

    <?php 
    // Tampilkan pesan error jika ada (dari redirect controller)
    if (isset($_GET['error']) && $_GET['error'] == 'failed'): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Gagal menambahkan akomodasi. Silakan coba lagi.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="?c=admin&m=createAccommodation" method="POST">
                
                <div class="mb-3">
                    <label for="nama_akomodasi" class="form-label">Nama Akomodasi</label>
                    <input type="text" class="form-control" id="nama_akomodasi" name="nama_akomodasi" required>
                </div>
                
                <div class="mb-3">
                    <label for="tipe_akomodasi" class="form-label">Tipe Akomodasi</label>
                    <select class="form-select" id="tipe_akomodasi" name="tipe_akomodasi" required>
                        <option value="">Pilih Tipe</option>
                        <option value="Hotel">Hotel</option>
                        <option value="Villa">Villa</option>
                        <option value="Apartment">Apartment</option>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="provinsi" class="form-label">Provinsi</label>
                        <input type="text" class="form-control" id="provinsi" name="provinsi" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="kota" class="form-label">Kota</label>
                        <input type="text" class="form-control" id="kota" name="kota" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="deskripsi_singkat" class="form-label">Deskripsi Singkat</label>
                    <input type="text" class="form-control" id="deskripsi_singkat" name="deskripsi_singkat" maxlength="255">
                    <div class="form-text">Maksimal 255 karakter.</div>
                </div>

                <div class="mb-3">
                    <label for="deskripsi_lengkap" class="form-label">Deskripsi Lengkap</label>
                    <textarea class="form-control" id="deskripsi_lengkap" name="deskripsi_lengkap" rows="5" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="url_gambar_utama" class="form-label">URL Gambar Utama</label>
                    <input type="url" class="form-control" id="url_gambar_utama" name="url_gambar_utama" required placeholder="https://example.com/gambar-akomodasi.jpg">
                    <div class="form-text">Link gambar utama akomodasi.</div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="harga_standard" class="form-label">Harga Standard (IDR)</label>
                        <input type="number" class="form-control" id="harga_standard" name="harga_standard" min="0" step="1000" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="harga_diskon" class="form-label">Harga Diskon (IDR) <small class="text-muted">(Opsional)</small></label>
                        <input type="number" class="form-control" id="harga_diskon" name="harga_diskon" min="0" step="1000">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="rating_bintang" class="form-label">Rating Bintang (1-5)</label>
                    <input type="number" class="form-control" id="rating_bintang" name="rating_bintang" min="1" max="5" step="1" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="telepon_kontak" class="form-label">Telepon Kontak</label>
                        <input type="tel" class="form-control" id="telepon_kontak" name="telepon_kontak" placeholder="+628123456789">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email_kontak" class="form-label">Email Kontak</label>
                        <input type="email" class="form-control" id="email_kontak" name="email_kontak" placeholder="email@example.com">
                    </div>
                </div>

                <button type="submit" class="btn btn-success mt-3"><i class="bi bi-save"></i> Simpan Akomodasi</button>
            </form>
        </div>
    </div>
</div>

<?php include_once ('views/layouts/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
