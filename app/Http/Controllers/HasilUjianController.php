<?php

namespace App\Http\Controllers;

use App\Models\HasilUjian;
use App\Models\Ujian;
use App\Models\AktivitasUjian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HasilUjianController extends Controller
{
    public function indexGuru(Request $request)
    {
        $query = HasilUjian::with(['user', 'ujian'])
            ->whereHas('ujian', function($q) {
                $q->where('guru_id', auth()->id());
            })
            ->whereHas('user', function($q) {
                $q->whereNotIn('email', ['admin@smk-aisyiyah.com', 'guru@smk-aisyiyah.com', 'kepsek@smk-aisyiyah.com']);
            });
        // Filter Ujian
        if ($request->filled('ujian')) {
            $query->where('ujian_id', $request->ujian);
        }

        // Filter Kelas
        if ($request->filled('kelas')) {
            $query->whereHas('ujian', function($q) use ($request) {
                $q->where('kelas', $request->kelas);
            });
        }

        // Search Nama Siswa
        if ($request->filled('search')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $hasilUjians = $query->latest()->paginate(15);
        $ujians = Ujian::where('guru_id', auth()->id())->select('id', 'judul')->get();

        // Statistik
        $statsQuery = HasilUjian::whereHas('ujian', function($q) {
                $q->where('guru_id', auth()->id());
            })->whereHas('user', function($q) {
            $q->whereNotIn('email', ['admin@smk-aisyiyah.com', 'guru@smk-aisyiyah.com', 'kepsek@smk-aisyiyah.com']);
        });

        $totalSiswa = (clone $statsQuery)->count();
        $kkm = 75;
        $lulusCount = (clone $statsQuery)->where('skor', '>=', $kkm)->count();
        $tidakLulusCount = $totalSiswa - $lulusCount;
        $rataRata = (clone $statsQuery)->avg('skor') ?? 0;
        
        $nilaiTertinggi = (clone $statsQuery)->max('skor') ?? 0;
        $nilaiTerendah = (clone $statsQuery)->min('skor') ?? 0;

        return view('Guru.hasil_ujian', compact(
            'hasilUjians', 
            'ujians', 
            'totalSiswa', 
            'lulusCount', 
            'tidakLulusCount', 
            'rataRata',
            'nilaiTertinggi',
            'nilaiTerendah',
            'kkm'
        ));
    }

    public function downloadLaporan(Request $request)
    {
        $query = HasilUjian::with(['user', 'ujian'])
            ->whereHas('ujian', function($q) {
                $q->where('guru_id', auth()->id());
            })
            ->whereHas('user', function($q) {
                $q->whereNotIn('email', ['admin@smk-aisyiyah.com', 'guru@smk-aisyiyah.com', 'kepsek@smk-aisyiyah.com']);
            });

        // Filter Ujian
        if ($request->filled('ujian')) {
            $query->where('ujian_id', $request->ujian);
        }

        // Filter Kelas
        if ($request->filled('kelas')) {
            $query->whereHas('ujian', function($q) use ($request) {
                $q->where('kelas', $request->kelas);
            });
        }

        // Search Nama Siswa
        if ($request->filled('search')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $hasilUjians = $query->latest()->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('Guru.laporan_pdf', compact('hasilUjians'));
        return $pdf->download('Laporan_Hasil_Ujian_Siswa.pdf');
    }
}
