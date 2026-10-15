<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak - LaraPress</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>
<body>

    <header class="navbar" id="navbar">
        <div class="container">
            <div class="nav-wrapper">
                <a href="/" class="brand-wrapper">
                    <span class="brand-title">LaraPress</span>
                </a>
                <nav class="nav-links">
                    <a href="/tentang-kami" class="nav-item">Tentang Kami</a>
                    <a href="/kontak" class="nav-item active">Customer Service</a>
                </nav>
            </div>
        </div>
    </header>

    <div class="page-header">
        <div class="container">
            <h1 class="page-title">Hubungi Kami
        </div>
    </div>

    <div class="container subpage-container">
        <div class="info-box">
            <h3 style="font-size: 1.25rem; color: #ffffff; margin-bottom: 1.25rem;">
                <i class="fa-solid fa-address-card" style="color: var(--accent-indigo); margin-right: 0.4rem;"></i>
                Informasi Kontak
            </h3>

            <div class="info-item">
                <div class="info-details">
                    <h4>Nama Penanggung Jawab</h4>
                    <p>Silvina Lara</p>
                </div>
            </div>

            <div class="info-item">
                <div class="info-details">
                    <h4>Nomor Telepon / WhatsApp</h4>
                    <p><a href="tel:085244567098">085244567098</a></p>
                </div>
            </div>

            <div style="margin-top: 2rem; display: flex; gap: 1rem; flex-wrap: wrap;">
                <a href="/" class="btn btn-secondary">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Halaman Utama
                </a>
                <a href="https://www.instagram.com/7_dilz_?stkn=MXZ5cWFmam1lcHQ4eA==" target="_blank" rel="noopener noreferrer" class="btn btn-instagram">
                    <i class="fab fa-instagram"></i> Kunjungi Instagram
                </a>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-brand">
                    <span>LaraPress &copy; 2026</span>
                </div>
                <div>
                    <span style="font-size: 0.85rem; color: var(--text-muted);">
                        Praktikum Pemrograman Berbasis Web
                    </span>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>