<x-app-layout title="Jadwal Kegiatan">
    @if($jadwalBesok->isNotEmpty())
    <div class="banner-h1">
        <span class="banner-icon">🔔</span>
        <div class="banner-text">
            <div class="banner-title">Pengumuman H-1!</div>
            @foreach($jadwalBesok as $j)
            <div class="banner-sub">{{ $j->judul }} — besok {{ $j->tanggal->format("d M Y") }} pukul {{ substr($j->waktu_mulai,0,5) }}{{ $j->lokasi ? " di ".$j->lokasi : "" }}</div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="card">
        <div class="card-header">
            <span class="card-title">📅 Daftar Jadwal Kegiatan</span>
            @can("jadwal.create")
            <a href="{{ route("jadwal.create") }}" class="btn btn-primary btn-sm">+ Tambah Jadwal</a>
            @endcan
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Kegiatan</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwals as $jadwal)
                    <tr>
                        <td>
                            <div style="font-weight:600;color:#f1f5f9;">{{ $jadwal->judul }}</div>
                            @if($jadwal->deskripsi)<div style="font-size:0.75rem;color:var(--text-muted);">{{ Str::limit($jadwal->deskripsi, 60) }}</div>@endif
                        </td>
                        <td>{{ $jadwal->tanggal->format("d M Y") }}</td>
                        <td>{{ substr($jadwal->waktu_mulai,0,5) }}{{ $jadwal->waktu_selesai ? " - ".substr($jadwal->waktu_selesai,0,5) : "" }}</td>
                        <td>{{ $jadwal->lokasi ?? "-" }}</td>
                        <td><span class="badge badge-{{ $jadwal->status }}">{{ ucfirst($jadwal->status) }}</span></td>
                        <td>
                            <div style="display:flex;gap:0.4rem;flex-wrap:wrap;">
                                @can("presensi.catat")
                                <a href="{{ route("presensi.create", $jadwal) }}" class="btn btn-success btn-sm">✓ Presensi</a>
                                @endcan
                                @can("jadwal.update")
                                <a href="{{ route("jadwal.edit", $jadwal) }}" class="btn btn-warning btn-sm">Edit</a>
                                @endcan
                                @can("jadwal.delete")
                                <form action="{{ route("jadwal.destroy", $jadwal) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini?')" style="margin:0;">
                                    @csrf @method("DELETE")
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align:center;color:var(--text-muted);padding:2rem;">Belum ada jadwal kegiatan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="margin-top:1rem;">{{ $jadwals->links() }}</div>
    </div>
</x-app-layout>