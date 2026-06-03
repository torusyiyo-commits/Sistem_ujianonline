<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mulai Ujian - Sistem Ujian Online</title>
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
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 2rem;
        }

        .container {
            background-color: white;
            border-radius: 1rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            width: 100%;
            overflow: hidden;
        }

        .header {
            background-color: #059669; /* Emerald 600 */
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .header h1 {
            font-size: 1.875rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .content {
            padding: 2.5rem;
        }

        .exam-info {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            margin-bottom: 2.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .info-item {
            flex: 1;
            min-width: 200px;
        }

        .info-label {
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 0.25rem;
            font-weight: 500;
        }

        .info-value {
            font-size: 1.125rem;
            font-weight: 600;
            color: #111827;
        }

        .rules-section {
            background-color: #fef2f2; /* Light red */
            border-left: 4px solid #ef4444; /* Red */
            padding: 1.5rem;
            border-radius: 0.5rem;
            margin-bottom: 2.5rem;
        }

        .rules-title {
            color: #b91c1c; /* Dark red */
            font-weight: 700;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .rules-list {
            list-style-position: inside;
            color: #7f1d1d;
            space-y: 0.5rem;
        }

        .rules-list li {
            margin-bottom: 0.5rem;
        }

        .actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
            border: none;
            font-family: inherit;
            font-size: 1rem;
        }

        .btn-cancel {
            background-color: #f3f4f6;
            color: #4b5563;
        }

        .btn-cancel:hover {
            background-color: #e5e7eb;
        }

        .btn-start {
            background-color: #10b981; /* Emerald 500 */
            color: white;
        }

        .btn-start:hover {
            background-color: #059669; /* Emerald 600 */
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <h1>Konfirmasi Ujian</h1>
            <p>Sistem Ujian Online SMK Pariwisata Aisyiyah Sumbar</p>
        </div>
        
        <div class="content">
            <div class="exam-info">
                <div class="info-item">
                    <div class="info-label">Mata Pelajaran</div>
                    <div class="info-value">{{ $ujian->mata_pelajaran }} - {{ $ujian->judul }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Durasi Ujian</div>
                    <div class="info-value">{{ $ujian->durasi }} Menit</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Jumlah Soal</div>
                    @php
                        $jumlahSoalTampil = ($ujian->jumlah_soal_ditampilkan > 0 && $ujian->jumlah_soal_ditampilkan < $ujian->soals_count) 
                            ? $ujian->jumlah_soal_ditampilkan 
                            : $ujian->soals_count;
                    @endphp
                    <div class="info-value">{{ $jumlahSoalTampil }} Pilihan Ganda</div>
                </div>
            </div>

            <div class="rules-section">
                <div class="rules-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    Peraturan & Keamanan Ujian
                </div>
                <ul class="rules-list">
                    <li>Ujian akan berjalan dalam <strong>Mode Fullscreen</strong> (Layar Penuh).</li>
                    <li>Siswa <strong>dilarang keras keluar dari halaman ujian</strong> atau membuka tab/aplikasi lain.</li>
                    <li>Fungsi klik kanan, <em>copy</em>, dan <em>paste</em> telah dinonaktifkan.</li>
                    <li>Setiap percobaan pelanggaran akan dicatat otomatis oleh sistem.</li>
                    <li>Ujian akan otomatis tersubmit jika waktu habis.</li>
                </ul>
            </div>

            <div class="actions">
                <a href="{{ route('siswa.dashboard') }}" class="btn btn-cancel">Batal</a>
                <button id="btnStartExam" class="btn btn-start">Saya Mengerti, Mulai Ujian</button>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('btnStartExam').addEventListener('click', function() {
            // Meminta mode fullscreen lalu mengalihkan halaman
            let elem = document.documentElement;
            if (elem.requestFullscreen) {
                elem.requestFullscreen().then(() => {
                    window.location.href = "{{ route('siswa.ujian.kerjakan', ['id' => $id]) }}";
                }).catch(err => {
                    alert("Gagal mengaktifkan mode fullscreen. Harap izinkan browser untuk menampilkan layar penuh.");
                    // Fallback redirect jika browser memblokir (meski jarang pada user click)
                    window.location.href = "{{ route('siswa.ujian.kerjakan', ['id' => $id]) }}";
                });
            } else {
                // Browser tidak mendukung fullscreen API standar
                window.location.href = "{{ route('siswa.ujian.kerjakan', ['id' => $id]) }}";
            }
        });
    </script>
</body>
</html>
