<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@yield('title', 'SEbiduk Ekonomi')</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <link href="{{ asset('template/frontend/assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('template/frontend/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <link href="{{ asset('template/frontend/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template/frontend/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('template/frontend/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('template/frontend/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template/frontend/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">

    <link href="{{ asset('template/frontend/assets/css/main.css') }}" rel="stylesheet">
    <style>
        /* Pembungkus utama */
        .logo-wrapper {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Tulisan Utama SEbiduk */
        .logo .sitename {
            margin: 0;
            padding: 0;
            line-height: 1;
            /* Mencegah spasi bawaan yang terlalu besar */
        }

        /* Tulisan BPS di Bawah */
        .sub-logo {
            display: block;
            font-size: 9px;
            /* Ukuran teks kecil */
            font-weight: 700;
            color: var(--default-color);
            width: 100%;
            /* Agar bisa justify sesuai lebar SEbiduk */

            /* PENGATUR JARAK */
            margin-top: 5px;
            /* Tambah angka ini jika masih kurang jauh */

            /* PENGATUR AGAR PANJANGNYA PAS */
            text-align: justify;
            text-align-last: justify;
            letter-spacing: 0.2px;
            text-transform: uppercase;
        }
    </style>
</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center fixed-top">
        <div
            class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">
            <div class="logo-container">
                <a href="index.html" class="logo d-flex align-items-center">
                    <h1 class="sitename">SEbiduk</h1>
                </a>
                <div class="sub-logo-wrapper">
                    <span class="sub-logo">BPS KOTA LUBUKLINGGAU</span>
                </div>
            </div>
            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="index.html" class="active">Home</a></li>
                    <li><a href="/GroundCheck">Ground Check</a></li>

                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            <a class="btn-getstarted" href="">Login</a>
        </div>
    </header>

    <main class="main">
        @yield('content')
    </main>

    <footer id="footer" class="footer position-relative light-background">
        <div class="container copyright text-center mt-4">
            <p>© <span>Created With ❤️</span> <strong class="px-1 sitename">TIM SPBE</strong> <span>BPS Kota Lubuk
                    Linggau</span>
            </p>
        </div>
    </footer>

    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>
    <div id="preloader"></div>

    <script src="{{ asset('template/frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('template/frontend/assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('template/frontend/assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('template/frontend/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('template/frontend/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('template/frontend/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('template/frontend/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('template/frontend/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>

    <script src="{{ asset('template/frontend/assets/js/main.js') }}"></script>
</body>

</html>
