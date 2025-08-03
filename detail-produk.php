<?php
require_once 'koneksi.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// 1. Ambil ID produk dari URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: produk.php");
    exit();
}
$product_id = (int)$_GET['id'];

// 2. Ambil detail produk utama DAN nama kategorinya
$sql = "SELECT p.*, c.name AS category_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id 
        WHERE p.id = ? 
        LIMIT 1";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $product = $result->fetch_assoc();
} else {
    die("<h1>Produk tidak ditemukan.</h1><a href='produk.php'>Kembali ke daftar produk</a>");
}

// 3. Ambil 4 produk lain dari kategori yang sama untuk rekomendasi
$related_products = [];
if (!empty($product['category_id'])) {
    $sql_related = "SELECT id, name, price, image FROM products WHERE id != ? AND category_id = ? ORDER BY RAND() LIMIT 4";
    $stmt_related = $koneksi->prepare($sql_related);
    $stmt_related->bind_param("ii", $product_id, $product['category_id']);
    $stmt_related->execute();
    $result_related = $stmt_related->get_result();
    if ($result_related->num_rows > 0) {
        while ($row = $result_related->fetch_assoc()) {
            $related_products[] = $row;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Chocloud - <?php echo htmlspecialchars($product['name']); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <style>
        body { font-family: "Poppins", sans-serif; color: #4a2511; }
        .product-card { background-color: white; border-radius: 0.75rem; border: 1px solid #f0e9e1; overflow: hidden; transition: all 0.3s ease-in-out; }
        .product-card:hover { transform: translateY(-8px); box-shadow: 0 15px 25px rgba(74, 37, 17, 0.08); }
        .buy-button { transition: all 0.3s ease; }
    </style>
</head>
<body class="bg-white">

     <nav
      class="bg-[#4a2511] flex justify-between items-center px-6 md:px-20 py-3 fixed w-full top-0 z-50 shadow-lg"
    >
      <a href="produk.php">
        <img src="https://res.cloudinary.com/dlhmvpmc8/image/upload/v1754056451/logo_iwztru.png" alt="Chocloud Logo" class="h-12 w-auto">
      </a>
      <ul class="hidden md:flex space-x-8 text-white text-sm font-light">
        <li>
          <a href="index.php" class="hover:text-[#f4c97a]">Home</a>
        </li>
        <li class="relative group py-4">
            <a href="tentang.php" class="hover:text-[#f4c97a] transition-colors inline-flex items-center gap-1.5">
                Tentang
                <i class="fas fa-chevron-down text-xs opacity-70"></i>
            </a>
            <ul class="absolute left-0 top-full w-48 bg-white text-gray-800 rounded-md shadow-lg py-1 hidden group-hover:block z-10">
                <li><a href="tentang.php#sejarah" class="block px-4 py-2 text-sm hover:bg-gray-100">Sejarah</a></li>
                <li><a href="tentang.php#visi-misi" class="block px-4 py-2 text-sm hover:bg-gray-100">Visi & Misi</a></li>
            </ul>
        </li>
        <li>
          <a href="informasi.php" class="hover:text-[#f4c97a] transition-colors"
            >Informasi</a
          >
        </li>
        <li>
          <a
            href="produk.php"
            class="text-[#f4c97a] font-semibold transition-colors"
            >Produk</a
          >
        </li>
      </ul>
      <div class="text-white text-2xl cursor-pointer md:hidden">
        <i class="fas fa-bars"></i>
      </div>
    </nav>

     <nav class="bg-[#4a2511] flex justify-between items-center px-6 md:px-20 py-3 fixed w-full top-0 z-50 shadow-lg">
        <a href="index.php">
            <img src="https://res.cloudinary.com/dlhmvpmc8/image/upload/v1754056451/logo_iwztru.png" alt="Chocloud Logo" class="h-12 w-auto">
        </a>
        
        <ul id="mobile-menu" class="hidden md:flex md:items-center md:space-x-8 text-white text-sm font-light">
            <li><a href="index.php" class="hover:text-[#f4c97a] transition-colors block py-2 md:py-0">Home</a></li>
            <li class="relative group py-4">
            <a href="tentang.php" class="hover:text-[#f4c97a] transition-colors inline-flex items-center gap-1.5">
                Tentang
                <i class="fas fa-chevron-down text-xs opacity-70"></i>
            </a>
            <ul class="absolute left-0 top-full w-48 bg-white text-gray-800 rounded-md shadow-lg py-1 hidden group-hover:block z-10">
                <li><a href="tentang.php#sejarah" class="block px-4 py-2 text-sm hover:bg-gray-100">Sejarah</a></li>
                <li><a href="tentang.php#visi-misi" class="block px-4 py-2 text-sm hover:bg-gray-100">Visi & Misi</a></li>
            </ul>
        </li>
            <li><a href="informasi.php" class="hover:text-[#f4c97a] transition-colors block py-2 md:py-0">Informasi</a></li>
            <li><a href="produk.php" class="text-[#f4c97a] font-semibold transition-colors block py-2 md:py-0">Produk</a></li>
        </ul>

        <div id="hamburger-btn" class="text-white text-2xl cursor-pointer md:hidden">
            <i class="fas fa-bars"></i>
        </div>
    </nav>

    <main>
      <section class="bg-[#f4c97a] pt-28 pb-16">
        <div class="container mx-auto px-6 md:px-20 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
          
          <div class="w-full">
            <a href="produk.php" class="inline-flex items-center gap-2 text-sm text-gray-700 font-medium mb-4 hover:text-[#4a2511] transition">
              <i class="fas fa-arrow-left"></i>
              Kembali ke Produk
            </a>
            
            <h1 class="font-extrabold text-4xl lg:text-6xl my-2 leading-none text-[#4a2511]"><?php echo htmlspecialchars($product['name']); ?></h1>
            
            <p class="text-gray-800 font-light leading-relaxed mt-4 mb-6 text-justify">
                <?php echo nl2br(htmlspecialchars($product['description'])); ?>
            </p>

            <p class="text-4xl font-bold text-[#4a2511] mb-8">Rp<?php echo number_format($product['price'], 0, ',', '.'); ?></p>
            
            <div>
              <p class="font-semibold mb-3 text-base">Pilih Opsi Pemesanan:</p>
              <div class="flex flex-col sm:flex-row gap-4">
                
                <a href="<?php echo htmlspecialchars($product['shopee_link']); ?>" target="_blank" 
                  class="flex-1 flex items-center justify-center gap-3 bg-[#4a2511] text-white font-bold py-3 px-6 rounded-lg hover:bg-opacity-90 transition-transform hover:scale-105 shadow-md">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span>Shopee</span>
                </a>
                
                  <?php
                    // Ambil link dasar WhatsApp dari database
                    $base_wa_link = $product['whatsapp_link'];
                    
                    // --- PERUBAHAN DI SINI ---
                    // Siapkan pesan dinamis dengan ID, Nama, dan Harga produk
                    $harga_formatted = "Rp" . number_format($product['price'], 0, ',', '.');
                    $pesan_wa = "Halo Chocloud, saya mau pesan produk di bawah ini:\n\n";
                    $pesan_wa .= "Produk: " . $product['name'] . "\n";
                    $pesan_wa .= "ID Produk: " . $product['id'] . "\n";
                    $pesan_wa .= "Harga (Paket): " . $harga_formatted . "\n\n"; // <-- BARIS INI DITAMBAHKAN
                    $pesan_wa .= "Mohon diisi data berikut:\n";
                    $pesan_wa .= "Nama Penerima: \n";
                    $pesan_wa .= "Alamat Lengkap: \n";
                    $pesan_wa .= "No. HP: \n";
                    $pesan_wa .= "Jumlah Pesanan: \n\n";
                    $pesan_wa .= "Terima kasih.";
                    
                    $pesan_wa_encoded = urlencode($pesan_wa);
                    
                    // Gabungkan link dasar dengan pesan
                    if (strpos($base_wa_link, '?') === false) {
                        $link_wa_final = $base_wa_link . "?text=" . $pesan_wa_encoded;
                    } else {
                        $link_wa_final = $base_wa_link . "&text=" . $pesan_wa_encoded;
                    }
                ?>
                
                
                <a href="<?php echo htmlspecialchars($link_wa_final); ?>" target="_blank" 
                  class="flex-1 flex items-center justify-center gap-3 bg-[#4a2511] text-white font-bold py-3 px-6 rounded-lg hover:bg-opacity-90 transition-transform hover:scale-105 shadow-md">
                    <i class="fab fa-whatsapp"></i>
                    <span>WhatsApp</span>
                </a>

              </div>
            </div>
          </div>

         <div class="w-full">
          <img alt="<?php echo htmlspecialchars($product['name']); ?>" 
          class="rounded-2xl object-cover w-full h-auto aspect-square shadow-2xl" 
          src="<?php echo htmlspecialchars($product['image']); ?>" />
        </div>

        </div>
      </section>

      <?php if (!empty($related_products)): ?>
      <section class="bg-white py-20">
        <div class="container mx-auto px-6 md:px-20">
          <h2 class="text-3xl font-bold text-center mb-10">Anda Mungkin Juga Suka</h2>
          <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
           <?php foreach ($related_products as $related): ?>
    <div class="product-card flex flex-col">
        <a href="detail-produk.php?id=<?php echo $related['id']; ?>">
            <img alt="<?php echo htmlspecialchars($related['name']); ?>" src="<?php echo htmlspecialchars($related['image']); ?>" class="w-full h-48 object-cover"/>
        </a>
        <div class="p-4 flex flex-col flex-grow">
            <h4 class="font-semibold text-base truncate flex-grow"><?php echo htmlspecialchars($related['name']); ?></h4>
            <div class="flex justify-between items-center mt-3">
                <p class="font-bold text-lg">Rp<?php echo number_format($related['price'], 0, ',', '.'); ?></p>
                <a href="detail-produk.php?id=<?php echo $related['id']; ?>" class="buy-button text-xs px-4 py-2 rounded-full border border-gray-300 hover:bg-[#4a2511] hover:text-white transition">
                    Lihat Detail
                </a>
            </div>
        </div>
    </div>
<?php endforeach; ?>
          </div>
        </div>
      </section>
      <?php endif; ?>
    </main>
    
<!-- Footer -->
<footer class="bg-[#4a2511] text-white/90 py-16 px-6 md:px-20 text-sm">
    <div class="container mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 text-center md:text-left">

            <div class="flex flex-col items-center md:items-start">
                <a href="index.php" class="inline-block mb-4">
                    <img src="https://res.cloudinary.com/dlhmvpmc8/image/upload/v1754056451/logo_iwztru.png" alt="Chocloud Logo" class="h-14 w-auto">
                </a>
                <p class="text-white/70 text-sm max-w-xs mx-auto md:mx-0 text-justify">
                    Camilan cokelat truffle premium yang menghadirkan kelembutan dalam setiap gigitan.
                </p>
            </div>

          <div class="flex flex-col items-center md:items-start">
                <h3 class="font-bold text-white text-lg mb-4">Hubungi Kami</h3>
                <div class="space-y-3 text-white/70 font-light flex flex-col items-center md:items-start">
                    <p>
                        <a href="https://maps.app.goo.gl/MJ8SPXcmZPActLzRA?g_st=aw" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors">
                            Jl. Teuku Umar No. 5, Lebakgede, Coblong, Kota Bandung, 40132
                        </a>
                    </p>
                    <a href="mailto:chocloudijah@gmail.com" class="inline-flex items-center justify-center md:justify-start gap-2 hover:text-white transition-colors">
                        <i class="fas fa-envelope fa-fw"></i>
                        <span>chocloudijah@gmail.com</span>
                    </a>
                    <a href="https://wa.me/628112292013" target="_blank" class="inline-flex items-center justify-center md:justify-start gap-2 hover:text-white transition-colors">
                        <i class="fas fa-phone-alt fa-fw"></i>
                        <span>08112292013</span>
                    </a>
                    <div class="flex space-x-4 text-xl justify-center md:justify-start">
                    <a href="https://www.facebook.com/share/16g2CgE538/" target="_blank" class="hover:text-white transition-colors"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://wa.me/628112292013" target="_blank" class="hover:text-white transition-colors"><i class="fab fa-whatsapp"></i></a>
                    <a href="https://www.instagram.com/chocloud_bynadi?igsh=bzVncmFjZHFibzN0" target="_blank" class="hover:text-white transition-colors"><i class="fab fa-instagram"></i></a>
                </div>
                </div>
            </div>

            <div>
                <h3 class="font-bold text-white text-lg mb-4">Socials</h3>
                <ul class="space-y-3 text-white/70 font-light mb-6">
                    <li><a href="https://wa.me/628112292013" target="_blank" class="hover:text-white transition-colors">Whatsapp</a></li>
                    <li><a href="https://www.instagram.com/chocloud_bynadi?igsh=bzVncmFjZHFibzN0" target="_blank" class="hover:text-white transition-colors">Instagram</a></li>
                    <li><a href="https://www.tiktok.com/@chocloud_bynadi?_t=ZS-8yVzkcPkh4E&_r=1" target="_blank" class="hover:text-white transition-colors">Tiktok</a></li>
                    <li><a href="https://www.facebook.com/share/16g2CgE538/" target="_blank" class="hover:text-white transition-colors">Facebook</a></li>
                </ul>
            </div>

        </div>

       <div class="text-center text-xs mt-16 border-t border-white/20 pt-8 text-white/60">
            <p>
                <span>© <?php echo date("Y"); ?> Chocloud by Nadi. All rights reserved.</span>
                <span class="mx-2 hidden sm:inline">|</span>
                <a href="privacy-policy.php" class="hover:text-white transition-colors block sm:inline mt-2 sm:mt-0">Privacy Policy</a>
                <span class="mx-2 hidden sm:inline">|</span>
                <a href="terms.php" class="hover:text-white transition-colors block sm:inline mt-2 sm:mt-0">Terms & Conditions</a>
            </p>
        </div>
    </div>
</footer>

</body>
</html>
<?php
$stmt->close();
if (isset($stmt_related) && $stmt_related) {
    $stmt_related->close();
}
$koneksi->close();
?>