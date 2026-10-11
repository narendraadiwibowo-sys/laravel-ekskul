<x-app-layout>
    <x-slot name="title">Struktur Organisasi & Silsilah Kepengurusan</x-slot>

    <style>
        .org-header {
            text-align: center;
            margin-bottom: 2.5rem;
            position: relative;
        }
        .org-title {
            font-size: 2rem;
            font-weight: 800;
            background: linear-gradient(135deg, #60a5fa, #a78bfa, #f472b6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.02em;
        }
        .org-sub {
            color: #94a3b8;
            font-size: 0.95rem;
            margin-top: 0.5rem;
        }
        .badge-periode {
            display: inline-block;
            margin-top: 0.75rem;
            padding: 0.25rem 0.85rem;
            border-radius: 9999px;
            background: rgba(59, 130, 246, 0.15);
            border: 1px solid rgba(59, 130, 246, 0.3);
            color: #93c5fd;
            font-size: 0.8rem;
            font-weight: 600;
        }

        /* Tree hierarchy styles */
        .org-level {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 1.5rem;
            margin-bottom: 2.5rem;
            position: relative;
        }

        .org-card {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 16px;
            overflow: hidden;
            width: 210px;
            display: flex;
            flex-direction: column;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }
        .org-card:hover {
            transform: translateY(-6px);
            border-color: #3b82f6;
            box-shadow: 0 12px 30px rgba(59, 130, 246, 0.25);
        }

        .org-card.card-koor {
            border: 1.5px solid #f59e0b;
            box-shadow: 0 4px 20px rgba(245, 158, 11, 0.15);
        }
        .org-card.card-koor:hover {
            border-color: #fbbf24;
            box-shadow: 0 12px 30px rgba(245, 158, 11, 0.3);
        }

        .org-card.card-inti {
            border: 1.5px solid #3b82f6;
            box-shadow: 0 4px 20px rgba(59, 130, 246, 0.2);
            width: 230px;
        }

        .photo-wrapper {
            position: relative;
            width: 100%;
            height: 230px;
            background: #0f172a;
            overflow: hidden;
        }
        .photo-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: top center;
            transition: transform 0.4s ease;
        }
        .org-card:hover .photo-img {
            transform: scale(1.05);
        }

        .koor-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: #fff;
            font-size: 0.65rem;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.4);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .card-body-pengurus {
            padding: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            flex: 1;
        }

        .pengurus-name {
            font-size: 0.92rem;
            font-weight: 700;
            color: #f8fafc;
            line-height: 1.25;
        }

        .pengurus-role {
            font-size: 0.75rem;
            font-weight: 600;
            color: #60a5fa;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .pengurus-kelas {
            font-size: 0.72rem;
            color: #94a3b8;
        }

        .pengurus-ig {
            margin-top: 0.4rem;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.72rem;
            color: #f472b6;
            text-decoration: none;
            transition: color 0.2s;
        }
        .pengurus-ig:hover {
            color: #fb7185;
            text-decoration: underline;
        }

        .divisi-section {
            background: rgba(30, 41, 59, 0.5);
            border: 1px solid #334155;
            border-radius: 20px;
            padding: 1.75rem;
            margin-bottom: 2.5rem;
        }
        .divisi-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #334155;
            padding-bottom: 1rem;
            margin-bottom: 1.5rem;
        }
        .divisi-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #f1f5f9;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .divisi-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #3b82f6;
        }
    </style>

    <div class="org-header">
        <h1 class="org-title">Silsilah & Bagan Kepengurusan</h1>
        <p class="org-sub">English Club SEC (Students' English Club) SMKN 1 Purwokerto</p>
        <span class="badge-periode">Periode {{ $periode ?? '2026/2027' }}</span>

        @can('pengurus.manage')
        <div style="margin-top: 1rem;">
            <a href="{{ route('struktur.manage') }}" class="btn btn-primary btn-sm">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Kelola Data Pengurus (Superadmin)
            </a>
        </div>
        @endcan
    </div>

    {{-- LEVEL 1: PENGURUS INTI (KETUA & WAKIL) --}}
    <div style="text-align: center; margin-bottom: 1rem;">
        <span style="font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: #60a5fa; background: rgba(59,130,246,0.1); padding: 4px 12px; border-radius: 20px;">
            Presidium Utama (Ketua & Wakil)
        </span>
    </div>
    <div class="org-level">
        @foreach($inti as $p)
        <div class="org-card card-inti">
            <div class="photo-wrapper">
                <img src="{{ $p->fotoUrl() }}" alt="{{ $p->nama }}" class="photo-img" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($p->nama) }}&background=1e3a8a&color=fff&size=300'">
            </div>
            <div class="card-body-pengurus">
                <span class="pengurus-role" style="color: #60a5fa;">{{ $p->jabatan }}</span>
                <div class="pengurus-name">{{ $p->nama }}</div>
                <div class="pengurus-kelas">{{ $p->kelas }}</div>
                @if($p->instagram)
                <a href="https://instagram.com/{{ ltrim($p->instagram, '@') }}" target="_blank" class="pengurus-ig">
                    <svg width="12" height="12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.13-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    {{ '@' . ltrim($p->instagram, '@') }}
                </a>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    {{-- LEVEL 2: SEKRETARIS & BENDAHARA (BPH INTI) --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(360px, 1fr)); gap: 1.5rem; margin-bottom: 2.5rem;">
        {{-- SEKRETARIS --}}
        <div class="divisi-section" style="margin-bottom:0;">
            <div class="divisi-header">
                <div class="divisi-title">
                    <span class="divisi-dot" style="background:#10b981;"></span>
                    Sekretariat (BPH)
                </div>
                <span class="badge" style="background: rgba(16,185,129,0.15); color: #34d399;">2 Personil</span>
            </div>
            <div style="display: flex; justify-content: center; gap: 1.25rem; flex-wrap: wrap;">
                @foreach($sekretaris as $p)
                <div class="org-card {{ $p->is_koordinator ? 'card-koor' : '' }}">
                    <div class="photo-wrapper">
                        @if($p->is_koordinator)
                        <span class="koor-badge">Koor / Utama</span>
                        @endif
                        <img src="{{ $p->fotoUrl() }}" alt="{{ $p->nama }}" class="photo-img" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($p->nama) }}&background=047857&color=fff&size=300'">
                    </div>
                    <div class="card-body-pengurus">
                        <span class="pengurus-role" style="color: #34d399;">{{ $p->jabatan }}</span>
                        <div class="pengurus-name">{{ $p->nama }}</div>
                        <div class="pengurus-kelas">{{ $p->kelas }}</div>
                        @if($p->instagram)
                        <a href="https://instagram.com/{{ ltrim($p->instagram, '@') }}" target="_blank" class="pengurus-ig">
                            {{ '@' . ltrim($p->instagram, '@') }}
                        </a>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- BENDAHARA --}}
        <div class="divisi-section" style="margin-bottom:0;">
            <div class="divisi-header">
                <div class="divisi-title">
                    <span class="divisi-dot" style="background:#f59e0b;"></span>
                    Kebendaharaan (BPH)
                </div>
                <span class="badge" style="background: rgba(245,158,11,0.15); color: #fbbf24;">2 Personil</span>
            </div>
            <div style="display: flex; justify-content: center; gap: 1.25rem; flex-wrap: wrap;">
                @foreach($bendahara as $p)
                <div class="org-card {{ $p->is_koordinator ? 'card-koor' : '' }}">
                    <div class="photo-wrapper">
                        @if($p->is_koordinator)
                        <span class="koor-badge">Koor / Utama</span>
                        @endif
                        <img src="{{ $p->fotoUrl() }}" alt="{{ $p->nama }}" class="photo-img" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($p->nama) }}&background=b45309&color=fff&size=300'">
                    </div>
                    <div class="card-body-pengurus">
                        <span class="pengurus-role" style="color: #fbbf24;">{{ $p->jabatan }}</span>
                        <div class="pengurus-name">{{ $p->nama }}</div>
                        <div class="pengurus-kelas">{{ $p->kelas }}</div>
                        @if($p->instagram)
                        <a href="https://instagram.com/{{ ltrim($p->instagram, '@') }}" target="_blank" class="pengurus-ig">
                            {{ '@' . ltrim($p->instagram, '@') }}
                        </a>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- LEVEL 3: DIVISI OPERASIONAL --}}
    
    {{-- DIVISI HUMAS --}}
    <div class="divisi-section">
        <div class="divisi-header">
            <div class="divisi-title">
                <span class="divisi-dot" style="background:#ec4899;"></span>
                Divisi Hubungan Masyarakat (Humas)
            </div>
            <span class="badge" style="background: rgba(236,72,153,0.15); color: #f472b6;">{{ $humas->count() }} Anggota</span>
        </div>
        <div style="display: flex; justify-content: center; gap: 1.25rem; flex-wrap: wrap;">
            @foreach($humas as $p)
            <div class="org-card {{ $p->is_koordinator ? 'card-koor' : '' }}">
                <div class="photo-wrapper">
                    @if($p->is_koordinator)
                    <span class="koor-badge">Koordinator</span>
                    @endif
                    <img src="{{ $p->fotoUrl() }}" alt="{{ $p->nama }}" class="photo-img" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($p->nama) }}&background=be185d&color=fff&size=300'">
                </div>
                <div class="card-body-pengurus">
                    <span class="pengurus-role" style="color: #f472b6;">{{ $p->jabatan }}</span>
                    <div class="pengurus-name">{{ $p->nama }}</div>
                    <div class="pengurus-kelas">{{ $p->kelas }}</div>
                    @if($p->instagram)
                    <a href="https://instagram.com/{{ ltrim($p->instagram, '@') }}" target="_blank" class="pengurus-ig">
                        {{ '@' . ltrim($p->instagram, '@') }}
                    </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- DIVISI ACARA / EVENT --}}
    <div class="divisi-section">
        <div class="divisi-header">
            <div class="divisi-title">
                <span class="divisi-dot" style="background:#3b82f6;"></span>
                Divisi Acara & Program Kerja
            </div>
            <span class="badge" style="background: rgba(59,130,246,0.15); color: #60a5fa;">{{ $acara->count() }} Anggota</span>
        </div>
        <div style="display: flex; justify-content: center; gap: 1.25rem; flex-wrap: wrap;">
            @foreach($acara as $p)
            <div class="org-card {{ $p->is_koordinator ? 'card-koor' : '' }}">
                <div class="photo-wrapper">
                    @if($p->is_koordinator)
                    <span class="koor-badge">Koordinator</span>
                    @endif
                    <img src="{{ $p->fotoUrl() }}" alt="{{ $p->nama }}" class="photo-img" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($p->nama) }}&background=1d4ed8&color=fff&size=300'">
                </div>
                <div class="card-body-pengurus">
                    <span class="pengurus-role" style="color: #60a5fa;">{{ $p->jabatan }}</span>
                    <div class="pengurus-name">{{ $p->nama }}</div>
                    <div class="pengurus-kelas">{{ $p->kelas }}</div>
                    @if($p->instagram)
                    <a href="https://instagram.com/{{ ltrim($p->instagram, '@') }}" target="_blank" class="pengurus-ig">
                        {{ '@' . ltrim($p->instagram, '@') }}
                    </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- DIVISI PDD --}}
    <div class="divisi-section">
        <div class="divisi-header">
            <div class="divisi-title">
                <span class="divisi-dot" style="background:#8b5cf6;"></span>
                Divisi Publikasi, Dekorasi & Dokumentasi (PDD)
            </div>
            <span class="badge" style="background: rgba(139,92,246,0.15); color: #a78bfa;">{{ $pdd->count() }} Anggota</span>
        </div>
        <div style="display: flex; justify-content: center; gap: 1.25rem; flex-wrap: wrap;">
            @foreach($pdd as $p)
            <div class="org-card {{ $p->is_koordinator ? 'card-koor' : '' }}">
                <div class="photo-wrapper">
                    @if($p->is_koordinator)
                    <span class="koor-badge">Koordinator</span>
                    @endif
                    <img src="{{ $p->fotoUrl() }}" alt="{{ $p->nama }}" class="photo-img" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($p->nama) }}&background=6d28d9&color=fff&size=300'">
                </div>
                <div class="card-body-pengurus">
                    <span class="pengurus-role" style="color: #a78bfa;">{{ $p->jabatan }}</span>
                    <div class="pengurus-name">{{ $p->nama }}</div>
                    <div class="pengurus-kelas">{{ $p->kelas }}</div>
                    @if($p->instagram)
                    <a href="https://instagram.com/{{ ltrim($p->instagram, '@') }}" target="_blank" class="pengurus-ig">
                        {{ '@' . ltrim($p->instagram, '@') }}
                    </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- DIVISI PERKAP --}}
    <div class="divisi-section">
        <div class="divisi-header">
            <div class="divisi-title">
                <span class="divisi-dot" style="background:#14b8a6;"></span>
                Divisi Perlengkapan & Logistik (Perkap)
            </div>
            <span class="badge" style="background: rgba(20,184,166,0.15); color: #2dd4bf;">{{ $perkap->count() }} Anggota</span>
        </div>
        <div style="display: flex; justify-content: center; gap: 1.25rem; flex-wrap: wrap;">
            @foreach($perkap as $p)
            <div class="org-card {{ $p->is_koordinator ? 'card-koor' : '' }}">
                <div class="photo-wrapper">
                    @if($p->is_koordinator)
                    <span class="koor-badge">Koordinator</span>
                    @endif
                    <img src="{{ $p->fotoUrl() }}" alt="{{ $p->nama }}" class="photo-img" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($p->nama) }}&background=0f766e&color=fff&size=300'">
                </div>
                <div class="card-body-pengurus">
                    <span class="pengurus-role" style="color: #2dd4bf;">{{ $p->jabatan }}</span>
                    <div class="pengurus-name">{{ $p->nama }}</div>
                    <div class="pengurus-kelas">{{ $p->kelas }}</div>
                    @if($p->instagram)
                    <a href="https://instagram.com/{{ ltrim($p->instagram, '@') }}" target="_blank" class="pengurus-ig">
                        {{ '@' . ltrim($p->instagram, '@') }}
                    </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>

</x-app-layout>
