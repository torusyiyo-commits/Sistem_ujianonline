@extends('Admin.layout')

@section('title', 'Data Ujian')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h3>Daftar Ujian Sistem</h3>
        <a href="{{ route('admin.ujian.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Ujian</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Mata Pelajaran</th>
                <th>Kelas</th>
                <th>Jadwal</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ujians as $index => $ujian)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td><strong>{{ $ujian->judul }}</strong></td>
                <td>{{ $ujian->mata_pelajaran }}</td>
                <td>{{ $ujian->kelas }}</td>
                <td>
                    @if($ujian->tanggal_ujian)
                        {{ \Carbon\Carbon::parse($ujian->tanggal_ujian)->format('d/m/Y') }} <br>
                        <small>{{ $ujian->jam_mulai }} - {{ $ujian->jam_selesai }}</small>
                    @else
                        <span style="color: #9ca3af; font-size: 0.875rem;">Belum dijadwalkan</span>
                    @endif
                </td>
                <td>
                    @if($ujian->soals_count > 0)
                        <span style="background-color: #d1fae5; color: #065f46; padding: 0.2rem 0.5rem; border-radius: 0.25rem; font-size: 0.8rem;">Ready ({{ $ujian->soals_count }} soal)</span>
                    @else
                        <span style="background-color: #fee2e2; color: #991b1b; padding: 0.2rem 0.5rem; border-radius: 0.25rem; font-size: 0.8rem;">Kosong</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.ujian.edit', $ujian->id) }}" class="btn btn-warning" style="padding: 0.3rem 0.5rem; font-size: 0.875rem;"><i class="fas fa-edit"></i> Edit</a>
                    <form action="{{ route('admin.ujian.destroy', $ujian->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="padding: 0.3rem 0.5rem; font-size: 0.875rem;" onclick="return confirm('Hapus ujian ini? Data soal dan hasil akan terhapus!');"><i class="fas fa-trash"></i> Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
