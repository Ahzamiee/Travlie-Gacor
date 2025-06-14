<html lang="en">
<head>
  <title>Account Profile</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.ico" type="x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Pro:wght@200..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style/style-profile.css">  
</head>  

<body>
<?php include_once('views/layouts/header.php'); ?>

<main>
  <div class="container mt-4">
    <div class="row justify-content-center">

      <?php
          $userId = $_SESSION['user']['user_id'];
          $photoFilename = $_SESSION['user']['photo'] ?? null;

          if ($photoFilename && file_exists(__DIR__ . '/../../uploads/' . $photoFilename)) {
              $photoUrl = 'uploads/' . $photoFilename;
          } else {
              $matches = glob(__DIR__ . '/../../uploads/user_' . $userId . '_*');
              $photoUrl = isset($matches[0]) ? '../../uploads/' . basename($matches[0]) : '../../uploads/default.png';
          }
      ?>
      <div class="col-md-5 mb-4">
        <div class="card shadow-sm">
          <div class="card-header bg-primary text-white fw-bold">
            Informasi Pengguna
          </div>
          <div class="card-body text-center">
              <div class="text-center mb-3">
                <img src="<?= $photoUrl ?>" width="150" class="rounded-circle">
              </div>
            <p class="mb-1"><strong>Nama: </strong><?= htmlspecialchars($_SESSION['user']['fullname'])?></p>
            <p class="mb-0"><strong>Email: </strong><?= htmlspecialchars($_SESSION['user']['email'])?></p>
          </div>
        </div>
      </div>

      <div class="col-md-5 mb-4">
        <div class="card shadow-sm">
          <div class="card-header bg-dark text-white fw-bold">
            Pengaturan Akun
          </div>
          <div class="card-body">
            <ul class="list-group list-group-flush">
              <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                <li class="list-group-item"><a href="?c=admin&m=manageUsers">Kelola Pengguna</a></li>
              <?php endif; ?>
              <li class="list-group-item"><a href="?c=dashboard&m=editSelf">Ubah Profile</a></li>
              <li class="list-group-item"><a href="#">Ganti Password</a></li>
              <li class="list-group-item"><a href="?c=auth&m=logout">Logout</a></li>
            </ul>
          </div>
        </div>
      </div>

    </div>
  </div>
</main>

<?php include_once 'views/layouts/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>
