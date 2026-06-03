<!DOCTYPE html>
<html>
<head>
    <title>Laporan Global Hasil Ujian</title>
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
        <h3>LAPORAN GLOBAL HASIL UJIAN ONLINE</h3>
    </div>

    <p>Tanggal Cetak: {{ date('d F Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Mata Pelajaran</th>
                <th>Kelas</th>
                <th>Jumlah Soal</th>
                <th>Peserta Selesai</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporan as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->mata_pelajaran }}</td>
                    <td>{{ $item->kelas }}</td>
                    <td>{{ $item->soals_count }}</td>
                    <td>{{ $item->hasil_ujians_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Padang, {{ date('d F Y') }}</p>
        <br><br><br>
        <p><b>Ir. Yunita Nazar, MP</b></p>
    </div>
</body>
</html>
