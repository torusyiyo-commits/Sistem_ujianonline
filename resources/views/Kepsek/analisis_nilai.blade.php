@extends('Kepsek.layout')

@push('styles')
<style>
    .analysis-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .stat-card {
        background-color: white;
        border-radius: 0.75rem;
        padding: 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: 1px solid #f3f4f6;
        text-align: center;
    }

    .stat-title {
        color: #6b7280;
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 1rem;
    }

    .stat-value {
        font-size: 2.5rem;
        font-weight: 800;
        color: #059669; /* Emerald 600 */
        margin-bottom: 0.5rem;
    }

    .stat-desc {
        color: #4b5563;
        font-size: 0.875rem;
    }

    /* Mock Bar Chart CSS */
    .chart-container {
        background-color: white;
        border-radius: 0.75rem;
        padding: 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: 1px solid #f3f4f6;
        margin-top: 1.5rem;
    }

    .chart-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 1.5rem;
    }

    .bar-chart {
        display: flex;
        align-items: flex-end;
        gap: 1rem;
        height: 200px;
        padding-bottom: 1rem;
        border-bottom: 2px solid #e5e7eb;
    }

    .bar-item {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
    }

    .bar-fill {
        width: 100%;
        max-width: 60px;
        background-color: #34d399; /* Emerald 400 */
        border-radius: 0.25rem 0.25rem 0 0;
        transition: height 0.5s ease;
        display: flex;
        justify-content: center;
        padding-top: 0.5rem;
        color: white;
        font-weight: 700;
        font-size: 0.75rem;
    }

    .bar-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #4b5563;
        text-align: center;
    }
</style>
@endpush

@section('content')
    <h2 class="page-title">Analisis Nilai</h2>

    <div class="card">
        <h3 class="chart-title">Analisis Performa per Mata Pelajaran</h3>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f9fafb;">
                    <th style="padding: 1rem; border-bottom: 2px solid #e5e7eb; text-align: center;">Ujian</th>
                    <th style="padding: 1rem; border-bottom: 2px solid #e5e7eb; text-align: center;">Kelas</th>
                    <th style="padding: 1rem; border-bottom: 2px solid #e5e7eb; text-align: center;">Rata-rata</th>
                    <th style="padding: 1rem; border-bottom: 2px solid #e5e7eb; text-align: center;">Tertinggi</th>
                    <th style="padding: 1rem; border-bottom: 2px solid #e5e7eb; text-align: center;">Terendah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($analisis as $a)
                    @php
                        $stats = $a->hasilUjians->first();
                    @endphp
                    <tr>
                        <td style="padding: 1rem; border-bottom: 1px solid #f3f4f6; text-align: center;">{{ $a->judul }}</td>
                        <td style="padding: 1rem; border-bottom: 1px solid #f3f4f6; text-align: center;">{{ $a->kelas }}</td>
                        <td style="padding: 1rem; border-bottom: 1px solid #f3f4f6; text-align: center; font-weight: 700; color: #059669;">
                            {{ $stats ? number_format($stats->rata_rata, 1) : '-' }}
                        </td>
                        <td style="padding: 1rem; border-bottom: 1px solid #f3f4f6; text-align: center; color: #3b82f6;">
                            {{ $stats ? number_format($stats->tertinggi, 1) : '-' }}
                        </td>
                        <td style="padding: 1rem; border-bottom: 1px solid #f3f4f6; text-align: center; color: #ef4444;">
                            {{ $stats ? number_format($stats->terendah, 1) : '-' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
