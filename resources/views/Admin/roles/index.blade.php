@extends('Admin.layout')

@section('title', 'Hak Akses Role')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h3>Daftar Role & Permission</h3>
        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Role</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Role</th>
                <th>Hak Akses (Permissions)</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $index => $role)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td><strong>{{ ucfirst($role->name) }}</strong></td>
                <td>
                    @forelse($role->permissions as $permission)
                        <span style="background-color: #f3f4f6; padding: 0.2rem 0.5rem; border-radius: 0.25rem; font-size: 0.8rem; margin-right: 0.25rem;">{{ $permission->name }}</span>
                    @empty
                        <span style="color: #9ca3af; font-size: 0.875rem;">Tidak ada permission khusus</span>
                    @endforelse
                </td>
                <td>
                    <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-warning" style="padding: 0.3rem 0.5rem; font-size: 0.875rem;"><i class="fas fa-edit"></i> Edit</a>
                    @if(!in_array($role->name, ['admin', 'siswa', 'guru', 'kepala_sekolah']))
                    <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="padding: 0.3rem 0.5rem; font-size: 0.875rem;" onclick="return confirm('Hapus role ini?');"><i class="fas fa-trash"></i> Hapus</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
