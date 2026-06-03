<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mengerjakan Ujian - Sistem Ujian Online</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            user-select: none; /* Mencegah seleksi teks */
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
            color: #1f2937;
            height: 100vh;
            display: flex;
            flex-direction: column;
            overflow: hidden; /* Mencegah scroll body */
        }

        /* Header / Topbar */
        .topbar {
            background-color: #059669; /* Emerald 600 */
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            z-index: 10;
        }

        .exam-title {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .timer-container {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background-color: #047857; /* Emerald 700 */
            padding: 0.5rem 1.5rem;
            border-radius: 9999px;
            font-weight: 700;
            font-size: 1.25rem;
            letter-spacing: 1px;
            border: 2px solid #34d399;
        }

        .timer-warning {
            color: #fca5a5;
            border-color: #ef4444;
            animation: pulse 1s infinite;
        }

        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }

        /* Layout Utama */
        .main-container {
            display: flex;
            flex: 1;
            overflow: hidden;
        }

        /* Sidebar Navigasi Soal */
        .sidebar {
            width: 300px;
            background-color: white;
            border-left: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 1rem;
            font-weight: 600;
            border-bottom: 1px solid #e5e7eb;
            background-color: #f9fafb;
            text-align: center;
        }

        .grid-soal {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 0.75rem; /* Memperlebar gap agar lebih rapi */
            padding: 1.5rem 1rem;
            overflow-y: auto;
            flex: 1;
            align-content: start; /* Mencegah item memanjang/stretch vertikal */
        }

        .btn-soal {
            aspect-ratio: 1; /* Membuatnya berbentuk kotak persegi sempurna */
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid transparent;
            border-radius: 0.375rem; /* Sedikit lebih membulat */
            font-weight: 600;
            cursor: pointer;
            background-color: #10b981; /* Warna hijau default */
            color: white;
            transition: all 0.2s;
            font-size: 0.95rem;
            padding: 0;
        }

        .btn-soal:hover {
            background-color: #059669; /* Hijau lebih gelap saat dihover */
        }

        .btn-soal.dijawab {
            background-color: #ef4444; /* Berubah jadi Merah jika sudah dijawab */
            border-color: #ef4444;
            color: white;
        }

        .btn-soal.aktif {
            border: 3px solid #064e3b; /* Border hijau sangat gelap agar terlihat jelas saat aktif */
            font-weight: 800;
            transform: scale(1.05); /* Sedikit membesar agar stand out */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.2);
        }

        .sidebar-footer {
            padding: 1rem;
            border-top: 1px solid #e5e7eb;
        }

        .btn-submit {
            width: 100%;
            background-color: #ef4444; /* Red */
            color: white;
            border: none;
            padding: 0.75rem;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
            font-size: 1rem;
        }

        .btn-submit:hover {
            background-color: #dc2626;
        }

        /* Area Konten Soal */
        .content-area {
            flex: 1;
            padding: 2rem;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .card-soal {
            background-color: white;
            border-radius: 0.75rem;
            padding: 2.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            max-width: 800px;
            margin: 0 auto;
            width: 100%;
        }

        .nomor-soal {
            font-size: 1.125rem;
            font-weight: 600;
            color: #059669;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f0fdf4;
        }

        .teks-soal {
            font-size: 1.125rem;
            line-height: 1.7;
            margin-bottom: 2rem;
        }

        .opsi-jawaban {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .opsi-label {
            display: flex;
            align-items: center;
            padding: 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .opsi-label:hover {
            background-color: #f9fafb;
            border-color: #9ca3af;
        }

        .opsi-radio {
            margin-right: 1rem;
            width: 1.25rem;
            height: 1.25rem;
            accent-color: #059669;
        }

        /* Checked State styling via CSS trick */
        input[type="radio"]:checked + .opsi-text {
            font-weight: 600;
            color: #059669;
        }

        .opsi-label:has(input[type="radio"]:checked) {
            border-color: #059669;
            background-color: #f0fdf4;
        }

        .navigasi-bawah {
            display: flex;
            justify-content: space-between;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e5e7eb;
        }

        .btn-nav {
            padding: 0.5rem 1.5rem;
            background-color: white;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-nav:hover:not(:disabled) {
            background-color: #f3f4f6;
        }

        .btn-nav:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Monitoring Indicator */
        .monitoring-indicator {
            position: fixed;
            bottom: 1.5rem;
            left: 1.5rem;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            z-index: 100;
        }

        .dot-pulse {
            width: 8px;
            height: 8px;
            background-color: #34d399;
            border-radius: 50%;
            animation: pulse-dot 1.5s infinite;
        }

        @keyframes pulse-dot {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(52, 211, 153, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(52, 211, 153, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(52, 211, 153, 0); }
        }
        
        /* (Modal CSS dihapus) */

        /* Form khusus untuk submit data */
        #formUjian {
            display: none;
        }
    </style>
</head>
<body>

    <div class="topbar">
        <div class="exam-title">{{ $ujian->judul }} - {{ $ujian->mata_pelajaran }}</div>
        <div class="timer-container" id="timer">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span id="timeDisplay">{{ str_pad(floor($ujian->durasi), 2, '0', STR_PAD_LEFT) }}:00</span>
        </div>
    </div>

    <div class="main-container">
        <!-- Area Konten -->
        <div class="content-area">
            <div class="card-soal">
                <div class="nomor-soal" id="nomorSoalText">Soal No. 1</div>
                <div class="teks-soal" id="teksSoalContainer">
                    <!-- Teks soal dummy -->
                </div>
                
                <div class="opsi-jawaban" id="opsiContainer">
                    <!-- Pilihan Ganda -->
                </div>

                <div class="navigasi-bawah">
                    <button class="btn-nav" id="btnPrev" onclick="gantiSoal(soalAktif - 1)">Kembali</button>
                    <button class="btn-nav" id="btnNext" onclick="gantiSoal(soalAktif + 1)">Selanjutnya</button>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">Navigasi Soal</div>
            <div class="grid-soal" id="navigasiSoalContainer" style="flex: none; border-bottom: 1px solid #e5e7eb;">
                <!-- Tombol navigasi soal akan di-generate via JS -->
            </div>
            <div class="sidebar-footer">
                <button type="button" class="btn-submit" onclick="konfirmasiSubmit()">Akhiri Ujian</button>
            </div>
        </div>
    </div>

    <div class="monitoring-indicator">
        <div class="dot-pulse"></div>
        Sistem Memantau Aktivitas
    </div>

    <!-- Modal Pelanggaran (Dihapus) -->

    <!-- Overlay Mulai Ujian -->
    <div id="startExamOverlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(5, 150, 105, 0.95); z-index: 9999; display: flex; flex-direction: column; justify-content: center; align-items: center; color: white; backdrop-filter: blur(5px);">
        <h1 style="font-size: 2.5rem; margin-bottom: 1rem; font-weight: 700;">Ujian Siap Dimulai</h1>
        <p style="margin-bottom: 2rem; font-size: 1.125rem; text-align: center; max-width: 600px;">Sistem membutuhkan interaksi Anda untuk mengaktifkan mode Layar Penuh (Fullscreen) demi keamanan ujian. Klik tombol di bawah untuk masuk dan memulai timer.</p>
        <button id="btnStartOverlay" style="padding: 1rem 2.5rem; font-size: 1.25rem; border-radius: 9999px; background-color: white; color: #059669; border: none; font-weight: bold; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); transition: transform 0.2s;">Masuk Mode Ujian</button>
    </div>

    <!-- Hidden form to submit -->
    <form id="formUjian" action="{{ route('siswa.ujian.submit', ['id' => $id]) }}" method="POST">
        @csrf
        <input type="hidden" name="answers" id="inputAnswers">
        <input type="hidden" name="violations" id="inputViolations">
    </form>

    <script>
        // Data dari Database (di-inject via Controller)
        const soalData = @json($soals);
        const totalSoal = soalData.length;
        
        let soalAktif = 1;
        let jawabanSiswa = {}; // Format {1: 'A', 2: 'C', ...}
        let jumlahPelanggaran = 0;
        let isFinished = false; // Flag untuk menandai ujian sudah selesai/sedang disubmit

        // Inisialisasi Soal
        function inisialisasiMock() {
            const container = document.getElementById('navigasiSoalContainer');
            for (let i = 1; i <= totalSoal; i++) {
                const btn = document.createElement('div');
                btn.className = 'btn-soal';
                btn.id = `nav-${i}`;
                btn.innerText = i;
                btn.onclick = () => gantiSoal(i);
                container.appendChild(btn);
            }
            if(totalSoal > 0) gantiSoal(1);
        }

        // Render Soal
        function gantiSoal(nomor) {
            if(nomor < 1 || nomor > totalSoal) return;
            
            // Dapatkan data soal aktual (index = nomor - 1)
            const soalCurrent = soalData[nomor - 1];
            
            // Update UI Navigasi
            document.querySelectorAll('.btn-soal').forEach(btn => btn.classList.remove('aktif'));
            document.getElementById(`nav-${nomor}`).classList.add('aktif');
            
            soalAktif = nomor;
            document.getElementById('nomorSoalText').innerText = `Soal No. ${nomor}`;
            
            // Hapus angka di awal teks soal (misal "25. Apa..." atau "<p>25. Apa...")
            let pertanyaanBersih = soalCurrent.pertanyaan;
            if (pertanyaanBersih) {
                pertanyaanBersih = pertanyaanBersih.replace(/^(?:\s*<[^>]+>\s*)*\d+[\.\)]\s*/i, function(match) {
                    return match.replace(/\d+[\.\)]\s*/, '');
                });
            }
            
            // Pertanyaan aktual
            document.getElementById('teksSoalContainer').innerHTML = `<p>${pertanyaanBersih}</p>`;
            
            // Render Opsi
            const opsiContainer = document.getElementById('opsiContainer');
            opsiContainer.innerHTML = '';
            
            const pilihan = ['A', 'B', 'C', 'D', 'E'];
            
            pilihan.forEach((huruf) => {
                const teksPilihan = soalCurrent.opsi[huruf];
                if (!teksPilihan || teksPilihan.trim() === '') return; // Lewati jika opsi kosong

                const label = document.createElement('label');
                label.className = 'opsi-label';
                
                const isChecked = jawabanSiswa[nomor] === huruf ? 'checked' : '';
                
                label.innerHTML = `
                    <input type="radio" name="jawaban" value="${huruf}" class="opsi-radio" ${isChecked} onchange="simpanJawaban(${nomor}, '${huruf}')">
                    <span class="opsi-text">${huruf}. ${teksPilihan}</span>
                `;
                opsiContainer.appendChild(label);
            });

            // Atur tombol prev/next
            document.getElementById('btnPrev').disabled = (nomor === 1);
            document.getElementById('btnNext').disabled = (nomor === totalSoal);
        }

        // Simpan Jawaban
        function simpanJawaban(nomor, opsi) {
            jawabanSiswa[nomor] = opsi;
            document.getElementById(`nav-${nomor}`).classList.add('dijawab');
            
            // Log aktivitas ke server (Asynchronous)
            logAktivitas('menjawab', { soal: nomor, opsi: opsi });
        }

        // Timer Logic (Dari Controller)
        let sisaWaktu = {{ isset($sisaWaktuDetik) ? floor($sisaWaktuDetik) : ($ujian->durasi * 60) }}; // durasi sisa ujian dalam detik
        let timerInterval;
        
        function updateTimer() {
            let menit = Math.floor(sisaWaktu / 60);
            let detik = sisaWaktu % 60;
            
            menit = menit < 10 ? '0' + menit : menit;
            detik = detik < 10 ? '0' + detik : detik;
            
            document.getElementById('timeDisplay').innerText = `${menit}:${detik}`;
            
            if (sisaWaktu <= 300) { // 5 Menit Terakhir
                document.getElementById('timer').classList.add('timer-warning');
            }
            
            if (sisaWaktu <= 0) {
                clearInterval(timerInterval);
                alert("Waktu Habis! Ujian akan disubmit secara otomatis.");
                submitUjian();
            } else {
                sisaWaktu--;
            }
        }
        
        // Fungsi untuk memulai ujian dari overlay
        function startUjian() {
            let elem = document.documentElement;
            if (elem.requestFullscreen) {
                elem.requestFullscreen().catch(e => console.log("Fullscreen error:", e));
            }
            
            document.getElementById('startExamOverlay').style.display = 'none';
            
            inisialisasiMock();
            logAktivitas('mulai_ujian', {});
            
            // Mulai timer
            timerInterval = setInterval(updateTimer, 1000);
            updateTimer();
        }

        document.getElementById('btnStartOverlay').addEventListener('click', startUjian);

        // Submit Logic
        function konfirmasiSubmit() {
            const terjawab = Object.keys(jawabanSiswa).length;
            const belumTerjawab = totalSoal - terjawab;
            
            let pesan = `Anda telah menjawab ${terjawab} dari ${totalSoal} soal.\n`;
            if(belumTerjawab > 0) {
                pesan += `Masih ada ${belumTerjawab} soal yang belum dijawab.\n\n`;
            }
            pesan += "Apakah Anda yakin ingin mengakhiri ujian ini?";
            
            if(confirm(pesan)) {
                submitUjian();
            }
        }

        function submitUjian() {
            isFinished = true; // Tandai sudah selesai agar tidak muncul peringatan pelanggaran saat pindah halaman
            document.getElementById('inputAnswers').value = JSON.stringify(jawabanSiswa);
            document.getElementById('inputViolations').value = jumlahPelanggaran;
            document.getElementById('formUjian').submit();
        }

        // --- SISTEM KEAMANAN (ANTI CHEAT) ---

        // 1. Blokir Klik Kanan
        document.addEventListener('contextmenu', event => event.preventDefault());

        // 2. Blokir Copy Paste
        document.addEventListener('copy', event => {
            event.preventDefault();
            catatPelanggaran("Mencoba Copy");
        });
        document.addEventListener('paste', event => event.preventDefault());

        // 3. Blokir Shortcut Keyboard Tertentu (F12, Ctrl+Shift+I, PrintScreen, dll)
        document.addEventListener('keydown', function(event) {
            // Blokir Print Screen
            if (event.key === 'PrintScreen' || event.keyCode === 44) {
                event.preventDefault();
                navigator.clipboard.writeText('Screenshots are disabled.');
                catatPelanggaran("Mencoba Screenshot (Print Screen)");
            }
            // Blokir Win + Shift + S (Snipping Tool Windows) atau Cmd + Shift + S (Mac)
            if ((event.metaKey || event.ctrlKey) && event.shiftKey && (event.key === 's' || event.key === 'S')) {
                event.preventDefault();
                catatPelanggaran("Mencoba Alat Screenshot");
            }
            // F12
            if (event.key === 'F12') {
                event.preventDefault();
            }
            // Ctrl+Shift+I atau Ctrl+Shift+J atau Ctrl+U
            if (event.ctrlKey && event.shiftKey && (event.key === 'I' || event.key === 'J' || event.key === 'i' || event.key === 'j')) {
                event.preventDefault();
            }
            if (event.ctrlKey && (event.key === 'U' || event.key === 'u')) {
                event.preventDefault();
            }
        });

        // 3b. Mencegah Print Screen di keyup karena pada beberapa OS tercatat saat dilepas
        document.addEventListener('keyup', function(event) {
            if (event.key === 'PrintScreen' || event.keyCode === 44) {
                navigator.clipboard.writeText('Screenshots are disabled.');
                catatPelanggaran("Mencoba Screenshot (Print Screen)");
            }
        });

        // 4. Deteksi Pindah Tab / Kehilangan Fokus
        document.addEventListener('visibilitychange', function() {
            if (document.visibilityState === 'hidden') {
                catatPelanggaran("Berpindah Tab/Aplikasi");
            }
        });

        window.addEventListener('blur', function() {
            catatPelanggaran("Kehilangan Fokus Jendela");
        });

        // 5. Mencegah user keluar tanpa menekan Akhiri Ujian
        window.addEventListener('beforeunload', function (e) {
            if (!isFinished) {
                e.preventDefault();
                e.returnValue = '';
            }
        });

        // 6. Enforce fullscreen jika terkeluar
        document.addEventListener('fullscreenchange', function() {
            if (!document.fullscreenElement && !isFinished) {
                document.documentElement.requestFullscreen().catch(e => {});
            }
        });

        // Paksa Fullscreen saat load (Mungkin memerlukan interaksi user jika direct visit)
        window.onload = () => {
            // Semua inisialisasi sekarang dijalankan ketika tombol Start di klik (via fungsi startUjian)
        };

        // Fungsi mencatat pelanggaran
        function catatPelanggaran(jenis) {
            if (isFinished) return; // Jika sudah submit/selesai, abaikan pelanggaran
            
            jumlahPelanggaran++;
            logAktivitas('pelanggaran', { jenis: jenis });
            
            // Jika sedang fullscreen dan keluar, paksa masuk lagi secara senyap
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen().catch(e => {});
            }
        }

        // Fungsi log ke server
        function logAktivitas(tipe, data) {
            fetch("{{ route('siswa.ujian.log', ['id' => $id]) }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ type: tipe, data: data, time: new Date().toISOString() })
            }).catch(e => console.error("Gagal mengirim log"));
        }
    </script>
</body>
</html>
