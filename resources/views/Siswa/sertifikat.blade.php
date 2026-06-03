<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat Kelulusan Ujian</title>
    <style>
        @page { margin: 30px; }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;                                      
            padding: 0;
            background-color: #ffffff;
            color: #333333;
        }

        .certificate-container {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 60px 40px;
            text-align: center;
            border: 10px solid #059669; /* Emerald 600 */
        }

        .logo {
            width: 100px;
            margin-bottom: 20px;
        }

        .school-name {
            font-size: 24px;
            font-weight: bold;
            color: #059669;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .school-address {
            font-size: 12px;
            color: #666666;
            margin-bottom: 40px;
        }

        .title {
            font-size: 40px;
            font-weight: bold;
            color: #111827;
            margin-bottom: 30px;
            letter-spacing: 2px;
        }

        .subtitle {
            font-size: 16px;
            color: #4b5563;
            margin-bottom: 30px;
        }

        .student-name {
            font-size: 36px;
            font-weight: bold;
            color: #059669;
            margin-bottom: 30px;
            text-decoration: underline;
        }

        .description {
            font-size: 16px;
            line-height: 1.6;
            color: #374151;
            margin-bottom: 40px;
            padding: 0 50px;
        }

        .footer {
            margin-top: 60px;
            display: flex;
            justify-content: space-between;
            padding: 0 50px;
        }

        .signature-box {
            text-align: center;
            width: 250px;
            display: inline-block;
        }

        .signature-line {
            border-bottom: 1px solid #333;
            margin-bottom: 5px;
            height: 60px;
        }

        .signature-name {
            font-weight: bold;
            font-size: 14px;
        }

        .signature-title {
            font-size: 12px;
            color: #666;
        }

        .date {
            margin-top: 40px;
            font-size: 14px;
            font-style: italic;
        }

        /* Watermark */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 100px;
            color: rgba(5, 150, 105, 0.05);
            font-weight: bold;
            z-index: -1;
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <div class="watermark">LULUS UJIAN</div>
        
        <!-- Karena ini diexport PDF, base64 / path absolute lokal sangat disarankan untuk gambar. Kita pakai path dummy atau hilangkan logonya jika bermasalah -->
        <h1 class="school-name">SMK Pariwisata Aisyiyah Sumbar</h1>
        <p class="school-address">Sistem Ujian Online Terpadu</p>

        <h2 class="title">SERTIFIKAT KELULUSAN</h2>
        <p class="subtitle">Diberikan dengan penuh rasa bangga kepada:</p>

        <div class="student-name">{{ $nama_siswa ?? 'Siswa Teladan' }}</div>

        <p class="description">
            Telah menyelesaikan dan dinyatakan <strong>LULUS</strong> pada <strong>Ujian Akhir Semester (UAS)</strong> untuk mata pelajaran <strong>{{ $mata_pelajaran ?? 'Matematika' }}</strong> dengan hasil yang memuaskan dan telah memenuhi Kriteria Ketuntasan Minimal (KKM).
        </p>

        <div class="date">
            Diterbitkan pada: {{ \Carbon\Carbon::now()->format('d F Y') }}
        </div>

        <table style="width: 100%; margin-top: 60px;">
            <tr>
                <td style="width: 50%; text-align: center;">
                </td>
                <td style="width: 50%; text-align: center;">
                    <div class="signature-box">
                        <div class="signature-line"></div>
                        <div class="signature-name">Ir. Yunita Nazar, MP</div>
                        <div class="signature-title">Kepala Sekolah</div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
