<?php

$host = "localhost";
$user = "root"; // or your DB username
$pass = "";     // or your DB password
$db   = "warung_makan_kebumen"; // ganti dengan nama database Anda

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}


function clean_input($data) {
    global $conn;
    return mysqli_real_escape_string($conn, htmlspecialchars(strip_tags(trim($data))));
}
?>