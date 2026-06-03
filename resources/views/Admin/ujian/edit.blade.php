@extends('Admin.layout')

@section('title', 'Edit Ujian')

@section('content')
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <form action="{{ route('admin.ujian.update', $ujian->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Judul Ujian</label>
            <input type="text" name="judul" class="form-control" value="{{ $ujian->judul }}" required>
        </div>
        <div class="form-group">
            <label>Mata Pelajaran</label>
            <input type="text" name="mata_pelajaran" class="form-control" value="{{ $ujian->mata_pelajaran }}" required>
        </div>
        <div class="form-group">
            <label>Kelas</label>
            <input type="text" name="kelas" class="form-control" value="{{ $ujian->kelas }}" required>
        </div>
        <div class="form-group">
            <label>Durasi (Menit)</label>
            <input type="number" name="durasi" class="form-control" value="{{ $ujian->durasi }}" required>
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Perbarui Ujian</button>
        <a href="{{ route('admin.ujian.index') }}" class="btn btn-danger" style="margin-left: 0.5rem;">Batal</a>
    </form>
</div>
@endsection
