<?php include_once 'views/layouts/header.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - <?php echo htmlspecialchars($invoice_details['order_code']); ?></title>
    <link rel="shortcut icon" href="style/assets/favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Pro:wght@200..900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="style/style-order.css">
</head>
<body>

<?php
    $numeric_price = (float) preg_replace('/[^0-9]/', '', $invoice_details['total_price']);
?>

<div class="container my-5">
    <div class="invoice-card">
   
        <div class="card-header bg-transparent text-center py-4">
            <h1 class="invoice-title">INVOICE</h1>
            <p class="invoice-id text-muted mb-0">ID Pesanan: <strong><?php echo htmlspecialchars($invoice_details['full_order_id']); ?></strong></p>
        </div>

     
        <div class="card-body p-4 p-md-5">
            <div class="text-end mb-4">
                <h5 class="section-subtitle">Tanggal Invoice:</h5>
                <p><?php echo date("d F Y", strtotime($invoice_details['order_date'])); ?></p>
            </div>

            <div class="table-responsive mb-4">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="border-0">Deskripsi</th>
                            <th class="text-end border-0">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo htmlspecialchars($invoice_details['order_title']); ?></td>
                            <td class="text-end fw-bold"><?php echo 'Rp ' . number_format($numeric_price, 0, ',', '.'); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <hr>

            <div class="text-end">
                <small>Total Tagihan</small>
                <p class="display-6 total-price-display"><?php echo 'Rp ' . number_format($numeric_price, 0, ',', '.'); ?></p>
            </div>

            <div class="thank-you-note text-center mt-5">
                <img src="style/assets/logo_travlie.png" alt="Travlie Logo" height="30" class="mb-3">
                <p class="mb-0">Terima kasih telah memesan melalui Travlie!</p>
            </div>
        </div>

  
        <div class="card-footer bg-transparent text-center py-4">
             <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print me-2"></i>Cetak Invoice
            </button>
            <a href="index.php?c=order&m=index" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>
</div>

<?php include_once 'views/layouts/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
