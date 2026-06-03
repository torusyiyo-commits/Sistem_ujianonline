@extends('Kepsek.layout')

@push('styles')
<style>
    .filter-bar {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
        background-color: white;
        padding: 1rem 1.5rem;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        border: 1px solid #e5e7eb;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .filter-group label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #4b5563;
    }

    .filter-group select {
        padding: 0.5rem 1rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        background-color: #f9fafb;
        color: #1f2937;
        font-family: inherit;
        outline: none;--=
    }

    .table-container {
        background-color: white;
        border-radius: 0.75rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: 1px solid #f3f4f6;
        overflow: hidden;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        background-color: #f9fafb;
        padding: 1rem 1.5rem;
        text-align: left;
        font-size: 0.875rem;
        font-weight: 600;
        color: #4b5563;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid #e5e7eb;
    }

    td {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #f3f4f6;
        color: #374151;
        font-size: 0.95rem;
    }

    tr:last-child td {
        border-bottom: none;
    }

    tr:hover {
        background-color: #f9fafb;
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .status-lulus {
        background-color: #d1fae5;
        color: #065f46;
    }

    .status-gagal {
        background-color: #fee2e2;
        color: #b91c1c;
    }
</style>
@endpush

@section('content')
    <h2 class="page-title">Hasil Ujian</h2>

    <div class="filter-bar">
        <div class="filter-group">
            <label>Kelas</label>
            <select>
                <option value="">Semua Kelas</option>
                <option value="10">Kelas 10</option>
                <option value="11">Kelas 11</option>
                <option value="12">Kelas 12</option>
            </select>
        </div>
        <div class="filter-group">
            <label>Mata Pelajaran</label>
            <select>
                <option value="">Semua Mata Pelajaran</option>
                <option value="matematika">Matematika</option>
                <option value="bahasa_indonesia">Bahasa Indonesia</option>
                <option value="kejuruan">Kejuruan Pariwisata</option>
            </select>
        </div>
        <div class="filter-group">
            <label>Ujian</label>
            <select>
                <option value="">Semua Ujian</option>
                <option value="uas">UAS Genap 2026</option>
                <option value="uts">UTS Ganjil 2025</option>
            </select>
        </div>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th style="text-align: center;">No</th>
                    <th style="text-align: center;">Nama Siswa</th>
                    <th style="text-align: center;">Kelas</th>
                    <th style="text-align: center;">Ujian</th>
                    <th style="text-align: center;">Nilai</th>
                    <th style="text-align: center;">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($hasilUjians as $index => $hasil)
                    <tr>
                        <td style="text-align: center;">{{ $hasilUjians->firstItem() + $index }}</td>
                        <td style="text-align: center;">{{ $hasil->user->name ?? 'N/A' }}</td>
                        <td style="text-align: center;">{{ $hasil->ujian->kelas ?? '-' }}</td>
                        <td style="text-align: center;">{{ $hasil->ujian->judul ?? '-' }}</td>
                        <td style="text-align: center;"><span style="font-weight: 700;">{{ $hasil->skor }}</span></td>
                        <td style="text-align: center;">
                            @if($hasil->skor >= 75)
                                <span class="status-badge status-lulus">Lulus</span>
                            @else
                                <span class="status-badge status-gagal">Tidak Lulus</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 2rem;">Belum ada data hasil ujian.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div style="padding: 1rem;">
            {{ $hasilUjians->links() }}
        </div>
        </table>
    </div>
@endsection
