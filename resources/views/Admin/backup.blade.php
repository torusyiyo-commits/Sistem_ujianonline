@extends('Admin.layout')

@section('title', 'Backup & Restore Database')

@section('content')
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
    <div class="card">
        <h3 style="margin-bottom: 1rem;"><i class="fas fa-download"></i> Backup Database</h3>
        <p style="margin-bottom: 1.5rem; color: #4b5563;">Unduh salinan seluruh data sistem (SQL) untuk keperluan pengarsipan dan keamanan.</p>
        <form action="{{ route('admin.backup.create') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary"><i class="fas fa-file-export"></i> Buat & Download Backup</button>
        </form>
    </div>

    <div class="card">
        <h3 style="margin-bottom: 1rem;"><i class="fas fa-upload"></i> Restore Database</h3>
        <p style="margin-bottom: 1.5rem; color: #4b5563;">Pulihkan database sistem menggunakan file SQL backup sebelumnya. Perhatian: Aksi ini akan menimpa data yang ada!</p>
        <form action="{{ route('admin.backup.restore') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <input type="file" name="backup_file" class="form-control" accept=".sql" required>
            </div>
            <button type="submit" class="btn btn-danger" onclick="return confirm('Peringatan: Seluruh data saat ini akan ditimpa! Lanjutkan?');"><i class="fas fa-file-import"></i> Restore Data</button>
        </form>
    </div>
</div>
@endsection
