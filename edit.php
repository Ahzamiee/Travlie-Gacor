<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($pageTitle) ?></title>
  <link rel="shortcut icon" href="favicon.ico" type="x-icon">
  <link href="https://fonts.googleapis.com/css2?family=Crimson+Pro:wght@200..900&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<h2 class="text-center my-4">Edit Promo</h2>

<div class="d-flex justify-content-center">
  <div class="card p-4 shadow" style="max-width: 600px; width: 100%;">

    <form action="?c=adminPromo&m=update" method="POST">
      <input type="hidden" name="promo_id" value="<?= $promo['promo_id'] ?>">
        <div class="mb-3">
            <label>Judul Promo</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($promo['title']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="description" class="form-control" required><?= htmlspecialchars($promo['description']) ?></textarea>
        </div>
        <div class="mb-3">
            <label>URL Gambar</label>
            <input type="text" name="image_url" class="form-control" value="<?= htmlspecialchars($promo['image_url']) ?>">
        </div>
        <div class="mb-3">
            <label>Kategori</label>
            <input type="text" name="category" class="form-control" value="<?= htmlspecialchars($promo['category']) ?>">
        </div>
        <div class="mb-3">
            <label>Kode Promo</label>
            <input type="text" name="promo_code" class="form-control" value="<?= htmlspecialchars($promo['promo_code']) ?>">
        </div>
        <div class="mb-3">
            <label>Jenis Diskon</label>
            <select name="discount_type" class="form-control">
                <option value="percent" <?= $promo['discount_type'] === 'percent' ? 'selected' : '' ?>>Persentase</option>
                <option value="fixed" <?= $promo['discount_type'] === 'fixed' ? 'selected' : '' ?>>Potongan Tetap</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Nilai Diskon</label>
            <input type="number" step="0.01" name="discount_value" class="form-control" value="<?= $promo['discount_value'] ?>">
        </div>
        <div class="mb-3">
            <label>Tanggal Mulai</label>
            <input type="date" name="start_date" class="form-control" value="<?= $promo['start_date'] ?>">
        </div>
        <div class="mb-3">
            <label>Tanggal Berakhir</label>
            <input type="date" name="end_date" class="form-control" value="<?= $promo['end_date'] ?>">
        </div>
        <div class="mb-3">
            <label>Syarat & Ketentuan</label>
            <textarea name="terms_conditions" class="form-control"><?= htmlspecialchars($promo['terms_conditions']) ?></textarea>
        </div>
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="active" <?= $promo['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                <option value="inactive" <?= $promo['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Limit Penggunaan</label>
            <input type="number" name="usage_limit" class="form-control" value="<?= $promo['usage_limit'] ?>">
        </div>

        <div class="form-check mb-3">
          <input class="form-check-input" type="checkbox" name="is_default" id="is_default" value="1" <?= $promo['is_default'] ? 'checked' : '' ?>>
            <label class="form-check-label" for="is_default">
            Jadikan Promo Default (Akan tampil di halaman user)
            </label>
        </div>

        <div class="d-grid">
          <button type="submit" class="btn btn-success">Simpan Promo</button>
        </div>

    </form>
    <hr>  
      <a href="?c=promo&m=index" class="btn btn-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Kembali ke Daftar Promo
      </a>
  </div>
</div>