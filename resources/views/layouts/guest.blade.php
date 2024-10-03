<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>GASJek Transportasi & Makanan</title>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="title" content="GASJek Transportasi & Makanan">
    <meta name="description"
        content="GASJek adalah layanan transportasi online dan food delivery yang menghubungkan pengguna dengan driver dan merchant di seluruh Indonesia.">
    <meta name="keywords"
        content="ojek online, transportasi online, food delivery, delivery, kurir, pengiriman, antar jemput">
    <meta name="author" content="GASJek">
    <meta name="robots" content="index, follow">

    <meta property="og:type" content="business.business">
    <meta property="og:title" content="GASJek Transportasi & Makanan">
    <meta property="og:url" content="https://gasjek.com">
    <meta property="og:image" content="">
    <meta property="og:description"
        content="GASJek adalah layanan transportasi online dan food delivery yang menghubungkan pengguna dengan driver dan merchant di seluruh Indonesia.">
    <meta property="business:contact_data:street_address" content="Gelumbang, Kampung 2">
    <meta property="business:contact_data:locality" content="Palembang">
    <meta property="business:contact_data:region" content="Sumatera Selatan">
    <meta property="business:contact_data:postal_code" content="31171">
    <meta property="business:contact_data:country_name" content="Indonesia">

    <meta name="twitter:card" content="app">
    <meta name="twitter:site" content="@GASJek Transportasi & Makanan">
    <meta name="twitter:description"
        content="GASJek adalah layanan transportasi online dan food delivery yang menghubungkan pengguna dengan driver dan merchant di seluruh Indonesia.">
    <meta name="twitter:app:name:googleplay" content="GASJek">
    <meta name="twitter:app:url:googleplay" content="">
    <meta name="twitter:app:id:googleplay" content="">
    <meta name="twitter:app:name:iphone" content="GASJek">
    <meta name="twitter:app:url:iphone" content="">
    <meta name="twitter:app:id:iphone" content="">

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <script type="application/ld+json">
    {
        "@context": "http://schema.org/",
        "@type": "Organization",
        "name": "GASJek Transportasi & Makanan",
        "logo": "https://gasjek.com/storage/img/gasjek_biru.png",
        "url": "https://gasjek.com/",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "Gelumbang, Kampung 2",
            "addressLocality": "Palembang",
            "addressRegion": "Sumatera Selatan",
            "postalCode": "31171",
            "addressCountry": "Indonesia"
        }
    }
    </script>
    @stack('custom-css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="">
    <!-- Navbar -->
    <header class="sticky top-0 lg:h-[90px] h-[70px] bg-white z-30">
        <div class="container mx-auto px-4 flex justify-between h-full items-center">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center">
                <img src="{{ asset('storage/img/gasjek_biru.png') }}" alt="Logo" class="h-[2rem]" />
                <!-- <span class="lg:text-3xl text-2xl font-primary text-secondary">gasjek</span> -->
            </a>

            <nav>
                <!-- nav mobile triger -->
                <div class="cursor-pointer lg:hidden" id="nav_toggle">
                    <i id="nav_icon" class="ri-menu-3-line text-3xl text-secondary"></i>
                </div>
                <ul class="fixed w-full h-0 p-0 bg-white lg:bg-white overflow-hidden border-r top-[60px] left-0 right-0 flex flex-col lg:gap-8 gap-4 lg:relative lg:flex-row lg:p-0 lg:top-0 border-none lg:h-full transition-all duration-300 font-semibold"
                    id="nav_menu">
                    <li><a href="{{ route('home') }}" class="menu-item">Home</a></li>
                    <li><a href="{{ route('layanan') }}" class="menu-item">Layanan</a></li>
                    <li><a href="{{ route('mitra') }}" class="menu-item">Mitra</a></li>
                    <li><a href="#contact" class="menu-item">Kontak</a></li>
                    <li><a href="#contact" class="menu-item">Blog</a></li>
                    <li><a href="#contact" class="menu-item">Bantuan</a></li>
                    <li><a href="#en" class="menu-item">EN</a></li>
                </ul>
            </nav>
        </div>
    </header>

    @yield('content')

    <!-- Footer -->
    <footer class="footer-wrapper c-footer bg-secondary text-white py-16">
        <div class="container border-b border-gray-shade3">
            <div>
                <img class="mb-7 justify-center logo_gasjek_putih" src="{{ asset('storage/img/gasjek_putih.png') }}"
                    alt="Logo Gasjek">
                <div class="menu__list grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-12 lg:gap-6">
                    <div class="menu__container">
                        <p class="c-footer__title mb-5 md:mb-8 lg:mb-6 font-semibold">Perusahaan</p>
                        <ul class="space-y-4 md:space-y-6 lg:space-y-4">
                            <li class="gj-footer-list">
                                <a class="text-white text-lg font-secondary footer-item block md:inline-block"
                                    href="#">Tentang</a>
                            </li>
                            <li class="gj-footer-list">
                                <a class="text-white text-lg font-secondary footer-item block md:inline-block"
                                    href="{{ route('layanan') }}">Layanan</a>
                            </li>
                            <li class="gj-footer-list">
                                <a class="text-white text-lg font-secondary footer-item block md:inline-block"
                                    href="#">Blog</a>
                            </li>
                        </ul>
                    </div>
                    <div class="menu__container">
                        <p class="c-footer__title mb-5 md:mb-8 lg:mb-6 font-semibold">Bergabung</p>
                        <ul class="space-y-4 md:space-y-6 lg:space-y-4">
                            <li class="gj-footer-list">
                                <a class="text-white text-lg font-secondary footer-item block md:inline-block"
                                    href="#">Mitra Driver</a>
                            </li>
                            <li class="gj-footer-list">
                                <a class="text-white text-lg font-secondary footer-item block md:inline-block"
                                    href="#">Mitra UMKM</a>
                            </li>
                        </ul>
                    </div>
                    <div class="menu__container">
                        <p class="c-footer__title mb-5 md:mb-8 lg:mb-6 font-semibold">Hubungi</p>
                        <ul class="space-y-4 md:space-y-6 lg:space-y-4">
                            <li class="gj-footer-list">
                                <a class="text-white text-lg font-secondary footer-item block md:inline-block"
                                    href="#">Bantuan</a>
                            </li>
                            <li class="gj-footer-list">
                                <a class="text-white text-lg font-secondary footer-item block md:inline-block"
                                    href="#">Lokasi kami</a>
                            </li>
                        </ul>
                    </div>
                    <div class="menu__container">
                        <div>
                            <p class="c-footer__title mb-5 md:mb-8 lg:mb-6 font-semibold">Terhubung dengan Kami</p>
                            <ul class="space-y-4 md:space-y-6 lg:space-y-4">
                                <div class="flex space-x-7">
                                    <a href="#" class="text-3xl"><i class="fa-brands fa-facebook"></i></a>
                                    <a href="#" class="text-3xl"><i class="fa-brands fa-instagram"></i></a>
                                    <a href="#" class="text-3xl"><i class="fa-brands fa-whatsapp"></i></a>
                                    <a href="#" class="text-3xl"><i class="fa-brands fa-youtube"></i></a>
                                </div>
                            </ul>
                        </div>
                        <div class="my-8">
                            <p class="c-footer__title mb-5 md:mb-8 lg:mb-6 font-semibold">Download the app</p>
                            <ul class="space-y-4 md:space-y-6 lg:space-y-4">
                                <div class="hidden md:flex space-x-7">
                                    <a href="#" class="text-3xl"><i class="fa-brands fa-google-play"></i></a>
                                    <a href="#" class="text-3xl"><i class="fa-brands fa-app-store"></i></a>
                                </div>
                                <div class="md:hidden flex flex-col space-y-5">
                                    <a href="#"
                                        class="bg-white text-black px-4 py-3 rounded-full w-full text-center">
                                        <i class="fa-brands fa-google-play"></i> Google Play
                                    </a>
                                    <a href="#"
                                        class="bg-white text-black px-4 py-3 rounded-full w-full text-center">
                                        <i class="fa-brands fa-app-store"></i> App Store
                                    </a>
                                </div>
                            </ul>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="menu__list grid grid-cols-1 md:grid-cols-2 lg:grid-cols-7 gap-12 lg:gap-6 pt-10">
                <div class="menu__container">
                    <ul class="space-y-4 md:space-y-6 lg:space-y-4">
                        <li class="gj-footer-list">
                            <a class="text-white text-lg font-secondary footer-item block md:inline-block underline"
                                href="#">Pemberitahuan Privasi</a>
                        </li>
                        <li class="gj-footer-list">
                            <a class="text-white text-lg font-secondary footer-item block md:inline-block underline"
                                href="#">Syarat dan Ketentuan</a>
                        </li>
                    </ul>
                </div>
                <div class="menu__container">
                    <ul class="space-y-4 md:space-y-6 lg:space-y-4">
                        <li class="gj-footer-list">
                            <a class="text-white text-lg font-secondary footer-item block md:inline-block underline"
                                href="#">Atribusi Data</a>
                        </li>
                        <li class="gj-footer-list">
                            <a class="text-white text-lg font-secondary footer-item block md:inline-block underline"
                                href="#">Cookie Settings</a>
                        </li>
                    </ul>
                </div>
            </div>
            <p class="text-white text-base mt-10">© 2023 Gojek | Gojek adalah merek milik PT GoTo Gojek Tokopedia Tbk.
                Terdaftar pada Direktorat Jendral Kekayaan Intelektual Republik Indonesia.</p>
        </div>
    </footer>

    <!-- JavaScript dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ asset('js/main-23742.js') }}"></script>
    @stack('custom-js')
</body>

</html>
