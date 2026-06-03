<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Bank Soal - Sistem Ujian Online</title>
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

        /* Buttons & Inputs for Kelola Soal */
        .btn-primary {
            background-color: var(--green-main);
            color: white;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            border: 1px solid var(--green-main);
            cursor: pointer;
        }

        .btn-primary:hover {
            background-color: var(--green-dark);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .btn-outline {
            background-color: white;
            color: var(--green-main);
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            border: 1px solid var(--green-main);
            cursor: pointer;
        }

        .btn-outline:hover {
            background-color: #f0fdf4;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transform: translateY(-2px);
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

        /* Table Design */
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
            background: #e0f2fe;
            color: #0369a1;
            padding: 0.25rem 0.75rem;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .btn-icon {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .btn-edit {
            background: #eff6ff;
            color: #2563eb;
        }

        .btn-edit:hover {
            background: #dbeafe;
        }

        .btn-delete {
            background: #fef2f2;
            color: #dc2626;
        }

        .btn-delete:hover {
            background: #fee2e2;
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

        /* Modal */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .modal-overlay.active {
            display: flex;
            opacity: 1;
        }

        .modal-content {
            background: white;
            width: 100%;
            max-width: 500px;
            border-radius: 12px;
            padding: 2rem;
            position: relative;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            transform: translateY(-20px);
            transition: transform 0.3s;
        }

        .modal-overlay.active .modal-content {
            transform: translateY(0);
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

            .filters-section {
                flex-direction: column;
            }

            .filters-section .filter-group {
                width: 100%;
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
            <a href="/guru/dashboard" class="nav-item">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            <a href="/guru/kelola-soal" class="nav-item active">
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
            <!-- Page Title & Actions -->
            <div
                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
                <h1 style="font-size: 1.75rem; color: var(--text-main); font-weight: 700;">Kelola Bank Soal</h1>
                <div style="display: flex; gap: 1rem;">
                    <button class="btn-outline" onclick="openModal()">
                        <i class="fas fa-upload"></i> Upload Soal
                    </button>

                </div>
            </div>

            <!-- Filters -->
            <form action="/guru/kelola-soal" method="GET" class="filters-section"
                style="background: white; padding: 1.25rem; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.03); margin-bottom: 1.5rem; display: flex; gap: 1rem; align-items: center; flex-wrap: wrap; border: 1px solid #e5e7eb;">
                <div class="filter-group" style="flex: 1; min-width: 200px;">
                    <select name="mapel" class="form-control" onchange="this.form.submit()">
                        <option value="">Semua Mata Pelajaran</option>
                        <option value="Pancasila dan Kewarganegaraan" {{ request('mapel') == 'Pancasila dan Kewarganegaraan' ? 'selected' : '' }}>Pancasila dan Kewarganegaraan</option>
                        <option value="PAI" {{ request('mapel') == 'PAI' ? 'selected' : '' }}>PAI</option>
                        <option value="Kuliner" {{ request('mapel') == 'Kuliner' ? 'selected' : '' }}>Kuliner</option>
                        <option value="Bimbingan Konseling" {{ request('mapel') == 'Bimbingan Konseling' ? 'selected' : '' }}>Bimbingan Konseling</option>
                        <option value="Bahasa Inggris" {{ request('mapel') == 'Bahasa Inggris' ? 'selected' : '' }}>Bahasa Inggris</option>
                        <option value="Kewirausahaan" {{ request('mapel') == 'Kewirausahaan' ? 'selected' : '' }}>Kewirausahaan</option>
                        <option value="Bahasa Jepang" {{ request('mapel') == 'Bahasa Jepang' ? 'selected' : '' }}>Bahasa Jepang</option>
                        <option value="Perhotelan" {{ request('mapel') == 'Perhotelan' ? 'selected' : '' }}>Perhotelan</option>
                        <option value="Matematika" {{ request('mapel') == 'Matematika' ? 'selected' : '' }}>Matematika</option>
                        <option value="Sejarah Indonesia" {{ request('mapel') == 'Sejarah Indonesia' ? 'selected' : '' }}>Sejarah Indonesia</option>
                        <option value="Informatika" {{ request('mapel') == 'Informatika' ? 'selected' : '' }}>Informatika</option>
                        <option value="Seni Budaya" {{ request('mapel') == 'Seni Budaya' ? 'selected' : '' }}>Seni Budaya</option>
                        <option value="Bahasa Indonesia" {{ request('mapel') == 'Bahasa Indonesia' ? 'selected' : '' }}>Bahasa Indonesia</option>
                        <option value="PJOK" {{ request('mapel') == 'PJOK' ? 'selected' : '' }}>PJOK</option>
                        <option value="Kemuhammadiyahan dan Tahsin" {{ request('mapel') == 'Kemuhammadiyahan dan Tahsin' ? 'selected' : '' }}>Kemuhammadiyahan dan Tahsin</option>
                    </select>
                </div>
                <div class="filter-group" style="flex: 1; min-width: 200px;">
                    <select name="kelas" class="form-control" onchange="this.form.submit()">
                        <option value="">Semua Kelas</option>
                        <option value="10" {{ request('kelas') == '10' ? 'selected' : '' }}>Kelas 10</option>
                        <option value="11" {{ request('kelas') == '11' ? 'selected' : '' }}>Kelas 11</option>
                        <option value="12" {{ request('kelas') == '12' ? 'selected' : '' }}>Kelas 12</option>
                    </select>
                </div>
                <div class="filter-group" style="flex: 2; min-width: 250px; position: relative;">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                        placeholder="Cari judul soal..." style="padding-left: 2.5rem;">
                    <button type="submit"
                        style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer;">
                        <i class="fas fa-search" style="color: #9ca3af;"></i>
                    </button>
                </div>
            </form>

            <!-- Table Container -->
            <div
                style="background: white; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid #e5e7eb;">
                <div style="overflow-x: auto;">
                    <table class="styled-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Mata Pelajaran</th>
                                <th>Kelas</th>
                                <th>Judul Soal / Nama File</th>
                                <th>Jadwal Ujian</th>
                                <th style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php /** @var \App\Models\Ujian[] $ujians */ ?>
                            @forelse($ujians ?? [] as $index => $ujian)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $ujian->mata_pelajaran }}</td>
                                    <td><span class="badge">Kelas {{ $ujian->kelas }}</span></td>
                                    <td>{{ $ujian->judul }}<br><small
                                            style="color: #6b7280;">{{ $ujian->file_sumber }}</small></td>
                                    <td style="color: #6b7280; font-size: 0.9rem;">
                                        @if($ujian->tanggal_ujian)
                                            <i class="fas fa-calendar-day"></i> {{ \Carbon\Carbon::parse($ujian->tanggal_ujian)->format('d M Y') }}<br>
                                            <i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($ujian->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($ujian->jam_selesai)->format('H:i') }}
                                        @else
                                            <span style="color: #9ca3af;">Belum diatur</span>
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                            <button class="btn-icon btn-edit" title="Edit"
                                                onclick="openEditModal({{ $ujian->id }}, '{{ addslashes($ujian->judul) }}', '{{ addslashes($ujian->mata_pelajaran) }}', '{{ $ujian->kelas }}', '{{ $ujian->durasi }}', '{{ $ujian->jumlah_soal_ditampilkan }}', '{{ $ujian->tanggal_ujian }}', '{{ $ujian->jam_mulai }}', '{{ $ujian->jam_selesai }}')"><i
                                                    class="fas fa-pencil-alt"></i></button>
                                            <form action="{{ route('kelola.soal.destroy', $ujian->id) }}" method="POST"
                                                style="display:inline;"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus ujian ini beserta seluruh soalnya?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-icon btn-delete" title="Hapus"><i
                                                        class="fas fa-trash-alt"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 2rem;">Belum ada bank soal yang
                                        diunggah.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(isset($ujians) && count($ujians) > 0)
                    <!-- Pagination Dummy (Bisa diganti dg Laravel Pagination) -->
                    <div
                        style="padding: 1rem 1.5rem; border-top: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; background: #f9fafb;">
                        <span style="font-size: 0.85rem; color: #6b7280;">Menampilkan {{ count($ujians) }} soal</span>
                    </div>
                @endif
            </div>
        </main>

        <!-- Footer -->
        <footer class="footer">
            <p>&copy; 2026 SMK Pariwisata Aisyiyah Sumbar</p>
        </footer>

    </div>

    <!-- Upload Modal -->
    <div id="uploadModal" class="modal-overlay">
        <form action="/guru/kelola-soal/upload" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin-bottom: 1.5rem;">Upload Bank
                Soal (Excel / Word)</h2>

            @if(session('error'))
                <div
                    style="background-color: #fee2e2; color: #ef4444; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                    {{ session('error') }}
                </div>
            @endif
            @if(session('success'))
                <div
                    style="background-color: #d1fae5; color: #059669; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                    {{ session('success') }}
                </div>
            @endif

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Judul Ujian</label>
                <input type="text" name="judul" class="form-control" required placeholder="Contoh: UAS Ganjil 2026">
            </div>

            <div style="display: flex; gap: 1rem; margin-bottom: 1rem;">
                <div style="flex: 1;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Mata Pelajaran</label>
                    <select name="mata_pelajaran" class="form-control" required>
                        <option value="Pancasila dan Kewarganegaraan">Pancasila dan Kewarganegaraan</option>
                        <option value="PAI">PAI</option>
                        <option value="Kuliner">Kuliner</option>
                        <option value="Bimbingan Konseling">Bimbingan Konseling</option>
                        <option value="Bahasa Inggris">Bahasa Inggris</option>
                        <option value="Kewirausahaan">Kewirausahaan</option>
                        <option value="Bahasa Jepang">Bahasa Jepang</option>
                        <option value="Perhotelan">Perhotelan</option>
                        <option value="Matematika">Matematika</option>
                        <option value="Sejarah Indonesia">Sejarah Indonesia</option>
                        <option value="Informatika">Informatika</option>
                        <option value="Seni Budaya">Seni Budaya</option>
                        <option value="Bahasa Indonesia">Bahasa Indonesia</option>
                        <option value="PJOK">PJOK</option>
                        <option value="Kemuhammadiyahan dan Tahsin">Kemuhammadiyahan dan Tahsin</option>
                    </select>
                </div>
                <div style="flex: 1;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Kelas</label>
                    <select name="kelas" class="form-control" required>
                        <option value="10">Kelas 10</option>
                        <option value="11">Kelas 11</option>
                        <option value="12">Kelas 12</option>
                    </select>
                </div>
                <div style="flex: 1;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Durasi (Menit)</label>
                    <input type="number" name="durasi" class="form-control" required value="90" min="10">
                </div>
                <div style="flex: 1;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Jml Soal Tampil</label>
                    <input type="number" name="jumlah_soal_ditampilkan" class="form-control" placeholder="Kosongkan = Tampil Semua" min="1">
                </div>
            </div>



            <input type="file" id="fileUpload" name="file_soal" style="display: none;"
                onchange="document.getElementById('fileName').innerText = this.files[0].name" accept=".xls,.xlsx,.doc,.docx"
                required>

            <div onclick="document.getElementById('fileUpload').click()"
                style="border: 2px dashed #d1d5db; border-radius: 8px; padding: 2rem; text-align: center; margin-bottom: 1rem; background: #f9fafb; cursor: pointer; transition: border-color 0.3s;"
                onmouseover="this.style.borderColor='var(--green-main)'" onmouseout="this.style.borderColor='#d1d5db'">
                <i class="fas fa-file-upload"
                    style="font-size: 2.5rem; color: var(--green-main); margin-bottom: 1rem;"></i>
                <p id="fileName" style="font-size: 1rem; color: #4b5563; font-weight: 500; margin-bottom: 0.5rem;">Klik
                    untuk memilih file Excel (.xlsx) atau Word (.docx)</p>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-bottom: 1.5rem;">
                <a href="{{ route('kelola.soal.template', ['type' => 'excel']) }}"
                    style="color: var(--green-main); text-decoration: none; font-size: 0.9rem; font-weight: 600;"><i
                        class="fas fa-file-excel"></i> Template Excel</a>
                <a href="{{ route('kelola.soal.template', ['type' => 'word']) }}"
                    style="color: #2563eb; text-decoration: none; font-size: 0.9rem; font-weight: 600;"><i
                        class="fas fa-file-word"></i> Template Word</a>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 1rem;">
                <button type="button" onclick="closeModal()"
                    style="padding: 0.6rem 1.2rem; background: white; border: 1px solid #d1d5db; border-radius: 8px; font-weight: 500; color: #374151; cursor: pointer;">Batal</button>
                <button type="submit" class="btn-primary">Upload & Simpan</button>
            </div>
        </form>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="modal-overlay">
        <form id="editForm" method="POST" class="modal-content">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h2>Edit Data Ujian</h2>
            </div>

            <div class="modal-body">
                <div class="form-group" style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Judul Ujian / Soal</label>
                    <input type="text" id="edit_judul" name="judul" class="form-control" required
                        style="width: 100%; padding: 0.6rem; border: 1px solid #d1d5db; border-radius: 8px;">
                </div>

                <div style="display: flex; gap: 1rem; margin-bottom: 1rem;">
                    <div style="flex: 1;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Mata Pelajaran</label>
                        <select id="edit_mata_pelajaran" name="mata_pelajaran" class="form-control" required
                            style="width: 100%; padding: 0.6rem; border: 1px solid #d1d5db; border-radius: 8px;">
                            <option value="">Pilih Mata Pelajaran</option>
                            <option value="Pancasila dan Kewarganegaraan">Pancasila dan Kewarganegaraan</option>
                            <option value="PAI">PAI</option>
                            <option value="Kuliner">Kuliner</option>
                            <option value="Bimbingan Konseling">Bimbingan Konseling</option>
                            <option value="Bahasa Inggris">Bahasa Inggris</option>
                            <option value="Kewirausahaan">Kewirausahaan</option>
                            <option value="Bahasa Jepang">Bahasa Jepang</option>
                            <option value="Perhotelan">Perhotelan</option>
                            <option value="Matematika">Matematika</option>
                            <option value="Sejarah Indonesia">Sejarah Indonesia</option>
                            <option value="Informatika">Informatika</option>
                            <option value="Seni Budaya">Seni Budaya</option>
                            <option value="Bahasa Indonesia">Bahasa Indonesia</option>
                            <option value="PJOK">PJOK</option>
                            <option value="Kemuhammadiyahan dan Tahsin">Kemuhammadiyahan dan Tahsin</option>
                        </select>
                    </div>

                    <div style="flex: 1;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Kelas</label>
                        <select id="edit_kelas" name="kelas" class="form-control" required
                            style="width: 100%; padding: 0.6rem; border: 1px solid #d1d5db; border-radius: 8px;">
                            <option value="">Pilih Kelas</option>
                            <option value="10">Kelas 10</option>
                            <option value="11">Kelas 11</option>
                            <option value="12">Kelas 12</option>
                        </select>
                    </div>
                </div>

                <div style="display: flex; gap: 1rem; margin-bottom: 1rem;">
                    <div style="flex: 1;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Durasi (Menit)</label>
                        <input type="number" id="edit_durasi" name="durasi" class="form-control" required min="10">
                    </div>
                    <div style="flex: 1;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Jml Soal Tampil</label>
                        <input type="number" id="edit_jumlah_soal_ditampilkan" name="jumlah_soal_ditampilkan" class="form-control" placeholder="Kosongkan = Tampil Semua" min="1">
                    </div>
                    <div style="flex: 1;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Tanggal Ujian</label>
                        <input type="date" id="edit_tanggal_ujian" name="tanggal_ujian" class="form-control" required>
                    </div>
                </div>

                <div style="display: flex; gap: 1rem; margin-bottom: 1rem;">
                    <div style="flex: 1;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Jam Mulai</label>
                        <input type="time" id="edit_jam_mulai" name="jam_mulai" class="form-control" required>
                    </div>
                    <div style="flex: 1;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Jam Selesai</label>
                        <input type="time" id="edit_jam_selesai" name="jam_selesai" class="form-control" required>
                    </div>
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 1rem; padding-top: 1rem;">
                <button type="button" onclick="closeEditModal()"
                    style="padding: 0.6rem 1.2rem; background: white; border: 1px solid #d1d5db; border-radius: 8px; font-weight: 500; color: #374151; cursor: pointer;">Batal</button>
                <button type="submit" class="btn-primary"
                    style="padding: 0.6rem 1.2rem; background: var(--green-main); color: white; border: none; border-radius: 8px; font-weight: 500; cursor: pointer;">Simpan
                    Perubahan</button>
            </div>
        </form>
    </div>

    <script>
        function openModal() {
            const modal = document.getElementById('uploadModal');
            modal.style.display = 'flex';
            setTimeout(() => modal.classList.add('active'), 10);
        }
        function closeModal() {
            const modal = document.getElementById('uploadModal');
            modal.classList.remove('active');
            setTimeout(() => modal.style.display = 'none', 300);
        }

        function openEditModal(id, judul, mapel, kelas, durasi, jumlah_soal_ditampilkan, tanggal, jam_mulai, jam_selesai) {
            // Set action url
            document.getElementById('editForm').action = '/guru/kelola-soal/' + id;

            // Set values
            document.getElementById('edit_judul').value = judul;
            document.getElementById('edit_mata_pelajaran').value = mapel;
            document.getElementById('edit_kelas').value = kelas;
            document.getElementById('edit_durasi').value = durasi;
            document.getElementById('edit_jumlah_soal_ditampilkan').value = jumlah_soal_ditampilkan;
            document.getElementById('edit_tanggal_ujian').value = tanggal;
            document.getElementById('edit_jam_mulai').value = jam_mulai;
            document.getElementById('edit_jam_selesai').value = jam_selesai;

            // Show modal
            const modal = document.getElementById('editModal');
            modal.style.display = 'flex';
            setTimeout(() => modal.classList.add('active'), 10);
        }

        function closeEditModal() {
            const modal = document.getElementById('editModal');
            modal.classList.remove('active');
            setTimeout(() => modal.style.display = 'none', 300);
        }
    </script>
</body>

</html>