<?php
require_once 'koneksi.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// 1. Ambil semua kategori dari database untuk membuat tombol filter
$categories = [];
$sql_categories = "SELECT name, LOWER(name) AS slug FROM categories ORDER BY id";
$hasil_categories = $koneksi->query($sql_categories);
if ($hasil_categories && $hasil_categories->num_rows > 0) {
    while($row = $hasil_categories->fetch_assoc()) {
        $categories[] = $row;
    }
}

$products = [];
$sql_products = "
    SELECT 
        p.id, 
        p.name, 
        p.price, 
        p.image, 
        LOWER(c.name) AS category_slug 
    FROM 
        products p 
    JOIN 
        categories c ON p.category_id = c.id 
    ORDER BY 
        p.created_at DESC"; // LIMIT 8 dihapus dari sini

$hasil_products = $koneksi->query($sql_products);

if ($hasil_products === false) {
    die("Gagal mengambil data produk: " . $koneksi->error);
}
if ($hasil_products->num_rows > 0) {
    while($row = $hasil_products->fetch_assoc()) {
        $products[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Chocloud - Varian Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <style>
      html {
        scroll-behavior: smooth;
      }
      body {
        font-family: "Poppins", sans-serif;
        background-color: #fdf8f2; /* Latar utama yang lembut */
        color: #4a2511;
      }
      #filterTabs li.active {
        color: #4a2511;
        border-bottom: 2px solid #4a2511;
      }
      /* Desain kartu produk yang lebih modern */
      .product-card {
        background-color: white;
        border-radius: 0.75rem; /* rounded-xl */
        border: 1px solid #f0e9e1;
        overflow: hidden;
        transition: all 0.3s ease-in-out;
      }
      .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 25px rgba(0, 0, 0, 0.08);
      }
      .product-card img {
        width: 100%;
        height: 14rem; /* 224px, lebih tinggi agar proporsional */
        object-fit: cover;
      }
      /* Tombol Beli yang lebih profesional */
      .buy-button {
        background-color: transparent;
        color: #4a2511;
        border: 1px solid #c9b49b;
        transition: all 0.3s ease;
        font-weight: 500;
      }
      .buy-button:hover {
        background-color: #4a2511;
        color: white;
        border-color: #4a2511;
      }

       
        /* Penyesuaian agar script tailwind mengenali warna custom */
        .bg-brand-cream { background-color: #f4c97a; }
        .bg-brand-ivory { background-color: #F8F5F1; }
        .bg-brand-darkbrown { background-color: #3D2314; }
        .text-brand-darkbrown { color: #3D2314; }
        .btn-dark { background-color: #3D2314; color: white; }
        .btn-dark:hover { background-color: #2a150b; }
        
              /* CSS untuk kontrol Swiper.js */
        .swiper-pagination-bullet-active { background-color: #4a2511 !important; }
        .swiper-controls { display: flex; justify-content: space-between; align-items: center; margin-top: 2rem; }
        .swiper-nav-buttons { display: flex; gap: 0.75rem; }
        .swiper-button-next, .swiper-button-prev { position: static; width: 44px; height: 44px; margin: 0; background-color: white; border-radius: 9999px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); color: #4a2511; transition: all 0.2s; }
        .swiper-button-next:hover, .swiper-button-prev:hover { background-color: #4a2511; color: white; }
        .swiper-button-next:after, .swiper-button-prev:after { font-size: 16px; font-weight: bold; }
        .swiper-pagination { position: static; width: auto; }
        /* Memastikan slide mengisi grid dengan benar */
        .swiper-slide { height: auto; display: flex; }    
         /* Kelas untuk menyembunyikan slide yang difilter */
        /* .swiper-slide-filtered { display: none !important; } */
      </style>
  </head>
  <body class="bg-[#fdf6ee]">
    <!-- Navbar -->
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
    <section class="relative bg-brand-cream min-h-[50vh] lg:min-h-[70vh] flex items-center">
        <div class="absolute top-0 right-0 h-full w-full md:w-3/5 lg:w-2/3">
            <img src="https://res.cloudinary.com/dlhmvpmc8/image/upload/v1753985870/Hero_image_quw34m.jpg" alt="chocolate truffle" class="w-full h-full object-cover">
                <div class="absolute top-0 left-0 h-full w-[50%] bg-gradient-to-r from-[#f4c97a] via-[#f4c97a]/40 to-transparent"></div>
        </div>

        <div class="container mx-auto px-6 md:px-20 relative z-10 pt-20">
    <div class="md:w-2/5 lg:w-1/3 text-center md:text-left">
        <h1 class="font-extrabold text-5xl lg:text-6xl leading-tight my-4 text-brand-darkbrown">
            DAFTAR<br />VARIAN
          </h1>
          <p class="text-base text-brand-darkbrown max-w-lg mb-8 mx-auto md:mx-0 text-justify">
            Temukan kelezatan cokelat truffle premium kami. Dibuat dengan cinta
            dan bahan-bahan terbaik untuk setiap momen berharga Anda. Choclab
            merupakan chocolate brand yang pertama di kota Solo dengan produk
            homemade dan authentic premium. Setiap varian yang kami produksi dan
            jual selalu mengutamakan kualitas dan rasa yang sangat nikmat.
            Produk yang kami punya dibuat secara handmade dengan tanpa bahan
            pengawet atau bahan tambahan lainnya.
          </p>
    </div>
</div>
    </section>
    <main class="pt-20">
      <section id="produk">
        <div class="container mx-auto px-6 md:px-20">
          <h2 class="text-3xl lg:text-4xl font-bold text-center mb-3">Produk Pilihan Kami</h2>
          <p class="text-center text-sm text-gray-500 max-w-xl mx-auto mb-12">"Setiap varian dibuat secara handmade dengan bahan berkualitas terbaik untuk menjaga keaslian rasa."</p>
          
          <ul id="filterTabs" class="flex justify-center space-x-8 md:space-x-12 text-gray-500 font-medium border-b mb-12 text-md cursor-pointer">
              <li data-filter="all" class="active pb-3">Semua</li>
              <?php foreach ($categories as $category): ?>
                  <li data-filter="<?php echo $category['slug']; ?>" class="pb-3"><?php echo htmlspecialchars($category['name']); ?></li>
              <?php endforeach; ?>
          </ul>
          
 <div class="swiper product-swiper">
            <div class="swiper-wrapper">
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <div class="swiper-slide h-auto pb-12" data-category="<?php echo $product['category_slug']; ?>">
                            <div class="product-card h-full w-full shadow-lg">
                                <a href="detail-produk.php?id=<?php echo $product['id']; ?>">
                                    <img alt="<?php echo htmlspecialchars($product['name']); ?>" src="<?php echo htmlspecialchars($product['image']); ?>" class="w-full h-56 object-cover" />
                                </a>
                                <div class="p-5 flex flex-col flex-grow">
                                    <h4 class="font-semibold text-lg flex-grow"><?php echo htmlspecialchars($product['name']); ?></h4>
                                    <div class="flex justify-between items-center mt-3">
                                        <p class="font-bold text-xl">Rp<?php echo number_format($product['price'], 0, ',', '.'); ?></p>
                                        <a href="detail-produk.php?id=<?php echo $product['id']; ?>" class="buy-button text-xs px-4 py-2 rounded-full">Lihat Detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="w-full text-center text-gray-500">Produk belum tersedia.</div>
                <?php endif; ?>
            </div>

            <div class="swiper-controls">
                <div class="swiper-pagination"></div>
                <div class="swiper-nav-buttons">
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
          </div>
        </div>
      </section>
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

  <script>
    document.addEventListener('DOMContentLoaded', function () {
        // --- Script untuk Menu Hamburger Mobile ---
        const hamburgerBtn = document.getElementById('hamburger-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const hamburgerIcon = hamburgerBtn.querySelector('i');

        hamburgerBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            if (mobileMenu.classList.contains('hidden')) {
                hamburgerIcon.classList.remove('fa-xmark');
                hamburgerIcon.classList.add('fa-bars');
            } else {
                hamburgerIcon.classList.remove('fa-bars');
                hamburgerIcon.classList.add('fa-xmark');
            }
        });

         // --- Inisialisasi Slider Produk dengan Grid 2 Baris ---
         const productSwiper = new Swiper('.product-swiper', {
            slidesPerView: 2,
            slidesPerGroup: 2,
            grid: { rows: 2, fill: 'row' },
            spaceBetween: 16,
            pagination: { el: '.product-swiper .swiper-pagination', clickable: true },
            navigation: { nextEl: '.product-swiper .swiper-button-next', prevEl: '.product-swiper .swiper-button-prev' },
            breakpoints: {
                768: { slidesPerView: 3, slidesPerGroup: 3, spaceBetween: 24, grid: { rows: 2, fill: 'row' } },
                1024: { slidesPerView: 4, slidesPerGroup: 4, spaceBetween: 32, grid: { rows: 2, fill: 'row' } }
            },
            // Tambahkan observer untuk menangani perubahan pada slide
            observer: true,
            observeParents: true,
        });

        // --- Script untuk Filter Produk yang Lebih Cerdas ---
        const tabs = document.querySelectorAll("#filterTabs li");
        
        tabs.forEach((tab) => {
            tab.addEventListener("click", () => {
                tabs.forEach((t) => t.classList.remove("active"));
                tab.classList.add("active");
                const filterValue = tab.getAttribute("data-filter");

                let visibleSlidesCount = 0;
                
                // Tampilkan/Sembunyikan slide yang sesuai
                productSwiper.slides.forEach((slide) => {
                    const slideCategory = slide.getAttribute("data-category");
                    if (filterValue === "all" || filterValue === slideCategory) {
                        slide.style.display = 'flex'; // Gunakan flex agar layout card tidak rusak
                        visibleSlidesCount++;
                    } else {
                        slide.style.display = 'none';
                    }
                });

                const slidesPerView = productSwiper.params.breakpoints[1024].slidesPerView || 4;
                
                // Atur ulang mode grid secara dinamis
                if (visibleSlidesCount <= slidesPerView) {
                    productSwiper.params.grid.rows = 1;
                } else {
                    productSwiper.params.grid.rows = 2;
                }
                
                // Perbarui Swiper agar mengenali perubahan struktur dan slide
                productSwiper.update();
            });
        });
    });
    </script>
  </body>
</html>
<?php
// Tutup koneksi setelah halaman selesai dimuat
$koneksi->close();
?>