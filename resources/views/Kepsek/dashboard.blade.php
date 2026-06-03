@extends('Kepsek.layout')

@push('styles')
<style>
    .summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .summary-card {
        background-color: white;
        border-radius: 0.75rem;
        padding: 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: 1px solid #f3f4f6;
        display: flex;
        align-items: center;
        gap: 1.25rem;
    }

    .icon-box {
        width: 60px;
        height: 60px;
        border-radius: 0.75rem;
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
    }

    .icon-ujian { background-color: #3b82f6; /* Blue */ }
    .icon-siswa { background-color: #8b5cf6; /* Purple */ }
    .icon-lulus { background-color: #10b981; /* Emerald */ }
    .icon-nilai { background-color: #f59e0b; /* Amber */ }

    .summary-info h4 {
        color: #6b7280;
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 0.25rem;
    }

    .summary-info .value {
        font-size: 1.875rem;
        font-weight: 700;
        color: #111827;
    }
</style>
@endpush

@section('content')
    <h2 class="page-title">Dashboard Utama</h2>

    <div class="summary-grid">
        <!-- Card 1: Jumlah Ujian -->
        <div class="summary-card">
            <div class="icon-box icon-ujian">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width: 30px; height: 30px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div class="summary-info">
                <h4>Ujian Dilaksanakan</h4>
                <div class="value">{{ $totalUjian }}</div>
            </div>
        </div>

        <!-- Card 2: Jumlah Siswa -->
        <div class="summary-card">
            <div class="icon-box icon-siswa">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width: 30px; height: 30px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <div class="summary-info">
                <h4>Total Peserta</h4>
                <div class="value">{{ $totalSiswa }}</div>
            </div>
        </div>

        <!-- Card 3: Pelanggaran -->
        <div class="summary-card">
            <div class="icon-box icon-lulus" style="background-color: #ef4444;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width: 30px; height: 30px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div class="summary-info">
                <h4>Total Pelanggaran</h4>
                <div class="value">{{ $totalPelanggaran }}</div>
            </div>
        </div>

        <!-- Card 4: Rata-rata Nilai -->
        <div class="summary-card">
            <div class="icon-box icon-nilai">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width: 30px; height: 30px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
            </div>
            <div class="summary-info">
                <h4>Rata-rata Nilai</h4>
                <div class="value">{{ number_format($rataRataNilai, 1) }}</div>
            </div>
        </div>
    </div>

    <!-- Grafik Nilai -->
    <div class="card">
        <h3 style="margin-bottom: 1rem; font-size: 1.1rem; font-weight: 600;">Ringkasan Nilai Rata-rata per Ujian</h3>
        <div style="height: 300px; display: flex; align-items: flex-end; gap: 2rem; padding: 1rem 0;">
            @foreach($grafikData as $data)
                <div style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 0.5rem;">
                    <div style="width: 100%; background-color: #10b981; border-radius: 4px 4px 0 0; height: {{ $data->avg_skor }}%; min-height: 20px; display: flex; justify-content: center; align-items: flex-start; padding-top: 5px; color: white; font-size: 0.75rem; font-weight: bold;">
                        {{ number_format($data->avg_skor, 0) }}
                    </div>
                    <span style="font-size: 0.75rem; color: #6b7280; text-align: center; height: 3rem; overflow: hidden;">{{ $data->ujian->judul }}</span>
                </div>
            @endforeach
        </div>
    </div>
@endsection
