<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <main class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white fw-bold">Ubah Profil Saya</div>
            <div class="card-body">
                <form action="?c=dashboard&m=updateSelf" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="fullname" class="form-control" value="<?= htmlspecialchars($user['fullname']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Foto Profil</label>
                            <?php
                                $userId = $user['user_id'];
                                $photoFilename = $_SESSION['user']['photo'] ?? null;

                                if ($photoFilename && file_exists(__DIR__ . '/../../uploads/' . $photoFilename)) {
                                    $photoUrl = 'uploads/' . $photoFilename;
                                } else {
                                    $matches = glob(__DIR__ . '/../../uploads/user_' . $userId . '_*');
                                    $photoUrl = isset($matches[0]) ? 'uploads/' . basename($matches[0]) : 'uploads/default.png';
                                }
                            ?>
                            <div class="mb-2">
                                <img src="<?= $photoUrl ?>" alt="Foto Profil" width="100" class="squared-circle">
                            </div>
                            <input type="file" name="photo" class="form-control">
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="?c=dashboard&m=profile" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                </form>
            </div>
        </div>
        </div>
    </div>
    </main>
</body>
