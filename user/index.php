<!doctype html>
<html lang="en">
<head>
  <title>Manajemen Pengguna</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="favicon.ico" type="x-icon">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Crimson+Pro:wght@200..900&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="style/style-profile.css">
</head>

<body>
<?php include_once('views/layouts/header.php'); ?>

<main class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary">Manajemen Pengguna</h3>
        <a href="?c=dashboard&m=profile" class="btn btn-outline-secondary">
          <i class="bi bi-arrow-left"></i> Kembali ke Profil
        </a>
      </div>

      <div class="mb-3">
        <a href="?c=admin&m=createUser" class="btn btn-success">
          <i class="bi bi-person-plus-fill"></i> Tambah User
        </a>
      </div>

      <div class="card shadow-sm">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
              <thead class="table-primary text-center">
                <tr>
                  <th>ID</th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($users as $u): ?>
                <tr>
                  <td class="text-center"><?= $u['user_id'] ?></td>
                  <td><?= htmlspecialchars($u['fullname']) ?></td>
                  <td><?= htmlspecialchars($u['email']) ?></td>
                  <td class="text-center"><?= ucfirst($u['role']) ?></td>
                  <td class="text-center">
                    <a href="?c=admin&m=editUser&id=<?= $u['user_id'] ?>" class="btn btn-sm btn-outline-primary me-1">
                      <i class="bi bi-pencil-square"></i> Edit
                    </a>
                    <a href="?c=admin&m=deleteUser&id=<?= $u['user_id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus pengguna ini?')">
                      <i class="bi bi-trash"></i> Hapus
                    </a>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
  </div>
</main>

<?php include_once('views/layouts/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
