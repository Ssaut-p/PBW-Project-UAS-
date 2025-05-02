<?php
// Include koneksi database
include 'config.php';

// Inisialisasi variabel
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : 'Semua';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Query untuk mengambil data menu
$query = "SELECT * FROM menu WHERE 1=1";

// Filter berdasarkan kategori jika tidak 'Semua'
if ($kategori != 'Semua') {
    $query .= " AND kategori = '$kategori'";
}

// Filter berdasarkan pencarian
if (!empty($search)) {
    $query .= " AND (nama_menu LIKE '%$search%' OR deskripsi LIKE '%$search%')";
}

$result = mysqli_query($conn, $query);

// Inisialisasi keranjang dari session
session_start();
if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = array();
}

// Hitung total harga
$total = 0;
foreach ($_SESSION['keranjang'] as $item) {
    $total += $item['harga'] * $item['jumlah'];
}

// Ambil semua kategori untuk filter
$kategori_query = "SELECT DISTINCT kategori FROM menu";
$kategori_result = mysqli_query($conn, $kategori_query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warung Makan Kebumen - Pemesanan Menu</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        
        body {
            background-color: #c0d8b8;
        }
        
        .container {
            display: flex;
            max-width: 100%;
            height: 100vh;
        }
        
        /* Panel Kiri - Keranjang */
        .keranjang-panel {
            background-color: #4a5745;
            color: white;
            width: 35%;
            padding: 15px;
            position: relative;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .kembali-button {
            color: white;
            font-size: 24px;
            margin-bottom: 20px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        
        .resto-info {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .resto-logo {
            width: 40px;
            margin-right: 10px;
        }
        
        .total-box {
            background-color: #5f7159;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .items-container {
            flex-grow: 1;
            overflow-y: auto;
            margin-bottom: 20px;
        }
        
        .keranjang-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #5f7159;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        
        .item-info {
            display: flex;
            align-items: center;
            width: 80%;
        }
        
        .item-img {
            width: 40px;
            height: 40px;
            border-radius: 5px;
            object-fit: cover;
            margin-right: 10px;
        }
        
        .item-detail {
            font-size: 12px;
            width: 100%;
        }
        
        .item-qty {
            display: flex;
            align-items: center;
            margin-top: 5px;
        }
        
        .qty-btn {
            background: none;
            border: 1px solid white;
            color: white;
            width: 20px;
            height: 20px;
            border-radius: 3px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }
        
        .qty-val {
            margin: 0 10px;
        }
        
        .hapus-btn {
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
        }
        
        .pesan-btn {
            background-color: #c0d8b8;
            color: #4a5745;
            border: none;
            border-radius: 20px;
            padding: 15px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            text-transform: uppercase;
            margin-top: auto;
            text-align: center;
            width: 100%;
        }
        
        /* Panel Kanan - Menu */
        .menu-panel {
            background-color: #c0d8b8;
            width: 65%;
            padding: 20px;
            overflow-y: auto;
        }
        
        .cari-box {
            background-color: white;
            border-radius: 20px;
            display: flex;
            align-items: center;
            padding: 8px 15px;
            margin-bottom: 15px;
        }
        
        .cari-input {
            border: none;
            flex-grow: 1;
            padding: 5px;
            background: transparent;
            outline: none;
        }
        
        .cari-icon {
            color: #888;
            cursor: pointer;
        }
        
        .kategori-bar {
            margin-bottom: 20px;
        }
        
        .kategori-label {
            color: #4a5745;
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }
        
        .kategori-list {
            overflow-x: auto;
            white-space: nowrap;
            padding-bottom: 10px;
        }
        
        .kategori-item {
            display: inline-block;
            background-color: #e8f1e3;
            padding: 8px 15px;
            border-radius: 20px;
            margin-right: 10px;
            cursor: pointer;
            font-size: 14px;
        }
        
        .kategori-item.active {
            background-color: #4a5745;
            color: white;
        }
        
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
        
        .menu-item {
            background-color: #e8f1e3;
            border-radius: 10px;
            overflow: hidden;
            cursor: pointer;
            transition: transform 0.2s;
            position: relative;
        }
        
        .menu-item:hover {
            transform: scale(1.03);
        }
        
        .menu-item.habis {
            pointer-events: none;
        }
        
        .menu-item.habis::after {
            content: "HABIS";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            font-size: 24px;
            font-weight: bold;
        }
        
        .menu-img {
            width: 100%;
            height: 120px;
            object-fit: cover;
        }
        
        .menu-detail {
            padding: 10px;
        }
        
        .menu-nama {
            font-size: 14px;
            margin-bottom: 5px;
        }
        
        .menu-desc {
            font-size: 10px;
            color: #666;
            margin-bottom: 5px;
            height: 30px;
            overflow: hidden;
        }
        
        .menu-harga {
            font-size: 22px;
            font-weight: bold;
            color: #4a5745;
            text-align: center;
        }
        
        .notifikasi {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #4a5745;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            display: none;
            z-index: 100;
        }
    </style>
</head>
<body>
    <div class="notifikasi" id="notifikasi"></div>
    <div class="container">
        <!-- Panel Kiri - Keranjang -->
        <div class="keranjang-panel">
            <a href="index.php" class="kembali-button">←</a>
            <div class="resto-info">
                <img src="../IMAGE/logo.png" alt="Logo" class="resto-logo">
                <div>
                    <h3>Warung Makan</h3>
                    <h4>Kebumen</h4>
                </div>
            </div>
            
            <div class="total-box">
                <h3>Total</h3>
                <h2>Rp.<?= number_format($total, 0, ',', '.') ?></h2>
            </div>
            
            <div class="items-container" id="keranjang-items">
                <?php foreach ($_SESSION['keranjang'] as $id => $item): ?>
                <div class="keranjang-item" data-id="<?= $id ?>">
                    <div class="item-info">
                        <img src="<?= $item['gambar'] ?>" alt="<?= $item['nama_menu'] ?>" class="item-img">
                        <div class="item-detail">
                            <div><?= $item['nama_menu'] ?></div>
                            <div><?= $item['jumlah'] ?> pcs · Rp <?= number_format($item['harga'], 0, ',', '.') ?></div>
                            <div class="item-qty">
                                <button class="qty-btn kurang-qty" data-id="<?= $id ?>">-</button>
                                <span class="qty-val"><?= $item['jumlah'] ?></span>
                                <button class="qty-btn tambah-qty" data-id="<?= $id ?>">+</button>
                            </div>
                        </div>
                    </div>
                    <button class="hapus-btn" data-id="<?= $id ?>">×</button>
                </div>
                <?php endforeach; ?>
            </div>
            
            <button class="pesan-btn" id="pesan-btn">Pesan</button>
        </div>
        
        <!-- Panel Kanan - Menu -->
        <div class="menu-panel">
            <form action="pesanmenu.php" method="GET" id="cari-form">
                <div class="cari-box">
                    <input type="text" name="search" class="cari-input" placeholder="Cari Menu" value="<?= $search ?>">
                    <span class="cari-icon">🔍</span>
                </div>
            </form>
            
            <div class="kategori-bar">
                <div class="kategori-label">KATEGORI:</div>
                <div class="kategori-list">
                    <a href="pesanmenu.php?kategori=Semua" class="kategori-item <?= $kategori == 'Semua' ? 'active' : '' ?>">Semua</a>
                    <?php while($kat = mysqli_fetch_assoc($kategori_result)): ?>
                    <a href="pesanmenu.php?kategori=<?= $kat['kategori'] ?>" class="kategori-item <?= $kategori == $kat['kategori'] ? 'active' : '' ?>"><?= $kat['kategori'] ?></a>
                    <?php endwhile; ?>
                </div>
            </div>
            
            <div class="menu-grid">
                <?php while($menu = mysqli_fetch_assoc($result)): ?>
                <div class="menu-item <?= $menu['status'] == 'Habis' ? 'habis' : '' ?>" 
                     data-id="<?= $menu['id_menu'] ?>" 
                     data-nama="<?= $menu['nama_menu'] ?>" 
                     data-harga="<?= $menu['harga'] ?>" 
                     data-gambar="<?= $menu['gambar'] ?>"
                     data-status="<?= $menu['status'] ?>">
                    <img src="<?= $menu['gambar'] ?>" alt="<?= $menu['nama_menu'] ?>" class="menu-img">
                    <div class="menu-detail">
                        <h3 class="menu-nama"><?= $menu['nama_menu'] ?></h3>
                        <p class="menu-desc"><?= $menu['deskripsi'] ?></p>
                        <div class="menu-harga">Rp.<?= number_format($menu['harga'], 0, ',', '.') ?></div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk menampilkan notifikasi
        function tampilNotifikasi(pesan) {
            const notifikasi = document.getElementById('notifikasi');
            notifikasi.textContent = pesan;
            notifikasi.style.display = 'block';
            
            // Sembunyikan notifikasi setelah 3 detik
            setTimeout(() => {
                notifikasi.style.display = 'none';
            }, 3000);
        }
        
        // Fungsi untuk menambah item ke keranjang via AJAX
        function tambahKeKeranjang(idMenu) {
            fetch('proses_keranjang.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'aksi=tambah&id=' + idMenu
            })
            .then(response => response.json())
            .then(data => {
                if (data.sukses) {
                    // Refresh tampilan keranjang
                    updateTampilanKeranjang();
                    tampilNotifikasi('Menu berhasil ditambahkan ke keranjang');
                } else {
                    tampilNotifikasi('Gagal menambahkan menu: ' + data.pesan);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                tampilNotifikasi('Terjadi kesalahan. Silakan coba lagi.');
            });
        }
        
        // Fungsi untuk menghapus item dari keranjang
        function hapusDariKeranjang(idMenu) {
            fetch('proses_keranjang.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'aksi=hapus&id=' + idMenu
            })
            .then(response => response.json())
            .then(data => {
                if (data.sukses) {
                    // Refresh tampilan keranjang
                    updateTampilanKeranjang();
                    tampilNotifikasi('Menu dihapus dari keranjang');
                } else {
                    tampilNotifikasi('Gagal menghapus menu');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
        
        // Fungsi untuk mengubah jumlah item
        function ubahJumlah(idMenu, perubahan) {
            fetch('proses_keranjang.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'aksi=ubah&id=' + idMenu + '&perubahan=' + perubahan
            })
            .then(response => response.json())
            .then(data => {
                if (data.sukses) {
                    // Refresh tampilan keranjang
                    updateTampilanKeranjang();
                } else {
                    tampilNotifikasi(data.pesan);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
        
        // Fungsi untuk memperbarui tampilan keranjang
        function updateTampilanKeranjang() {
            fetch('ambil_keranjang.php')
            .then(response => response.text())
            .then(html => {
                document.getElementById('keranjang-items').innerHTML = html;
                
                // Update total
                fetch('ambil_total_keranjang.php')
                .then(response => response.json())
                .then(data => {
                    document.querySelector('.total-box h2').textContent = 'Rp.' + data.total_formatted;
                    
                    // Tambahkan event listener untuk tombol-tombol baru
                    tambahEventListenerKeranjang();
                });
            });
        }
        
        // Fungsi untuk menambahkan event listeners pada item keranjang
        function tambahEventListenerKeranjang() {
            // Event listener untuk tombol hapus
            document.querySelectorAll('.hapus-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const idMenu = this.getAttribute('data-id');
                    hapusDariKeranjang(idMenu);
                });
            });
            
            // Event listener untuk tombol kurangi jumlah
            document.querySelectorAll('.kurang-qty').forEach(button => {
                button.addEventListener('click', function() {
                    const idMenu = this.getAttribute('data-id');
                    ubahJumlah(idMenu, -1);
                });
            });
            
            // Event listener untuk tombol tambah jumlah
            document.querySelectorAll('.tambah-qty').forEach(button => {
                button.addEventListener('click', function() {
                    const idMenu = this.getAttribute('data-id');
                    ubahJumlah(idMenu, 1);
                });
            });
        }
        
        // Event listener untuk menu items
        document.querySelectorAll('.menu-item:not(.habis)').forEach(item => {
            item.addEventListener('click', function() {
                const idMenu = this.getAttribute('data-id');
                tambahKeKeranjang(idMenu);
            });
        });
        
        // Event listener untuk tombol pesan
        document.getElementById('pesan-btn').addEventListener('click', function() {
            // Redirect ke halaman pembayaran
            window.location.href = 'pembayaran.php';
        });
        
        // Inisialisasi event listeners untuk keranjang
        tambahEventListenerKeranjang();
    </script>
</body>
</html>