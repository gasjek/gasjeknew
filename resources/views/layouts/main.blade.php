<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>GASJek Transportasi & Makanan</title>

    <!-- favico -->
    <link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon/favicon-16x16.png">
    <link rel="icon" type="image/ico" sizes="16x16" href="img/favicon/favicon.ico">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon/android-chrome-512x512.png">
    <link rel="manifest" href="img/favicon/site.webmanifest">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.min.css" />
    <link
        href="https://fonts.googleapis.com/css2?family=Days+One&family=Rambla:ital,wght@0,400;0,700;1,400;1,700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    @stack('custom-css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <!-- Navbar -->
    <header class="sticky top-0 lg:h-[90px] h-[60px] bg-white z-30">
        <div class="container mx-auto px-4 flex justify-between h-full items-center">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center">
                <img src="{{ asset('storage/img/gasjek_biru.png') }}" alt="Logo" class="h-[50px]" />
                <!-- <span class="lg:text-3xl text-2xl font-primary text-secondary">gasjek</span> -->
            </a>

            <nav>
                <!-- nav mobile triger -->
                <div class="cursor-pointer lg:hidden" id="nav_toggle">
                    <i id="nav_icon" class="ri-menu-3-line text-2xl text-secondary"></i>
                </div>
                <ul class="fixed w-full h-0 p-0 bg-white lg:bg-white overflow-hidden border-r top-[60px] left-0 right-0 flex flex-col lg:gap-8 gap-4 lg:relative lg:flex-row lg:p-0 lg:top-0 border-none lg:h-full transition-all duration-300 font-semibold"
                    id="nav_menu">
                    <li><a href="{{ route('home') }}" class="menu-item">Home</a></li>
                    <li><a href="#services" class="menu-item">Layanan</a></li>
                    <li><a href="{{ route('mitra') }}" class="menu-item">Mitra</a></li>
                    <li><a href="#contact" class="menu-item">Kontak</a></li>
                    <li><a href="#en" class="menu-item">EN</a></li>
                </ul>
            </nav>
        </div>
    </header>

    @yield('content')

    <!-- Footer -->
    <footer class="footer-wrapper c-footer bg-secondary text-white lg:py-16">
        <div class="container border-b border-gray-shade3 py-10">
            <div>
                <img class="mb-14 justify-center logo_gasjek_putih" src="{{ asset('storage/img/gasjek_putih.png') }}"
                    alt="Logo Gasjek">
                <div class="menu__list grid grid-cols-2 md:grid-cols-5">
                    <div class="menu__container">
                        <p class="c-footer__title mb-5 md:mb-8 lg:mb-6 font-semibold">Company</p>
                        <ul class="space-y-4 md:space-y-6 lg:space-y-4">
                            <li class="gj-footer-list">
                                <a class="text-white text-lg font-secondary footer-item" href="#">About</a>
                            </li>
                            <li class="gj-footer-list">
                                <a class="text-white text-lg font-secondary footer-item" href="#">Products</a>
                            </li>
                            <li class="gj-footer-list">
                                <a class="text-white text-lg font-secondary footer-item" href="#">Blog</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ asset('js/main-23742.js') }}"></script>
    @stack('custom-js')
</body>

</html>
