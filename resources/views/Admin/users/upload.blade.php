@extends('Admin.layout')

@section('title', 'Upload Data Pengguna (Excel)')

@section('content')
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <h3 style="margin-bottom: 1rem;"><i class="fas fa-file-excel"></i> Upload Data Pengguna</h3>
    <p style="margin-bottom: 1.5rem; color: #4b5563;">Unggah file Excel yang berisi daftar pengguna. Sistem akan otomatis mendaftarkan dan membuatkan password untuk mereka.</p>
    
    <div style="margin-bottom: 1.5rem; padding: 1rem; background-color: #f3f4f6; border-radius: 0.5rem; border-left: 4px solid #3b82f6;">
        <p style="font-weight: 600; margin-bottom: 0.5rem;">Langkah-langkah:</p>
        <ol style="margin-left: 1.5rem; color: #4b5563;">
            <li>Pilih dan unduh template Excel sesuai dengan tipe pengguna yang ingin ditambahkan (Siswa atau Guru).</li>
            <li><strong>Untuk Siswa:</strong> Isi Nama Lengkap, NISN, dan Kelas.</li>
            <li><strong>Untuk Guru:</strong> Isi Nama & Gelar, serta NIK.</li>
            <li>Sistem akan otomatis mengatur Username dan Password menggunakan NISN / NIK yang Anda masukkan.</li>
            <li>Unggah kembali file tersebut di bawah ini.</li>
        </ol>
        <div style="margin-top: 1.5rem; display: flex; gap: 1rem; flex-wrap: wrap;">
            <a href="{{ route('admin.users.template.siswa') }}" class="btn" style="background-color: #f59e0b; color: white; padding: 0.5rem 1rem; border-radius: 0.25rem; text-decoration: none; font-size: 0.875rem;"><i class="fas fa-user-graduate"></i> Download Template Siswa</a>
            <a href="{{ route('admin.users.template.guru') }}" class="btn" style="background-color: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 0.25rem; text-decoration: none; font-size: 0.875rem;"><i class="fas fa-chalkboard-teacher"></i> Download Template Guru</a>
        </div>
    </div>

    <form action="{{ route('admin.users.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>File Excel (.xlsx / .xls)</label>
            <input type="file" name="file_users" class="form-control" accept=".xlsx, .xls" required>
        </div>
        
        <button type="submit" class="btn btn-primary" style="margin-top: 1rem;"><i class="fas fa-upload"></i> Proses Upload</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-danger" style="margin-left: 0.5rem; margin-top: 1rem;">Batal</a>
    </form>
</div>
@endsection
