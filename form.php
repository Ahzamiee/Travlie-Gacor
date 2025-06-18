<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($flight['id']) ? 'Edit' : 'Tambah'; ?> Penerbangan - Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style/style-admin.css">
    <link rel="stylesheet" href="style/style-admin-form.css"> <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
</head>
<body>
    <?php include_once ('views/layouts/header.php'); ?>

    <div class="admin-form-container">
        <h2><?php echo isset($flight['id']) ? 'Edit Penerbangan' : 'Tambah Penerbangan Baru'; ?></h2>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="message-box message-error">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form action="index.php?c=admin&m=<?php echo htmlspecialchars($action); ?>" method="POST">
            <?php if (isset($flight['id'])): ?>
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($flight['id']); ?>">
            <?php endif; ?>

            <div class="form-group">
                <label for="airline">Maskapai:</label>
                <input type="text" id="airline" name="airline" value="<?php echo htmlspecialchars($flight['airline'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="flight_number">Nomor Penerbangan:</label>
                <input type="text" id="flight_number" name="flight_number" value="<?php echo htmlspecialchars($flight['flight_number'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="departure_city_code">Kode Kota Keberangkatan:</label>
                <input type="text" id="departure_city_code" name="departure_city_code" value="<?php echo htmlspecialchars($flight['departure_city_code'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="departure_city_name">Nama Kota Keberangkatan:</label>
                <input type="text" id="departure_city_name" name="departure_city_name" value="<?php echo htmlspecialchars($flight['departure_city_name'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="arrival_city_code">Kode Kota Kedatangan:</label>
                <input type="text" id="arrival_city_code" name="arrival_city_code" value="<?php echo htmlspecialchars($flight['arrival_city_code'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="arrival_city_name">Nama Kota Kedatangan:</label>
                <input type="text" id="arrival_city_name" name="arrival_city_name" value="<?php echo htmlspecialchars($flight['arrival_city_name'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="departure_date">Tanggal Keberangkatan:</label>
                <input type="date" id="departure_date" name="departure_date" value="<?php echo htmlspecialchars($flight['departure_date'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="departure_time">Waktu Keberangkatan:</label>
                <input type="time" id="departure_time" name="departure_time" value="<?php echo htmlspecialchars($flight['departure_time'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="arrival_date">Tanggal Kedatangan:</label>
                <input type="date" id="arrival_date" name="arrival_date" value="<?php echo htmlspecialchars($flight['arrival_date'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="arrival_time">Waktu Kedatangan:</label>
                <input type="time" id="arrival_time" name="arrival_time" value="<?php echo htmlspecialchars($flight['arrival_time'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="flight_class">Kelas Penerbangan:</label>
                <select id="flight_class" name="flight_class" required>
                    <option value="Economy" <?php echo (isset($flight['flight_class']) && $flight['flight_class'] == 'Economy') ? 'selected' : ''; ?>>Economy</option>
                    <option value="Business" <?php echo (isset($flight['flight_class']) && $flight['flight_class'] == 'Business') ? 'selected' : ''; ?>>Business</option>
                    <option value="First" <?php echo (isset($flight['flight_class']) && $flight['flight_class'] == 'First') ? 'selected' : ''; ?>>First Class</option>
                </select>
            </div>
            <div class="form-group">
                <label for="price">Harga:</label>
                <input type="number" step="0.01" id="price" name="price" value="<?php echo htmlspecialchars($flight['price'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="image_url">URL Gambar:</label>
                <input type="text" id="image_url" name="image_url" value="<?php echo htmlspecialchars($flight['image_url'] ?? ''); ?>">
            </div>

            <div class="form-actions">
                <button type="submit"><?php echo isset($flight['id']) ? 'Perbarui' : 'Tambah'; ?> Penerbangan</button>
                <a href="index.php?c=admin&m=flights" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>

    <?php include_once ('views/layouts/footer.php'); ?>
</body>
</html>