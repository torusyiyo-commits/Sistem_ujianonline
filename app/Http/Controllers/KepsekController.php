<?php

namespace App\Http\Controllers;

use App\Models\Ujian;
use App\Models\HasilUjian;
use App\Models\AktivitasUjian;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class KepsekController extends Controller
{

    public function hasilUjian(Request $request)
    {
        $query = HasilUjian::with(['user', 'ujian'])
            ->whereHas('user', function($q) {
                $q->whereNotIn('email', ['admin@smk-aisyiyah.com', 'guru@smk-aisyiyah.com', 'kepsek@smk-aisyiyah.com']);
            });

        if ($request->filled('search')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $hasilUjians = $query->latest()->paginate(15);
        return view('Kepsek.hasil_ujian', compact('hasilUjians'));
    }



    public function laporan()
    {
        $laporan = Ujian::withCount(['soals', 'hasilUjians'])->get();
        return view('Kepsek.laporan', compact('laporan'));
    }



    public function downloadLaporan()
    {
        $laporan = Ujian::withCount(['soals', 'hasilUjians'])->get();
        $pdf = Pdf::loadView('Kepsek.laporan_pdf', compact('laporan'));
        return $pdf->download('Laporan_Global_Ujian_SMK_Aisyiyah.pdf');
    }
}
