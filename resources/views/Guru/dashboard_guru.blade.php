<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru - Sistem Ujian Online</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --green-main: #059669;
            /* Hijau utama */
            --green-dark: #047857;
            /* Hijau tua untuk sidebar */
            --green-hover: #065f46;
            /* Efek hover sidebar */
            --bg-color: #f3f4f6;
            /* Latar abu-abu terang */
            --text-main: #1f2937;
            --text-muted: #6b7280;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-main);
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background-color: var(--green-dark);
            color: white;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            z-index: 20;
        }

        .user-profile {
            padding: 2.5rem 1rem 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .user-icon {
            width: 60px;
            height: 60px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 1rem;
        }

        .user-name {
            font-weight: 600;
            font-size: 1.05rem;
            letter-spacing: 0.5px;
        }

        .sidebar-nav {
            padding: 1.5rem 0;
            flex: 1;
            overflow-y: auto;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 0.85rem 1.75rem;
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            transition: all 0.3s ease;
            gap: 14px;
        }

        .nav-item:hover,
        .nav-item.active {
            background-color: var(--green-hover);
            color: white;
            border-left: 4px solid #34d399;
            /* Aksen hijau muda */
        }

        .nav-item i {
            width: 20px;
            text-align: center;
            font-size: 18px;
            /* Ukuran icon kecil ±16-20px */
            transition: transform 0.3s ease;
        }

        .nav-item:hover i,
        .nav-item.active i {
            transform: scale(1.1);
        }

        .nav-item span {
            font-size: 0.95rem;
            font-weight: 500;
        }

        /* Main Area */
        .main-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* Header */
        .header {
            background-color: var(--green-main);
            color: white;
            padding: 1.25rem 2rem;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            z-index: 10;
        }

        .header h2 {
            font-weight: 600;
            font-size: 1.25rem;
            margin: 0;
            letter-spacing: 0.5px;
        }

        /* Content */
        .content {
            flex: 1;
            padding: 2.5rem 3rem;
            overflow-y: auto;
        }

        .welcome-section {
            margin-bottom: 2.5rem;
        }

        .welcome-section h1 {
            font-size: 1.75rem;
            color: var(--text-main);
            margin-bottom: 0.5rem;
            font-weight: 700;
        }

        .welcome-section p {
            color: var(--text-muted);
            font-size: 1rem;
        }

        /* Cards Grid */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 1.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            transition: all 0.3s ease;
            border: 1px solid #e5e7eb;
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            border-color: #34d399;
            /* Aksen hijau */
        }

        .card-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 1.25rem;
            color: var(--green-main);
            background-color: #d1fae5;
            /* Latar hijau super muda */
        }

        .card h3 {
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
            color: var(--text-main);
            font-weight: 600;
        }

        .card p {
            font-size: 0.9rem;
            color: var(--text-muted);
            line-height: 1.5;
        }

        /* Footer */
        .footer {
            background-color: var(--green-main);
            color: white;
            text-align: center;
            padding: 1rem;
            font-size: 0.9rem;
            box-shadow: 0 -2px 8px rgba(0, 0, 0, 0.1);
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            body {
                flex-direction: column;
                overflow: auto;
            }

            .sidebar {
                width: 100%;
                flex-direction: row;
                align-items: center;
                padding: 0 1rem;
                overflow-x: auto;
            }

            .user-profile {
                flex-direction: row;
                padding: 1rem;
                border-bottom: none;
                gap: 1rem;
            }

            .user-icon {
                width: 40px;
                height: 40px;
                font-size: 18px;
                margin-bottom: 0;
            }

            .sidebar-nav {
                display: flex;
                padding: 0;
            }

            .nav-item {
                padding: 1rem;
                border-left: none;
                border-bottom: 3px solid transparent;
            }

            .nav-item:hover,
            .nav-item.active {
                border-left: none;
                border-bottom: 3px solid #34d399;
            }

            .nav-item span {
                display: none;
            }

            .main-wrapper {
                flex: auto;
                overflow: visible;
            }

            .content {
                padding: 1.5rem;
            }

            .cards-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="user-profile">
            <div class="user-icon" style="background-color: transparent; overflow: hidden;">
                <img src="{{ asset('Guru.jpg') }}" alt="Foto Guru"
                    style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <div class="user-name">{{ Auth::user()->name ?? 'Guru' }}</div>
        </div>
        <nav class="sidebar-nav">
            <a href="/guru/dashboard" class="nav-item active">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            <a href="/guru/kelola-soal" class="nav-item">
                <i class="fas fa-file-pen"></i>
                <span>Kelola Soal</span>
            </a>
            <a href="/guru/hasil-ujian" class="nav-item">
                <i class="fas fa-chart-bar"></i>
                <span>Hasil Ujian Siswa</span>
            </a>

        </nav>
        <div class="sidebar-footer"
            style="padding: 1rem 0; border-top: 1px solid rgba(255,255,255,0.1); margin-top: auto;">
            <a href="/logout" class="nav-item" style="color: #fca5a5;"
                onclick="return confirm('Apakah Anda yakin ingin keluar?');">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="main-wrapper">

        <!-- Header -->
        <header class="header">
            <h2>Sistem Ujian Online</h2>
        </header>

        <!-- Main Content Area -->
        <main class="content">
            <div class="welcome-section">
                <h1>Selamat datang di sistem ujian online</h1>
            </div>

            <div class="cards-grid">
                <!-- Card 1 -->
                <a href="/guru/kelola-soal" class="card">
                    <div class="card-icon">
                        <i class="fas fa-file-pen"></i>
                    </div>
                    <h3>Kelola Soal</h3>
                    <p>tambah, edit, hapus soal</p>
                </a>

                <!-- Card 3 -->
                <a href="/guru/hasil-ujian" class="card">
                    <div class="card-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h3>Hasil Ujian</h3>
                    <p>melihat nilai siswa</p>
                </a>


            </div>
        </main>

        <!-- Footer -->
        <footer class="footer">
            <p>&copy; 2026 SMK Pariwisata Aisyiyah Sumbar</p>
        </footer>

    </div>

</body>

</html>