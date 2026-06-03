@extends('Kepsek.layout')

@push('styles')
<style>
    .monitor-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }

    .monitor-card {
        background-color: white;
        border-radius: 0.75rem;
        padding: 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: 1px solid #f3f4f6;
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .indicator-circle {
        width: 16px;
        height: 16px;
        border-radius: 50%;
    }

    .bg-active { background-color: #3b82f6; animation: pulse 2s infinite; }
    .bg-done { background-color: #10b981; }

    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(59, 130, 246, 0); }
        100% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0); }
    }

    .monitor-info h4 {
        color: #6b7280;
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .monitor-info .value {
        font-size: 2rem;
        font-weight: 800;
        color: #111827;
    }

    /* Table Styling for Monitoring */
    .table-container {
        background-color: white;
        border-radius: 0.75rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: 1px solid #f3f4f6;
        overflow: hidden;
    }

    .table-header {
        padding: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        background-color: #f9fafb;
    }

    .table-header h3 {
        font-size: 1.125rem;
        color: #111827;
        font-weight: 700;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        background-color: white;
        padding: 1rem 1.5rem;
        text-align: left;
        font-size: 0.875rem;
        font-weight: 600;
        color: #4b5563;
        text-transform: uppercase;
        border-bottom: 1px solid #e5e7eb;
    }

    td {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #f3f4f6;
        color: #374151;
        font-size: 0.95rem;
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
    }

    .status-berlangsung {
        background-color: #dbeafe;
        color: #1d4ed8;
    }

    .status-selesai {
        background-color: #d1fae5;
        color: #065f46;
    }

    .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }

    .dot-blue { background-color: #2563eb; }
    .dot-green { background-color: #059669; }

</style>
@endpush

@section('content')
    <h2 class="page-title">Monitoring Pelaksanaan Ujian</h2>

    <div class="monitor-grid">
        <div class="monitor-card">
            <div class="indicator-circle bg-active"></div>
            <div class="monitor-info">
                <h4>Siswa Sedang Ujian (Live)</h4>
                <div class="value">{{ $sedangUjian }}</div>
            </div>
        </div>

        <div class="monitor-card">
            <div class="indicator-circle bg-done"></div>
            <div class="monitor-info">
                <h4>Siswa Sudah Selesai Hari Ini</h4>
                <div class="value">{{ $sudahSelesai }}</div>
            </div>
        </div>
    </div>

    <div class="table-container">
        <div class="table-header">
            <h3>Status Ujian Hari Ini ({{ date('d M Y') }})</h3>
        </div>
        <table>
            <thead>
                <tr>
                    <th style="text-align: center;">Ujian</th>
                    <th style="text-align: center;">Kelas</th>
                    <th style="text-align: center;">Waktu</th>
                    <th style="text-align: center;">Status Ujian</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ujianAktif as $u)
                    @php
                        $now = \Carbon\Carbon::now();
                        $end = \Carbon\Carbon::parse($u->tanggal_ujian . ' ' . $u->jam_selesai);
                        $isFinished = $now->gt($end);
                    @endphp
                    <tr>
                        <td style="text-align: center;">{{ $u->judul }}</td>
                        <td style="text-align: center;">{{ $u->kelas }}</td>
                        <td style="text-align: center;">{{ $u->jam_mulai }} - {{ $u->jam_selesai }}</td>
                        <td style="text-align: center;">
                            @if(!$isFinished)
                                <span class="status-badge status-berlangsung">
                                    <span class="status-dot dot-blue"></span> Berlangsung
                                </span>
                            @else
                                <span class="status-badge status-selesai">
                                    <span class="status-dot dot-green"></span> Selesai
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 2rem;">Tidak ada ujian yang dijadwalkan hari ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
