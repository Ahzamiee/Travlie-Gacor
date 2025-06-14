<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <main class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-white fw-bold">
            <i class="bi bi-pencil-square"></i> Edit Data Pengguna
            </div>
            <div class="card-body">
            <form action="?c=admin&m=updateUser" method="post">
                <input type="hidden" name="id" value="<?= $user['user_id'] ?>">

                <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" name="fullname" value="<?= htmlspecialchars($user['fullname']) ?>" required>
                </div>

                <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                </div>

                <?php if ($_SESSION['user']['email'] === 'admin@gmail.com'): ?>
                <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-select">
                    <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
                    <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                </select>
                </div>
                <?php else: ?>
                <input type="hidden" name="role" value="<?= $user['role'] ?>">
                <?php endif; ?>

                <div class="d-flex justify-content-between">
                <a href="?c=admin&m=manageUsers" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan Perubahan
                </button>
                </div>
            </form>
            </div>
        </div>
        </div>
    </div>
    </main>
</body>
