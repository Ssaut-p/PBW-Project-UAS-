<?php
// Include koneksi database
include 'config.php';

// Cek ID pesanan
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: menu.php');
    exit;
}

$id_pesanan = intval($_GET['id']);

// Ambil data pesanan
$query_pesanan = "SELECT * FROM pesanan WHERE id_pesanan = $id_pesanan";
$result_pesanan = mysqli_query($conn, $query_pesanan);

if (mysqli_num_rows($result_pesanan) == 0) {
    header('Location: menu.php');
    exit;
}

$pesanan = mysqli_fetch_assoc($result_pesanan);

// Ambil detail pesanan
$query_detail = "SELECT d.*, m.nama_menu, m.gambar 
                FROM detail_pesanan d 
                JOIN menu m ON d.id_menu = m.id_menu 
                WHERE d.id_pesanan = $id_pesanan";
$result_detail = mysqli_query($conn, $query_detail);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warung Makan Kebumen - Pesanan Berhasil</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
            padding: 20px;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .header {
            background-color: #4a5745;
            color: white;
            padding: 20px;
            text-align: center;
        }
        
        .success-icon {
            font-size: 50px;
            color: #4CAF50;
            text-align: center;
            margin: 20px 0;
        }
        
        .content {
            padding: 20px;
        }
        
        .info-box {
            background-color: #f7f7f7;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .info-row {
            display: flex;
            margin-bottom: 10px;
        }
        
        .info-label {
            width: 150px;
            font-weight: bold;
        }
        
        .order-items {
            margin-top: 20px;
        }
        
        .order-item {
            display: flex;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }
        
        .item-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
            margin-right: 10px;
        }
        
        .item-details {
            flex-grow: 1;
        }
        
        .item-name {
            font-weight: bold;
        }
        
        .item-price {
            color: #666;
            font-size: 14px;
        }
        
        .item-quantity {
            margin-left: auto;
            text-align: right;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 15px 0;
            font-weight: bold;
            border-top: 2px solid #ddd;
            margin-top: 10px;
        }
        
        .btn {
            display: inline-block;
            background-color: #4a5745;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
            margin-top: 20px;
        }
        
        .btn-center {
            display: block;
            width: 200px;
            margin: 20px auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Pesanan Berhasil</h1>
        </div>
        
        <div class="success-icon">✓</div>
        
        <div class="content">
            <h2>Terima kasih atas pesanan Anda!</h2>
            <p>Pesanan Anda telah kami terima dan sedang diproses. Mohon tunggu sebentar.</p>
            
            <div class="info-box">
                <div class="info-row">
                    <div class="info-label">No. Pesanan:</div>
                    <div><?= $id_pesanan ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Nama Pemesan:</div>
                    <div><?= $pesanan['nama_pelanggan'] ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">No. Meja:</div>
                    <div><?= $pesanan['no_meja'] ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Tanggal:</div>
                    <div><?= date('d/m/Y H:i', strtotime($pesanan['tanggal'])) ?></div>
                </div>
                <?php if (!empty($pesanan['catatan'])): ?>
                <div class="info-row">
                    <div class="info-label">Catatan:</div>
                    <div><?= $pesanan['catatan'] ?></div>
                </div>
                <?php endif; ?>
            </div>
            
            <h3>Detail Pesanan</h3>
            <div class="order-items">
                <?php while ($item = mysqli_fetch_assoc($result_detail)): ?>
                <div class="order-item">
                    <img src="<?= $item['gambar'] ?>" alt="<?= $item['nama_menu'] ?>" class="item-image">
                    <div class="item-details">
                        <div class="item-name"><?= $item['nama_menu'] ?></div>
                        <div class="item-price">Rp. <?= number_format($item['harga'], 0, ',', '.') ?></div>
                    </div>
                    <div class="item-quantity">
                        <div>x<?= $item['jumlah'] ?></div>
                        <div>Rp. <?= number_format($item['subtotal'], 0, ',', '.') ?></div>
                    </div>
                </div>
                <?php endwhile; ?>
                
                <div class="total-row">
                    <div>Total</div>
                    <div>Rp. <?= number_format($pesanan['total_harga'], 0, ',', '.') ?></div>
                </div>
            </div>
            
            <a href="menu.php" class="btn btn-center">Kembali ke Menu</a>
        </div>
    </div>
</body>
</html>