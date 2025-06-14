<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <main class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white fw-bold">
            <i class="bi bi-person-plus-fill"></i> Tambah User Baru
            </div>
            <div class="card-body">
            <form action="?c=admin&m=storeUser" method="post">
                <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" name="fullname" required>
                </div>

                <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" required>
                </div>

                <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
                </div>

                <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-select">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
                </div>

                <div class="d-flex justify-content-between">
                <a href="?c=admin&m=manageUsers" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Batal
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-lg"></i> Simpan
                </button>
                </div>
            </form>
            </div>
        </div>
        </div>
    </div>
    </main>
</body>
