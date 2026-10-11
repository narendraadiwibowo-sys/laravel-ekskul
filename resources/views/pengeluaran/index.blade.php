<x-layouts.app title="Pengeluaran Kas">
    <div class="stat-card red" style="margin-bottom:1.25rem;max-width:280px;">
        <span class="stat-label">Total Pengeluaran Bulan Ini</span>
        <span class="stat-value">Rp {{ number_format($totalBulanIni,0,",",".") }}</span>
    </div>

    <div style="display:grid;grid-template-columns:1fr {{ auth()->user()->can("pengeluaran.create") ? "1fr" : "" }};gap:1.25rem;">
        {{-- LIST PENGELUARAN --}}
        <div class="card">
            <div class="card-header">
                <span class="card-title">📉 Riwayat Pengeluaran</span>
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr><th>Tanggal</th><th>Judul</th><th>Kategori</th><th>Nominal</th><th>Aksi</th></tr>
                    </thead>
                    <tbody>
                        @forelse($pengeluarans as $p)
                        <tr>
                            <td>{{ $p->tanggal->format("d M Y") }}</td>
                            <td>
                                <div style="font-weight:500;color:#f1f5f9;">{{ $p->judul }}</div>
                                @if($p->keterangan)<div style="font-size:0.72rem;color:var(--text-muted);">{{ Str::limit($p->keterangan,60) }}</div>@endif
                            </td>
                            <td>
                                <span class="badge" style="background:rgba(139,92,246,0.2);color:#a78bfa;text-transform:capitalize;">{{ $p->kategori }}</span>
                            </td>
                            <td style="font-weight:600;color:#f87171;">Rp {{ number_format($p->nominal,0,",",".") }}</td>
                            <td>
                                @can("pengeluaran.delete")
                                <form action="{{ route("pengeluaran.destroy", $p) }}" method="POST" onsubmit="return confirm('Hapus catatan pengeluaran ini?')" style="margin:0;">
                                    @csrf @method("DELETE")
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" style="text-align:center;color:var(--text-muted);padding:2rem;">Belum ada catatan pengeluaran.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div style="margin-top:1rem;">{{ $pengeluarans->links() }}</div>
        </div>

        {{-- FORM TAMBAH PENGELUARAN --}}
        @can("pengeluaran.create")
        <div class="card">
            <div class="card-header">
                <span class="card-title">+ Catat Pengeluaran</span>
            </div>
            <form action="{{ route("pengeluaran.store") }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Judul Pengeluaran *</label>
                    <input type="text" name="judul" class="form-control" value="{{ old("judul") }}" required placeholder="Contoh: Beli spidol whiteboard">
                    @error("judul")<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Kategori *</label>
                    <select name="kategori" class="form-control">
                        <option value="alat" {{ old("kategori") === "alat" ? "selected" : "" }}>🔧 Alat</option>
                        <option value="konsumsi" {{ old("kategori") === "konsumsi" ? "selected" : "" }}>🍱 Konsumsi</option>
                        <option value="lainnya" {{ old("kategori") === "lainnya" ? "selected" : "" }}>📦 Lainnya</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Nominal (Rp) *</label>
                    <input type="number" name="nominal" class="form-control" value="{{ old("nominal") }}" required min="1" placeholder="15000">
                    @error("nominal")<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Tanggal *</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ old("tanggal", now()->format("Y-m-d")) }}" required>
                </div>
                <div class="form-group">
                    <label>Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="3" placeholder="Detail tambahan...">{{ old("keterangan") }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%;">💾 Simpan Pengeluaran</button>
            </form>
        </div>
        @endcan
    </div>
</x-layouts.app>