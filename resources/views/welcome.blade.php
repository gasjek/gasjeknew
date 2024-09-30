@extends('layouts.main')
@section('content')
    <!-- Home Section -->
    <main class="mx-w-[1920px] mx-auto bg-white overflow-hidden" id="home">
        <div class="xl:bg-grid xl:bg-center xl-bg-repeat-y top-0 bottom-0 left-0 right-0 z-10"></div>
        <section id="section-1" class="hero h-[640px] xl:h[840px] bg-center lg:bg-cover bg-no-repeat relative z-20">
            <div
                class="container lg:pr-32 mx-auto h-full flex flex-col lg:flex-row items-center justify-center xl:justify-start xl:space-x-8">
                <!-- Bagian Selamat Datang -->
                <div class="flex flex-col items-center text-center lg:text-left lg:items-start">
                    <h1 class="h1">Nikmati Pelayanan Terbaik Bersama GASJek.</h1>
                    <p class="mb-4 font-secondary">Layanan terbaik untuk pesan ojek dan delivery makanan.</p>
                    <div class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0">
                        <a href="#"
                            class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white border-2 border-primary transition duration-300 ease-in-out hover:bg-primary hover:text-white rounded-full">
                            Pesan sekrang
                            <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M1 5h12m0 0L9 1m4 4L9 9" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <section id="section-2" class=" bg-white pt-10 md:pt-20 pb-5 md:pb-10">
            <div class="container flex text-center justify-center">
                <div class="w-full lg:w-full ml-0">
                    <h2 class="text-5xl text-primary">Bertumbuh besar bersama Gasjek</h2>
                </div>
            </div>
        </section>
        <section class="pb-[15px] md:pb-[20px]">
            <div class="container mx-auto z-10 grid grid-cols-1 gap-y-6 md:grid-cols-3 md:gap-x-10">
                <div class="flex flex-col">
                    <img alt="tiny card" src="https://cdn-site.gojek.com/uploads/employees_fef08f1b0f.svg"
                        class="h-9 mb-4 mr-auto">
                    <h3 class="text-[24px] leading-8 mb-2 text-primary">Gabung jadi GaTroops, yuk!</h3>
                    <div class="text-xs leading-6 mb-4 text-primary">
                        <p>Di belakang startup dengan pertumbuhan paling tinggi di Asia Tenggara, terdapat talenta yang
                            memiliki ide-ide cemerlang</p>
                    </div>
                    <a target="_self"
                        class="py-3 text-lg px-5 text-white bg-primary hover:bg-secondary focus:outline-none rounded-full text-center me-2 mb-2 dark:bg-primary dark:hover:bg-secondary transition duration-300 ease-in-out leading-6 w-fit"
                        href="/mitra/daftar-driver"><span>Selengkapnya</span>
                    </a>
                </div>
                <div class="flex flex-col">
                    <img alt="tiny card" src="https://cdn-site.gojek.com/uploads/driver_partner_166faab31a.svg"
                        class="h-9 mb-4 mr-auto">
                    <h3 class="text-[24px] leading-8 mb-2 text-primary">Gabung jadi Mitra Driver</h3>
                    <div class="text-xs leading-6 mb-4 text-primary">
                        <p>Kami adalah rumah bagi lebih dari 2 juta mitra driver di Asia Tenggara, yang mendapat jaminan
                            finansial dan fasilitas kesehatan.</p>
                    </div>
                    <a target="_self"
                        class="py-3 text-lg px-5 text-white bg-primary hover:bg-secondary focus:outline-none rounded-full text-center me-2 mb-2 dark:bg-primary dark:hover:bg-secondary transition duration-300 ease-in-out leading-6 w-fit"
                        href="/mitra/daftar-driver"><span>Selengkapnya</span></a>
                </div>
                <div class="flex flex-col">
                    <img alt="tiny card" src="https://cdn-site.gojek.com/uploads/merchant_partner_57c8629626.svg"
                        class="h-9 mb-4 mr-auto">
                    <h3 class="text-[24px] leading-8 mb-2 text-primary">Gabung jadi Mitra Usaha</h3>
                    <div class="text-xs leading-6 mb-4 text-primary">
                        <p>Kami membantu 500.000+ Mitra Usaha melipatgandakan penjualan, meluaskan jangkauan, dan berkembang
                            dengan teknologi baru.</p>
                    </div>
                    <a target="_self"
                        class="py-3 text-lg px-5 text-white bg-primary hover:bg-secondary focus:outline-none rounded-full text-center me-2 mb-2 dark:bg-primary dark:hover:bg-secondary transition duration-300 ease-in-out leading-6 w-fit"
                        href="/mitra/daftar-driver"><span>Selengkapnya</span></a>
                </div>
        </section>
    </main>
@endsection
