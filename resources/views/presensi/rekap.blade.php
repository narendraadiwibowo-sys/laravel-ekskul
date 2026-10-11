<x-layouts.app title="Rekap Presensi">
    <div class="card">
        <div class="card-header">
            <span class="card-title">📊 Rekap Kehadiran Anggota</span>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>% Kehadiran</th>
                        <th>Indikator</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($anggotas as $i => $a)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td style="font-weight:500;color:#f1f5f9;">{{ $a["nama"] }}</td>
                        <td>{{ $a["kelas"] ?? "-" }}</td>
                        <td>
                            <span style="font-weight:700;color:{{ $a['persen_kehadiran'] >= 75 ? '#34d399' : ($a['persen_kehadiran'] >= 50 ? '#fbbf24' : '#f87171') }};">
                                {{ $a["persen_kehadiran"] }}%
                            </span>
                        </td>
                        <td>
                            <div style="background:rgba(255,255,255,0.1);border-radius:999px;height:8px;width:120px;overflow:hidden;">
                                <div style="height:100%;width:{{ $a["persen_kehadiran"] }}%;background:{{ $a['persen_kehadiran'] >= 75 ? '#10b981' : ($a['persen_kehadiran'] >= 50 ? '#f59e0b' : '#ef4444') }};border-radius:999px;transition:width 0.5s;"></div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" style="text-align:center;color:var(--text-muted);padding:2rem;">Belum ada data presensi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>