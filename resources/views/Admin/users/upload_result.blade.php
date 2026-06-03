@extends('Admin.layout')

@section('title', 'Hasil Upload Pengguna')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <div>
            <h3 style="color: #065f46;"><i class="fas fa-check-circle"></i> Upload Berhasil!</h3>
            <p style="color: #4b5563; margin-top: 0.5rem;">Data pengguna berhasil ditambahkan dan tersimpan ke dalam sistem.</p>
        </div>
        <div>
            <button onclick="window.print()" class="btn btn-warning" style="margin-right: 0.5rem;"><i class="fas fa-print"></i> Print Data</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
    </div>

    <table style="border: 2px solid #e5e7eb;">
        <thead>
            <tr style="background-color: #f3f4f6;">
                <th>No</th>
                <th>Nama Lengkap</th>
                @if(isset($isGuruTemplate) && $isGuruTemplate)
                <th>NIK</th>
                <th>Role</th>
                @else
                <th>Role</th>
                <th>NISN</th>
                <th>Kelas</th>
                @endif
                <th>Username</th>
                <th>Password</th>
            </tr>
        </thead>
        <tbody>
            @foreach($createdUsers as $index => $user)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td><strong>{{ $user['name'] }}</strong></td>
                @if(isset($isGuruTemplate) && $isGuruTemplate)
                <td>{{ $user['nik'] ?? '-' }}</td>
                <td>
                    <span style="background-color: #d1fae5; color: #065f46; padding: 0.2rem 0.5rem; border-radius: 0.25rem; font-size: 0.8rem; text-transform: capitalize;">{{ $user['role'] }}</span>
                </td>
                @else
                <td>
                    <span style="background-color: #d1fae5; color: #065f46; padding: 0.2rem 0.5rem; border-radius: 0.25rem; font-size: 0.8rem; text-transform: capitalize;">{{ $user['role'] }}</span>
                </td>
                <td>{{ $user['nisn'] ?? '-' }}</td>
                <td>{{ $user['kelas'] ?? '-' }}</td>
                @endif
                <td style="color: #2563eb; font-family: monospace;">{{ $user['email'] }}</td>
                <td style="font-family: monospace; font-size: 1.1rem; letter-spacing: 1px;"><strong>{{ $user['password'] }}</strong></td>
            </tr>
            @endforeach
            
            @if(count($createdUsers) == 0)
            <tr>
                <td colspan="{{ (isset($isGuruTemplate) && $isGuruTemplate) ? 6 : 7 }}" style="text-align: center; color: #dc2626; padding: 2rem;">
                    Tidak ada pengguna baru yang ditambahkan. (Kemungkinan baris kosong atau email sudah terdaftar).
                </td>
            </tr>
            @endif
        </tbody>
    </table>
    
    <style>
        @media print {
            body * { visibility: hidden; }
            .card, .card * { visibility: visible; }
            .card { position: absolute; left: 0; top: 0; width: 100%; box-shadow: none; }
            .btn { display: none !important; }
        }
    </style>
</div>
@endsection
