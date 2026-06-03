<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Ujian Siswa - Sistem Ujian Online</title>
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

        /* Sidebar ... */
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
        }

        .nav-item i {
            width: 20px;
            text-align: center;
            font-size: 18px;
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

        .content {
            flex: 1;
            padding: 2.5rem 3rem;
            overflow-y: auto;
        }

        /* Filters */
        .filters-section {
            background: white;
            padding: 1.25rem;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.03);
            margin-bottom: 1.5rem;
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
            border: 1px solid #e5e7eb;
        }

        .filter-group {
            flex: 1;
            min-width: 200px;
        }

        .form-control {
            width: 100%;
            padding: 0.6rem 1rem;
            border-radius: 8px;
            border: 1px solid #d1d5db;
            color: #374151;
            font-family: inherit;
            outline: none;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            border-color: var(--green-main);
            box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
        }

        /* Summary Cards */
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .summary-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }

        .summary-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .icon-blue {
            background: #eff6ff;
            color: #3b82f6;
        }

        .icon-green {
            background: #f0fdf4;
            color: #22c55e;
        }

        .icon-red {
            background: #fef2f2;
            color: #ef4444;
        }

        .icon-yellow {
            background: #fefce8;
            color: #eab308;
        }

        .summary-info h3 {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 500;
            margin-bottom: 0.25rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .summary-info p {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-main);
            margin: 0;
        }

        /* Stats Bar */
        .stats-bar {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: space-around;
            align-items: center;
        }

        .stat-item {
            text-align: center;
        }

        .stat-label {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .stat-value {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--green-main);
        }

        /* Table */
        .table-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            border: 1px solid #e5e7eb;
        }

        .styled-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .styled-table th {
            padding: 1rem;
            font-weight: 600;
            color: #4b5563;
            font-size: 0.9rem;
            background-color: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
        }

        .styled-table td {
            padding: 1rem;
            color: #374151;
            font-size: 0.95rem;
            border-bottom: 1px solid #f3f4f6;
        }

        .styled-table tbody tr:hover {
            background-color: #f9fafb;
        }

        .badge {
            padding: 0.25rem 0.75rem;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .badge-success {
            background: #dcfce7;
            color: #166534;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
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

        @media (max-width: 1024px) {
            .summary-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

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

            .summary-grid {
                grid-template-columns: 1fr;
            }

            .stats-bar {
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="user-profile">
            <div class="user-icon" style="background-color: transparent; overflow: hidden;">
                <img src="{{ asset('Guru.jpg') }}" alt="Foto Guru" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <div class="user-name">{{ Auth::user()->name ?? 'Guru' }}</div>
        </div>
        <nav class="sidebar-nav">
            <a href="/guru/dashboard" class="nav-item">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            <a href="/guru/kelola-soal" class="nav-item">
                <i class="fas fa-file-pen"></i>
                <span>Kelola Soal</span>
            </a>
            <a href="/guru/hasil-ujian" class="nav-item active">
                <i class="fas fa-chart-bar"></i>
                <span>Hasil Ujian Siswa</span>
            </a>

        </nav>
        <div class="sidebar-footer" style="padding: 1rem 0; border-top: 1px solid rgba(255,255,255,0.1); margin-top: auto;">
            <a href="/logout" class="nav-item" style="color: #fca5a5;" onclick="return confirm('Apakah Anda yakin ingin keluar?');">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="main-wrapper">
        <header class="header">
            <h2>Sistem Ujian Online</h2>
        </header>

        <main class="content">
            <div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <h1 style="font-size: 1.75rem; color: var(--text-main); font-weight: 700; margin-bottom: 0.5rem;">Hasil
                        Ujian Siswa</h1>
                    <p style="color: var(--text-muted);">Lihat nilai dan statistik kelulusan siswa berdasarkan ujian.</p>
                </div>
                <a href="{{ route('hasil.ujian.download', request()->query()) }}" style="background-color: var(--green-main); color: white; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; box-shadow: 0 2px 4px rgba(5, 150, 105, 0.2); transition: background-color 0.2s;">
                    <i class="fas fa-download"></i> Unduh Laporan
                </a>
            </div>

            <form action="{{ route('hasil.ujian') }}" method="GET" class="filters-section">
                <div class="filter-group">
                    <select name="ujian" class="form-control" onchange="this.form.submit()">
                        <option value="">Pilih Ujian...</option>
                        @foreach($ujians as $u)
                            <option value="{{ $u->id }}" {{ request('ujian') == $u->id ? 'selected' : '' }}>{{ $u->judul }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group">
                    <select name="kelas" class="form-control" onchange="this.form.submit()">
                        <option value="">Pilih Kelas...</option>
                        <option value="10" {{ request('kelas') == '10' ? 'selected' : '' }}>Kelas X</option>
                        <option value="11" {{ request('kelas') == '11' ? 'selected' : '' }}>Kelas XI</option>
                        <option value="12" {{ request('kelas') == '12' ? 'selected' : '' }}>Kelas XII</option>
                    </select>
                </div>
                <div class="filter-group" style="flex: 2; position: relative;">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari nama siswa..."
                        style="padding-left: 2.5rem;">
                    <button type="submit"
                        style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer;">
                        <i class="fas fa-search" style="color: #9ca3af;"></i>
                    </button>
                </div>
            </form>

            <div class="summary-grid">
                <div class="summary-card">
                    <div class="summary-icon icon-blue"><i class="fas fa-users"></i></div>
                    <div class="summary-info">
                        <h3>Total Siswa</h3>
                        <p>{{ $totalSiswa }}</p>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon icon-green"><i class="fas fa-check-circle"></i></div>
                    <div class="summary-info">
                        <h3>Lulus</h3>
                        <p>{{ $lulusCount }}</p>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon icon-red"><i class="fas fa-times-circle"></i></div>
                    <div class="summary-info">
                        <h3>Tidak Lulus</h3>
                        <p>{{ $tidakLulusCount }}</p>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon icon-yellow"><i class="fas fa-star"></i></div>
                    <div class="summary-info">
                        <h3>Rata-Rata Nilai</h3>
                        <p>{{ number_format($rataRata, 1) }}</p>
                    </div>
                </div>
            </div>

            <div class="stats-bar">
                <div class="stat-item">
                    <div class="stat-label">Nilai Tertinggi</div>
                    <div class="stat-value">{{ number_format($nilaiTertinggi, 2) }}</div>
                </div>
                <div style="width: 1px; height: 40px; background-color: #e5e7eb;"></div>
                <div class="stat-item">
                    <div class="stat-label">Nilai Terendah</div>
                    <div class="stat-value" style="color: #ef4444;">{{ number_format($nilaiTerendah, 2) }}</div>
                </div>
                <div style="width: 1px; height: 40px; background-color: #e5e7eb;"></div>
                <div class="stat-item">
                    <div class="stat-label">KKM / Batas Kelulusan</div>
                    <div class="stat-value" style="color: #374151;">{{ number_format($kkm, 2) }}</div>
                </div>
            </div>

            <!-- Table Container -->
            <div class="table-container">
                <div style="overflow-x: auto;">
                    <table class="styled-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Nilai</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($hasilUjians as $index => $hasil)
                                <tr>
                                    <td>{{ $hasilUjians->firstItem() + $index }}</td>
                                    <td><span style="font-weight: 500;">{{ $hasil->user->name ?? 'N/A' }}</span></td>
                                    <td>Kelas {{ $hasil->ujian->kelas ?? '-' }}</td>
                                    <td><span style="font-weight: 600; color: {{ $hasil->skor >= $kkm ? 'inherit' : '#ef4444' }};">{{ $hasil->skor }}</span></td>
                                    <td>
                                        @if($hasil->skor >= $kkm)
                                            <span class="badge badge-success">Lulus</span>
                                        @else
                                            <span class="badge badge-danger">Tidak Lulus</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center; padding: 2rem;">Belum ada data hasil ujian.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div
                    style="padding: 1rem 1.5rem; border-top: 1px solid #e5e7eb; background: #f9fafb;">
                    {{ $hasilUjians->links() }}
                </div>
            </div>

        </main>

        <footer class="footer">
            <p>&copy; 2026 SMK Pariwisata Aisyiyah Sumbar</p>
        </footer>
    </div>
</body>

</html>