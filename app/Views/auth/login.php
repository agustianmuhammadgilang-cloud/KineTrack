<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Kinetrack</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- GSAP for animation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

    <style>
        :root {
            --polban-blue: #1d2f83;
            --polban-orange: #f58025;
        }

        /* Background Slideshow */
        .bg-slide {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -2;
        }

        .bg-slide img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0;
            transition: opacity 1.8s ease-in-out;
        }

        .bg-slide img.active {
            opacity: 1;
        }

        /* Frosted Glass Card */
        .glass-card {
            backdrop-filter: blur(14px);
            background: rgba(255, 255, 255, 0.55);
            border-radius: 22px;
            border: 1px solid rgba(255,255,255,0.3);
            box-shadow: 0 12px 35px rgba(0,0,0,0.1);
        }

        .btn-polban {
            background-color: var(--polban-orange);
            transition: 0.25s;
        }

        .btn-polban:hover {
            background-color: #cf6d1f;
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(245,128,37,0.35);
        }
    </style>
</head>

<body class="min-h-screen flex justify-center items-center relative">

    <!-- BACKGROUND SLIDESHOW -->
    <div class="bg-slide">
        <img src="<?= base_url('img/Gedung1.jpg') ?>" class="active">
        <img src="<?= base_url('img/Gedung2.jpg') ?>">
        <img src="<?= base_url('img/Gedung3.jpg') ?>">
    </div>

    <!-- LOGIN CARD -->
    <div id="card" class="glass-card p-10 w-full max-w-md opacity-0 scale-90">

        <!-- LOGO -->
        <div class="flex justify-center mb-5">
            <img id="logo" src="<?= base_url('img/Logo No Name.png') ?>" 
                 alt="Logo" class="w-24 opacity-0">
        </div>

        <h1 id="title" class="text-center text-3xl font-bold mb-6 opacity-0"
            style="color: var(--polban-blue);">
            LOGIN
        </h1>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-100 text-red-700 px-3 py-2 rounded mb-3 animate__animated animate__shakeX">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('/login/process'); ?>" method="POST" class="space-y-4">
            <div>
                <label class="font-semibold">Email</label>
                <input type="email" name="email" required 
                       class="w-full mt-1 px-3 py-2 rounded border focus:outline-none focus:ring-2 focus:ring-orange-400">
            </div>

            <div>
                <label class="font-semibold">Password</label>
                <input type="password" name="password" required 
                       class="w-full mt-1 px-3 py-2 rounded border focus:outline-none focus:ring-2 focus:ring-orange-400">
            </div>

            <button class="btn-polban text-white w-full py-2 rounded-lg font-bold shadow-md">Login</button>
        </form>
    </div>

    <script>
        // Card fade-in animation
        gsap.to('#card', {
            opacity: 1,
            scale: 1,
            duration: 1.1,
            ease: 'power3.out'
        });

        // Logo fade-in
        gsap.fromTo('#logo', 
            { opacity: 0, y: -20 }, 
            { opacity: 1, y: 0, delay: 0.4, duration: 1, ease: "power3.out" }
        );

        // Title fade-in
        gsap.fromTo('#title',
            { opacity: 0, y: -15 },
            { opacity: 1, y: 0, delay: 0.7, duration: 1, ease: "power3.out" }
        );

        // Background slideshow logic
        const slides = document.querySelectorAll(".bg-slide img");
        let index = 0;

        setInterval(() => {
            slides[index].classList.remove("active");
            index = (index + 1) % slides.length;
            slides[index].classList.add("active");
        }, 6000); // change slide every 6 seconds
    </script>

</body>
</html>
