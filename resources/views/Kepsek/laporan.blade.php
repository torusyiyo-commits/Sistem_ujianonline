@extends('Kepsek.layout')

@push('styles')
<style>
    .report-card {
        background-color: white;
        border-radius: 0.75rem;
        padding: 2.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: 1px solid #f3f4f6;
        max-width: 800px;
        margin: 0 auto;
        text-align: center;
    }

    .report-icon {
        width: 80px;
        height: 80px;
        background-color: #d1fae5;
        color: #059669;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0 auto 1.5rem;
    }

    .report-icon svg {
        width: 40px;
        height: 40px;
    }

    .report-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 0.5rem;
    }

    .report-desc {
        color: #6b7280;
        margin-bottom: 2.5rem;
        font-size: 1rem;
        line-height: 1.6;
    }

    .btn-download {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        background-color: #059669;
        color: white;
        padding: 1rem 2rem;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 1.125rem;
        text-decoration: none;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
    }

    .btn-download:hover {
        background-color: #047857;
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(5, 150, 105, 0.2);
    }

    .info-list {
        text-align: left;
        background-color: #f9fafb;
        padding: 1.5rem;
        border-radius: 0.5rem;
        margin-bottom: 2.5rem;
        border: 1px solid #e5e7eb;
    }

    .info-list h4 {
        margin-bottom: 1rem;
        color: #374151;
    }

    .info-list ul {
        list-style-position: inside;
        color: #4b5563;
    }

    .info-list li {
        margin-bottom: 0.5rem;
    }
</style>
@endpush

@section('content')
    <h2 class="page-title">Laporan Global Sekolah</h2>

    <div class="card" style="margin-bottom: 2rem; max-width: 900px; margin-left: auto; margin-right: auto;">
        <h3 style="margin-bottom: 1.5rem; font-weight: 700;">Ringkasan Pelaksanaan Ujian</h3>
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="background: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                    <th style="padding: 1rem; text-align: center;">Mata Pelajaran</th>
                    <th style="padding: 1rem; text-align: center;">Kelas</th>
                    <th style="padding: 1rem; text-align: center;">Jumlah Soal</th>
                    <th style="padding: 1rem; text-align: center;">Peserta Selesai</th>
                </tr>
            </thead>
            <tbody>
                @foreach($laporan as $item)
                    <tr style="border-bottom: 1px solid #f3f4f6;">
                        <td style="padding: 1rem; text-align: center;">{{ $item->mata_pelajaran }}</td>
                        <td style="padding: 1rem; text-align: center;">{{ $item->kelas }}</td>
                        <td style="padding: 1rem; text-align: center;">{{ $item->soals_count }}</td>
                        <td style="padding: 1rem; text-align: center;">{{ $item->hasil_ujians_count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="report-card">
        <div class="report-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
        </div>
        
        <h3 class="report-title">Unduh Rekap Hasil Ujian</h3>
        <p class="report-desc">Unduh dokumen laporan hasil pelaksanaan ujian secara keseluruhan untuk keperluan arsip dan evaluasi sekolah.</p>

        <a href="{{ route('kepsek.laporan.download') }}" class="btn-download">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
            </svg>
            Download Laporan Lengkap (PDF)
        </a>
    </div>
@endsection
