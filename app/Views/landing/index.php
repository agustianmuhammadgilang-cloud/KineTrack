<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>KINETRACK – Pelaporan Kinerja Polban</title>

  <!-- FONT INTER -->
  <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

  <!-- TAILWIND CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        fontFamily: {
          sans: ["Inter", "sans-serif"],
        },
        extend: {
          colors: {
            polbanBlue: "#1D2F83",
            polbanOrange: "#F58025",
            polbanDark: "#121B4A",
          },
        },
      },
    };
  </script>

  <style>
    /* Scroll reveal transition */
    .reveal {
      opacity: 0;
      transform: translateY(40px);
      transition: all 0.7s ease;
    }
    .reveal.visible {
      opacity: 1;
      transform: translateY(0px);
    }

    /* Navbar blur effect */
    .nav-blur {
      backdrop-filter: blur(10px);
      background: rgba(255, 255, 255, 0.6);
    }
  </style>
</head>

<body class="bg-gray-100 text-gray-800 font-sans">

  <!-- NAVBAR -->
  <nav id="navbar" class="fixed top-0 w-full z-50 shadow nav-blur transition">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

      <!-- Logo -->
      <h1 class="font-extrabold text-xl tracking-wide text-polbanBlue">
        KINETRACK
      </h1>

      <!-- Desktop Menu -->
      <div class="hidden md:flex items-center space-x-8">
        <a href="#fitur" class="text-polbanBlue hover:text-polbanOrange font-semibold">Fitur</a>

        <a href="<?= base_url('login'); ?>"
          class="px-4 py-2 bg-polbanOrange text-white rounded-md shadow hover:bg-orange-600 transition font-semibold">
          Login
        </a>
      </div>

      <!-- Mobile Menu Toggle -->
      <button id="menuToggle" class="md:hidden text-polbanBlue text-3xl">
        ☰
      </button>
    </div>

    <!-- MOBILE MENU -->
    <div id="mobileMenu" class="hidden flex-col bg-white shadow-md md:hidden px-6 pb-4 space-y-3">
      <a href="#fitur" class="block py-2 font-semibold text-polbanBlue">Fitur</a>
      <a href="<?= base_url('login'); ?>"
        class="block py-2 bg-polbanOrange text-white rounded-md text-center font-semibold">
        Login
      </a>
    </div>
  </nav>

  <!-- HERO -->
  <section class="pt-32 pb-24 bg-polbanBlue text-white text-center">
    <div class="max-w-4xl mx-auto px-6 reveal">
      <h1 class="text-4xl md:text-6xl font-extrabold leading-tight">
        Sistem Pelaporan Kinerja Pegawai yang Modern & Akurat.
      </h1>

      <p class="mt-4 text-lg md:text-xl opacity-90">
        Meningkatkan efisiensi pelaporan kinerja Polban—lebih cepat, lebih rapi, lebih otomatis.
      </p>

      <a href="<?= base_url('login'); ?>"
        class="mt-8 inline-block px-8 py-4 bg-white text-polbanBlue rounded-lg font-bold text-lg 
               shadow hover:bg-gray-200 transition">
        Mulai Sekarang
      </a>
    </div>
  </section>

  <!-- STATS -->
  <section class="py-20 px-6 bg-white">
    <div class="max-w-6xl mx-auto grid md:grid-cols-3 gap-10 text-center">

      <div class="reveal bg-gray-50 p-8 rounded-xl shadow">
        <h2 class="text-4xl font-bold text-polbanBlue">100%</h2>
        <p class="mt-2 opacity-75">Digitalisasi Pelaporan</p>
      </div>

      <div class="reveal bg-gray-50 p-8 rounded-xl shadow">
        <h2 class="text-4xl font-bold text-polbanBlue">3x</h2>
        <p class="mt-2 opacity-75">Lebih Cepat dari Manual</p>
      </div>

      <div class="reveal bg-gray-50 p-8 rounded-xl shadow">
        <h2 class="text-4xl font-bold text-polbanBlue">0%</h2>
        <p class="mt-2 opacity-75">Kesalahan Rekap Data</p>
      </div>

    </div>
  </section>

  <!-- FITUR UTAMA -->
  <section id="fitur" class="py-20 px-6">
    <div class="max-w-6xl mx-auto text-center reveal">
      <h2 class="text-3xl md:text-4xl font-bold text-polbanBlue mb-4">
        Dirancang untuk Efisiensi Tinggi
      </h2>
      <p class="text-lg opacity-80 mb-12">
        Fitur-fitur utama yang mempercepat alur kerja pegawai, atasan, dan admin.
      </p>
    </div>

    <div class="max-w-6xl mx-auto grid md:grid-cols-3 gap-10">

      <div class="reveal bg-white p-8 rounded-2xl shadow border-t-4 border-polbanBlue hover:-translate-y-1 hover:shadow-xl transition">
        <h3 class="text-xl font-semibold mb-2">Input Laporan Harian</h3>
        <p class="opacity-80">Pegawai mengisi aktivitas harian dengan cepat dan rapi.</p>
      </div>

      <div class="reveal bg-white p-8 rounded-2xl shadow border-t-4 border-polbanOrange hover:-translate-y-1 hover:shadow-xl transition">
        <h3 class="text-xl font-semibold mb-2">Sistem Approval Terpusat</h3>
        <p class="opacity-80">Atasan menyetujui atau menolak laporan dengan catatan khusus.</p>
      </div>

      <div class="reveal bg-white p-8 rounded-2xl shadow border-t-4 border-polbanBlue hover:-translate-y-1 hover:shadow-xl transition">
        <h3 class="text-xl font-semibold mb-2">Rekap Otomatis</h3>
        <p class="opacity-80">Sistem membuat rekap bulanan secara otomatis & akurat.</p>
      </div>

    </div>
  </section>

  <!-- CTA FINAL -->
  <section class="py-20 bg-polbanDark text-white text-center">
    <div class="max-w-4xl mx-auto px-6 reveal">
      <h2 class="text-4xl font-bold mb-4">
        Siap Mengubah Cara Polban Melaporkan Kinerja?
      </h2>
      <p class="text-lg opacity-90 mb-8">
        Tingkatkan produktivitas dan akurasi dengan sistem pelaporan modern.
      </p>

      <a href="<?= base_url('login'); ?>"
        class="inline-block px-10 py-4 bg-polbanOrange text-white rounded-lg font-semibold 
               text-xl shadow-lg hover:bg-orange-600 transition">
        Login ke Kinetrack
      </a>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="bg-gray-900 text-center text-white py-6">
    © <?= date('Y'); ?> KINETRACK • Politeknik Negeri Bandung
  </footer>

  <!-- JAVASCRIPT INTERAKTIF -->
  <script>
    // Mobile Menu
    const toggle = document.getElementById("menuToggle");
    const menu = document.getElementById("mobileMenu");

    toggle.addEventListener("click", () => {
      menu.classList.toggle("hidden");
    });

    // Scroll Reveal Animation
    const reveals = document.querySelectorAll(".reveal");
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("visible");
        }
      });
    });

    reveals.forEach((el) => observer.observe(el));
  </script>

</body>
</html>
