<x-app-layout title="Input Presensi">
    <div class="card">
        <div class="card-header">
            <div>
                <span class="card-title">✓ Input Presensi</span>
                <div style="font-size:0.8rem;color:var(--text-muted);margin-top:0.25rem;">{{ $jadwal->judul }} — {{ $jadwal->tanggal->format("d M Y") }}</div>
            </div>
            <a href="{{ route("jadwal.index") }}" class="btn btn-secondary btn-sm">← Kembali</a>
        </div>
        <form action="{{ route("presensi.store", $jadwal) }}" method="POST">
            @csrf
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Anggota</th>
                            <th>Kelas</th>
                            <th>Status Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($anggotas as $i => $anggota)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td style="font-weight:500;color:#f1f5f9;">{{ $anggota->name }}</td>
                            <td>{{ $anggota->kelas ?? "-" }}</td>
                            <td>
                                <div style="display:flex;gap:1rem;">
                                    @foreach(["hadir" => "✅ Hadir", "izin" => "📋 Izin", "alpa" => "❌ Alpa"] as $val => $label)
                                    <label style="display:flex;align-items:center;gap:0.4rem;cursor:pointer;font-size:0.85rem;color:var(--text-muted);">
                                        <input type="radio" name="presensi[{{ $anggota->id }}]" value="{{ $val }}"
                                            {{ ($existing[$anggota->id] ?? "") === $val ? "checked" : ($val === "hadir" && !isset($existing[$anggota->id]) ? "checked" : "") }}
                                            style="accent-color:#3b82f6;">
                                        {{ $label }}
                                    </label>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" style="text-align:center;color:var(--text-muted);padding:2rem;">Belum ada anggota terdaftar.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($anggotas->isNotEmpty())
            <div style="margin-top:1.25rem;">
                <button type="submit" class="btn btn-primary">💾 Simpan Presensi ({{ $anggotas->count() }} anggota)</button>
            </div>
            @endif
        </form>
    </div>
</x-app-layout>