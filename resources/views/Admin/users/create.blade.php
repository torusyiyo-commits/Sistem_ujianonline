@extends('Admin.layout')

@section('title', 'Tambah Pengguna')

@section('content')
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required minlength="6">
        </div>
        <div class="form-group">
            <label>Role</label>
            <select name="roles" class="form-control" required>
                <option value="">-- Pilih Role --</option>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Pengguna</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-danger" style="margin-left: 0.5rem;">Batal</a>
    </form>
</div>
@endsection
