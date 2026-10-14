<x-app-layout title="Manajemen Kas">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.5rem;">
        <div class="stat-card green">
            <span class="stat-label">Total Lunas Bulan Ini</span>
            <span class="stat-value">Rp {{ number_format($totalLunas,0,",",".") }}</span>
        </div>
        <div class="stat-card red">
            <span class="stat-label">Total Belum Lunas</span>
            <span class="stat-value">Rp {{ number_format($totalBelumLunas,0,",",".") }}</span>
        </div>
    </div>

    {{-- Generate Tagihan --}}
    @can("kas.catat")
    <div class="card" style="margin-bottom:1.25rem;">
        <div class="card-header">
            <span class="card-title">⚙️ Generate Tagihan Kas</span>
        </div>
        <form action="{{ route("kas.generate") }}" method="POST" style="display:flex;gap:0.75rem;flex-wrap:wrap;align-items:flex-end;">
            @csrf
            <div class="form-group" style="margin:0;min-width:120px;">
                <label>Bulan</label>
                <select name="bulan" class="form-control">
                    @foreach([1=>"Januari",2=>"Februari",3=>"Maret",4=>"April",5=>"Mei",6=>"Juni",7=>"Juli",8=>"Agustus",9=>"September",10=>"Oktober",11=>"November",12=>"Desember"] as $nb => $nm)
                    <option value="{{ $nb }}" {{ $nb == $bulan ? "selected" : "" }}>{{ $nm }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" style="margin:0;min-width:100px;">
                <label>Tahun</label>
                <input type="number" name="tahun" class="form-control" value="{{ $tahun }}" min="2020">
            </div>
            <div class="form-group" style="margin:0;min-width:140px;">
                <label>Nominal (Rp)</label>
                <input type="number" name="nominal" class="form-control" value="5000" min="0">
            </div>
            <button type="submit" class="btn btn-primary" style="height:38px;">Generate Tagihan</button>
        </form>
    </div>
    @endcan

    {{-- Filter Bulan Tahun --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title">💰 Rekap Tagihan</span>
            <form method="GET" action="{{ route("kas.index") }}" style="display:flex;gap:0.5rem;align-items:center;">
                <select name="bulan" class="form-control" style="width:auto;padding:0.35rem 0.65rem;">
                    @foreach([1=>"Jan",2=>"Feb",3=>"Mar",4=>"Apr",5=>"Mei",6=>"Jun",7=>"Jul",8=>"Agu",9=>"Sep",10=>"Okt",11=>"Nov",12=>"Des"] as $nb => $nm)
                    <option value="{{ $nb }}" {{ $nb == $bulan ? "selected" : "" }}>{{ $nm }}</option>
                    @endforeach
                </select>
                <input type="number" name="tahun" class="form-control" value="{{ $tahun }}" style="width:80px;padding:0.35rem 0.5rem;">
                <button type="submit" class="btn btn-secondary btn-sm">Filter</button>
            </form>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Anggota</th>
                        <th>Kelas</th>
                        <th>Nominal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tagihans as $i => $t)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td style="font-weight:500;color:#f1f5f9;">{{ $t->anggota?->name ?? "—" }}</td>
                        <td>{{ $t->anggota?->kelas ?? "-" }}</td>
                        <td>Rp {{ number_format($t->nominal,0,",",".") }}</td>
                        <td><span class="badge badge-{{ $t->status === 'lunas' ? 'lunas' : 'belum' }}">{{ $t->status === "lunas" ? "✅ Lunas" : "⏳ Belum Lunas" }}</span></td>
                        <td>
                            @can("kas.catat")
                            @if($t->status !== "lunas")
                            <button onclick="showBayarModal({{ $t->id }}, {{ $t->nominal }})" class="btn btn-success btn-sm">+ Catat Bayar</button>
                            @endif
                            @endcan
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align:center;color:var(--text-muted);padding:2rem;">Belum ada tagihan. Klik "Generate Tagihan" untuk membuat tagihan bulan ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>

{{-- Modal Bayar --}}
<div id="modal-bayar" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.7);z-index:100;align-items:center;justify-content:center;">
    <div style="background:#1e293b;border:1px solid #334155;border-radius:16px;padding:1.5rem;width:100%;max-width:380px;margin:1rem;">
        <h3 style="font-size:1rem;font-weight:700;color:#f1f5f9;margin-bottom:1.25rem;">💳 Catat Pembayaran</h3>
        <form id="form-bayar" method="POST">
            @csrf
            <div class="form-group">
                <label>Nominal Dibayar (Rp) *</label>
                <input type="number" id="bayar-nominal" name="nominal" class="form-control" min="1" required>
            </div>
            <div class="form-group">
                <label>Tanggal Bayar *</label>
                <input type="date" name="tanggal_bayar" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
            </div>
            <div style="display:flex;gap:0.5rem;justify-content:flex-end;">
                <button type="button" onclick="hideBayarModal()" class="btn btn-secondary">Batal</button>
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </form>
    </div>
</div>
<script>
function showBayarModal(tagihanId, nominal) {
    document.getElementById("form-bayar").action = "/kas/" + tagihanId + "/bayar";
    document.getElementById("bayar-nominal").value = nominal;
    document.getElementById("modal-bayar").style.display = "flex";
}
function hideBayarModal() {
    document.getElementById("modal-bayar").style.display = "none";
}
</script>