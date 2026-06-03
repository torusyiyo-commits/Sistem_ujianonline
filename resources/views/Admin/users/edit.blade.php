@extends('Admin.layout')

@section('title', 'Edit Pengguna')

@section('content')
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
        </div>
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>
        <div class="form-group">
            <label>Password <small>(Biarkan kosong jika tidak ingin mengubah)</small></label>
            <input type="password" name="password" class="form-control" minlength="6">
        </div>
        <div class="form-group">
            <label>Role</label>
            <select name="roles" class="form-control" required>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ in_array($role->name, $userRole) ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Perbarui Pengguna</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-danger" style="margin-left: 0.5rem;">Batal</a>
    </form>
</div>
@endsection
