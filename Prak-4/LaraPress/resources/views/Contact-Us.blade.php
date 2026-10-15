<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Hubungi Kami') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="simple-card">
                <div class="simple-card-header">
                    <h3 class="simple-card-title">Kontak & Customer Service</h3>
                    <p class="simple-card-subtitle">Silakan hubungi kontak di bawah jika memiliki pertanyaan seputar aplikasi LaraPress.</p>
                </div>

                <!-- Informasi Kontak -->
                <div style="margin-bottom: 24px;">
                    <div class="contact-item">
                        <span class="contact-label">Nama Penanggung Jawab</span>
                        <span class="contact-value">Silvina Lara</span>
                    </div>

                    <div class="contact-item">
                        <span class="contact-label">Nomor Telepon / WhatsApp</span>
                        <span class="contact-value">
                            <a href="tel:085244567098">0852-4456-7098</a>
                        </span>
                    </div>

                    <div class="contact-item">
                        <span class="contact-label">Media Sosial</span>
                        <span class="contact-value">
                            Instagram: <a href="https://www.instagram.com/7_dilz_?stkn=MXZ5cWFmam1lcHQ4eA==" target="_blank" rel="noopener noreferrer">@7_dilz_</a>
                        </span>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 10px; margin-top: 20px;">
                    <a href="/" class="btn-simple btn-simple-secondary">
                        Kembali ke Halaman Utama
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
