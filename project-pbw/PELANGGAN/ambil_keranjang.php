<?php
// File ini mengembalikan HTML untuk item keranjang yang akan diperbarui dengan AJAX

// Mulai session
session_start();

// Pastikan keranjang sudah diinisialisasi
if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = array();
}

// Render HTML untuk setiap item di keranjang
foreach ($_SESSION['keranjang'] as $id => $item): ?>
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