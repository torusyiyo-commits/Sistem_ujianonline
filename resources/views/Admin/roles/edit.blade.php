@extends('Admin.layout')

@section('title', 'Edit Role')

@section('content')
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label>Nama Role</label>
            <input type="text" name="name" class="form-control" value="{{ $role->name }}" required {{ in_array($role->name, ['admin', 'guru', 'siswa', 'kepala_sekolah']) ? 'readonly' : '' }}>
            @if(in_array($role->name, ['admin', 'guru', 'siswa', 'kepala_sekolah']))
                <small style="color: #d97706;"><i class="fas fa-info-circle"></i> Nama role bawaan sistem tidak dapat diubah.</small>
            @endif
        </div>
        
        <div class="form-group" style="margin-top: 1rem;">
            <label style="display: block; margin-bottom: 0.5rem;">Pilih Hak Akses (Permissions)</label>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem;">
                @foreach($permissions as $permission)
                <div>
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-weight: normal;">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" 
                            {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>
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
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Perbarui Role</button>
            <a href="{{ route('admin.roles.index') }}" class="btn btn-danger" style="margin-left: 0.5rem;">Batal</a>
        </div>
    </form>
</div>
@endsection
