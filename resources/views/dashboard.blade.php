<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Ujian Online - SMK Pariwisata Aisyiyah Sumbar</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fdfa;
            /* Extremely soft green background for the whole page */
            color: #333;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* Color Variables */
        :root {
            --primary-green: #059669;
            /* Emerald 600 - The main brand color */
            --dark-green: #047857;
            /* Emerald 700 - For hovers and headings */
            --light-green: #d1fae5;
            /* Emerald 100 - For backgrounds and accents */
            --white: #ffffff;
            --text-dark: #1f2937;
            --text-muted: #6b7280;
        }

        /* Navbar */
        .navbar {
            background-color: var(--primary-green);
            color: var(--white);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.25rem 5%;
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.15);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
            font-weight: 700;
            font-size: 1.25rem;
            letter-spacing: -0.02em;
        }

        .logo {
            width: 42px;
            height: 42px;
            background-color: var(--white);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: var(--primary-green);
            overflow: hidden;
        }

        .logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .navbar-menu {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .navbar-menu .nav-link {
            font-weight: 600;
            opacity: 0.9;
            transition: opacity 0.3s ease;
        }

        .navbar-menu .nav-link:hover {
            opacity: 1;
        }

        .btn-nav-login {
            background-color: var(--white);
            color: var(--primary-green) !important;
            padding: 0.6rem 1.5rem;
            border-radius: 999px;
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .btn-nav-login:hover {
            background-color: #f3f4f6;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transform: translateY(-1px);
        }

        /* Hero Section */
        .hero {
            text-align: center;
            padding: 7rem 5% 6rem;
            background: linear-gradient(135deg, #e6f9f0 0%, #ffffff 100%);
        }

        .hero h1 {
            font-size: 3.25rem;
            font-weight: 800;
            color: var(--dark-green);
            margin-bottom: 1.5rem;
            max-width: 900px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.2;
            letter-spacing: -0.025em;
        }

        .hero p {
            font-size: 1.15rem;
            color: var(--text-muted);
            max-width: 650px;
            margin: 0 auto 3rem;
        }

        .hero-buttons {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
        }

        .btn-primary {
            background-color: var(--primary-green);
            color: var(--white);
            padding: 1rem 2.5rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.05rem;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid var(--primary-green);
            box-shadow: 0 4px 6px -1px rgba(5, 150, 105, 0.2), 0 2px 4px -1px rgba(5, 150, 105, 0.1);
        }

        .btn-primary:hover {
            background-color: var(--dark-green);
            border-color: var(--dark-green);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(5, 150, 105, 0.3), 0 4px 6px -2px rgba(5, 150, 105, 0.15);
        }

        .btn-outline {
            background-color: transparent;
            color: var(--primary-green);
            padding: 1rem 2.5rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.05rem;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid var(--primary-green);
        }

        .btn-outline:hover {
            background-color: var(--light-green);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(5, 150, 105, 0.1);
        }

        /* Features Section */
        .features {
            padding: 6rem 5%;
            background-color: var(--white);
        }

        .features-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 2.5rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .feature-card {
            background-color: var(--white);
            padding: 3rem 2.5rem;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid #f1f5f9;
        }

        .feature-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 20px 25px -5px rgba(5, 150, 105, 0.1), 0 10px 10px -5px rgba(5, 150, 105, 0.04);
            border-color: var(--light-green);
        }

        .feature-icon {
            width: 72px;
            height: 72px;
            background-color: var(--light-green);
            border-radius: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 2rem;
            color: var(--primary-green);
            transition: transform 0.3s ease;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.05) rotate(5deg);
        }

        .feature-icon svg {
            width: 36px;
            height: 36px;
        }

        .feature-card h3 {
            font-size: 1.35rem;
            color: var(--text-dark);
            margin-bottom: 1rem;
            font-weight: 700;
            letter-spacing: -0.01em;
        }

        .feature-card p {
            color: var(--text-muted);
            font-size: 1rem;
            line-height: 1.7;
        }

        /* Footer */
        .footer {
            background-color: var(--primary-green);
            color: rgba(255, 255, 255, 0.9);
            text-align: center;
            padding: 2.5rem 5%;
            margin-top: 2rem;
        }

        .footer p {
            font-size: 0.95rem;
            font-weight: 400;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                gap: 1.25rem;
                padding: 1.5rem 5%;
            }

            .navbar-menu {
                gap: 1.5rem;
            }

            .hero {
                padding: 4rem 5% 3rem;
            }

            .hero h1 {
                font-size: 2.25rem;
            }

            .hero p {
                font-size: 1rem;
                margin-bottom: 2rem;
            }

            .hero-buttons {
                flex-direction: column;
                gap: 1rem;
            }

            .features {
                padding: 4rem 5%;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-brand">
            <div class="logo">
                <img src="{{ asset('logo smk.png') }}" alt="Logo SMK">
            </div>
            Sistem Ujian Online
        </div>
        <div class="navbar-menu">
            <a href="#" class="nav-link">Beranda</a>
            <a href="/login" class="btn-nav-login">Login</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero">
        <h1>Sistem Ujian Online<br>SMK Pariwisata Aisyiyah Sumbar</h1>
        <p>Akses ujian dengan mudah dan aman melalui platform berbasis web kami. Dilengkapi dengan teknologi deteksi
            aktivitas siswa untuk memastikan integritas selama pelaksanaan ujian.</p>
        <div class="hero-buttons">
            <a href="#fitur" class="btn-primary">Mulai</a>
            <a href="/login" class="btn-outline">Login</a>
        </div>
    </header>

    <!-- Features Section -->
    <section id="fitur" class="features">
        <div class="features-container">
            <!-- Card 1 -->
            <div class="feature-card">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h3>Ujian Online</h3>
                <p>Mengerjakan soal ujian secara fleksibel, real-time, dan stabil di berbagai perangkat kapan pun
                    dibutuhkan.</p>
            </div>

            <!-- Card 2 -->
            <div class="feature-card">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </div>
                <h3>Deteksi Aktivitas</h3>
                <p>Sistem mengunci ujian dalam mode layar penuh (fullscreen) dan menonaktifkan fungsi salin (copy) soal untuk menjaga fokus dan keamanan ujian.
                </p>
            </div>

            <!-- Card 3 -->
            <div class="feature-card">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <h3>Laporan Otomatis</h3>
                <p>Nilai dan evaluasi ujian akan direkap secara otomatis dan hanya dapat diakses oleh Guru serta Admin untuk menjaga kerahasiaan hasil siswa.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2026 Sistem Ujian Online SMK Pariwisata Aisyiyah Sumbar. Hak Cipta Dilindungi.</p>
    </footer>

</body>

</html>