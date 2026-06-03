@extends('Admin.layout')

@section('title', 'Tambah Role')

@section('content')
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <form action="{{ route('admin.roles.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nama Role</label>
            <input type="text" name="name" class="form-control" placeholder="Misal: pengawas_ujian" required>
            <small style="color: #6b7280;">Gunakan huruf kecil dan tanpa spasi (gunakan underscore)</small>
        </div>
        
        <div class="form-group" style="margin-top: 1rem;">
            <label style="display: block; margin-bottom: 0.5rem;">Pilih Hak Akses (Permissions)</label>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem;">
                @foreach($permissions as $permission)
                <div>
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-weight: normal;">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}">
                        {{ $permission->name }}
                    </label>
                </div>
                @endforeach
            </div>
            @if(count($permissions) == 0)
                <p style="color: #9ca3af; font-size: 0.875rem;">Belum ada permission di database.</p>
            @endif
        </div>

        <div style="margin-top: 1.5rem;">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Role</button>
            <a href="{{ route('admin.roles.index') }}" class="btn btn-danger" style="margin-left: 0.5rem;">Batal</a>
        </div>
    </form>
</div>
@endsection
