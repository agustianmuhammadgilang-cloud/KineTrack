<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kinetrack - Pelaporan Kinerja Polban</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --polban-blue: #1D2F83;
            --polban-orange: #F58025;
        }

        body {
            background-color: #f7f7f7;
        }

        .hero {
            background: linear-gradient(135deg, var(--polban-blue), var(--polban-orange));
            color: white;
            padding: 120px 0;
        }

        .feature-icon {
            font-size: 50px;
            color: var(--polban-orange);
        }

        .btn-polban {
            background-color: var(--polban-orange);
            color: white;
        }

        .btn-polban:hover {
            background-color: #cf6d1f;
            color: white;
        }

        footer {
            background-color: var(--polban-blue);
            color: white;
            padding: 25px 0;
        }
    </style>
</head>

<body>

    <!-- HERO SECTION -->
    <section class="hero text-center">
        <div class="container">
            <h1 class="display-4 fw-bold">KINETRACK</h1>
            <p class="lead">Sistem Pelaporan Kinerja Pegawai Politeknik Negeri Bandung</p>

            <div class="mt-4">
                <a href="<?= base_url ('login'); ?>" class="btn btn-polban px-4 py-2">Login</a>
            </div>
        </div>
    </section>

    <!-- FEATURES -->
    <section class="py-5">
        <div class="container text-center">
            <h3 class="mb-4 fw-bold">Fitur Utama</h3>

            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="p-4">
                        <div class="feature-icon mb-3">📝</div>
                        <h5>Input Laporan Harian</h5>
                        <p>Staff dapat mencatat aktivitas harian secara mudah dan cepat.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-4">
                        <div class="feature-icon mb-3">✔</div>
                        <h5>Approval Atasan</h5>
                        <p>Atasan dapat memeriksa dan memvalidasi laporan secara langsung.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-4">
                        <div class="feature-icon mb-3">📊</div>
                        <h5>Rekap Bulanan</h5>
                        <p>Laporan otomatis direkap menjadi data bulanan kinerja pegawai.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="text-center">
        <p>© 2025 Kinetrack • Politeknik Negeri Bandung</p>
    </footer>

</body>
</html>