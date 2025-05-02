<?php
// Mulai session
session_start();
// Include koneksi database
include 'config.php';
// Pastikan keranjang sudah diinisialisasi
if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = array();
}
// Cek jika keranjang kosong, redirect ke halaman menu
if (empty($_SESSION['keranjang'])) {
    header('Location: pesanmenu.php');
    exit;
}
// Hitung total harga
$total = 0;
foreach ($_SESSION['keranjang'] as $item) {
    $total += $item['harga'] * $item['jumlah'];
}
// Proses pembayaran jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $metode_pembayaran = isset($_POST['metode_pembayaran']) ? $_POST['metode_pembayaran'] : '';
    
    if (empty($metode_pembayaran)) {
        $error = "Silakan pilih metode pembayaran";
    } else {
        // Simpan pesanan ke database
        
        // 1. Simpan data pesanan ke tabel pesanan
        $tanggal = date('Y-m-d H:i:s');
        $status_pesanan = 'Menunggu Pembayaran';
        
        $query_pesanan = "INSERT INTO pesanan (tanggal, total, metode_pembayaran, status) 
                         VALUES ('$tanggal', $total, '$metode_pembayaran', '$status_pesanan')";
        
        if (mysqli_query($conn, $query_pesanan)) {
            $id_pesanan = mysqli_insert_id($conn);
            
            // 2. Simpan detail pesanan
            foreach ($_SESSION['keranjang'] as $item) {
                $id_menu = $item['id_menu'];
                $jumlah = $item['jumlah'];
                $harga = $item['harga'];
                
                $query_detail = "INSERT INTO pesanan_detail (id_pesanan, id_menu, jumlah, harga) 
                                VALUES ($id_pesanan, $id_menu, $jumlah, $harga)";
                mysqli_query($conn, $query_detail);
            }
            
            // Kosongkan keranjang
            $_SESSION['keranjang'] = array();
            
            // Redirect ke halaman konfirmasi pembayaran
            $_SESSION['id_pesanan'] = $id_pesanan;
            header('Location: konfirmasi_pembayaran.php');
            exit;
        } else {
            $error = "Terjadi kesalahan. Silakan coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metode Pembayaran</title>
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
        
        .total-box {
            background-color: #6b8669;
            color: white;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            margin: 30px auto;
            max-width: 300px;
        }
        
        .total-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .total-amount {
            font-size: 28px;
            font-weight: bold;
        }
        
        .payment-title {
            font-size: 18px;
            color: #5b775b;
            margin: 20px 0;
            text-align: center;
        }
        
        .payment-options {
            display: flex;
            justify-content: space-around;
            margin: 30px 0;
        }
        
        .payment-option {
            text-align: center;
            width: 45%;
        }
        
        .payment-option label {
            display: block;
            background-color: #5b775b;
            padding: 15px;
            border-radius: 10px;
            cursor: pointer;
            color: white;
            margin-bottom: 10px;
        }
        
        .payment-option input[type="radio"] {
            display: none;
        }
        
        .payment-option input[type="radio"]:checked + label {
            background-color: #4a6148;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
        }
        
        .payment-icon {
            width: 100px;
            height: 90px;
            margin-bottom: 10px;
        }
        
        .payment-name {
            font-size: 18px;
            font-weight: bold;
        }
        
        .submit-button {
            background-color: #5b775b;
            color: white;
            border: none;
            padding: 15px;
            font-size: 18px;
            border-radius: 10px;
            width: 100%;
            cursor: pointer;
            margin-top: 20px;
        }
        
        .submit-button:hover {
            background-color: #4a6148;
        }
        
        .error-message {
            color: red;
            text-align: center;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="keranjang.php" class="back-button">←</a>
            <div class="header-title">METODE PEMBAYARAN</div>
        </div>
        
        <div class="total-box">
            <div class="total-title">TOTAL</div>
            <div class="total-amount">Rp <?= number_format($total, 0, ',', '.') ?></div>
        </div>
        
        <?php if (isset($error)): ?>
            <div class="error-message"><?= $error ?></div>
        <?php endif; ?>
        
        <div class="payment-title">PILIH METODE PEMBAYARAN</div>
        
        <form method="POST" action="">
            <div class="payment-options">
                <div class="payment-option">
                    <input type="radio" id="cash" name="metode_pembayaran" value="cash">
                    <label for="cash">
                        <img src="../IMAGE/cash.jpg" alt="Cash" class="payment-icon">
                        <div class="payment-name">CASH</div>
                    </label>
                </div>
                
                <div class="payment-option">
                    <input type="radio" id="cashless" name="metode_pembayaran" value="cashless">
                    <label for="cashless">
                        <img src="../IMAGE/barcode.jpg" alt="Cashless" class="payment-icon">
                        <div class="payment-name">CASHLESS</div>
                    </label>
                </div>
            </div>
            
            <button type="submit" class="submit-button">LANJUTKAN PEMBAYARAN</button>
        </form>
    </div>

</body>
</html>