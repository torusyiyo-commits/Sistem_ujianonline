<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa - Sistem Ujian Online</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0fdf4; /* Light green background */
            color: #1f2937;
        }

        /* Navbar */
        .navbar {
            background-color: #059669; /* Emerald 600 */
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 5%;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
            font-weight: 700;
            font-size: 1.25rem;
        }

        .logo {
            width: 40px;
            height: 40px;
            background-color: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .navbar-menu {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .nav-link {
            color: white;
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            transition: background-color 0.2s;
        }

        .nav-link:hover, .nav-link.active {
            background-color: #047857; /* Emerald 700 */
        }

        .btn-logout {
            background-color: white;
            color: #ef4444; /* Red for logout */
            padding: 0.5rem 1.25rem;
            border-radius: 9999px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            border: 1px solid white;
        }

        .btn-logout:hover {
            background-color: #fee2e2;
        }

        /* Main Content */
        .main-content {
            padding: 3rem 5%;
            max-width: 1400px; /* Hampir full layar */
            margin: 0 auto;
            text-align: center; /* Untuk memposisikan header di tengah */
        }

        .page-header {
            margin-bottom: 4rem; /* Jarak diperbesar */
            padding-bottom: 1.5rem;
        }

        .page-title {
            font-size: 2.5rem; /* Lebih besar dan tegas */
            font-weight: 800;
            color: #065f46; /* Emerald 800 */
            margin-bottom: 0.5rem;
            letter-spacing: -0.025em;
        }
        
        .page-subtitle {
            color: #6b7280; /* Abu-abu yang lebih halus */
            font-size: 1.125rem;
        }

        /* Exam Grid Layout */
        .exam-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center; /* Memastikan jika hanya 1 card, akan di tengah */
            gap: 3rem; /* Jarak antar card diperlebar */
            text-align: left; /* Teks di dalam card tetap rata kiri */
        }

        .exam-card {
            background: white;
            border-radius: 1.25rem; /* Sudut lebih membulat */
            padding: 2.5rem; /* Padding lebih luas */
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01); /* Bayangan lebih halus */
            border: 1px solid #f3f4f6;
            display: flex;
            flex-direction: column;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            width: 100%;
            max-width: 480px; /* Ukuran card diperbesar */
        }

        .exam-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(5, 150, 105, 0.1), 0 10px 10px -5px rgba(5, 150, 105, 0.04);
            border-color: #a7f3d0; /* Emerald 200 */
        }

        .exam-status {
            display: inline-block;
            padding: 0.35rem 1rem;
            background-color: #d1fae5;
            color: #065f46;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 700;
            margin-bottom: 1.5rem; /* Jarak ke judul ditambah */
            align-self: flex-start;
        }

        .exam-title {
            font-size: 1.5rem; /* Judul lebih besar */
            font-weight: 800;
            color: #111827;
            margin-bottom: 1.25rem;
            line-height: 1.3;
        }

        .exam-meta-container {
            display: flex;
            flex-direction: column;
            gap: 0.875rem; /* Jarak antar informasi ditambah */
            margin-bottom: 2rem;
        }

        .exam-meta {
            color: #4b5563;
            font-size: 1.05rem; /* Teks informasi diperbesar */
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .exam-meta svg {
            width: 20px; /* Ikon lebih besar */
            height: 20px;
            color: #10b981; /* Emerald 500 */
        }

        .spacer {
            flex-grow: 1;
        }

        .btn-start {
            display: block;
            width: 100%;
            text-align: center;
            background-color: #10b981; /* Emerald 500 */
            color: white;
            padding: 1rem 1.5rem; /* Tombol lebih tinggi */
            border-radius: 0.75rem; /* Sudut tombol lebih bulat */
            font-weight: 700;
            font-size: 1.125rem; /* Teks tombol lebih besar */
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.2);
            margin-top: auto;
        }

        .btn-start:hover {
            background-color: #059669; /* Emerald 600 */
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.3);
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
            <span>Portal Siswa</span>
        </div>
        <div class="navbar-menu">
            <a href="{{ route('siswa.dashboard') }}" class="nav-link active">Daftar Ujian</a>
            <a href="{{ route('logout') }}" class="btn-logout" onclick="event.preventDefault(); if(confirm('Apakah Anda yakin ingin keluar?')) document.getElementById('logout-form').submit();">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="GET" style="display: none;">
                @csrf
            </form>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <div class="page-header" style="margin-bottom: 2rem;">
            <h1 class="page-title">Ujian Tersedia</h1>
            <p class="page-subtitle">Silakan pilih ujian yang ingin Anda kerjakan.</p>
        </div>



        @if(session('error'))
            <div style="background-color: #fee2e2; color: #ef4444; padding: 1rem; border-radius: 0.75rem; margin-bottom: 2rem; border: 1px solid #fecaca; text-align: left; font-weight: 500;">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        @forelse($groupedUjians ?? [] as $tanggal => $ujiansHariIni)
            <div style="width: 100%; max-width: 1400px; margin: 0 auto 2rem auto; border-bottom: 2px solid #a7f3d0; padding-bottom: 0.5rem; text-align: left;">
                <h2 style="font-size: 1.5rem; color: #047857; font-weight: 700;">
                    <i class="far fa-calendar-alt"></i> 
                    {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}
                </h2>
            </div>
            
            <div class="exam-grid" style="margin-bottom: 4rem;">
                @foreach($ujiansHariIni as $ujian)
                @php
                    $now = \Carbon\Carbon::now();
                    $isStarted = true;

                    if ($ujian->tanggal_ujian && $ujian->jam_mulai) {
                        $start = \Carbon\Carbon::parse($ujian->tanggal_ujian . ' ' . $ujian->jam_mulai);
                        if ($now->lt($start)) $isStarted = false;
                    }
                @endphp
                <div class="exam-card">
                    @if(!$isStarted)
                        <span class="exam-status" style="background-color: #fef3c7; color: #92400e;">Mendatang</span>
                    @else
                        <span class="exam-status">Aktif</span>
                    @endif
                    <h3 class="exam-title">{{ $ujian->judul }} - {{ $ujian->mata_pelajaran }}</h3>
                    
                    <div class="exam-meta-container">
                        <div class="exam-meta">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ \Carbon\Carbon::parse($ujian->tanggal_ujian)->format('d F Y') }} ({{ \Carbon\Carbon::parse($ujian->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($ujian->jam_selesai)->format('H:i') }})
                        </div>
                        <div class="exam-meta">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Durasi: {{ $ujian->durasi }} Menit
                        </div>

                    </div>
                    
                    <div class="spacer"></div>
                    @if($ujian->has_taken)
                        <button class="btn-start" style="background-color: #9ca3af; cursor: not-allowed;" disabled>Sudah Dikerjakan</button>
                    @elseif(!$isStarted)
                        <button class="btn-start" style="background-color: #fbbf24; cursor: not-allowed;" disabled>Belum Dimulai</button>
                    @elseif($ujian->soals_count > 0)
                        <a href="{{ route('siswa.ujian.mulai', ['id' => $ujian->id]) }}" class="btn-start">Mulai Ujian</a>
                    @else
                        <button class="btn-start" style="background-color: #9ca3af; cursor: not-allowed;" disabled>Soal Belum Tersedia</button>
                    @endif
                </div>
                @endforeach
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; color: #6b7280; padding: 3rem; width: 100%;">
                <h3>Belum ada ujian yang tersedia saat ini.</h3>
            </div>
        @endforelse
    </main>

</body>
</html>
