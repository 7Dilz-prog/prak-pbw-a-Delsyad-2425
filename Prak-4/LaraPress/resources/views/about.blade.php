<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tentang Kami') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="simple-card">
                <div class="simple-card-header">
                    <h3 class="simple-card-title">Tentang LaraPress</h3>
                    <p class="simple-card-subtitle">Informasi seputar proyek dan praktikum pemrograman web.</p>
                </div>

                <p class="about-desc">
                    <strong>LaraPress</strong> adalah aplikasi blog dan web sederhana yang dibangun untuk memenuhi tugas <strong>Praktikum Pemrograman Berbasis Web (PBW)</strong> menggunakan framework <strong>Laravel 12</strong>. Aplikasi ini mencakup sistem autentikasi, manajemen post, serta navigasi halaman dasar.
                </p>

                <!-- Tabel Informasi Aplikasi -->
                <table class="info-table">
                    <tr>
                        <th>Nama Aplikasi</th>
                        <td>LaraPress</td>
                    </tr>
                    <tr>
                        <th>Framework</th>
                        <td>Laravel 12 & PHP</td>
                    </tr>
                    <tr>
                        <th>Praktikum</th>
                        <td>Praktikum Pemrograman Berbasis Web (Pertemuan 3)</td>
                    </tr>
                    <tr>
                        <th>Fitur Utama</th>
                        <td>Autentikasi User (Login/Register), Dashboard, Manajemen Konten</td>
                    </tr>
                </table>

                <!-- Tombol Navigasi -->
                <div style="margin-top: 24px; display: flex; justify-content: center; gap: 10px;">
                    <a href="{{ route('dashboard') }}" class="btn-simple btn-simple-secondary">
                        &larr; Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
