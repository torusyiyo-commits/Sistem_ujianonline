<?php

namespace App\Http\Controllers;

use App\Models\Ujian;
use App\Models\Soal;
use App\Models\HasilUjian;
use App\Models\AktivitasUjian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UjianController extends Controller
{
    public function mulai($id)
    {
        $ujian = Ujian::withCount('soals')->findOrFail($id);

        // Cek Jadwal
        if ($ujian->tanggal_ujian && $ujian->jam_mulai && $ujian->jam_selesai) {
            $now = Carbon::now();
            $start = Carbon::parse($ujian->tanggal_ujian . ' ' . $ujian->jam_mulai);
            $end = Carbon::parse($ujian->tanggal_ujian . ' ' . $ujian->jam_selesai);

            if ($end->lt($start)) {
                $end->addDay();
            }

            if ($now->lt($start)) {
                return redirect()->route('siswa.dashboard')->with('error', 'Ujian belum dimulai. Silakan kembali pada jam ' . $start->format('H:i'));
            }

            if ($now->gt($end)) {
                return redirect()->route('siswa.dashboard')->with('error', 'Waktu ujian telah berakhir.');
            }
            // Cek apakah sudah dikerjakan di jadwal ini
            $hasTaken = \App\Models\HasilUjian::where('ujian_id', $id)
                ->where('user_id', Auth::id())
                ->where('created_at', '>=', $start)
                ->exists();
            if ($hasTaken) {
                return redirect()->route('siswa.dashboard')->with('error', 'Anda sudah menyelesaikan ujian ini pada jadwal yang ditentukan.');
            }
        } else {
            return redirect()->route('siswa.dashboard')->with('error', 'Jadwal ujian belum diatur oleh guru.');
        }

        return view('Siswa.mulai_ujian', compact('ujian', 'id'));
    }

    public function kerjakan($id)
    {
        $ujian = Ujian::with('soals')->findOrFail($id);

        $sisaWaktuDetik = $ujian->durasi * 60;

        // Cek Jadwal
        if ($ujian->tanggal_ujian && $ujian->jam_mulai && $ujian->jam_selesai) {
            $now = Carbon::now();
            $start = Carbon::parse($ujian->tanggal_ujian . ' ' . $ujian->jam_mulai);
            $end = Carbon::parse($ujian->tanggal_ujian . ' ' . $ujian->jam_selesai);

            if ($end->lt($start)) {
                $end->addDay();
            }

            if ($now->lt($start)) {
                return redirect()->route('siswa.dashboard')->with('error', 'Ujian belum dimulai.');
            }

            if ($now->gt($end)) {
                return redirect()->route('siswa.dashboard')->with('error', 'Waktu ujian telah berakhir.');
            }
            
            // Hapus perhitungan keterlambatan yang salah karena siswa berhak mendapat sisa waktu selama masih dalam rentang waktu ujian
            // Keterlambatan hanya memotong waktu jika sisa sampai tutup ujian lebih kecil dari durasi (ditangani di bawah)
            
            // Jika sisa waktu lebih besar dari waktu sampai batas jam selesai, sesuaikan
            $sisaSampaiTutup = $end->getTimestamp() - $now->getTimestamp();
            if ($sisaWaktuDetik > $sisaSampaiTutup) {
                $sisaWaktuDetik = $sisaSampaiTutup;
            }
            
            if ($sisaWaktuDetik < 0) {
                $sisaWaktuDetik = 0;
            }

            // Cek apakah sudah dikerjakan di jadwal ini
            $hasTaken = \App\Models\HasilUjian::where('ujian_id', $id)
                ->where('user_id', Auth::id())
                ->where('created_at', '>=', $start)
                ->exists();
            if ($hasTaken) {
                return redirect()->route('siswa.dashboard')->with('error', 'Anda sudah menyelesaikan ujian ini pada jadwal yang ditentukan.');
            }
        } else {
            return redirect()->route('siswa.dashboard')->with('error', 'Jadwal ujian belum diatur oleh guru.');
        }
        
        $sessionKey = 'ujian_' . $id . '_soals_' . Auth::id();
        if (session()->has($sessionKey)) {
            $soalIds = session()->get($sessionKey);
            $soalsCollection = Soal::whereIn('id', $soalIds)->get();
            $soalsDict = $soalsCollection->keyBy('id');
            $selectedSoals = collect();
            foreach ($soalIds as $soalId) {
                if (isset($soalsDict[$soalId])) {
                    $selectedSoals->push($soalsDict[$soalId]);
                }
            }
        } else {
            $allSoals = $ujian->soals;
            if ($ujian->jumlah_soal_ditampilkan && $ujian->jumlah_soal_ditampilkan > 0) {
                $selectedSoals = $allSoals->shuffle()->take($ujian->jumlah_soal_ditampilkan);
            } else {
                $selectedSoals = $allSoals->shuffle(); // Acak urutan soal secara default
            }
            session()->put($sessionKey, $selectedSoals->pluck('id')->toArray());
        }

        // Pass data soal ke view dalam bentuk JSON agar mudah dibaca oleh script JS lama
        $soals = $selectedSoals->values()->map(function($soal) {
            return [
                'id' => $soal->id,
                'pertanyaan' => $soal->pertanyaan,
                'opsi' => [
                    'A' => $soal->opsi_a,
                    'B' => $soal->opsi_b,
                    'C' => $soal->opsi_c,
                    'D' => $soal->opsi_d,
                    'E' => $soal->opsi_e,
                ]
            ];
        });

        return view('Siswa.kerjakan_ujian', compact('ujian', 'id', 'soals', 'sisaWaktuDetik'));
    }

    public function submit(Request $request, $id)
    {
        $ujian = Ujian::with('soals')->findOrFail($id);
        
        // answers dikirim sebagai string JSON {"1":"A","2":"C"} - key adalah urutan soal mulai dari 1 (karena JS mengirim urutan, bukan soal id)
        $jawabanSiswaIndex = json_decode($request->answers, true) ?? [];
        $pelanggaran = $request->violations ?? 0;

        $sessionKey = 'ujian_' . $id . '_soals_' . Auth::id();
        $soalIds = session()->get($sessionKey, []);
        
        // Fallback jika session hilang
        if (empty($soalIds)) {
            $soalIds = $ujian->soals->pluck('id')->toArray();
        }

        $skor = 0;
        $totalSoal = count($soalIds);
        $bobot = $totalSoal > 0 ? (100 / $totalSoal) : 0;

        $detailJawaban = [];

        $soalsDict = Soal::whereIn('id', $soalIds)->get()->keyBy('id');
        
        foreach ($soalIds as $index => $soalId) {
            $urutanJs = $index + 1; // JS array start dari 1
            $jawabanDipilih = $jawabanSiswaIndex[$urutanJs] ?? null;
            
            $detailJawaban[$soalId] = $jawabanDipilih;

            if (isset($soalsDict[$soalId])) {
                $soal = $soalsDict[$soalId];
                if ($jawabanDipilih && strtoupper($jawabanDipilih) === strtoupper($soal->jawaban_benar)) {
                    $skor += $bobot;
                }
            }
        }
        
        // Bersihkan session setelah disubmit
        session()->forget($sessionKey);

        // Simpan Hasil
        $hasil = HasilUjian::create([
            'user_id' => Auth::id() ?? 1, // fallback jika blm auth
            'ujian_id' => $ujian->id,
            'skor' => round($skor),
            'jawaban_siswa' => $detailJawaban,
            'jumlah_pelanggaran' => $pelanggaran,
        ]);

        return redirect()->route('siswa.ujian.hasil', ['id' => $id]);
    }

    public function hasil($id)
    {
        $ujian = Ujian::findOrFail($id);
        $hasil = HasilUjian::where('ujian_id', $id)
                    ->where('user_id', Auth::id() ?? 1)
                    ->latest()
                    ->first();

        // KKM dummy misalnya 75
        $kkm = 75;
        $isLulus = $hasil ? ($hasil->skor >= $kkm) : false;

        return view('Siswa.hasil_ujian', compact('ujian', 'id', 'hasil', 'isLulus'));
    }

    public function logAktivitas(Request $request, $id)
    {
        AktivitasUjian::create([
            'user_id' => Auth::id(),
            'ujian_id' => $id,
            'tipe' => $request->type,
            'data' => $request->data,
        ]);

        return response()->json(['status' => 'success']);
    }
}
