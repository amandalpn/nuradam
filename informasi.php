<?php
// 1. Panggil file koneksi.php
require_once 'koneksi.php';

// Menampilkan semua error untuk kemudahan debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Mengambil daftar produk untuk ditampilkan di form
$products = [];
$sql_products = "SELECT id, name FROM products ORDER BY name ASC";
$hasil_products = $koneksi->query($sql_products);
if ($hasil_products && $hasil_products->num_rows > 0) {
    while($product_row = $hasil_products->fetch_assoc()) {
        $products[] = $product_row;
    }
}

// Memisahkan testimoni teks dan video dari database
$text_testimonials = [];
$video_testimonials = [];
$sql_testimonials = "SELECT customer_name, content, video_url FROM testimonials WHERE status = 'approved' ORDER BY id DESC";
$hasil_testimonials = $koneksi->query($sql_testimonials);

if ($hasil_testimonials === false) {
    die("Error pada query testimoni: " . $koneksi->error);
}

if ($hasil_testimonials->num_rows > 0) {
    while($row = $hasil_testimonials->fetch_assoc()) {
        if (!empty(trim($row['content']))) {
            $text_testimonials[] = $row;
        }
        if (!empty(trim($row['video_url']))) {
            $video_testimonials[] = $row;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Chocloud Informasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <style>
        body { font-family: "Poppins", sans-serif; background-color: #F8F5F1;}
         .swiper-pagination-bullet-active { background-color: #4a2511 !important; }
        
        .swiper-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1.5rem; /* 24px */
        }
        .swiper-nav-buttons {
            display: flex;
            gap: 0.75rem; /* 12px */
        }
        .swiper-button-next, .swiper-button-prev {
            position: static;
            width: 44px;
            height: 44px;
            margin: 0;
            background-color: white;
            border-radius: 9999px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            color: #4a2511;
            transition: all 0.2s;
        }
         .swiper-button-next:hover, .swiper-button-prev:hover {
            background-color: #4a2511;
            color: white;
        }
        .swiper-button-next:after, .swiper-button-prev:after {
            font-size: 16px;
            font-weight: bold;
        }
        .swiper-pagination {
            position: static;
            width: auto;
        }

        .video-slide-content { position: relative; width: 100%; padding-top: 177.77%; }
        .video-slide-content video { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; }

        #testimonial-form-container {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.7s ease-in-out, margin-top 0.7s ease-in-out;
        }
    </style>
</head>
<body class="text-[#3E1E00] flex flex-col min-h-screen">
  
    <nav class="bg-[#4a2511] flex justify-between items-center px-6 md:px-20 py-3 fixed w-full top-0 z-50 shadow-lg">
        <a href="index.php">
            <img src="https://res.cloudinary.com/dlhmvpmc8/image/upload/v1754056451/logo_iwztru.png" alt="Chocloud Logo" class="h-12 w-auto">
        </a>
        <ul class="hidden md:flex space-x-8 text-white text-sm font-light items-center">
            <li><a href="index.php" class="hover:text-[#f4c97a] transition-colors">Home</a></li>
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
            <li><a href="informasi.php" class="text-[#f4c97a] font-semibold">Informasi</a></li>
            <li><a href="produk.php" class="hover:text-[#f4c97a] transition-colors">Produk</a></li>
        </ul>
        <div class="text-white text-2xl cursor-pointer md:hidden"><i class="fas fa-bars"></i></div>
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
            <li><a href="informasi.php" class="text-[#f4c97a] font-semibold transition-colors block py-2 md:py-0">Informasi</a></li>
            <li><a href="produk.php" class="hover:text-[#f4c97a] transition-colors block py-2 md:py-0">Produk</a></li>
        </ul>

        <div id="hamburger-btn" class="text-white text-2xl cursor-pointer md:hidden">
            <i class="fas fa-bars"></i>
        </div>
    </nav>
    
   <main class="flex-grow">
        <section id="informasi" class="relative bg-[#f4c97a] min-h-[50vh] md:min-h-[70vh] flex items-center">
            <div class="absolute top-0 right-0 h-full w-full md:w-3/5 lg:w-2/3">
                <img src="https://res.cloudinary.com/dlhmvpmc8/image/upload/v1753985852/Hero_image_sckm4a.jpg" alt="Suasana Chocloud" class="w-full h-full object-cover">
                <div class="absolute top-0 left-0 h-full w-[50%] bg-gradient-to-r from-[#f4c97a] via-[#f4c97a]/40 to-transparent"></div>
            </div>

            <div class="container mx-auto px-6 md:px-20 relative z-10 pt-20">
                <div class="md:w-2/5 lg:w-1/3 text-center md:text-left">
                    <h1 class="font-extrabold text-5xl lg:text-6xl leading-tight my-4 text-brand-darkbrown">
                        INFORMASI
                    </h1>
                    <p class="text-base text-brand-darkbrown max-w-lg mb-8 mx-auto md:mx-0 text-justify">
                        Chocloud by Nadi telah mendapatkan ribuan ulasan positif dari pelanggan setia dan para influencer ternama. Dengan rating rata-rata 4.9 dari 5 bintang, produk cokelat truffle kami dikenal karena rasanya yang lembut, tampilan kemasannya elegan, dan pengalaman gifting yang berkesan. Dipercaya untuk momen spesial dari hadiah ulang tahun, hampers lebaran, hingga kejutan untuk orang tersayang Chocloud bukan sekadar camilan, tapi wujud perhatian yang manis. Baca langsung apa kata mereka, dan temukan kenapa Chocloud jadi pilihan banyak orang!
                    </p>
                </div>
            </div>
        </section>

             <section class="py-20 bg-white">
            <div class="container mx-auto px-6 md:px-20">
                <div class="text-center mb-12">
                    <h2 class="font-bold text-3xl sm:text-4xl mb-2">Kata Mereka</h2>
                    <p class="text-sm text-gray-600 max-w-md mx-auto">Bagaimana tanggapan Chocloud by Nadi menurut pelanggan:</p>
                </div>
            
                <?php if (!empty($text_testimonials)): ?>
                <div class="swiper text-swiper mb-16">
                    <div class="swiper-wrapper">
                        <?php foreach ($text_testimonials as $testi): ?>
                        <div class="swiper-slide h-auto">
                            <div class="bg-[#F2C87C] rounded-2xl p-8 flex flex-col shadow-lg h-full">
                                <div class="flex items-center mb-4">
                                    <div class="w-12 h-12 rounded-full bg-white mr-4 flex-shrink-0 flex items-center justify-center text-[#4a2511]/50">
                                        <i class="fas fa-user text-xl"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-semibold leading-tight text-lg"><?php echo htmlspecialchars($testi['customer_name']); ?></p>
                                        <p class="text-sm font-light">Bandung, Jawa Barat</p>
                                    </div>
                                </div>
                                <p class="text-base font-normal leading-relaxed text-gray-800 mt-2 flex-grow">"<?php echo nl2br(htmlspecialchars($testi['content'])); ?>"</p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="swiper-controls">
                        <div class="swiper-pagination"></div>
                        <div class="swiper-nav-buttons">
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <?php if (!empty($video_testimonials)): ?>
                <div class="swiper video-swiper mt-16">
                     <div class="swiper-wrapper">
                        <?php foreach ($video_testimonials as $testi): ?>
                            <div class="swiper-slide">
                                <div class="video-slide-content rounded-xl overflow-hidden bg-black shadow-2xl">
                                    <video src="<?php echo htmlspecialchars(trim($testi['video_url'])); ?>" loop controls playsinline></video>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="swiper-controls">
                        <div class="swiper-pagination"></div>
                        <div class="swiper-nav-buttons">
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </section>

       <section class="bg-white py-20">
            <div class="container mx-auto px-6 md:px-20">
                <div class="text-center max-w-xl mx-auto">
                    <h3 class="text-3xl font-bold mb-4">Bagikan Pendapat Anda</h3>
                    <p class="text-gray-600 mb-8">Ulasan Anda sangat berarti bagi kami untuk terus memberikan yang terbaik.</p>
                    
                    <div id="form-button-container">
                        <button id="show-form-btn" class="bg-[#4a2511] text-white py-3 px-8 rounded-lg font-semibold hover:bg-opacity-90 transition-all duration-300 shadow-md hover:shadow-lg">
                            Tulis Ulasan Anda
                        </button>
                    </div>
                </div>

                <div id="testimonial-form-container">
                    <form action="proses_testimoni.php" method="POST" class="space-y-5 p-8 bg-gray-50 rounded-lg shadow-lg border border-gray-200">
                        <div>
                            <label for="product_id" class="font-semibold block mb-2 text-sm">Pilih Produk yang Diulas</label>
                            <select name="product_id" id="product_id" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#f4c97a]" required>
                                <option value="" disabled selected>-- Pilih Produk --</option>
                                <?php foreach ($products as $product): ?>
                                    <option value="<?php echo $product['id']; ?>"><?php echo htmlspecialchars($product['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label for="nama" class="font-semibold block mb-2 text-sm">Nama Anda</label>
                            <input type="text" id="nama" name="customer_name" placeholder="Contoh: Budi" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#f4c97a]" required />
                        </div>
                        <div>
                            <label for="ulasan" class="font-semibold block mb-2 text-sm">Ulasan Anda</label>
                            <textarea id="ulasan" name="content" rows="5" placeholder="Tulis pengalaman Anda dengan produk Chocloud..." class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#f4c97a]"></textarea>
                        </div>
                        <div>
                            <label for="link_video" class="font-semibold block mb-2 text-sm">Link Video Testimoni (Opsional)</label>
                            <input type="url" id="link_video" name="video_url" placeholder="Contoh: https://instagram.com/..." class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#f4c97a]" />
                        </div>
                        <button type="submit" class="bg-[#4a2511] text-white w-full py-3 rounded-lg font-semibold hover:bg-opacity-90 transition-colors">Kirim Ulasan</button>
                    </form>
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

        // --- Inisialisasi Slider untuk Testimoni Teks ---
        if (document.querySelector('.text-swiper')) {
            const textSwiper = new Swiper('.text-swiper', {
                loop: true,
                slidesPerView: 1,
                spaceBetween: 24,
                pagination: { el: '.text-swiper .swiper-pagination', clickable: true, },
                navigation: { nextEl: '.text-swiper .swiper-button-next', prevEl: '.text-swiper .swiper-button-prev', },
                breakpoints: { 768: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } }
            });
        }

        // --- Inisialisasi Slider untuk Testimoni Video ---
        if (document.querySelector('.video-swiper')) {
            const videoSwiper = new Swiper('.video-swiper', {
                loop: true,
                slidesPerView: 1.2,
                centeredSlides: true,
                spaceBetween: 16,
                pagination: { el: '.video-swiper .swiper-pagination', clickable: true, },
                navigation: { nextEl: '.video-swiper .swiper-button-next', prevEl: '.video-swiper .swiper-button-prev', },
                breakpoints: {
                    768: { slidesPerView: 2, centeredSlides: false, spaceBetween: 24 },
                    1024: { slidesPerView: 2.5, centeredSlides: true, spaceBetween: 30 }
                },
                on: {
                    slideChange: function () {
                        this.slides.forEach(slide => {
                            const video = slide.querySelector('video');
                            if (video && !video.paused) { video.pause(); }
                        });
                    }
                }
            });
        }

         // --- Script untuk Menampilkan Form Testimoni ---
        const showFormBtn = document.getElementById('show-form-btn');
        const formContainer = document.getElementById('testimonial-form-container');
        // PERBAIKAN: Kita hanya menargetkan kontainer tombolnya saja
        const formButtonContainer = document.getElementById('form-button-container');

        if (showFormBtn && formContainer && formButtonContainer) {
            showFormBtn.addEventListener('click', () => {
                // Sembunyikan HANYA kontainer tombol
                formButtonContainer.style.transition = 'opacity 0.5s';
                formButtonContainer.style.opacity = '0';
                setTimeout(() => {
                    formButtonContainer.style.display = 'none';
                }, 500);

                // Tampilkan form dengan animasi
                formContainer.style.marginTop = '2rem';
                formContainer.style.maxHeight = formContainer.scrollHeight + 'px';
            });
        }

    });
    </script>
</body>
</html>