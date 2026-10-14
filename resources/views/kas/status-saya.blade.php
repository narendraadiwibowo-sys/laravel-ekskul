<x-app-layout title="Status Kas Saya">
    <div class="card" style="max-width:680px;">
        <div class="card-header">
            <span class="card-title">💳 Status Kas Saya</span>
        </div>

        @if($tagihanBulanIni)
        <div class="alert {{ $tagihanBulanIni->status === 'lunas' ? 'alert-success' : 'alert-warning' }}" style="margin-bottom:1.5rem;">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
            <div>
                <strong>Bulan {{ $tagihanBulanIni->namaBulan() }} {{ $tagihanBulanIni->tahun }}:</strong>
                @if($tagihanBulanIni->status === "lunas")
                    ✅ Kas bulan ini sudah lunas!
                @else
                    ⚠️ Kas bulan ini <strong>belum lunas</strong> — tagihan Rp {{ number_format($tagihanBulanIni->nominal,0,",",".") }}. Segera bayar ke bendahara ya!
                @endif
            </div>
        </div>
        @else
        <div class="alert alert-info" style="margin-bottom:1.5rem;">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Tagihan bulan ini belum digenerate oleh bendahara.
        </div>
        @endif

        <h3 style="font-size:0.875rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.75rem;">Riwayat Semua Tagihan</h3>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr><th>Bulan</th><th>Tahun</th><th>Nominal</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $t)
                    <tr>
                        <td>{{ $t->namaBulan() }}</td>
                        <td>{{ $t->tahun }}</td>
                        <td>Rp {{ number_format($t->nominal,0,",",".") }}</td>
                        <td><span class="badge badge-{{ $t->status === 'lunas' ? 'lunas' : 'belum' }}">{{ $t->status === "lunas" ? "✅ Lunas" : "⏳ Belum Lunas" }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="4" style="text-align:center;color:var(--text-muted);padding:2rem;">Belum ada riwayat tagihan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>