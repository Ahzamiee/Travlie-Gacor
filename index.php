<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Penerbangan - Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style/style-admin.css"> <style>
        /* Gaya dasar untuk tabel admin */
        .admin-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #eee;
            padding-bottom: 15px;
        }
        .admin-header h2 {
            margin: 0;
            color: #333;
            font-size: 2em;
        }
        .btn-add-new {
            background-color: #28a745;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .btn-add-new:hover {
            background-color: #218838;
        }
        .admin-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .admin-table th, .admin-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
            vertical-align: top;
        }
        .admin-table th {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #555;
        }
        .admin-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .admin-table tbody tr:hover {
            background-color: #f1f1f1;
        }
        .admin-table .actions a {
            margin-right: 8px;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.9em;
        }
        .admin-table .actions .btn-edit {
            background-color: #007bff;
            color: white;
        }
        .admin-table .actions .btn-edit:hover {
            background-color: #0056b3;
        }
        .admin-table .actions .btn-delete {
            background-color: #dc3545;
            color: white;
        }
        .admin-table .actions .btn-delete:hover {
            background-color: #c82333;
        }
        .message-box {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-weight: bold;
        }
        .message-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .message-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .no-flights {
            text-align: center;
            color: #777;
            padding: 20px;
            border: 1px dashed #ccc;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <?php include_once ('views/layouts/header.php'); ?>

    <div class="admin-container">
        <div class="admin-header">
            <h2>Kelola Data Penerbangan</h2>
            <a href="index.php?c=admin&m=createFlight" class="btn-add-new">
                <i class="fas fa-plus"></i> Tambah Penerbangan Baru
            </a>
        </div>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="message-box message-success">
                <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="message-box message-error">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($flights)): ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Maskapai</th>
                    <th>Nomor Penerbangan</th>
                    <th>Dari (Kode & Nama)</th>
                    <th>Ke (Kode & Nama)</th>
                    <th>Tgl/Waktu Berangkat</th>
                    <th>Tgl/Waktu Tiba</th>
                    <th>Kelas</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($flights as $flight): ?>
                <tr>
                    <td><?php echo htmlspecialchars($flight['id']); ?></td>
                    <td><?php echo htmlspecialchars($flight['airline']); ?></td>
                    <td><?php echo htmlspecialchars($flight['flight_number']); ?></td>
                    <td><?php echo htmlspecialchars($flight['departure_city_code'] . ' (' . $flight['departure_city_name'] . ')'); ?></td>
                    <td><?php echo htmlspecialchars($flight['arrival_city_code'] . ' (' . $flight['arrival_city_name'] . ')'); ?></td>
                    <td><?php echo htmlspecialchars(date('d M Y H:i', strtotime($flight['departure_date'] . ' ' . $flight['departure_time']))); ?></td>
                    <td><?php echo htmlspecialchars(date('d M Y H:i', strtotime($flight['arrival_date'] . ' ' . $flight['arrival_time']))); ?></td>
                    <td><?php echo htmlspecialchars($flight['flight_class']); ?></td>
                    <td>Rp <?php echo number_format($flight['price'], 0, ',', '.'); ?></td>
                    <td class="actions">
                        <a href="index.php?c=admin&m=editFlight&id=<?php echo htmlspecialchars($flight['id']); ?>" class="btn-edit">Edit</a>
                        <a href="index.php?c=admin&m=deleteFlight&id=<?php echo htmlspecialchars($flight['id']); ?>" class="btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus penerbangan ini?');">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
            <p class="no-flights">Belum ada data penerbangan.</p>
        <?php endif; ?>
    </div>

    <?php include_once ('views/layouts/footer.php'); ?>
</body>
</html>