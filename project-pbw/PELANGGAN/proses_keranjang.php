<?php
// Proses_keranjang.php - File untuk menangani operasi keranjang melalui AJAX

// Mulai session
session_start();

// Include koneksi database
include 'config.php';

// Inisialisasi array keranjang jika belum ada
if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = array();
}

// Fungsi untuk mengambil data menu dari database
function getMenuData($id) {
    global $conn;
    $id = mysqli_real_escape_string($conn, $id);
    $query = "SELECT * FROM menu WHERE id_menu = '$id'";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

// Cek jika request adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $aksi = isset($_POST['aksi']) ? $_POST['aksi'] : '';
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    
    // Validasi ID
    if (empty($id)) {
        echo json_encode(['sukses' => false, 'pesan' => 'ID menu tidak valid']);
        exit;
    }
    
    // Switch berdasarkan aksi yang diminta
    switch ($aksi) {
        case 'tambah':
            // Cek apakah menu sudah ada di keranjang
            if (isset($_SESSION['keranjang'][$id])) {
                // Menu sudah ada, tambah jumlahnya
                $_SESSION['keranjang'][$id]['jumlah']++;
                echo json_encode(['sukses' => true, 'pesan' => 'Jumlah menu ditambah']);
            } else {
                // Menu belum ada, ambil data menu dari database
                $menu = getMenuData($id);
                
                if ($menu) {
                    // Cek status menu
                    if ($menu['status'] == 'Habis') {
                        echo json_encode(['sukses' => false, 'pesan' => 'Menu tidak tersedia']);
                        exit;
                    }
                    
                    // Tambahkan menu ke keranjang
                    $_SESSION['keranjang'][$id] = [
                        'id_menu' => $menu['id_menu'],
                        'nama_menu' => $menu['nama_menu'],
                        'harga' => $menu['harga'],
                        'gambar' => $menu['gambar'],
                        'jumlah' => 1
                    ];
                    
                    echo json_encode(['sukses' => true, 'pesan' => 'Menu ditambahkan ke keranjang']);
                } else {
                    echo json_encode(['sukses' => false, 'pesan' => 'Menu tidak ditemukan']);
                }
            }
            break;
            
        case 'hapus':
            // Hapus menu dari keranjang
            if (isset($_SESSION['keranjang'][$id])) {
                unset($_SESSION['keranjang'][$id]);
                echo json_encode(['sukses' => true, 'pesan' => 'Menu dihapus dari keranjang']);
            } else {
                echo json_encode(['sukses' => false, 'pesan' => 'Menu tidak ada di keranjang']);
            }
            break;
            
        case 'ubah':
            // Ubah jumlah item
            $perubahan = isset($_POST['perubahan']) ? (int)$_POST['perubahan'] : 0;
            
            if (isset($_SESSION['keranjang'][$id])) {
                // Hitung jumlah baru
                $jumlah_baru = $_SESSION['keranjang'][$id]['jumlah'] + $perubahan;
                
                // Validasi jumlah baru
                if ($jumlah_baru <= 0) {
                    // Jumlah nol atau negatif, hapus dari keranjang
                    unset($_SESSION['keranjang'][$id]);
                    echo json_encode(['sukses' => true, 'pesan' => 'Menu dihapus dari keranjang']);
                } else {
                    // Update jumlah
                    $_SESSION['keranjang'][$id]['jumlah'] = $jumlah_baru;
                    echo json_encode(['sukses' => true, 'pesan' => 'Jumlah menu diperbarui']);
                }
            } else {
                echo json_encode(['sukses' => false, 'pesan' => 'Menu tidak ada di keranjang']);
            }
            break;
            
        default:
            echo json_encode(['sukses' => false, 'pesan' => 'Aksi tidak valid']);
            break;
    }
} else {
    echo json_encode(['sukses' => false, 'pesan' => 'Method tidak valid']);
}
?>