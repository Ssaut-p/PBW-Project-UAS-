<?php
session_start();
include 'config.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warung Makan Kebumen</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #a7beae;
            font-family: Arial, sans-serif;
        }
        .logo {
            text-align: center;
            margin: 20px 0;
        }
        .logo img {
            width: 100px;
        }
        .options {
            display: flex;
            justify-content: space-around;
            margin: 50px auto;
            max-width: 800px;
        }
        .option-card {
            background-color: white;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            width: 45%;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .option-card img {
            width: 100px;
            height: 100px;
            object-fit: contain;
            margin-bottom: 15px;
        }
        .option-card h3 {
            color: #4a6d51;
            margin-bottom: 10px;
        }
        .btn-order {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 20px;
            cursor: pointer;
            width: 100%;
            max-width: 300px;
        }
        h1 {
            color: white;
            text-align: center;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="../IMAGE/logo.png" alt="Logo Warung Makan Kebumen">
            <h1>Warung Makan Kebumen</h1>
        </div>
        
        <div class="options">
            <div class="option-card">
                <img src="../IMAGE/kursi.jpg" alt="Makan di Tempat">
                <h3>DiTempat</h3>
                <a href="pesanmenu.php?jenis=DiTempat" class="btn btn-success btn-order">Pilih</a>
            </div>
            
            <div class="option-card">
                <img src="../IMAGE/bungkus.jpg" alt="Bawa Pulang" >
                <h3>Bawa Pulang</h3>
                <a href="pesanmenu.php?jenis=BawaPulang" class="btn btn-success btn-order">Pilih</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>