<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - LaraPress</title>

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
                    <a href="/tentang-kami" class="nav-item active">Tentang Kami</a>
                    <a href="/kontak" class="nav-item">Customer Service</a>
                </nav>
            </div>
        </div>
    </header>

    <div class="page-header">
        <div class="container">
             <div style="margin-bottom: 1.5rem; margin-top: 70px">
                <h2 style="font-size: 3.25rem; color: #ffffff; margin-bottom: 0.75rem;">Tentang <span class="gradient-text">LaraPress</span> </h2>
                <p style="color: var(--text-muted); font-size: 1.05rem; line-height: 1.7;">
                    LaraPress adalah sebuah proyek blog sederhana yang dibuat untuk mempelajari dasar-dasar framework <strong>Laravel 12</strong>.
                </p>
            </div>

            <div style="margin-top: 2rem; display: flex; gap: 1rem; flex-wrap: wrap; justify-content: center; align-items: center">
                <a href="/" class="btn btn-secondary" >
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Halaman Utama
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