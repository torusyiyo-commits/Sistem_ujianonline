<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Ujian;

class AdminController extends Controller
{
    public function dashboard()
    {
        $usersCount = User::count();
        $ujiansCount = Ujian::count();
        return view('Admin.dashboard', compact('usersCount', 'ujiansCount'));
    }

    public function monitoring()
    {
        // Fitur monitoring aktivitas siswa yang realtime
        $aktivitas = \App\Models\AktivitasUjian::with(['user', 'ujian'])->latest()->take(50)->get();
        return view('Admin.monitoring.index', compact('aktivitas'));
    }
}
