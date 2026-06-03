<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Ujian - Sistem Ujian Online</title>
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
            background-color: #f0fdf4; /* Light green */
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
            max-width: 600px;
            width: 100%;
            overflow: hidden;
            text-align: center;
        }

        .header {
            background-color: #059669; /* Emerald 600 */
            color: white;
            padding: 2rem;
        }

        .header h1 {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .content {
            padding: 3rem 2rem;
        }

        /* Status Icon */
        .status-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 1.5rem;
        }

        .icon-lulus {
            background-color: #d1fae5;
            color: #059669;
        }

        .icon-gagal {
            background-color: #fee2e2;
            color: #ef4444;
        }

        .status-title {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .text-lulus { color: #059669; }
        .text-gagal { color: #ef4444; }

        .status-message {
            color: #4b5563;
            font-size: 1.125rem;
            line-height: 1.6;
            margin-bottom: 2.5rem;
        }

        /* Aturan pembatasan nilai */
        .info-nilai-tersembunyi {
            background-color: #f3f4f6;
            padding: 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .actions {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            max-width: 300px;
            margin: 0 auto;
        }

        .btn {
            display: inline-block;
            width: 100%;
            padding: 0.875rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
            border: none;
            font-family: inherit;
            font-size: 1rem;
        }

        .btn-primary {
            background-color: #059669; /* Emerald 600 */
            color: white;
        }

        .btn-primary:hover {
            background-color: #047857; /* Emerald 700 */
        }

        .btn-outline {
            background-color: transparent;
            color: #059669;
            border: 2px solid #059669;
        }

        .btn-outline:hover {
            background-color: #f0fdf4;
        }
    </style>
</head>
<body>

    <!-- Status kelulusan dan nilai telah dihitung dari Controller (UjianController) -->

    <div class="container">
        <div class="header">
            <h1>Ujian Selesai</h1>
        </div>
        
        <div class="content">
            @if($isLulus)
                <!-- Tampilan Lulus -->
                <div class="status-icon icon-lulus">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h2 class="status-title text-lulus">LULUS</h2>
                <p class="status-message">Selamat! Anda telah mencapai Kriteria Ketuntasan Minimal (KKM). Terima kasih telah menyelesaikan ujian dengan jujur.</p>
                
                <div class="info-nilai-tersembunyi">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Detail nilai ujian hanya dapat diakses oleh Guru.
                </div>

                <div class="actions">
                    <a href="{{ route('siswa.ujian.sertifikat', ['id' => $id]) }}" class="btn btn-primary" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="vertical-align: text-bottom; margin-right: 5px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Unduh Sertifikat
                    </a>
                    <a href="{{ route('siswa.dashboard') }}" class="btn btn-outline">Kembali ke Dashboard</a>
                </div>

            @else
                <!-- Tampilan Tidak Lulus -->
                <div class="status-icon icon-gagal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <h2 class="status-title text-gagal">BELUM LULUS</h2>
                <p class="status-message">Tetap semangat! Skor Anda saat ini belum mencapai Kriteria Ketuntasan Minimal (KKM). Silakan belajar lebih giat lagi.</p>
                
                <div class="info-nilai-tersembunyi">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Detail nilai ujian hanya dapat diakses oleh Guru.
                </div>

                <div class="actions">
                    <a href="{{ route('siswa.dashboard') }}" class="btn btn-primary">Kembali ke Dashboard</a>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Memastikan tidak bisa kembali ke halaman ujian via tombol back browser
        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            history.go(1);
        };
    </script>
</body>
</html>
