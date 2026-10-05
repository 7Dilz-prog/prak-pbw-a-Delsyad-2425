<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LaraPress Website</title>
    <meta name="description" content="Website Resmi Laravel - LaraPress">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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
                    <a href="/kontak" class="nav-item">Customer Service</a>
                </nav>
            </div>
        </div>
    </header>

    
    <section class="hero-section" id="home">
        <div class="container hero-container">

            <h1 class="hero-title">
                Selamat Datang di <span class="gradient-text">LaraPress</span>
            </h1>

            <p class="hero-desc">
                Ini adalah halaman utama dari aplikasi blog LaraPress. Dibuat dengan Laravel untuk pembelajaran Praktikum Pemrograman Berbasis Web
            </p>
        </div>
    </section>

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