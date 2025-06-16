<div class=<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($pageTitle) ?></title>
  <link rel="shortcut icon" href="favicon.ico" type="x-icon">
  <link href="https://fonts.googleapis.com/css2?family=Crimson+Pro:wght@200..900&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<h2 class="text-center my-4">Tambah Promo Baru</h2>

<div class="d-flex justify-content-center">
  <div class="card p-4 shadow" style="max-width: 600px; width: 100%;">
    
   <form action="?c=admin&m=storePromo" method="POST">
      <div class="mb-3">
        <input type="text" name="title" class="form-control" placeholder="Judul Promo" required>
      </div>
      
      <div class="mb-3">
        <textarea name="description" class="form-control" placeholder="Deskripsi" required></textarea>
      </div>
      
      <div class="mb-3">
        <input type="text" name="image_url" class="form-control" placeholder="URL Gambar">
      </div>
      
      <div class="mb-3">
        <input type="text" name="category" class="form-control" placeholder="Kategori (misal: Flight)">
      </div>
      
      <div class="mb-3">
        <input type="text" name="promo_code" class="form-control" placeholder="Kode Promo">
      </div>
      
      <div class="mb-3">
        <select name="discount_type" class="form-select">
          <option value="percent">Persentase</option>
          <option value="fixed">Potongan Tetap</option>
        </select>
      </div>
      
      <div class="mb-3">
        <input type="number" step="0.01" name="discount_value" class="form-control" placeholder="Nilai Diskon">
      </div>
      
      <div class="mb-3">
        <label class="form-label">Tanggal Mulai</label>
        <input type="date" name="start_date" class="form-control">
      </div>
      
      <div class="mb-3">
        <label class="form-label">Tanggal Berakhir</label>
        <input type="date" name="end_date" class="form-control">
      </div>
      
      <div class="mb-3">
        <textarea name="terms_conditions" class="form-control" placeholder="Syarat & Ketentuan"></textarea>
      </div>
      
      <div class="mb-3">
        <select name="status" class="form-select">
          <option value="active">Active</option>
          <option value="inactive">Inactive</option>
        </select>
      </div>
      
      <div class="mb-3">
        <input type="number" name="usage_limit" class="form-control" placeholder="Limit Penggunaan">
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

    
   
