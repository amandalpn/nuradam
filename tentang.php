<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tentang Chocloud</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" /> <style>
        body { font-family: "Poppins", sans-serif; color: #4a2511; background-color: #F8F5F1;}
        .accordion-content { max-height: 0; opacity: 0; overflow: hidden; transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1); }
        .accordion-item.active .accordion-header i { transform: rotate(180deg); }
    </style>
</head>
  <body class="bg-[#f4c97a] text-[#4a2511]">
    <!-- Navbar -->
    <nav
      class="bg-[#4a2511] flex justify-between items-center px-6 md:px-20 py-3 fixed w-full top-0 z-50 shadow-lg"
    >
      <a href="tentang.php">
        <img src="https://res.cloudinary.com/dlhmvpmc8/image/upload/v1754056451/logo_iwztru.png" alt="Chocloud Logo" class="h-12 w-auto">
      </a>
      <ul
        class="hidden md:flex space-x-8 text-white text-sm font-light items-center"
      >
        <li>
          <a
            href="index.php"
            class="hover:text-[#f4c97a] transition-colors"
            >Home</a
          >
        </li>
        <li class="relative group">
    <a href="tentang.php" class="text-[#f4c97a] font-semibold transition-colors inline-flex items-center gap-1.5">
        Tentang
        <i class="fas fa-chevron-down text-xs opacity-70"></i>
    </a>
    
    <ul class="absolute left-0 mt-2 w-48 bg-white text-gray-800 rounded-md shadow-lg py-1 hidden group-hover:block z-10">
        <li>
            <a href="tentang.php#sejarah" class="block px-4 py-2 text-sm hover:bg-gray-100">Sejarah</a>
        </li>
        <li>
            <a href="tentang.php#visi-misi" class="block px-4 py-2 text-sm hover:bg-gray-100">Visi & Misi</a>
        </li>
    </ul>
</li>
        <li>
          <a href="informasi.php" class="hover:text-[#f4c97a] transition-colors"
            >Informasi</a
          >
        </li>
        <li>
          <a href="produk.php" class="hover:text-[#f4c97a] transition-colors"
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
            <a href="tentang.php" class="text-[#f4c97a] font-semibold transition-colors inline-flex items-center gap-1.5">
                Tentang
                <i class="fas fa-chevron-down text-xs opacity-70"></i>
            </a>
            <ul class="absolute left-0 top-full w-48 bg-white text-gray-800 rounded-md shadow-lg py-1 hidden group-hover:block z-10">
                <li><a href="tentang.php#sejarah" class="block px-4 py-2 text-sm hover:bg-gray-100">Sejarah</a></li>
                <li><a href="tentang.php#visi-misi" class="block px-4 py-2 text-sm hover:bg-gray-100">Visi & Misi</a></li>
            </ul>
        </li>
            <li><a href="informasi.php" class="hover:text-[#f4c97a] transition-colors block py-2 md:py-0">Informasi</a></li>
            <li><a href="produk.php" class="hover:text-[#f4c97a] transition-colors block py-2 md:py-0">Produk</a></li>
        </ul>

        <div id="hamburger-btn" class="text-white text-2xl cursor-pointer md:hidden">
            <i class="fas fa-bars"></i>
        </div>
    </nav>
    <!-- Hero Section -->
    <section id="hero-tentang" class="relative bg-[#f4c97a] min-h-[50vh] md:min-h-[70vh] flex items-center">
    <div class="absolute top-0 right-0 h-full w-full md:w-3/5 lg:w-2/3">
        <img src="https://res.cloudinary.com/dlhmvpmc8/image/upload/v1753985878/Hero_image_eyuhae.jpg" alt="tentang chocolate truffle" class="w-full h-full object-cover">
        <div class="absolute top-0 left-0 h-full w-[50%] bg-gradient-to-r from-[#f4c97a] via-[#f4c97a]/40 to-transparent"></div>
    </div>

    <div class="container mx-auto px-6 md:px-20 relative z-10 pt-20">
        <div class="md:w-2/5 lg:w-1/3 text-center md:text-left">
            <h1 class="font-extrabold text-5xl lg:text-6xl leading-tight my-4 text-brand-darkbrown">
                TENTANG
            </h1>
            <p class="text-base text-brand-darkbrown max-w-lg mb-8 mx-auto md:mx-0 text-justify">
               Chocloud by Nadi adalah alasan sederhana di balik senyum yang dibawa saat datang maupun pulang. Temukan cerita di balik setiap gigitan manis kami. Setiap Truffle punya cerita. Temukan bagaimana Chocloud by Nadi bermula dan ke mana kami ingin melangkah. Jelajahi sejarah dan visi misi kami di sini.
            </p>
        </div>
    </div>
</section>
    <!-- Tentang Section -->
    <section id="sejarah" class="py-20 bg-white">
      <div class="container mx-auto px-6 md:px-20">
        <!-- <h2 class="text-[#4a2511] font-extrabold text-4xl text-center mb-12">
          TENTANG
        </h2> -->
        <div class="flex flex-col md:flex-row md:items-center md:space-x-10">
          <div class="md:w-1/2 mb-8 md:mb-0">
            <img
              alt="Close up photo of a Chocloud chocolate box on a table with blurred background"
              class="rounded-tl-3xl rounded-br-3xl object-cover w-full max-h-[300px]"
              height="300"
              src="https://res.cloudinary.com/dlhmvpmc8/image/upload/v1753985879/Tentang_oq4nhb.jpg"
              width="400"
            />
          </div>
          <div class="md:w-3/5">
            <h2 class="font-extrabold text-4xl mb-4">SEJARAH</h2>
            <p class="text-sm font-light leading-relaxed text-justify">
              Chocloud by Nadi adalah bisnis camilan cokelat trufe yang
              didirikan oleh Liza Susanto pada tahun 2020 di Bandung. Ide awal
              bisnis ini muncul secara tidak sengaja dari tugas sekolah anaknya,
              Nadi, seorang siswa kelas 4 sd dalam masa pelajaran kewirausahaan
              selama pandemi yang kemudian menjadi inspirasi nama merek
              tersebut. Awalnya, Liza memproduksi cokelat trufe varian Classic
              di dapurnya rumah. Seiring waktu, bisnisnya berkembang pesat, dan
              ia mulai bermovasi dengan menambahkan varian rasa baru. Salah
              satunya adalah kolaborasi dengan Nestle untuk menghadirkan varian
              rasa KitKat. Saat ini, produk Chocloud by Nadi tersedia dalam
              berbagai varian rasa dan ukuran, yaitu Chocloud Classic, Chocloud
              Almond, Chocloud mix match, Chocloud Almix, dan Chocloud Bisco.
              Harga produk berkisar antara Rp38.000 hingga Rp140.000, tergantung
              varian dan ukuran yang dipilih. Produk-produk Chocloud by Nadi
              telah dipasarkan melalui media sosial dan berbagai platform
              digital, menjangkau pelanggan dari berbagai daerah di Indonesia.
              Dengan cita rasa premium dan tampilan kemasan yang menarik,
              Chocloud by Nadi berhasil menjadi salah satu camilan cokelat
              favorit yang cocok dinikmati sendiri maupun dijadikan hadiah.
            </p>
          </div>
        </div>
      </div>
    </section>
    <!-- Visi & Misi Section -->
      <section id="visi-misi" class="bg-[#4a2511] py-20">
          <div class="container mx-auto px-6 md:px-20 flex flex-col md:flex-row md:space-x-10">
            
            <div class="md:w-1/2 mb-8 md:mb-0 accordion-item">
              <div class="bg-[#f4c97a] rounded-xl shadow-lg">
                <button class="accordion-header w-full flex justify-between items-center text-left p-6 cursor-pointer">
                  <h3 class="font-bold text-2xl text-[#4a2511]">VISI</h3>
                  <div class="text-xl">
                      <!-- <i class="fas fa-plus icon-plus"></i>
                      <i class="fas fa-minus icon-minus"></i> -->
                      <i class="fas fa-chevron-down text-xl transition-transform duration-500"></i>
                  </div>
                </button>
                <div class="accordion-content">
                  <div class="px-6 pt-0 pb-6 text-base font-light text-gray-800">
                    <p class="leading-relaxed text-justify border-t border-yellow-700/20 pt-4">
                      Menjadi brand cokelat truffle lokal yang paling dicintai di Indonesia, dikenal karena kualitas premium, keunikan rasa, dan pengalaman gifting yang personal dan berkesan.
                    </p>
                  </div>
                </div>
              </div>
            </div>

            <div class="md:w-1/2 accordion-item">
              <div class="bg-[#f4c97a] rounded-xl shadow-lg">
                <button class="accordion-header w-full flex justify-between items-center text-left p-6 cursor-pointer">
                  <h3 class="font-bold text-2xl text-[#4a2511]">MISI</h3>
                  <div class="text-xl">
                      <!-- <i class="fas fa-plus icon-plus"></i>
                      <i class="fas fa-minus icon-minus"></i> -->
                      <i class="fas fa-chevron-down text-xl transition-transform duration-500"></i>
                  </div>
                </button>
                <div class="accordion-content">
                   <div class="px-6 pt-0 pb-6 text-base font-light text-gray-800">
                    <ol class="list-decimal list-inside space-y-2 leading-relaxed text-justify border-t border-yellow-700/20 pt-4">
                      <li>Menyajikan produk cokelat truffle premium dengan citarasa khas dan bahan pilihan berkualitas tinggi.</li>
                      <li>Menghadirkan pengalaman gifting yang bermakna, personal, dan menyenangkan untuk setiap momen spesial.</li>
                      <li>Berinovasi dalam varian rasa dan kemasan agar selalu relevan dengan tren dan kebutuhan konsumen muda maupun dewasa.</li>
                    </ol>
                   </div>
                </div>
              </div>
            </div>

          </div>
        </section>
    <div class="h-16 md:h-20 bg-white"></div>
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
        const accordionItems = document.querySelectorAll('.accordion-item');

        accordionItems.forEach(item => {
          const header = item.querySelector('.accordion-header');
          const content = item.querySelector('.accordion-content');

          header.addEventListener('click', () => {
            const isActive = item.classList.contains('active');

            // Tutup semua accordion lain
            accordionItems.forEach(otherItem => {
              if (otherItem !== item) {
                otherItem.classList.remove('active');
                otherItem.querySelector('.accordion-content').style.maxHeight = null;
                otherItem.querySelector('.accordion-content').style.opacity = '0';
              }
            });

            // Buka atau tutup accordion yang diklik
            if (isActive) {
              item.classList.remove('active');
              content.style.maxHeight = null;
              content.style.opacity = '0';
            } else {
              item.classList.add('active');
              content.style.maxHeight = content.scrollHeight + 'px';
              content.style.opacity = '1';
            }
          });
        });
      });
    </script>

    <script>
        // Pilih elemen yang dibutuhkan
        const hamburgerBtn = document.getElementById('hamburger-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const hamburgerIcon = hamburgerBtn.querySelector('i');

        // Tambahkan event listener untuk 'click'
        hamburgerBtn.addEventListener('click', () => {
            // Cek apakah menu sedang disembunyikan
            const isMenuHidden = mobileMenu.classList.contains('hidden');

            if (isMenuHidden) {
                // TAMPILKAN MENU
                mobileMenu.classList.remove('hidden');
                // Tambahkan kelas untuk tampilan mobile
                mobileMenu.classList.add('absolute', 'top-full', 'left-0', 'w-full', 'bg-[#4a2511]', 'flex', 'flex-col', 'items-center', 'space-y-4', 'py-4');
                // Hapus kelas desktop yang tidak perlu
                mobileMenu.classList.remove('md:flex', 'md:space-x-8');
                
                // Ganti ikon menjadi 'xmark'
                hamburgerIcon.classList.remove('fa-bars');
                hamburgerIcon.classList.add('fa-xmark');
            } else {
                // SEMBUNYIKAN MENU
                mobileMenu.classList.add('hidden');
                // Hapus kelas tampilan mobile
                mobileMenu.classList.remove('absolute', 'top-full', 'left-0', 'w-full', 'bg-[#4a2511]', 'flex', 'flex-col', 'items-center', 'space-y-4', 'py-4');
                // Tambahkan kembali kelas desktop
                mobileMenu.classList.add('md:flex', 'md:space-x-8');

                // Ganti ikon menjadi 'bars'
                hamburgerIcon.classList.remove('fa-xmark');
                hamburgerIcon.classList.add('fa-bars');
            }
        });
    </script>
  </body>
</html>
