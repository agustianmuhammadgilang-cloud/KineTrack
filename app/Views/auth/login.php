<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi eKinerja - POLBAN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        polban: {
                            navy: '#002855',
                            lightnav: '#003d80',
                            orange: '#FF6B00',
                            gold: '#FF9900'
                        }
                    }
                }
            }
        }
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }

        .fade-in { animation: fadeIn 0.8s ease-out forwards; opacity: 0; transform: translateY(20px); }
        @keyframes fadeIn { to { opacity: 1; transform: translateY(0); } }

        .glass-overlay {
            background: linear-gradient(135deg, rgba(0, 40, 85, 0.85) 0%, rgba(0, 20, 50, 0.95) 100%);
        }

        .slide { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 1.5s ease-in-out; }
        .slide.active { opacity: 1; }
    </style>
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4 md:p-6">

<div class="w-full max-w-[1100px] h-auto md:h-[650px] bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col md:flex-row fade-in ring-1 ring-gray-200">

    <!-- KIRI -->
    <div class="w-full md:w-[45%] p-8 md:p-12 flex flex-col justify-center relative bg-white z-10">

        <div class="mb-8 flex items-center gap-3">
            <div class="w-10 h-10 bg-polban-navy rounded-lg flex items-center justify-center shadow-lg shadow-blue-900/20">
                <i class="ph-fill ph-chart-line text-polban-orange text-2xl"></i>
            </div>
            <span class="text-2xl font-bold text-polban-navy tracking-tight">
                POLBAN<span class="text-polban-orange">eKinerja</span>
            </span>
        </div>

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-800 mb-2">Selamat Datang Pegawai!</h1>
            <p class="text-slate-500 text-sm">Silakan masuk untuk mengelola Sasaran Kinerja Pegawai (SKP) Anda.</p>
        </div>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-700 text-sm">
                <?= session()->getFlashdata('error'); ?>
            </div>
        <?php endif; ?>

        <!-- FORM -->
        <form action="<?= base_url('/login/process'); ?>" method="POST" class="space-y-5">

            <!-- EMAIL -->
            <div class="group relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                    <i class="ph ph-user-circle text-gray-400"></i>
                </div>

                <input type="text" name="email" class="w-full pl-10 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm
                    focus:outline-none focus:border-polban-orange focus:ring-1 focus:ring-polban-orange transition-all peer" 
                    placeholder=" " required />

                <label class="absolute left-10 top-3.5 text-gray-400 text-sm transition-all
                    peer-placeholder-shown:text-base peer-placeholder-shown:top-3.5
                    peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-polban-orange peer-focus:bg-white peer-focus:px-1">
                    NIP/NIK atau Email
                </label>
            </div>

            <!-- PASSWORD -->
            <div class="group relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                    <i class="ph ph-lock-key text-gray-400"></i>
                </div>

                <input type="password" name="password" id="password" 
                    class="w-full pl-10 pr-12 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm
                    focus:outline-none focus:border-polban-orange focus:ring-1 focus:ring-polban-orange transition-all peer"
                    placeholder=" " required />

                <label class="absolute left-10 top-3.5 text-gray-400 text-sm transition-all
                    peer-placeholder-shown:text-base peer-placeholder-shown:top-3.5
                    peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-polban-orange peer-focus:bg-white peer-focus:px-1">
                    Kata Sandi
                </label>

                <button type="button" onclick="togglePassword()"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-polban-navy transition">
                    <i id="eye-icon" class="ph ph-eye text-lg"></i>
                </button>
            </div>

            <!-- MATH CAPTCHA -->
            <div>
                <label class="text-sm font-medium text-gray-700">
                    Berapa <?= $a ?> + <?= $b ?> ?
                </label>
                <input type="number" name="captcha_answer"
                    class="mt-1 w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm
                    focus:outline-none focus:border-polban-orange focus:ring-1 focus:ring-polban-orange"
                    required>
            </div>

            <button type="submit"
                class="w-full bg-polban-navy hover:bg-polban-lightnav text-white font-semibold py-3.5 rounded-xl shadow-lg shadow-blue-900/20 
                hover:shadow-blue-900/40 hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-2 group">
                <span>Masuk eKinerja</span>
                <i class="ph-bold ph-arrow-right group-hover:translate-x-1 transition-transform"></i>
            </button>

        </form>

        <div class="mt-auto pt-8 text-center md:text-left">
            <p class="text-xs text-gray-400">&copy; 2025 Politeknik Negeri Bandung.<br class="md:hidden">All rights reserved.</p>
        </div>
    </div>

    <!-- KANAN -->
    <div class="hidden md:block w-[55%] relative overflow-hidden bg-polban-navy">
        <div id="slider" class="absolute inset-0">
            <img src="/img/Gedung1.jpg" class="slide active">
            <img src="/img/Gedung2.jpg" class="slide">
            <img src="/img/Gedung3.jpg" class="slide">
        </div>

        <div class="absolute inset-0 glass-overlay"></div>

        <div class="absolute inset-0 flex flex-col justify-between p-12 text-white z-20">
            <div class="flex justify-end">
                <div class="w-16 h-1 bg-polban-orange rounded-full opacity-80"></div>
            </div>

            <div class="space-y-4">
                <div class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-xl flex items-center justify-center border border-white/20">
                    <i class="ph-fill ph-target text-polban-orange text-2xl"></i>
                </div>
                <h2 class="text-4xl font-bold leading-tight">Kelola Kinerja dengan Akurat.</h2>
                <p class="text-blue-100 text-lg font-light max-w-md">
                    Platform terpadu untuk penyusunan SKP, pelaporan harian, dan evaluasi kinerja pegawai.
                </p>
            </div>

            <div class="flex gap-2">
                <div class="w-8 h-1.5 bg-polban-orange rounded-full"></div>
                <div class="w-2 h-1.5 bg-white/30 rounded-full"></div>
                <div class="w-2 h-1.5 bg-white/30 rounded-full"></div>
            </div>
        </div>

        <div class="absolute -bottom-24 -right-24 w-64 h-64 bg-polban-orange rounded-full mix-blend-multiply blur-3xl opacity-20 animate-pulse"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-blue-400 rounded-full mix-blend-overlay blur-3xl opacity-10"></div>
    </div>

</div>

<script>
function togglePassword() {
    const input = document.getElementById("password");
    const icon = document.getElementById("eye-icon");

    if (input.type === "password") {
        input.type = "text";
        icon.classList.replace("ph-eye", "ph-eye-slash");
    } else {
        input.type = "password";
        icon.classList.replace("ph-eye-slash", "ph-eye");
    }
}

let index = 0;
const slides = document.querySelectorAll("#slider .slide");

setInterval(() => {
    slides[index].classList.remove("active");
    index = (index + 1) % slides.length;
    slides[index].classList.add("active");
}, 5000);
</script>

</body>
</html>