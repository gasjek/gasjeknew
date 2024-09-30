@extends('layouts.main')
@section('content')
    <main class="min-h-screen">
        <div class="text-center items-center justify-center m-6">
            <h1 class="mb-4 text-2xl leading-none tracking-tight text-gray-900 md:text-3xl lg:text-4xl dark:text-white">
                Daftar untuk Bergabung sebagai <span
                    class="underline underline-offset-3 decoration-8 decoration-primary dark:decoration-secondary">Mitra
                    Driver GASJek</span></h1>
            <p class="text-lg font-normal text-gray-500 lg:text-xl dark:text-gray-400">Gabung menjadi mitra driver antar
                orang atau barang dan dapatkan sumber cuan baru!</p>
        </div>
        <div class="flex items-center justify-center">
            <div class="bg-white rounded-lg shadow-lg p-5 items-center my-6 mx-3 w-full sm:max-w-3xl">
                <form id="driverForm">
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="full_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                                Lengkap *</label>
                            <input type="text" id="full_name" name="full_name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary dark:focus:border-blue-500"
                                placeholder="Jhon Iskandar" required />
                        </div>
                        <div>
                            <label for="no_whatsapp"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomor
                                WhatsApp Aktif
                                *</label>
                            <input type="tel" id="no_whatsapp" name="no_whatsapp"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary dark:focus:border-blue-500"
                                placeholder="0821xxxxxxxx" required />
                        </div>
                        <div>
                            <label for="location"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Lokasi
                                *</label>
                            <input type="text" id="location" name="location"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary dark:focus:border-blue-500"
                                value="Gelumbang" readonly>
                        </div>
                        <div>
                            <label for="plat_number"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Plat
                                Kendaraan
                                *</label>
                            <input type="text" id="plat_number" name="plat_number"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary dark:focus:border-blue-500"
                                placeholder="BG 1234 AB" required />
                        </div>
                        <div>
                            <label for="vehicle_type"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jenis
                                Kendaraan
                                *</label>
                            <select id="countries" name="vehicle_type"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="ride">Motor</option>
                                <option value="car" disabled>Mobil</option>
                            </select>
                        </div>
                        <div>
                            <label for="vehicle_name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                                Kendaraan
                                *</label>
                            <input type="text" id="vehicle_name" name="vehicle_name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary dark:focus:border-blue-500"
                                placeholder="Beat Karbu Putih" required />
                        </div>
                    </div>
                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="ektp">Upload
                            E-KTP *</label>
                        <input
                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                            id="ektp" name="ektp" type="file">
                    </div>
                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="sim">Upload
                            SIM C *</label>
                        <input
                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                            id="sim" name="sim" type="file">
                    </div>
                    {{-- <div class="mb-6">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        for="photo_profile">Photo Profile *</label>
                    <input
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                        id="photo_profile" name="photo_profile" type="file">
                </div> --}}
                    <div class="mb-6">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email
                            address *</label>
                        <input type="email" id="email" name="email"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary dark:focus:border-blue-500"
                            placeholder="john.doe@company.com" required />
                    </div>
                    <div class="mb-6">
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password
                            *</label>
                        <input type="password" id="password" name="password"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary dark:focus:border-blue-500"
                            placeholder="•••••••••" required />
                    </div>
                    <div class="mb-6">
                        <label for="password_confirmation"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm password *</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary dark:focus:border-blue-500"
                            placeholder="•••••••••" required />
                    </div>
                    <div class="flex items-start mb-6">
                        <div class="flex items-center h-5">
                            <input id="remember" type="checkbox" value="setuju"
                                class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800"
                                required />
                        </div>
                        <label for="remember" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">I agree
                            with the <a href="#" class="text-blue-600 hover:underline dark:text-blue-500">terms and
                                conditions</a>. *</label>
                    </div>
                    <button type="submit"
                        class="text-white bg-primary hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                </form>
            </div>
        </div>
    </main>
@endsection

@push('custom-js')
    <!-- Tambahkan ini di view layout atau file blade yang memuat form -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('js/registerDriver.js') }}"></script>

    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('js/jsvalidation.min.js') }}"></script>
@endpush
