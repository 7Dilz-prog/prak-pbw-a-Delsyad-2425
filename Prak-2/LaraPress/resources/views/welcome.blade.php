
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LaraPress Website</title>
    <meta name="description"
        content="Website Resmi Laravel">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400&display=swap"
        rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <!-- ====================================================================
         1. NAVBAR / HEADER
         ==================================================================== -->
    <header class="navbar" id="navbar">
        <div class="container">
            <a href="#home" class="nav-brand">
                <img src="" alt="Logo" class="brand-logo">
                <div class="brand-text">
                    <span class="brand-title">LaraPress</span>
                </div>
            </a>
        </div>
        <nav class="nav-links">
            <a href="/" class="nav-item" data-lang-key="nav_profile">Beranda</a>
            <a href="/tentang-kami" class="nav-item" data-lang-key="nav_kegiatan">Tentang Kami</a>
            <a href="/kontak" class="nav-item" data-lang-key="nav_struktur">Customer Service</a>
        </nav>
    </header>
    <section class="hero-section" id="home">
        <div class="hero-slider-bg" id="heroSliderBg">
        </div>
        <div class="hero-overlay"></div>

        <div class="container hero-content">
            <h1 class="hero-title">
                Selamat Datang di LaraPress
            </h1>
            <p class="hero-desc" data-lang-key="hero_desc">
                Ini adalah halaman utama dari aplikasi blog kita.
            </p>
            <div class="hero-actions">
                <!-- Tombol Desktop: Instagram & LinkedIn -->
                <a href="https://www.instagram.com/rnd_pancasila?utm_source=ig_web_button_share_sheet&igsi=ZDNlZDc0MzIxNw=="
                    class="btn-primary hero-btn-desktop" target="_blank" rel="noopener noreferrer">
                    <i class="fab fa-instagram"></i> <span data-lang-key="btn_hero_join">@rnd_pancasila</span>
                </a>
                <a href="https://www.linkedin.com/company/ukm-research-and-development-kmup/" class="btn-linkedin hero-btn-desktop"
                    target="_blank" rel="noopener noreferrer">
                    <i class="fab fa-linkedin"></i> <span data-lang-key="btn_hero_linkedin">UKM R&amp;D KMUP</span>
                </a>
            </div>
        </div>
    </section>
</body>
</html>
    