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
                            class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white border-2 border-white transition duration-300 ease-in-out hover:bg-secondary hover:text-white rounded-full">
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

        {{-- Mitra Section --}}
        <x-mitra-section />

    </main>
@endsection
