<?php
// Menampilkan semua error PHP
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 1. Panggil file koneksi.php
require_once 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 2. Ambil data dari form
    $customer_name = trim($_POST['customer_name']);
    $content = trim($_POST['content']);
    $video_url = trim($_POST['video_url']);
    
    // ==================================================================
    // PERUBAHAN: Ambil product_id dari form yang dipilih pengguna
    // ==================================================================
    $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;

    // Validasi sederhana jika product_id tidak dipilih
    if ($product_id === 0) {
        die("Error: Anda harus memilih produk yang akan diulas.");
    }
    
    $status = 'pending';

    // 3. Query INSERT sudah benar dan tidak perlu diubah
    $sql = "INSERT INTO testimonials (customer_name, content, video_url, status, product_id) VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $koneksi->prepare($sql);

    if ($stmt) {
        // bind_param sudah benar
        $stmt->bind_param("ssssi", $customer_name, $content, $video_url, $status, $product_id);

        if ($stmt->execute()) {
            // Jika berhasil, alihkan ke halaman terima kasih
            header("Location: terima_kasih.html");
            exit();
        } else {
            // Jika gagal, tampilkan pesan error yang spesifik
            echo "Error saat menyimpan: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $koneksi->error;
    }

} else {
    // Jika file diakses langsung, alihkan ke halaman utama
    header("Location: index.php");
    exit();
}

$koneksi->close();
?>