@extends('Admin.layout')

@section('title', 'Tambah Ujian')

@section('content')
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <form action="{{ route('admin.ujian.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Judul Ujian</label>
            <input type="text" name="judul" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Mata Pelajaran</label>
            <input type="text" name="mata_pelajaran" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Kelas</label>
            <input type="text" name="kelas" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Durasi (Menit)</label>
            <input type="number" name="durasi" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Ujian</button>
        <a href="{{ route('admin.ujian.index') }}" class="btn btn-danger" style="margin-left: 0.5rem;">Batal</a>
    </form>
</div>
@endsection
