@extends('layouts.main')
@section('content')
    <!-- Home Section -->
    <main class="mx-w-[1920px] mx-auto bg-white overflow-hidden" id="home">
        <div class="xl:bg-grid xl:bg-center xl-bg-repeat-y top-0 bottom-0 left-0 right-0 z-10"></div>
        <section class="hero h-[640px] xl:h[840px] bg-center lg:bg-cover bg-no-repeat relative z-20">
            <div
                class="container lg:pr-32 mx-auto h-full flex flex-col lg:flex-row items-center justify-center xl:justify-start xl:space-x-8">
                <!-- Bagian Selamat Datang -->
                <div class="flex flex-col items-center text-center lg:text-left lg:items-start">
                    <h1 class="h1">Nikmati Pelayanan Terbaik Bersama GASJek.</h1>
                    <p class="mb-4 font-secondary">Layanan terbaik untuk pesan ojek dan delivery makanan.</p>
                </div>
            </div>
        </section>
    </main>
@endsection
