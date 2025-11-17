<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kinetrack</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --polban-blue: #1D2F83;
            --polban-orange: #F58025;
        }
        body {
            background: #eef1f7;
        }
        .login-card {
            margin-top: 80px;
            border-radius: 15px;
            padding: 30px;
            border-top: 6px solid var(--polban-orange);
        }
        .btn-polban {
            background-color: var(--polban-orange);
            color: white;
        }
        .btn-polban:hover {
            background-color: #cf6d1f;
        }
    </style>
</head>

<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">

            <div class="card login-card shadow-sm">
                <h4 class="text-center mb-3 fw-bold" style="color: var(--polban-blue);">LOGIN</h4>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('/login/process'); ?>" method="POST">
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>

                    <button class="btn btn-polban w-100">Login</button>
                </form>

            </div>
        </div>
    </div>
</div>

</body>
</html>
