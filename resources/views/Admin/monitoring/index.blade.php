@extends('Admin.layout')

@section('title', 'Monitoring Aktivitas Siswa')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h3>Aktivitas Ujian Real-time (50 Terakhir)</h3>
        <button class="btn btn-primary" onclick="location.reload();"><i class="fas fa-sync-alt"></i> Refresh Data</button>
    </div>

    <table>
        <thead>
            <tr>
                <th>Waktu</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Ujian</th>
                <th>Aktivitas</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($aktivitas as $log)
            <tr>
                <td>
                    {{ $log->created_at->diffForHumans() }} <br>
                    <small style="color: #6b7280;">{{ $log->created_at->format('d/m/Y H:i:s') }}</small>
                </td>
                <td><strong>{{ $log->user->name ?? 'Unknown' }}</strong></td>
                <td>{{ $log->ujian->kelas ?? '-' }}</td>
                <td>{{ $log->ujian->judul ?? 'Unknown' }}</td>
                <td>
                    @if($log->tipe == 'mulai_ujian')
                        <span style="color: #059669; font-weight: 600;"><i class="fas fa-play-circle"></i> Mulai Ujian</span>
                    @elseif($log->tipe == 'selesai_ujian')
                        <span style="color: #2563eb; font-weight: 600;"><i class="fas fa-check-circle"></i> Selesai Ujian</span>
                    @elseif($log->tipe == 'blur_window' || str_contains($log->tipe, 'pelanggaran'))
                        <span style="color: #dc2626; font-weight: 600;"><i class="fas fa-exclamation-triangle"></i> Terdeteksi Pelanggaran</span>
                    @else
                        <span style="color: #4b5563; font-weight: 600; text-transform: capitalize;">{{ str_replace('_', ' ', $log->tipe) }}</span>
                    @endif
                </td>
                <td>{{ !empty($log->data) ? json_encode($log->data) : '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; color: #6b7280;">Belum ada aktivitas ujian yang tercatat.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
