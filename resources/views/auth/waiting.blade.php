<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menunggu Verifikasi | Sebiduk Ekonomi 2026</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background: #f4f7f6;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-waiting {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            text-align: center;
            padding: 40px 20px;
            background: #fff;
        }

        .icon-box {
            width: 80px;
            height: 80px;
            background: #fff3e0;
            color: #ff9800;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            margin: 0 auto 20px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(255, 152, 0, 0.7);
            }

            70% {
                transform: scale(1);
                box-shadow: 0 0 0 15px rgba(255, 152, 0, 0);
            }

            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(255, 152, 0, 0);
            }
        }

        .btn-logout {
            border-radius: 20px;
            padding: 8px 25px;
            font-weight: 600;
        }

        .brand-text {
            color: #003366;
            /* Biru Khas BPS */
            font-weight: 800;
            letter-spacing: 1px;
        }
    </style>
    <meta http-equiv="refresh" content="30">

    <script>
        // Cek setiap 10 detik, jika status sudah berubah, reload halaman
        setInterval(function() {
            location.reload();
        }, 10000);
    </script>
</head>

<body>

    <div class="container">
        <div class="card-waiting mx-auto">
            <div class="icon-box">
                <i class="fas fa-user-clock"></i>
            </div>

            <h3 class="brand-text">Sebiduk Ekonomi</h3>
            <p class="text-muted mb-4">Badan Pusat Statistik Lubuk Linggau</p>

            <h5 class="font-weight-bold">Halo, {{ Auth::user()->name }}!</h5>
            <p class="text-secondary px-3">
                Akun Anda berhasil terdaftar. Saat ini status Anda sedang <strong>Menunggu Verifikasi</strong>.
                Mohon tunggu Tim IT/Admin memverifikasi akun dan memploting wilayah tugas Anda.
            </p>

            <div class="alert alert-info mx-3 small" role="alert">
                <i class="fas fa-info-circle mr-1"></i> Silakan hubungi Admin jika status ini tidak berubah dalam 1x24
                jam.
            </div>

            <hr class="my-4">
            <div class="mt-4">
                <a href="/backend" class="btn btn-primary btn-block mb-2"
                    style="border-radius: 20px; background-color: #003366;">
                    <i class="fas fa-sync-alt mr-2"></i> Cek Status Verifikasi
                </a>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-logout">
                    <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                </button>
            </form>
        </div>
    </div>

</body>

</html>
