<!DOCTYPE html>
<html>
<head>
    <title>Laporan Hasil Ujian Siswa</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h2 { margin: 0; text-transform: uppercase; }
        .header p { margin: 5px 0 0; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .footer { margin-top: 30px; text-align: right; font-size: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>SMK Pariwisata Aisyiyah Sumbar</h2>
        <p>Jalan lumba lumba, Padang, Sumatera Barat</p>
        <h3>LAPORAN HASIL UJIAN SISWA</h3>
    </div>

    <p>Tanggal Cetak: {{ date('d F Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Mata Pelajaran</th>
                <th>Kelas</th>
                <th>Nilai</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hasilUjians as $index => $hasil)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $hasil->user->name ?? 'N/A' }}</td>
                    <td>{{ $hasil->ujian->mata_pelajaran ?? '-' }}</td>
                    <td>{{ $hasil->ujian->kelas ?? '-' }}</td>
                    <td>{{ $hasil->skor }}</td>
                    <td>{{ $hasil->skor >= 75 ? 'Lulus' : 'Tidak Lulus' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Padang, {{ date('d F Y') }}</p>
        <br><br><br>
        <p><b>Guru Pengawas</b></p>
    </div>
</body>
</html>
