<?php
// Mulai session
session_start();
// Include koneksi database
include 'config.php';

// Cek apakah ada id_pesanan yang tersimpan di session
if (!isset($_SESSION['id_pesanan'])) {
    header('Location: pesanmenu.php');
    exit;
}

// Ambil data pesanan
$id_pesanan = $_SESSION['id_pesanan'];
$query = "SELECT * FROM pesanan WHERE id = $id_pesanan";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    header('Location: pesanmenu.php');
    exit;
}

$pesanan = mysqli_fetch_assoc($result);

// Fungsi untuk mengecek status pembayaran
function cekStatusPembayaran($conn, $id_pesanan) {
    // Di sini Anda bisa menambahkan logika untuk mengecek status pembayaran
    // Misalnya dari API payment gateway atau tabel status pembayaran
    
    $query = "SELECT status FROM pesanan WHERE id = $id_pesanan";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    
    return $row['status'];
}

// Jika tombol cek status diklik
if (isset($_POST['cek_status'])) {
    $status = cekStatusPembayaran($conn, $id_pesanan);
    
    if ($status === 'Dibayar') {
        // Jika pembayaran berhasil
        $_SESSION['pesan_sukses'] = "Pembayaran berhasil!";
        header('Location: konfirmasi_sukses.php');
        exit;
    } else {
        $pesan_error = "Pembayaran belum terverifikasi. Silakan coba lagi nanti.";
    }
}

// Generate invoice ID yang mudah dibaca
$invoice_id = "XXX-XXX-XXX";
if (isset($pesanan['id'])) {
    $invoice_id = sprintf("INV-%06d", $pesanan['id']);
}

// Nama merchant
$nama_merchant = "Warung Makan Kebumen";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Cashless</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        
        body {
            background-color: #e0ebd7;
        }
        
        .container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            background-color: #5b775b;
            color: white;
            padding: 15px;
            border-radius: 10px 10px 0 0;
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .back-button {
            margin-right: 15px;
            text-decoration: none;
            color: white;
            font-size: 24px;
        }
        
        .header-title {
            font-size: 18px;
            font-weight: bold;
        }
        
        .support-text {
            text-align: center;
            margin: 20px 0 10px;
            color: #5b775b;
            font-size: 14px;
        }
        
        .payment-logos {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .payment-logo {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .scan-title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: white;
            margin-bottom: 15px;
        }
        
        .qr-container {
            background-color: white;
            padding: 20px;
            border-radius: 20px;
            width: 220px;
            height: 220px;
            margin: 0 auto 30px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .qr-code {
            width: 180px;
            height: 180px;
        }
        
        .merchant-info {
            background-color: white;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .merchant-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }
        
        .merchant-value {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
            border-bottom: 1px dashed #ccc;
            padding-bottom: 5px;
        }
        
        .cek-status-btn {
            display: block;
            background-color: white;
            color: #5b775b;
            border: none;
            border-radius: 30px;
            padding: 15px;
            font-size: 16px;
            font-weight: bold;
            width: 100%;
            max-width: 300px;
            margin: 0 auto;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
        }
        
        .cek-status-btn:hover {
            background-color: #f0f0f0;
        }
        
        .error-message {
            background-color: rgba(255, 0, 0, 0.1);
            color: #d00;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="metode_pembayaran.php" class="back-button">←</a>
            <div class="header-title">PEMBAYARAN CASHLESS</div>
        </div>
        
        <div class="support-text">We Are Support :</div>
        
        <div class="payment-logos">
            <img src="images/ovo_logo.png" alt="OVO" class="payment-logo">
            <img src="images/dana_logo.png" alt="Dana" class="payment-logo">
            <img src="images/shopee_logo.png" alt="ShopeePay" class="payment-logo">
            <img src="images/bca_logo.png" alt="BCA" class="payment-logo">
        </div>
        
        <div class="scan-title">SCAN QRIS</div>
        
        <div class="qr-container">
            <img src="images/qris_code.png" alt="QRIS Code" class="qr-code">
        </div>
        
        <div class="merchant-info">
            <div class="merchant-label">Nama Merchant</div>
            <div class="merchant-value"><?= $nama_merchant ?></div>
            
            <div class="merchant-label">INVOICE ID</div>
            <div class="merchant-value"><?= $invoice_id ?></div>
        </div>
        
        <?php if (isset($pesan_error)): ?>
            <div class="error-message"><?= $pesan_error ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <button type="submit" name="cek_status" class="cek-status-btn">CEK STATUS PEMBAYARAN</button>
        </form>
    </div>
</body>
</html>