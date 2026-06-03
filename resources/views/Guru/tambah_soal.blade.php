<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Soal - Sistem Ujian Online</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --green-main: #059669; /* Hijau utama */
            --green-dark: #047857; /* Hijau tua untuk sidebar */
            --green-hover: #065f46; /* Efek hover sidebar */
            --bg-color: #f3f4f6; /* Latar abu-abu terang */
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
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            z-index: 20;
        }

        .user-profile {
            padding: 2.5rem 1rem 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .user-icon {
            width: 60px;
            height: 60px;
            background-color: rgba(255,255,255,0.2);
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
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            transition: all 0.3s ease;
            gap: 14px;
        }

        .nav-item:hover, .nav-item.active {
            background-color: var(--green-hover);
            color: white;
            border-left: 4px solid #34d399; /* Aksen hijau muda */
        }

        .nav-item i {
            width: 20px;
            text-align: center;
            font-size: 18px; /* Ukuran icon kecil ±16-20px */
            transition: transform 0.3s ease;
        }

        .nav-item:hover i, .nav-item.active i {
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
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
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

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-size: 0.95rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .form-control {
            width: 100%;
            padding: 0.8rem 1rem;
            border-radius: 8px;
            border: 1px solid #d1d5db;
            color: #374151;
            font-family: inherit;
            outline: none;
            transition: border-color 0.2s;
        }
        .form-control:focus {
            border-color: var(--green-main);
            box-shadow: 0 0 0 3px rgba(5,150,105,0.1);
        }

        .btn-primary {
            background-color: var(--green-main);
            color: white;
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            border: 1px solid var(--green-main);
            cursor: pointer;
        }
        .btn-primary:hover {
            background-color: var(--green-dark);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }

        .btn-outline {
            background-color: white;
            color: #4b5563;
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            border: 1px solid #d1d5db;
            cursor: pointer;
        }
        .btn-outline:hover {
            background-color: #f9fafb;
        }

        /* Footer */
        .footer {
            background-color: var(--green-main);
            color: white;
            text-align: center;
            padding: 1rem;
            font-size: 0.9rem;
            box-shadow: 0 -2px 8px rgba(0,0,0,0.1);
        }

        @media (max-width: 768px) {
            body { flex-direction: column; overflow: auto; }
            .sidebar { width: 100%; flex-direction: row; align-items: center; padding: 0 1rem; overflow-x: auto; }
            .user-profile { flex-direction: row; padding: 1rem; border-bottom: none; gap: 1rem; }
            .user-icon { width: 40px; height: 40px; font-size: 18px; margin-bottom: 0; }
            .sidebar-nav { display: flex; padding: 0; }
            .nav-item { padding: 1rem; border-left: none; border-bottom: 3px solid transparent; }
            .nav-item:hover, .nav-item.active { border-left: none; border-bottom: 3px solid #34d399; }
            .nav-item span { display: none; }
            .main-wrapper { flex: auto; overflow: visible; }
            .content { padding: 1.5rem; }
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
            <a href="/guru/kelola-soal" class="nav-item active">
                <i class="fas fa-file-pen"></i>
                <span>Kelola Soal</span>
            </a>
            <a href="/guru/hasil-ujian" class="nav-item">
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
        
        <!-- Header -->
        <header class="header">
            <h2>Sistem Ujian Online</h2>
        </header>

        <!-- Main Content Area -->
        <main class="content">
            <div style="margin-bottom: 2rem;">
                <h1 style="font-size: 1.75rem; color: var(--text-main); font-weight: 700; margin-bottom: 0.5rem;">Tambah Soal Baru</h1>
                <p style="color: var(--text-muted);">Masukkan detail pertanyaan dan opsi jawaban.</p>
            </div>

            <div style="background: white; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #e5e7eb; padding: 2rem;">
                <form action="#" method="POST">
                    @csrf
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label">Mata Pelajaran</label>
                            <select class="form-control" name="mata_pelajaran">
                                <option value="">Pilih Mata Pelajaran...</option>
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
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label">Kelas</label>
                            <select class="form-control" name="kelas">
                                <option value="">Pilih Kelas...</option>
                                <option value="10">Kelas 10</option>
                                <option value="11">Kelas 11</option>
                                <option value="12">Kelas 12</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Pertanyaan</label>
                        <textarea class="form-control" rows="4" placeholder="Ketik soal/pertanyaan di sini..." required></textarea>
                    </div>

                    <hr style="border: 0; border-top: 1px solid #e5e7eb; margin: 2rem 0;">
                    <h3 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 1.5rem; color: var(--text-main);">Opsi Jawaban</h3>

                    <div style="display: grid; gap: 1rem;">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <span style="font-weight: 600; width: 30px;">A.</span>
                            <input type="text" class="form-control" placeholder="Opsi A" required>
                        </div>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <span style="font-weight: 600; width: 30px;">B.</span>
                            <input type="text" class="form-control" placeholder="Opsi B" required>
                        </div>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <span style="font-weight: 600; width: 30px;">C.</span>
                            <input type="text" class="form-control" placeholder="Opsi C" required>
                        </div>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <span style="font-weight: 600; width: 30px;">D.</span>
                            <input type="text" class="form-control" placeholder="Opsi D" required>
                        </div>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <span style="font-weight: 600; width: 30px;">E.</span>
                            <input type="text" class="form-control" placeholder="Opsi E" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-top: 1.5rem;">
                        <label class="form-label">Kunci Jawaban</label>
                        <select class="form-control" style="max-width: 200px;">
                            <option value="A">Opsi A</option>
                            <option value="B">Opsi B</option>
                            <option value="C">Opsi C</option>
                            <option value="D">Opsi D</option>
                            <option value="E">Opsi E</option>
                        </select>
                    </div>

                    <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 2rem;">
                        <a href="/guru/kelola-soal" class="btn-outline">Batal</a>
                        <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Simpan Soal</button>
                    </div>
                </form>
            </div>
        </main>

        <!-- Footer -->
        <footer class="footer">
            <p>&copy; 2026 SMK Pariwisata Aisyiyah Sumbar</p>
        </footer>

    </div>

</body>
</html>
