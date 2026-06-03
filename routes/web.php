<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/login', function () {
    return view('login');
});

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'string'],
        'password' => ['required'],
    ]);

    $loginField = trim($request->email);
    $password = trim($request->password);
    
    // Cek login via username (kolom email)
    $isSuccess = Auth::attempt(['email' => $loginField, 'password' => $password]);

    if ($isSuccess) {
        $request->session()->regenerate();
        
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            return redirect()->intended('/admin/dashboard');
        } elseif ($user->hasRole('siswa')) {
            return redirect()->intended('/siswa/dashboard');
        } elseif ($user->hasRole('kepala_sekolah')) {
            return redirect()->intended('/kepsek/laporan');
        } else {
            return redirect()->intended('/guru/dashboard');
        }
    }

    return back()->withErrors([
        'email' => 'Kombinasi password dan username salah.',
    ])->onlyInput('email');
});

Route::get('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Rute Guru
Route::get('/guru/dashboard', function () {
    return view('Guru.dashboard_guru');
})->middleware('auth')->name('dashboard.guru');

Route::get('/guru/kelola-soal', [\App\Http\Controllers\SoalController::class, 'index'])->middleware('auth')->name('kelola.soal');
Route::post('/guru/kelola-soal/upload', [\App\Http\Controllers\SoalController::class, 'upload'])->middleware('auth');
Route::put('/guru/kelola-soal/{id}', [\App\Http\Controllers\SoalController::class, 'update'])->middleware('auth')->name('kelola.soal.update');
Route::delete('/guru/kelola-soal/{id}', [\App\Http\Controllers\SoalController::class, 'destroy'])->middleware('auth')->name('kelola.soal.destroy');
Route::get('/guru/kelola-soal/template', [\App\Http\Controllers\SoalController::class, 'downloadTemplate'])->middleware('auth')->name('kelola.soal.template');

Route::get('/guru/kelola-soal/create', function () {
    return view('Guru.tambah_soal');
})->middleware('auth')->name('kelola.soal.create');



Route::get('/guru/hasil-ujian', [App\Http\Controllers\HasilUjianController::class, 'indexGuru'])->middleware('auth')->name('hasil.ujian');
Route::get('/guru/hasil-ujian/download', [App\Http\Controllers\HasilUjianController::class, 'downloadLaporan'])->middleware('auth')->name('hasil.ujian.download');


// Rute Siswa (Mock/Dummy)
Route::prefix('siswa')->middleware('auth')->group(function() {
    Route::get('/dashboard', function (Illuminate\Http\Request $request) {
        $kelasAsli = auth()->user()->kelas ?? '10'; // Ambil kelas dari pengguna yang login, default 10
        // Ekstrak angka saja untuk fleksibilitas pencocokan (misal "Kelas 11" menjadi "11")
        preg_match('/\d+/', $kelasAsli, $matches);
        $kelasAngka = !empty($matches) ? $matches[0] : $kelasAsli;

        $now = \Carbon\Carbon::now();
        
        $query = \App\Models\Ujian::withCount('soals')
            ->whereNotNull('tanggal_ujian')
            ->orderBy('tanggal_ujian', 'asc')
            ->orderBy('jam_mulai', 'asc')
            ->where(function($q) use ($kelasAsli, $kelasAngka) {
                $q->where('kelas', $kelasAsli)
                  ->orWhere('kelas', $kelasAngka)
                  ->orWhere('kelas', 'Kelas ' . $kelasAngka);
            });
            
        $ujians = $query->get();

        $userId = auth()->id();
        $hasilUjians = \App\Models\HasilUjian::where('user_id', $userId)->get();

        $activeUjians = $ujians->filter(function($ujian) use ($now, $hasilUjians) {
            if (!$ujian->tanggal_ujian || !$ujian->jam_selesai) return false;
            $start = \Carbon\Carbon::parse($ujian->tanggal_ujian . ' ' . $ujian->jam_mulai);
            $end = \Carbon\Carbon::parse($ujian->tanggal_ujian . ' ' . $ujian->jam_selesai);
            
            // Fix overnight exams
            if ($end->lt($start)) {
                $end->addDay();
            }

            // Cek apakah sudah dikerjakan di jadwal ini
            $ujian->has_taken = $hasilUjians->where('ujian_id', $ujian->id)->filter(function($hasil) use ($start) {
                return $hasil->created_at->gte($start);
            })->isNotEmpty();

            return $now->lte($end);
        });

        $groupedUjians = $activeUjians->groupBy('tanggal_ujian');
        $kelas = $kelasAsli; // Restore variable name for the view

        return view('Siswa.dashboard', compact('groupedUjians', 'kelas'));
    })->name('siswa.dashboard');

    Route::get('/ujian/{id}/mulai', [\App\Http\Controllers\UjianController::class, 'mulai'])->name('siswa.ujian.mulai');
    Route::get('/ujian/{id}/kerjakan', [\App\Http\Controllers\UjianController::class, 'kerjakan'])->name('siswa.ujian.kerjakan');
    Route::post('/ujian/{id}/submit', [\App\Http\Controllers\UjianController::class, 'submit'])->name('siswa.ujian.submit');
    Route::get('/ujian/{id}/hasil', [\App\Http\Controllers\UjianController::class, 'hasil'])->name('siswa.ujian.hasil');

    Route::post('/ujian/{id}/log', [App\Http\Controllers\UjianController::class, 'logAktivitas'])->name('siswa.ujian.log');

    Route::get('/ujian/{id}/sertifikat', function ($id) {
        $data = [
            'nama_siswa' => Auth::user()->name ?? 'Siswa Teladan',
            'mata_pelajaran' => 'Matematika'
        ];
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('Siswa.sertifikat', $data);
        $pdf->setPaper('a4', 'landscape');
        return $pdf->download('Sertifikat_Kelulusan.pdf');
    })->name('siswa.ujian.sertifikat');
});

// Rute Kepala Sekolah
Route::prefix('kepsek')->middleware('auth')->group(function() {
    Route::get('/dashboard', function() { return redirect('/kepsek/laporan'); });
    Route::get('/hasil-ujian', [App\Http\Controllers\KepsekController::class, 'hasilUjian'])->name('kepsek.hasil_ujian');
    Route::get('/laporan', [App\Http\Controllers\KepsekController::class, 'laporan'])->name('kepsek.laporan');
    Route::get('/laporan/download', [App\Http\Controllers\KepsekController::class, 'downloadLaporan'])->name('kepsek.laporan.download');
});

// Rute Admin
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function() {
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Manajemen Pengguna
    Route::get('/users/upload', [App\Http\Controllers\AdminUserController::class, 'uploadForm'])->name('admin.users.upload.form');
    Route::get('/users/template/siswa', [App\Http\Controllers\AdminUserController::class, 'downloadTemplateSiswa'])->name('admin.users.template.siswa');
    Route::get('/users/template/guru', [App\Http\Controllers\AdminUserController::class, 'downloadTemplateGuru'])->name('admin.users.template.guru');
    Route::post('/users/upload', [App\Http\Controllers\AdminUserController::class, 'upload'])->name('admin.users.upload');
    Route::resource('/users', \App\Http\Controllers\AdminUserController::class)->names('admin.users');
    
    // Manajemen Role & Permission
    Route::resource('/roles', \App\Http\Controllers\AdminRoleController::class)->names('admin.roles');
    
    // Manajemen Ujian (CRUD Sentral)
    Route::resource('/ujian', \App\Http\Controllers\AdminUjianController::class)->names('admin.ujian');
    
    // Monitoring Siswa Realtime
    Route::get('/monitoring', [\App\Http\Controllers\AdminController::class, 'monitoring'])->name('admin.monitoring');
    
    // Hasil Ujian untuk Admin
    Route::get('/hasil-ujian', [\App\Http\Controllers\KepsekController::class, 'hasilUjian'])->name('admin.hasil_ujian');
    
    // Pengaturan Sistem
    Route::get('/settings', [\App\Http\Controllers\SystemSettingsController::class, 'index'])->name('admin.settings');
    Route::post('/settings', [\App\Http\Controllers\SystemSettingsController::class, 'store'])->name('admin.settings.store');
});
