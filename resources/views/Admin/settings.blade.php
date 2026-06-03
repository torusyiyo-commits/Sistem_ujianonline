@extends('Admin.layout')

@section('title', 'Pengaturan Sistem')

@section('content')
<div class="card">
    <form action="{{ route('admin.settings.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nama Aplikasi</label>
            <input type="text" name="app_name" class="form-control" value="{{ $settings['app_name'] ?? 'Sistem Ujian Online' }}">
        </div>
        <div class="form-group">
            <label>Nama Sekolah</label>
            <input type="text" name="school_name" class="form-control" value="{{ $settings['school_name'] ?? 'SMK Pariwisata Aisyiyah Sumbar' }}">
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Pengaturan</button>
    </form>
</div>
@endsection
