<?php
// Include koneksi database
include '../config.php';

// Inisialisasi variabel untuk menyimpan pesan
$pesan = "";

// Cek apakah form sudah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $id_menu = $_POST['id_menu'];
    $nama_menu = $_POST['nama_menu'];
    $harga = $_POST['harga'];
    $kategori = $_POST['kategori'];
    $jumlah = $_POST['jumlah'];
    $deskripsi = $_POST['deskripsi'];
    $status = "Tersedia"; // Default status
    
    // Upload gambar
    $target_dir = "../IMAGE/menu/";
    $gambar = $target_dir . basename($_FILES["gambar"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($gambar, PATHINFO_EXTENSION));
    
    // Cek apakah file gambar valid
    $check = getimagesize($_FILES["gambar"]["tmp_name"]);
    if($check === false) {
        $pesan = "File bukan gambar.";
        $uploadOk = 0;
    }
    
    // Cek ekstensi file
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        $pesan = "Hanya file JPG, JPEG, & PNG yang diizinkan.";
        $uploadOk = 0;
    }
    
    // Jika semuanya valid, simpan data ke database
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $gambar)) {
            // Query untuk menambah menu baru
            $query = "INSERT INTO menu (id_menu, nama_menu, harga, kategori, jumlah, deskripsi, gambar, status) 
                     VALUES ('$id_menu', '$nama_menu', $harga, '$kategori', $jumlah, '$deskripsi', '$gambar', '$status')";
            
            if (mysqli_query($conn, $query)) {
                $pesan = "Menu berhasil ditambahkan!";
                // Redirect ke halaman daftar menu setelah 2 detik
                header("refresh:2;url=daftar_menu.php");
            } else {
                $pesan = "Error: " . $query . "<br>" . mysqli_error($conn);
            }
        } else {
            $pesan = "Maaf, terjadi kesalahan saat upload gambar.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Menu - Warung Makan Kebumen</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        
        body {
            background-color: #c0d8b8;
            padding: 20px;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        h1 {
            color: #4a5745;
            text-align: center;
            margin-bottom: 30px;
        }
        
        .form-container {
            background-color: #e8f1e3;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-row {
            display: flex;
            gap: 20px;
        }
        
        .form-col {
            flex: 1;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #4a5745;
            font-weight: bold;
        }
        
        input[type="text"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        
        textarea {
            height: 100px;
            resize: vertical;
        }
        
        .upload-btn {
            background-color: #4a5745;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
        
        .submit-btn {
            background-color: #4a5745;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            margin-top: 10px;
        }
        
        .submit-btn:hover {
            background-color: #3a4536;
        }
        
        .kembali-btn {
            display: inline-block;
            padding: 10px 15px;
            background-color: #5f7159;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .pesan {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }
        
        .pesan-sukses {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .pesan-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }
        
        .file-input-wrapper input[type=file] {
            font-size: 100px;
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            cursor: pointer;
        }
        
        .file-name {
            margin-left: 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="daftar_menu.php" class="kembali-btn">← Kembali</a>
        
        <h1>Tambah Menu</h1>
        
        <?php if(!empty($pesan)): ?>
            <div class="pesan <?php echo (strpos($pesan, "berhasil") !== false) ? 'pesan-sukses' : 'pesan-error'; ?>">
                <?php echo $pesan; ?>
            </div>
        <?php endif; ?>
        
        <div class="form-container">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="id_menu">ID Menu:</label>
                    <input type="text" id="id_menu" name="id_menu" required>
                </div>
                
                <div class="form-group">
                    <label for="nama_menu">Nama Menu:</label>
                    <input type="text" id="nama_menu" name="nama_menu" required>
                </div>
                
                <div class="form-group">
                    <label for="harga">Harga:</label>
                    <input type="number" id="harga" name="harga" required>
                </div>
                
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="kategori">Kategori:</label>
                            <select id="kategori" name="kategori" required>
                                <option value="">Pilih Kategori</option>
                                <option value="Makanan">Makanan</option>
                                <option value="Minuman">Minuman</option>
                                <option value="Snack">Snack</option>
                                <option value="Paket">Paket</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-col">
                        <div class="form-group">
                            <label for="jumlah">Jumlah:</label>
                            <input type="number" id="jumlah" name="jumlah" required>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="deskripsi">Deskripsi:</label>
                    <textarea id="deskripsi" name="deskripsi" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="gambar">Upload Gambar:</label>
                    <div class="file-input-wrapper">
                        <button class="upload-btn">Pilih File</button>
                        <input type="file" id="gambar" name="gambar" required>
                    </div>
                    <span id="file-name" class="file-name">Tidak ada file yang dipilih</span>
                </div>
                
                <button type="submit" class="submit-btn">Simpan Menu</button>
            </form>
        </div>
    </div>
    
    <script>
        // Script untuk menampilkan nama file yang dipilih
        document.getElementById('gambar').addEventListener('change', function() {
            var fileName = this.files[0].name;
            document.getElementById('file-name').textContent = fileName;
        });
    </script>
</body>
</html>