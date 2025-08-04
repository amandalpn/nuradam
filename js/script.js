// document.addEventListener("DOMContentLoaded", () => {
//   const filterTabs = document.querySelectorAll("#filterTabs li");
//   const productGrid = document.querySelectorAll("#productGrid > div");

//   filterTabs.forEach((tab) => {
//     tab.addEventListener("click", () => {
//       // Hapus kelas 'active' dari semua tab
//       filterTabs.forEach((t) => t.classList.remove("active"));
//       // Tambahkan kelas 'active' ke tab yang diklik
//       tab.classList.add("active");

//       const filterValue = tab.getAttribute("data-filter");

//       // Tampilkan atau sembunyikan produk berdasarkan filter
//       productGrid.forEach((product) => {
//         const productCategory = product.getAttribute("data-category");

//         if (filterValue === "all" || filterValue === productCategory) {
//           product.style.display = "block";
//         } else {
//           product.style.display = "none";
//         }
//       });
//     });
//   });
// });

document.addEventListener("DOMContentLoaded", () => {
  // ===================================
  // FUNGSI 1: FILTER PRODUK (di produk.html)
  // ===================================
  const filterTabs = document.querySelectorAll("#filterTabs li");
  const productGrid = document.querySelectorAll("#productGrid > div");

  if (filterTabs.length > 0 && productGrid.length > 0) {
    filterTabs.forEach((tab) => {
      tab.addEventListener("click", () => {
        filterTabs.forEach((t) => t.classList.remove("active"));
        tab.classList.add("active");

        const filterValue = tab.getAttribute("data-filter");

        productGrid.forEach((product) => {
          const productCategory = product.getAttribute("data-category");
          if (filterValue === "all" || filterValue === productCategory) {
            // Menggunakan 'flex' agar konsisten dengan layout kartu produk
            product.style.display = "flex";
          } else {
            product.style.display = "none";
          }
        });
      });
    });
  }

  // =============================================
  // FUNGSI 2: MENU HAMBURGER MOBILE (di semua halaman)
  // =============================================
  const hamburgerBtn = document.getElementById("hamburger-btn");
  const mobileMenu = document.getElementById("mobile-menu");

  if (hamburgerBtn && mobileMenu) {
    const hamburgerIcon = hamburgerBtn.querySelector("i");
    hamburgerBtn.addEventListener("click", () => {
      mobileMenu.classList.toggle("hidden");

      // Ganti ikon bars <=> xmark
      if (mobileMenu.classList.contains("hidden")) {
        hamburgerIcon.classList.remove("fa-xmark");
        hamburgerIcon.classList.add("fa-bars");
      } else {
        hamburgerIcon.classList.remove("fa-bars");
        hamburgerIcon.classList.add("fa-xmark");
      }
    });
  }

  // =============================================
  // FUNGSI 3: SLIDER TESTIMONI (di informasi.html)
  // =============================================
  // Inisialisasi Slider untuk Testimoni Teks
  if (document.querySelector(".text-swiper")) {
    new Swiper(".text-swiper", {
      loop: true,
      slidesPerView: 1,
      spaceBetween: 24,
      pagination: { el: ".text-swiper .swiper-pagination", clickable: true },
      navigation: {
        nextEl: ".text-swiper .swiper-button-next",
        prevEl: ".text-swiper .swiper-button-prev",
      },
      breakpoints: {
        768: { slidesPerView: 2 },
        1024: { slidesPerView: 3 },
      },
    });
  }

  // Inisialisasi Slider untuk Testimoni Video
  if (document.querySelector(".video-swiper")) {
    new Swiper(".video-swiper", {
      loop: true,
      slidesPerView: 1.2,
      centeredSlides: true,
      spaceBetween: 16,
      pagination: { el: ".video-swiper .swiper-pagination", clickable: true },
      navigation: {
        nextEl: ".video-swiper .swiper-button-next",
        prevEl: ".video-swiper .swiper-button-prev",
      },
      breakpoints: {
        768: { slidesPerView: 2, centeredSlides: false, spaceBetween: 24 },
        1024: { slidesPerView: 2.5, centeredSlides: true, spaceBetween: 30 },
      },
      on: {
        slideChange: function () {
          this.slides.forEach((slide) => {
            const video = slide.querySelector("video");
            if (video && !video.paused) {
              video.pause();
            }
          });
        },
      },
    });
  }

  // =============================================
  // FUNGSI 4: FORM TESTIMONI (di informasi.html)
  // =============================================
  const showFormBtn = document.getElementById("show-form-btn");
  const formContainer = document.getElementById("testimonial-form-container");
  const formIntro = document.getElementById("form-intro");

  if (showFormBtn && formContainer && formIntro) {
    showFormBtn.addEventListener("click", () => {
      formIntro.style.transition = "opacity 0.5s, transform 0.5s";
      formIntro.style.opacity = "0";
      formIntro.style.transform = "translateY(-20px)";

      setTimeout(() => {
        formIntro.style.display = "none";
      }, 500);

      formContainer.style.marginTop = "0";
      formContainer.style.maxHeight = formContainer.scrollHeight + "px";
    });
  }

  // =============================================
  // FUNGSI 5: ACCORDION VISI & MISI (di tentang.html)
  // =============================================
  const accordionItems = document.querySelectorAll(".accordion-item");
  if (accordionItems.length > 0) {
    accordionItems.forEach((item) => {
      const header = item.querySelector(".accordion-header");
      const content = item.querySelector(".accordion-content");
      const icon = header.querySelector("i");

      header.addEventListener("click", () => {
        const isActive = item.classList.contains("active");

        accordionItems.forEach((otherItem) => {
          if (otherItem !== item) {
            otherItem.classList.remove("active");
            otherItem.querySelector(".accordion-content").style.maxHeight =
              null;
            otherItem.querySelector(".accordion-content").style.opacity = "0";
          }
        });

        if (isActive) {
          item.classList.remove("active");
          content.style.maxHeight = null;
          content.style.opacity = "0";
        } else {
          item.classList.add("active");
          content.style.maxHeight = content.scrollHeight + "px";
          content.style.opacity = "1";
        }
      });
    });
  }
}); // Penutup event listener DOMContentLoaded
