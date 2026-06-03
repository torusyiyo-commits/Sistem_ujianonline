@extends('Admin.layout')

@section('title', 'Dashboard')

@section('content')
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
    <div class="card" style="border-left: 4px solid #10b981;">
        <h3 style="color: #6b7280; font-size: 0.875rem; text-transform: uppercase;">Total Pengguna</h3>
        <p style="font-size: 2rem; font-weight: 700; color: #111827; margin-top: 0.5rem;">{{ $usersCount }}</p>
    </div>
    <div class="card" style="border-left: 4px solid #3b82f6;">
        <h3 style="color: #6b7280; font-size: 0.875rem; text-transform: uppercase;">Total Ujian</h3>
        <p style="font-size: 2rem; font-weight: 700; color: #111827; margin-top: 0.5rem;">{{ $ujiansCount }}</p>
    </div>
</div>

<div class="card">
    <h3>Selamat Datang di Admin Panel</h3>
    <p style="margin-top: 1rem; color: #4b5563;">Gunakan menu di sebelah kiri untuk mengelola sistem, pengguna, data ujian, dan melihat aktivitas secara keseluruhan.</p>
</div>
@endsection
