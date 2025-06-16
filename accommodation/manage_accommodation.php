<?php 
include_once ('views/layouts/header.php');
// Asumsi $data['accommodations'] sudah tersedia dari controller
$accommodations = $data['accommodations'] ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Akomodasi | Admin Travlie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style/css/style-accomodation.css"> 

    <style>
        /* Gaya dasar untuk baris akomodasi tidak aktif */
        .status-inactive {
            opacity: 0.7; /* Membuat baris sedikit lebih buram */
            filter: grayscale(50%); /* Memberikan efek abu-abu */
        }
    </style>
</head>
<body>

<div class="container mt-5">
  
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-gear-fill text-primary"></i> Kelola Akomodasi</h2>
        
        <a href="?c=admin&m=createAccommodation" class="btn btn-success ms-auto me-2">
            <i class="bi bi-plus-lg"></i> Tambah Baru
        </a>

          <a href="?c=accommodation&m=index" class="btn btn-info"> 
            <i class="bi bi-house"></i> Halaman Akomodasi
          </a>
        
    </div>

    <?php 
    // Menampilkan pesan sukses atau error dari operasi CRUD
    if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php 
            $message = '';
            switch ($_GET['success']) {
                case 'created': $message = 'Akomodasi berhasil ditambahkan!'; break;
                case 'updated': $message = 'Akomodasi berhasil diperbarui!'; break;
                case 'deleted': $message = 'Akomodasi berhasil dihapus!'; break;
                case 'status_updated': $message = 'Status akomodasi berhasil diperbarui!'; break;
                default: $message = 'Operasi berhasil!'; break;
            }
            echo $message;
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php 
            $message = '';
            switch ($_GET['error']) {
                case 'failed': $message = 'Operasi gagal! Silakan coba lagi.'; break;
                case 'delete_failed': $message = 'Gagal menghapus akomodasi!'; break;
                case 'status_failed': $message = 'Gagal memperbarui status akomodasi!'; break;
                case 'notfound': $message = 'Akomodasi tidak ditemukan!'; break;
                default: $message = 'Terjadi kesalahan!'; break;
            }
            echo $message;
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama & Tipe</th>
                    <th>Lokasi</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($accommodations)): ?>
                    <?php foreach ($accommodations as $accommodation): ?>
                        <tr class="<?php echo ($accommodation->is_aktif == 0) ? 'status-inactive' : ''; ?>">
                            <td><?= htmlspecialchars($accommodation->id_akomodasi) ?></td>
                            <td>
                                <strong><?= htmlspecialchars($accommodation->nama_akomodasi) ?></strong><br>
                                <small class="text-muted"><?= htmlspecialchars($accommodation->tipe_akomodasi) ?></small>
                            </td>
                            <td><?= htmlspecialchars($accommodation->kota) ?></td>
                            <td>
                                <?php if ($accommodation->harga_diskon > 0): ?>
                                    <span class="text-muted text-decoration-line-through small">IDR <?= number_format($accommodation->harga_standard, 0, ',', '.') ?></span><br>
                                    <strong>IDR <?= number_format($accommodation->harga_diskon, 0, ',', '.') ?></strong>
                                <?php else: ?>
                                    IDR <?= number_format($accommodation->harga_standard, 0, ',', '.') ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge bg-<?php echo ($accommodation->is_aktif == 1) ? 'success' : 'secondary'; ?>">
                                    <?php echo ($accommodation->is_aktif == 1) ? 'Aktif' : 'Tidak Aktif'; ?>
                                </span>
                            </td>
                            <td class="text-center text-nowrap">
                                <a href="?c=admin&m=editAccommodation&id=<?= $accommodation->id_akomodasi ?>" class="btn btn-sm btn-warning me-1" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" onclick="toggleStatus(<?= $accommodation->id_akomodasi ?>)" 
                                    class="btn btn-sm btn-<?php echo ($accommodation->is_aktif == 1) ? 'secondary' : 'success'; ?> me-1" 
                                    title="<?php echo ($accommodation->is_aktif == 1) ? 'Nonaktifkan' : 'Aktifkan'; ?>">
                                    <i class="bi bi-<?php echo ($accommodation->is_aktif == 1) ? 'eye-slash' : 'eye'; ?>"></i>
                                </button>
                                <button type="button" onclick="confirmDelete(<?= $accommodation->id_akomodasi ?>, '<?= htmlspecialchars($accommodation->nama_akomodasi, ENT_QUOTES) ?>')" 
                                    class="btn btn-sm btn-danger" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada akomodasi yang ditemukan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<?php include_once ('views/layouts/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="style/js/accomodation.js"></script> 

</body>
</html>
