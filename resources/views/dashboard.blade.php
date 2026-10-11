<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>

    {{-- BROADCAST PENGUMUMAN HUMAS / NOTICE BOARD --}}
    @if(isset($pengumumans) && $pengumumans->isNotEmpty())
    <div style="margin-bottom: 1.5rem;">
        @foreach($pengumumans as $p)
        <div style="background: {{ $p->penting ? 'linear-gradient(135deg, rgba(220,38,38,0.2), rgba(239,68,68,0.08))' : 'rgba(255,255,255,0.04)' }}; border: 1px solid {{ $p->penting ? 'rgba(239,68,68,0.4)' : 'rgba(255,255,255,0.08)' }}; border-radius: 12px; padding: 1rem 1.25rem; margin-bottom: 0.75rem; display: flex; align-items: flex-start; gap: 0.75rem;">
            <span style="font-size: 1.25rem;">{{ $p->penting ? '📢' : '📌' }}</span>
            <div style="flex: 1;">
                <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
                    @if($p->penting)
                    <span class="badge" style="background:#dc2626; color:white;">PENTING / URGENT</span>
                    @endif
                    <strong style="color: #f1f5f9; font-size: 0.95rem;">{{ $p->judul }}</strong>
                    <span style="font-size: 0.7rem; color: #94a3b8;">· Oleh: {{ $p->pembuat->name ?? 'Humas' }} ({{ $p->created_at->diffForHumans() }})</span>
                </div>
                <div style="font-size: 0.85rem; color: #cbd5e1; margin-top: 0.25rem; line-height: 1.5;">
                    {{ $p->isi }}
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    {{-- BANNER H-1 KEGIATAN --}}
    @if($jadwalBesok->isNotEmpty())
    <div class="banner-h1">
        <span class="banner-icon">🔔</span>
        <div class="banner-text">
            <div class="banner-title">Pengingat H-1: Ada kegiatan besok!</div>
            @foreach($jadwalBesok as $j)
            <div class="banner-sub">📅 {{ $j->judul }} — {{ $j->tanggal->format("d M Y") }}, {{ substr($j->waktu_mulai,0,5) }}
                @if($j->lokasi) di {{ $j->lokasi }}@endif</div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- BANNER PDD: PAMFLET HARUS NAIK TAYANG H-1 --}}
    @if(isset($pamfletH1) && $pamfletH1->isNotEmpty())
    <div class="banner-h1" style="background: linear-gradient(135deg, rgba(139, 92, 246, 0.2), rgba(236, 72, 153, 0.1)); border-color: rgba(139, 92, 246, 0.4);">
        <span class="banner-icon">🎨</span>
        <div class="banner-text">
            <div class="banner-title" style="color: #c084fc;">PENGINGAT PDD: Pamflet Harus Naik Tayang H-1!</div>
            @foreach($pamfletH1 as $p)
            <div class="banner-sub" style="color: #e9d5ff;">
                📢 <strong>{{ $p->judul }}</strong> — Target Naik: {{ $p->tanggal_tayang ? $p->tanggal_tayang->format('d M Y') : 'H-1' }}
                @can('drive.view')
                · <a href="{{ route('drive.index') }}" style="color:#67e8f9; text-decoration:underline;">Buka Modul PDD</a>
                @endcan
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- SUMMARY UTAMA SUPERADMIN / PENGURUS (KAS, BARANG RUSAK, EVENT TERDEKAT) --}}
    @if(isset($stats))
    <div class="stats-grid">
        <div class="stat-card green">
            <span class="stat-label">Sisa Kas Tersimpan</span>
            <span class="stat-value">Rp {{ number_format($stats['sisa_kas'], 0, ',', '.') }}</span>
            <span class="stat-sub">Saldo kas bersih saat ini</span>
        </div>
        <div class="stat-card blue">
            <span class="stat-label">Inventaris Baik</span>
            <span class="stat-value">{{ $stats['barang_tersedia'] }} Unit</span>
            <span class="stat-sub">Barang siap pakai & tersedia</span>
        </div>
        <div class="stat-card red">
            <span class="stat-label">Barang Rusak / Hilang</span>
            <span class="stat-value">{{ $stats['barang_rusak'] }} Unit</span>
            <span class="stat-sub">Perlu perbaikan / penggantian</span>
        </div>
        <div class="stat-card purple">
            <span class="stat-label">Proker Berjalan</span>
            <span class="stat-value">{{ $stats['proker_berjalan'] }} / {{ $stats['total_proker'] }}</span>
            <span class="stat-sub">Program kerja aktif divisi</span>
        </div>
    </div>
    @endif

    {{-- COUNTDOWN EVENT TERDEKAT --}}
    @if(isset($eventTerdekat) && $eventTerdekat)
    <div class="card" style="margin-bottom: 1.5rem; background: linear-gradient(135deg, rgba(30, 41, 59, 0.9), rgba(15, 23, 42, 0.9)); border-color: rgba(99, 102, 241, 0.3);">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div>
                <span class="badge" style="background: rgba(99, 102, 241, 0.2); color: #818cf8; margin-bottom: 0.35rem;">
                    🎯 COUNTDOWN EVENT UTAMA TERDEKAT
                </span>
                <h3 style="font-size: 1.15rem; font-weight: 700; color: #f1f5f9;">{{ $eventTerdekat->judul }}</h3>
                <p style="font-size: 0.8rem; color: #94a3b8; margin-top: 0.2rem;">
                    Pelaksanaan: {{ \Carbon\Carbon::parse($eventTerdekat->tanggal_mulai)->format('d F Y') }} · PIC: {{ $eventTerdekat->pic ?: 'Divisi Acara' }}
                </p>
            </div>
            <div style="text-align: right;">
                @php
                    $hariLagi = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($eventTerdekat->tanggal_mulai), false);
                @endphp
                @if($hariLagi > 0)
                    <div style="font-size: 1.75rem; font-weight: 800; color: #818cf8;">{{ ceil($hariLagi) }} Hari Lagi</div>
                @elseif($hariLagi == 0)
                    <div style="font-size: 1.75rem; font-weight: 800; color: #34d399;">HARI INI!</div>
                @else
                    <div style="font-size: 1.5rem; font-weight: 700; color: #94a3b8;">Sedang Berjalan</div>
                @endif
                <span class="badge badge-ongoing" style="text-transform: capitalize;">{{ str_replace('_', ' ', $eventTerdekat->status) }}</span>
            </div>
        </div>
    </div>
    @endif

    {{-- STATUS KAS PRIBADI ANGGOTA --}}
    @if(isset($tagihanBulanIni) && $tagihanBulanIni)
    <div class="alert {{ $tagihanBulanIni->status === 'lunas' ? 'alert-success' : 'alert-warning' }}" style="margin-bottom:1.5rem;">
        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
        <div>
            <strong>Status Kas Anda Bulan {{ $tagihanBulanIni->namaBulan() }} {{ $tagihanBulanIni->tahun }}:</strong>
            @if($tagihanBulanIni->status === "lunas")
                ✅ Sudah Lunas — terima kasih atas kontribusi aktif Anda!
            @else
                ⚠️ Belum Lunas — tagihan kas bulan ini sebesar Rp {{ number_format($tagihanBulanIni->nominal,0,",",".") }}
            @endif
        </div>
    </div>
    @endif

    {{-- GRID 2 KOLOM: JADWAL & QUICK ACCESS FITUR DIVISI --}}
    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 1.5rem; margin-bottom: 1.5rem;">
        {{-- JADWAL MENDATANG --}}
        <div class="card">
            <div class="card-header">
                <span class="card-title">📅 Jadwal Kegiatan Terdekat</span>
                @can("jadwal.view")
                <a href="{{ route("jadwal.index") }}" class="btn btn-secondary btn-sm">Lihat Semua</a>
                @endcan
            </div>
            @if($jadwalTerdekat->isEmpty())
                <p style="color:var(--text-muted);font-size:0.875rem;">Belum ada jadwal kegiatan terdekat.</p>
            @else
            <div style="display:flex;flex-direction:column;gap:0.75rem;">
                @foreach($jadwalTerdekat as $j)
                <div style="display:flex;align-items:center;gap:0.75rem;padding:0.75rem;background:rgba(255,255,255,0.04);border-radius:8px;border-left:3px solid {{ $j->status === 'upcoming' ? '#3b82f6' : ($j->status === 'ongoing' ? '#10b981' : '#64748b') }};">
                    <div style="flex:1;">
                        <div style="font-weight:600;font-size:0.875rem;color:#f1f5f9;">{{ $j->judul }}</div>
                        <div style="font-size:0.75rem;color:var(--text-muted);">{{ $j->tanggal->format("d M Y") }} · {{ substr($j->waktu_mulai,0,5) }}{{ $j->lokasi ? ' · '.$j->lokasi : '' }}</div>
                    </div>
                    <span class="badge badge-{{ $j->status }}">{{ ucfirst($j->status) }}</span>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- PINTASAN & STRUKTUR PENGURUS --}}
        <div class="card">
            <div class="card-header">
                <span class="card-title">👥 Silsilah & Modul Divisi</span>
                <a href="{{ route('struktur.index') }}" class="btn btn-primary btn-sm">Lihat Silsilah</a>
            </div>
            <div style="display:flex; flex-direction:column; gap:0.75rem;">
                <div style="display:flex; align-items:center; gap:0.75rem; padding:0.75rem; background:rgba(255,255,255,0.04); border-radius:8px;">
                    <img src="{{ asset('images/logo-sec.jpg') }}" style="width:38px;height:38px;object-fit:contain;border-radius:50%;" alt="SEC">
                    <div>
                        <div style="font-weight:600;font-size:0.875rem;color:#f1f5f9;">SEC SMKN 1 Purwokerto</div>
                        <div style="font-size:0.75rem;color:var(--text-muted);">Periode 2026/2027 · 25 Personil Kepengurusan</div>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; margin-top: 0.25rem;">
                    <a href="{{ route('struktur.index') }}" class="btn btn-secondary btn-sm" style="justify-content: center; font-size: 0.75rem;">
                        🌳 Silsilah Pengurus
                    </a>
                    <a href="{{ route('pengumuman.index') }}" class="btn btn-secondary btn-sm" style="justify-content: center; font-size: 0.75rem;">
                        📢 Papan Pengumuman
                    </a>
                    <a href="{{ route('proker.index') }}" class="btn btn-secondary btn-sm" style="justify-content: center; font-size: 0.75rem;">
                        🎯 Timeline Proker
                    </a>
                    <a href="{{ route('drive.index') }}" class="btn btn-secondary btn-sm" style="justify-content: center; font-size: 0.75rem;">
                        📂 Arsip Link Drive
                    </a>
                    <a href="{{ route('inventaris.index') }}" class="btn btn-secondary btn-sm" style="justify-content: center; font-size: 0.75rem;">
                        📦 Inventaris Perkap
                    </a>
                    <a href="{{ route('surat.index') }}" class="btn btn-secondary btn-sm" style="justify-content: center; font-size: 0.75rem;">
                        ✉️ Surat Menyurat
                    </a>
                    <a href="{{ route('kontak.index') }}" class="btn btn-secondary btn-sm" style="justify-content: center; font-size: 0.75rem;">
                        📞 Kontak & Link Resmi
                    </a>
                </div>

                <div style="display:flex; gap:0.4rem; flex-wrap:wrap; margin-top:0.5rem;">
                    @role("admin")<span class="badge" style="background:rgba(239,68,68,0.2);color:#f87171;">⚡ Superadmin</span>@endrole
                    @role("ketua")<span class="badge badge-ongoing">👑 Ketua / Wakil</span>@endrole
                    @role("sekretaris")<span class="badge badge-upcoming">✍️ Sekretaris</span>@endrole
                    @role("bendahara")<span class="badge badge-lunas">💰 Bendahara</span>@endrole
                    @role("humas")<span class="badge" style="background:rgba(236,72,153,0.2);color:#f472b6;">📢 Humas</span>@endrole
                    @role("acara")<span class="badge" style="background:rgba(59,130,246,0.2);color:#60a5fa;">🎯 Acara</span>@endrole
                    @role("pdd")<span class="badge" style="background:rgba(139,92,246,0.2);color:#a78bfa;">📸 PDD</span>@endrole
                    @role("perkap")<span class="badge" style="background:rgba(20,184,166,0.2);color:#2dd4bf;">🔧 Perkap</span>@endrole
                    @role("anggota")<span class="badge badge-completed">👤 Anggota</span>@endrole
                </div>
            </div>
        </div>
    </div>
</x-app-layout>