<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Kendaraan - Rent</title>
    <link rel="stylesheet" href="style/css/style-rent.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

    <?php include_once 'views/layouts/header.php'; ?>

    <div class="container my-4">
        <div class="search-summary mb-2 d-flex justify-content-between align-items-center flex-wrap">
            <div class="rental-summary-text-box d-flex flex-column align-items-start" id="rentalSummaryTextBox">
                <span id="currentRentalType" class="fs-4 fw-bold">Rental</span> 
                <div class="d-flex flex-wrap align-items-center"> 
                    <span id="currentLocation"></span>&nbsp;&#x2022;&nbsp; 
                    <span id="currentDates"></span>
            </div>
        </div>
        <button class="btn btn-primary ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse" id="toggleFilterBtn">
            <i class="bi bi-pencil-fill me-2"></i>Ganti Pencarian</button>
    </div>

    <div class="collapse" id="filterCollapse">
        <div class="filter-box d-flex flex-wrap justify-content-between align-items-end">
            <div class="mb-3 me-3 flex-grow-1">
                <label for="kota" class="form-label">Lokasi Rental Anda</label>
                <select class="form-select" id="kota">
                    <option disabled>Pilih Kota</option>
                    <option value="bali">Bali</option>
                    <option value="jakarta" selected>Jakarta</option> 
                    <option value="bandung">Bandung</option>
                    <option value="yogyakarta">Yogyakarta</option>
                    <option value="lombok">Lombok</option>
                </select>
            </div>
            <div class="mb-3 me-3">
                <label for="tanggalMulai" class="form-label">Tanggal Mulai</label>
                <input type="date" class="form-control" id="tanggalMulai" value="2025-06-16">
            </div>
            <div class="mb-3 me-3">
                <label for="waktuMulai" class="form-label">Waktu Mulai</label>
                <input type="time" class="form-control" id="waktuMulai" value="09:00">
            </div>
            <div class="mb-3 me-3">
                <label for="tanggalSelesai" class="form-label">Tanggal Selesai</label>
                <input type="date" class="form-control" id="tanggalSelesai" value="2025-06-18">
            </div>
            <div class="mb-3 me-3">
                <label for="waktuSelesai" class="form-label">Waktu Selesai</label>
                <input type="time" class="form-control" id="waktuSelesai" value="09:00">
            </div>
            <div class="mb-3">
                <button class="btn btn-primary h-100" id="cariMobilBtn">Cari</button>
            </div>
        </div>
    </div>
</div>

<div class="container mb-5">
    
    <?php $isAdmin = $data['isAdmin'] ?? false;
    
    // Tampilkan pesan flash (notifikasi) jika ada dari proses CRUD
    if (isset($_SESSION['message'])) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                ' . $_SESSION['message'] . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
        unset($_SESSION['message']); // Hapus pesan setelah ditampilkan
    }
    
    // tombol "Tambah Kendaraan" hanya untuk admin
        if ($isAdmin):
    ?>
    <div class="mb-3">
        <a href="?c=vehicle&m=create" class="btn btn-success"><i class="bi bi-plus-circle-fill me-2"></i>Tambah Kendaraan Baru</a>
    </div>
    <?php endif; ?>

    <div id="vehicle-list" class="list-group">
        <?php
        $defaultKota = 'jakarta'; 
        $defaultTanggalMulai = '2025-06-16';
        $defaultWaktuMulai = '09:00';
        $defaultTanggalSelesai = '2025-06-18';
        $defaultWaktuSelesai = '09:00';

        $defaultFilterParams = http_build_query([
            'kota' => $defaultKota,
            'tanggalMulai' => $defaultTanggalMulai,
            'waktuMulai' => $defaultWaktuMulai,
            'tanggalSelesai' => $defaultTanggalSelesai,
            'waktuSelesai' => $defaultWaktuSelesai
        ]);
        
        // Data $vehicles seharusnya sudah dilewatkan oleh controller
        if (empty($vehicles)) {
             $vehicleModel = new Vehicle();
             $vehicles = $vehicleModel->getAll($isAdmin);
        }

        if (!empty($vehicles)) {
            foreach ($vehicles as $row) {
                $id = $row['id_vehicle'];
                $merk = $row['merk'];
                $detail = $row['detail_kendaraan'];
                $harga = number_format($row['harga_per_hari'], 0, ',', '.');
                $gambar = $row['gambar_url'] ?? 'style/assets/default.png';
                $jenis = $row['jenis_kendaraan'];
                $kota = ucfirst($row['kota']);
                $sewaUrlDefault = "?c=vehicle&m=sewa&id=" . htmlspecialchars($id) . "&" . $defaultFilterParams;

                $statusBadge = $row['is_aktif'] 
                    ? '<span class="badge bg-success">Aktif</span>' 
                    : '<span class="badge bg-danger">Tidak Aktif</span>';

                $toggleUrl = "?c=vehicle&m=toggleStatus&id=" . $id;
                $toggleText = $row['is_aktif'] ? 'Nonaktifkan' : 'Aktifkan';
                $toggleButtonClass = $row['is_aktif'] ? 'btn-outline-secondary' : 'btn-outline-success';

                echo '
                <div class="list-group-item list-group-item-action mb-3 p-3">
                    <div class="row g-3 align-items-center">

                        <div class="col-md-8 d-none d-md-flex align-items-center" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#modal' . $id . '">
                            <img src="' . htmlspecialchars($gambar) . '" alt="' . htmlspecialchars($merk) . '" class="img-fluid rounded" style="width: 120px; height: 80px; object-fit: cover;">
                            <div class="ms-3">
                                <h5 class="mb-1">' . htmlspecialchars($merk) . '</h5>
                                <small class="text-muted">' . htmlspecialchars($detail) . '</small>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end d-none d-md-block">
                            <p class="mb-2">Mulai dari<br><strong class="fs-5 text-primary">IDR ' . htmlspecialchars($harga) . '</strong>/hari</p>
                            <a href="' . $sewaUrlDefault . '" class="btn btn-primary">Sewa Sekarang</a>
                            ' . ($isAdmin ? '
                            <div class="mt-2">
                                <a href="' . $toggleUrl . '" class="btn btn-sm ' . $toggleButtonClass . '">' . $toggleText . '</a>
                                <a href="?c=vehicle&m=edit&id=' . $id . '" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i> Edit</a>
                                <a href="?c=vehicle&m=destroy&id=' . $id . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Anda yakin ingin menghapus data ini?\')"><i class="bi bi-trash-fill"></i> Hapus</a>
                            </div>
                            ' : '') . '
                        </div>

                        <!--TAMPILAN MOBILE (<768px)-->
                        <div class="col-7 d-md-none">
                            <div class="d-flex flex-column h-100">
                                <h5 class="mb-1" style="font-size: 0.9rem;">' . htmlspecialchars($merk) . '</h5>
                                <small class="text-muted" style="font-size: 0.75rem;">' . htmlspecialchars($detail) . '</small>
                                <div class="mt-auto">
                                    <p class="mb-1" style="font-size: 0.8rem;">Mulai dari<br><strong class="fs-6 text-primary">IDR ' . $harga . '</strong>/hari</p>
                                    <div class="d-flex flex-wrap gap-1">
                                        <a href="' . $sewaUrlDefault . '" class="btn btn-sm btn-primary flex-grow-1">Sewa</a>
                                        ' . ($isAdmin ? '
                                        <a href="' . $toggleUrl . '" class="btn btn-sm ' . $toggleButtonClass . '">' . $toggleText . '</a>
                                        <a href="?c=vehicle&m=edit&id=' . $id . '" class="btn btn-sm btn-warning flex-grow-1">Edit</a>
                                        <a href="?c=vehicle&m=destroy&id=' . $id . '" class="btn btn-sm btn-danger flex-grow-1" onclick="return confirm(\'Anda yakin ingin menghapus data ini?\')">Hapus</a>
                                        ' : '') . '
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-5 d-md-none" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#modal' . $id . '">
                            <img src="' . htmlspecialchars($gambar) . '" alt="' . htmlspecialchars($merk) . '" class="img-fluid rounded">
                        </div>

                    </div>
                </div>

                <!-- Modal untuk detail -->
                <div class="modal fade" id="modal' . $id . '" tabindex="-1" aria-labelledby="modalLabel' . $id . '" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">' . htmlspecialchars($merk) . '</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <ul>
                                    <li>Jenis Kendaraan: ' . htmlspecialchars($jenis) . '</li>
                                    <li>Merk: ' . htmlspecialchars($merk) . '</li>
                                    <li>Detail: ' . htmlspecialchars($detail) . '</li>
                                    <li>Kota: ' . htmlspecialchars($kota) . '</li>
                                    <li>Harga: IDR ' . htmlspecialchars($harga) . '/hari</li>
                                </ul>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>';
            }
            } else {
                echo '<div class="alert alert-info text-center" role="alert">Tidak ada kendaraan ditemukan.</div>';
            }   
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="style/js/rent.js"></script>

</body>
</html>
