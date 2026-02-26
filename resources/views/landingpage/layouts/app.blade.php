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
        /* Kontainer luar */
        .logo-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            /* Kunci: Meratakan secara horizontal ke tengah */
            justify-content: center;
            background: transparent !important;
            border: none !important;
            padding: 0;
            margin: 0;
            text-align: center;
        }

        .logo {
            display: flex;
            justify-content: center;
            /* Memastikan gambar di dalam <a> berada di tengah */
            align-items: center;
            background: transparent !important;
            margin: 0 !important;
            padding: 0 !important;
            line-height: 0;
        }

        .logo img {
            height: 45px;
            /* Sesuaikan tinggi */
            width: auto;
            display: block;
            margin: 0 auto;
            /* Memaksa gambar di tengah secara horizontal */
        }

        .sub-logo-wrapper {
            display: block;
            width: 100%;
            margin-top: 2px;
            /* Jarak antara logo dan teks */
            background: transparent !important;
        }

        .sub-logo {
            display: block;
            font-size: 9px;
            font-weight: 700;
            color: var(--default-color);
            text-align: left;
            /* Pastikan teks di tengah */
            text-transform: uppercase;
            letter-spacing: 1px;
            white-space: nowrap;
            margin: 2 auto;
        }

        /* Hilangkan elemen bawaan template yang mungkin mengganggu */
        .sitename {
            display: none !important;
        }
    </style>
</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center fixed-top">
        <div
            class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">
            <div class="logo-container">
                <a href="/" class="logo">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo SEbiduk">
                </a>
                <div class="sub-logo-wrapper">
                    <span class="sub-logo">BPS KOTA LUBUKLINGGAU</span>
                </div>
            </div>
            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="/" class="active">Home</a></li>
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
