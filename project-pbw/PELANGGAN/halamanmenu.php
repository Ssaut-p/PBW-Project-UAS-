<?php
// Include koneksi database
include 'config.php';

// Inisialisasi variabel
$jenis = isset($_GET['jenis']) ? $_GET['jenis'] : 'Semua';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Query untuk mengambil data menu
$query = "SELECT * FROM menu WHERE 1=1";

// Filter berdasarkan kategori jika tidak 'Semua'
if ($jenis != 'Semua') {
    $query .= " AND kategori = '$jenis'";
}

// Filter berdasarkan pencarian
if (!empty($search)) {
    $query .= " AND (nama_menu LIKE '%$search%' OR deskripsi LIKE '%$search%')";
}

$result = mysqli_query($conn, $query);

// Fetch data keranjang dari session jika ada
session_start();
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Hitung total harga
$total = 0;
foreach ($_SESSION['cart'] as $cart_item) {
    $total += $cart_item['harga'] * $cart_item['jumlah'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warung Makan Kebumen - Pemesanan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
        }
        
        .container {
            display: flex;
            max-width: 100%;
            height: 100vh;
        }
        
        /* Left panel - Cart */
        .cart-panel {
            background-color: #4a5745;
            color: white;
            width: 35%;
            padding: 15px;
            position: relative;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .back-button {
            color: white;
            font-size: 24px;
            margin-bottom: 15px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        
        .restaurant-name {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .restaurant-logo {
            width: 30px;
            margin-right: 10px;
        }
        
        .total-section {
            background-color: #5f7159;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .cart-items {
            margin-bottom: 20px;
            flex-grow: 1;
            overflow-y: auto;
            max-height: calc(100vh - 250px);
        }
        
        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #5f7159;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        
        .cart-item-info {
            display: flex;
            align-items: center;
            width: 80%;
        }
        
        .cart-item-img {
            width: 40px;
            height: 40px;
            border-radius: 5px;
            object-fit: cover;
            margin-right: 10px;
        }
        
        .cart-item-details {
            font-size: 12px;
            width: 100%;
        }
        
        .quantity-controls {
            display: flex;
            align-items: center;
            margin-top: 5px;
        }
        
        .quantity-btn {
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
        
        .quantity {
            margin: 0 10px;
        }
        
        .remove-btn {
            background: none;
            border: none;
            color: white;
            font-size: 18px;
            cursor: pointer;
        }
        
        .order-btn {
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
        }
        
        /* Right panel - Menu */
        .menu-panel {
            background-color: #c0d8b8;
            width: 65%;
            padding: 15px;
            overflow-y: auto;
        }
        
        .search-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        
        .search-input {
            width: 85%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #e8f1e3;
        }
        
        .search-icon {
            width: 12%;
            background-color: #e8f1e3;
            border: none;
            border-radius: 5px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }
        
        .category-section {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 15px;
        }
        
        .category-label {
            background-color: #e8f1e3;
            padding: 5px 10px;
            border-radius: 15px;
            display: inline-block;
            font-size: 12px;
            text-transform: uppercase;
            cursor: pointer;
        }
        
        .category-label.active {
            background-color: #4a5745;
            color: white;
        }
        
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }
        
        .menu-item {
            background-color: #e8f1e3;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
            cursor: pointer;
            transition: transform 0.2s;
        }
        
        .menu-item:hover {
            transform: scale(1.03);
        }
        
        .menu-item.sold-out {
            cursor: not-allowed;
        }
        
        .menu-item.sold-out::after {
            content: "HABIS";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 20px;
            font-weight: bold;
        }
        
        .menu-img {
            width: 100%;
            height: 120px;
            object-fit: cover;
        }
        
        .menu-details {
            padding: 10px;
        }
        
        .menu-name {
            font-size: 14px;
            margin-bottom: 5px;
        }
        
        .menu-description {
            font-size: 10px;
            color: #666;
            margin-bottom: 10px;
            height: 30px;
            overflow: hidden;
        }
        
        .menu-price {
            font-size: 16px;
            font-weight: bold;
            color: #4a5745;
        }
        
        #notification {
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
    <div id="notification"></div>
    <div class="container">
        <!-- Left panel - Cart -->
        <div class="cart-panel">
            <a href="index.php" class="back-button">←</a>
            <div class="restaurant-name">
                <img src="IMAGE/logo.png" alt="Logo" class="restaurant-logo">
                <div>
                    <h3>Warung Makan</h3>
                    <h4>Kebumen</h4>
                </div>
            </div>
            
            <div class="total-section">
                <h3>Total</h3>
                <h2>Rp. <?= number_format($total, 0, ',', '.') ?></h2>
            </div>
            
            <div class="cart-items" id="cart-items-container">
                <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                <div class="cart-item" data-id="<?= $id ?>">
                    <div class="cart-item-info">
                        <img src="<?= $item['gambar'] ?>" alt="<?= $item['nama_menu'] ?>" class="cart-item-img">
                        <div class="cart-item-details">
                            <div><?= $item['nama_menu'] ?></div>
                            <div>Rp. <?= number_format($item['harga'], 0, ',', '.') ?></div>
                            <div class="quantity-controls">
                                <button class="quantity-btn decrease-qty" data-id="<?= $id ?>">-</button>
                                <span class="quantity"><?= $item['jumlah'] ?></span>
                                <button class="quantity-btn increase-qty" data-id="<?= $id ?>">+</button>
                            </div>
                        </div>
                    </div>
                    <button class="remove-btn" data-id="<?= $id ?>">×</button>
                </div>
                <?php endforeach; ?>
            </div>
            
            <button class="order-btn" id="order-btn">Pesan</button>
        </div>
        
        <!-- Right panel - Menu -->
        <div class="menu-panel">
            <form action="menu.php" method="GET" id="search-form">
                <div class="search-bar">
                    <input type="text" name="search" class="search-input" placeholder="Cari Menu" value="<?= $search ?>">
                    <button type="submit" class="search-icon">🔍</button>
                </div>
            </form>
            
            <div class="category-section">
                <?php
                // Ambil kategori dari database
                $categories_query = "SELECT DISTINCT kategori FROM menu";
                $categories_result = mysqli_query($conn, $categories_query);
                ?>
                <a href="menu.php?jenis=Semua" class="category-label <?= $jenis == 'Semua' ? 'active' : '' ?>">Semua</a>
                <?php while($category = mysqli_fetch_assoc($categories_result)): ?>
                <a href="menu.php?jenis=<?= $category['kategori'] ?>" class="category-label <?= $jenis == $category['kategori'] ? 'active' : '' ?>"><?= $category['kategori'] ?></a>
                <?php endwhile; ?>
            </div>
            
            <div class="menu-grid">
                <?php while($menu = mysqli_fetch_assoc($result)): ?>
                <div class="menu-item <?= $menu['status'] == 'Habis' ? 'sold-out' : '' ?>" data-id="<?= $menu['id_menu'] ?>" data-name="<?= $menu['nama_menu'] ?>" data-price="<?= $menu['harga'] ?>" data-img="<?= $menu['gambar'] ?>" data-status="<?= $menu['status'] ?>">
                    <img src="<?= $menu['gambar'] ?>" alt="<?= $menu['nama_menu'] ?>" class="menu-img">
                    <div class="menu-details">
                        <h3 class="menu-name"><?= $menu['nama_menu'] ?></h3>
                        <p class="menu-description"><?= $menu['deskripsi'] ?></p>
                        <div class="menu-price">Rp. <?= number_format($menu['harga'], 0, ',', '.') ?></div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk menampilkan notifikasi
        function showNotification(message) {
            const notification = document.getElementById('notification');
            notification.textContent = message;
            notification.style.display = 'block';
            
            // Hilangkan notifikasi setelah 3 detik
            setTimeout(() => {
                notification.style.display = 'none';
            }, 3000);
        }
        
        // Fungsi untuk menambahkan item ke keranjang melalui AJAX
        function addToCart(menuId) {
            fetch('cart_process.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=add&id=' + menuId
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Refresh konten keranjang
                    updateCartDisplay();
                    showNotification('Menu berhasil ditambahkan ke keranjang');
                } else {
                    showNotification('Gagal menambahkan menu: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan. Silakan coba lagi.');
            });
        }
        
        // Fungsi untuk menghapus item dari keranjang
        function removeFromCart(menuId) {
            fetch('cart_process.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=remove&id=' + menuId
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Refresh konten keranjang
                    updateCartDisplay();
                    showNotification('Menu dihapus dari keranjang');
                } else {
                    showNotification('Gagal menghapus menu');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
        
        // Fungsi untuk mengubah jumlah item
        function updateQuantity(menuId, change) {
            fetch('cart_process.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=update&id=' + menuId + '&change=' + change
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Refresh konten keranjang
                    updateCartDisplay();
                } else {
                    showNotification(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
        
        // Fungsi untuk memperbarui tampilan keranjang
        function updateCartDisplay() {
            fetch('get_cart.php')
            .then(response => response.text())
            .then(html => {
                document.getElementById('cart-items-container').innerHTML = html;
                
                // Update total
                fetch('get_cart_total.php')
                .then(response => response.json())
                .then(data => {
                    document.querySelector('.total-section h2').textContent = 'Rp. ' + data.total_formatted;
                    
                    // Tambahkan event listener untuk tombol-tombol baru
                    addCartEventListeners();
                });
            });
        }
        
        // Fungsi untuk menambahkan event listeners pada item keranjang
        function addCartEventListeners() {
            // Event listener untuk tombol hapus
            document.querySelectorAll('.remove-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const menuId = this.getAttribute('data-id');
                    removeFromCart(menuId);
                });
            });
            
            // Event listener untuk tombol kurangi jumlah
            document.querySelectorAll('.decrease-qty').forEach(button => {
                button.addEventListener('click', function() {
                    const menuId = this.getAttribute('data-id');
                    updateQuantity(menuId, -1);
                });
            });
            
            // Event listener untuk tombol tambah jumlah
            document.querySelectorAll('.increase-qty').forEach(button => {
                button.addEventListener('click', function() {
                    const menuId = this.getAttribute('data-id');
                    updateQuantity(menuId, 1);
                });
            });
        }
        
        // Event listener untuk menu items
        document.querySelectorAll('.menu-item:not(.sold-out)').forEach(item => {
            item.addEventListener('click', function() {
                const menuId = this.getAttribute('data-id');
                addToCart(menuId);
            });
        });
        
        // Menambahkan event listener ke tombol pesan
        document.getElementById('order-btn').addEventListener('click', function() {
            // Redirect ke halaman checkout atau proses pesanan
            window.location.href = 'checkout.php';
        });
        
        // Inisialisasi event listeners untuk keranjang
        addCartEventListeners();
    </script>
</body>
</html>