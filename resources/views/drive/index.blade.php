<x-app-layout>
    <x-slot name="title">Arsip Drive & Pamflet H-1 (Divisi PDD)</x-slot>

    {{-- STATS GRID PDD --}}
    <div class="stats-grid">
        <div class="stat-card purple">
            <span class="stat-label">Arsip Google Drive</span>
            <span class="stat-value">{{ $totalDrive }}</span>
            <span class="stat-sub">Folder dokumentasi event terpusat</span>
        </div>
        <div class="stat-card blue">
            <span class="stat-label">Manajemen Pamflet</span>
            <span class="stat-value">{{ $totalPamflet }}</span>
            <span class="stat-sub">Desain pamflet & poster publikasi</span>
        </div>
        <div class="stat-card {{ $pamfletH1->isNotEmpty() ? 'red' : 'green' }}">
            <span class="stat-label">Pamflet Deadline H-1</span>
            <span class="stat-value">{{ $pamfletH1->count() }}</span>
            <span class="stat-sub">{{ $pamfletH1->isNotEmpty() ? 'Harus naik tayang segera!' : 'Semua pamflet terjadwal' }}</span>
        </div>
    </div>

    {{-- ALERT PENGINGAT PAMFLET H-1 NAIK TAYANG --}}
    @if($pamfletH1->isNotEmpty())
    <div class="banner-h1" style="background: linear-gradient(135deg, rgba(139, 92, 246, 0.2), rgba(236, 72, 153, 0.1)); border-color: rgba(139, 92, 246, 0.4);">
        <span class="banner-icon">📢</span>
        <div class="banner-text">
            <div class="banner-title" style="color: #c084fc;">PENGINGAT PDD: Pamflet Harus Naik Tayang H-1!</div>
            @foreach($pamfletH1 as $p)
            <div class="banner-sub" style="color: #e9d5ff;">
                🎨 <strong>{{ $p->judul }}</strong> — Jadwal Tayang: {{ $p->tanggal_tayang ? $p->tanggal_tayang->format('d M Y') : 'H-1' }}
                @if($p->thumbnail)
                · <a href="{{ asset('images/thumbnails/' . $p->thumbnail) }}" target="_blank" style="color:#67e8f9; text-decoration:underline;">Lihat File Desain</a>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="card">
        <div class="card-header">
            <div>
                <h2 class="card-title">Arsip Google Drive & Manajemen Pamflet H-1</h2>
                <p style="font-size: 0.8rem; color: #94a3b8; margin-top: 0.25rem;">
                    Penyimpanan terpusat dokumentasi foto video dan pengontrolan desain pamflet publikasi
                </p>
            </div>
            @can('drive.create')
            <div style="display: flex; gap: 0.5rem;">
                <button onclick="bukaModalDrive('drive')" class="btn btn-primary btn-sm" style="background: #2563eb;">
                    + Simpan Link Drive
                </button>
                <button onclick="bukaModalDrive('pamflet')" class="btn btn-primary btn-sm" style="background: #8b5cf6;">
                    + Upload Pamflet H-1
                </button>
            </div>
            @endcan
        </div>

        {{-- FILTER & SEARCH --}}
        <form method="GET" action="{{ route('drive.index') }}" style="margin-bottom: 1.5rem; display: flex; gap: 0.75rem; flex-wrap: wrap;">
            <input type="text" name="search" class="form-control" placeholder="Cari judul event atau pamflet..." value="{{ request('search') }}" style="max-width: 320px;">
            <select name="tipe" class="form-control" style="max-width: 180px;">
                <option value="">-- Semua Tipe --</option>
                <option value="drive" {{ request('tipe') == 'drive' ? 'selected' : '' }}>Google Drive</option>
                <option value="pamflet" {{ request('tipe') == 'pamflet' ? 'selected' : '' }}>Pamflet Publikasi</option>
            </select>
            <select name="status_tayang" class="form-control" style="max-width: 180px;">
                <option value="">-- Status Tayang --</option>
                <option value="siap_tayang" {{ request('status_tayang') == 'siap_tayang' ? 'selected' : '' }}>Siap Tayang H-1</option>
                <option value="sudah_tayang" {{ request('status_tayang') == 'sudah_tayang' ? 'selected' : '' }}>Sudah Tayang</option>
                <option value="draft" {{ request('status_tayang') == 'draft' ? 'selected' : '' }}>Draft</option>
            </select>
            <button type="submit" class="btn btn-secondary btn-sm">Filter</button>
            @if(request()->anyFilled(['search', 'tipe', 'status_tayang']))
            <a href="{{ route('drive.index') }}" class="btn btn-secondary btn-sm">Reset</a>
            @endif
        </form>

        {{-- GRID EVENT DRIVES & PAMFLET --}}
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
            @forelse($items as $drive)
            <div style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 14px; overflow: hidden; display: flex; flex-direction: column; transition: transform 0.2s, border-color 0.2s;">
                <div style="height: 180px; background: #0f172a; position: relative; overflow: hidden;">
                    @if($drive->thumbnail)
                        <img src="{{ asset('images/thumbnails/' . $drive->thumbnail) }}" alt="{{ $drive->judul }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #1e293b, #0f172a); color: #8b5cf6;">
                            <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    @endif

                    {{-- BADGE TIPE --}}
                    <span style="position: absolute; top: 8px; left: 8px; background: {{ $drive->tipe === 'pamflet' ? 'rgba(139, 92, 246, 0.9)' : 'rgba(37, 99, 235, 0.9)' }}; color: white; font-size: 0.65rem; font-weight: 700; padding: 2px 8px; border-radius: 4px; text-transform: uppercase;">
                        {{ $drive->tipe === 'pamflet' ? '🎨 Pamflet H-1' : '📂 Cloud Drive' }}
                    </span>

                    @if($drive->tipe === 'pamflet')
                    <span style="position: absolute; top: 8px; right: 8px; background: {{ $drive->status_tayang === 'sudah_tayang' ? '#059669' : ($drive->status_tayang === 'siap_tayang' ? '#d97706' : '#64748b') }}; color: white; font-size: 0.65rem; font-weight: 700; padding: 2px 8px; border-radius: 4px;">
                        {{ str_replace('_', ' ', strtoupper($drive->status_tayang)) }}
                    </span>
                    @endif

                    @if($drive->tanggal_event || $drive->tanggal_tayang)
                    <span style="position: absolute; bottom: 8px; left: 8px; background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(4px); color: #e2e8f0; font-size: 0.72rem; padding: 2px 8px; border-radius: 6px; border: 1px solid rgba(255,255,255,0.1);">
                        📅 {{ ($drive->tanggal_event ?: $drive->tanggal_tayang)->format('d M Y') }}
                    </span>
                    @endif
                </div>

                <div style="padding: 1.25rem; flex: 1; display: flex; flex-direction: column; justify-content: space-between; gap: 0.75rem;">
                    <div>
                        <h3 style="font-size: 1rem; font-weight: 700; color: #f1f5f9; line-height: 1.3; margin-bottom: 0.4rem;">
                            {{ $drive->judul }}
                        </h3>
                        @if($drive->deskripsi)
                        <p style="font-size: 0.8rem; color: #94a3b8; line-height: 1.5;">
                            {{ Str::limit($drive->deskripsi, 90) }}
                        </p>
                        @endif
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 0.5rem; margin-top: 0.5rem;">
                        @if($drive->link_drive && $drive->link_drive !== '#')
                        <a href="{{ $drive->link_drive }}" target="_blank" class="btn btn-primary btn-sm" style="background: #2563eb; justify-content: center;">
                            <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM17 13l-5 5-5-5h3V9h4v4h3z"/></svg>
                            Buka Folder Google Drive
                        </a>
                        @elseif($drive->thumbnail)
                        <a href="{{ asset('images/thumbnails/' . $drive->thumbnail) }}" target="_blank" class="btn btn-primary btn-sm" style="background: #8b5cf6; justify-content: center;">
                            🔍 Lihat Desain Pamflet HD
                        </a>
                        @endif

                        @canany(['drive.update', 'drive.delete'])
                        <div style="display: flex; justify-content: flex-end; gap: 0.4rem;">
                            @can('drive.delete')
                            <form action="{{ route('drive.destroy', $drive) }}" method="POST" onsubmit="return confirm('Hapus arsip PDD ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" style="padding: 0.25rem 0.5rem; font-size: 0.7rem;">Hapus</button>
                            </form>
                            @endcan
                        </div>
                        @endcanany
                    </div>
                </div>
            </div>
            @empty
            <div style="grid-column: 1 / -1; text-align: center; color: #94a3b8; padding: 3rem 1rem;">
                <p>Belum ada data arsip drive atau pamflet yang disimpan.</p>
            </div>
            @endforelse
        </div>

        <div style="margin-top: 1.5rem;">
            {{ $items->links() }}
        </div>
    </div>

    {{-- MODAL TAMBAH ARSIP DRIVE / PAMFLET --}}
    <div id="modal-tambah-drive" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.7); z-index:99; align-items:center; justify-content:center; padding: 1rem;">
        <div style="background:#1e293b; border:1px solid #334155; border-radius:14px; max-width:550px; width:100%; padding:1.5rem; max-height:90vh; overflow-y:auto;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.25rem;">
                <h3 id="modal-pdd-title" style="font-size:1.1rem; font-weight:700; color:#f1f5f9;">+ Simpan Arsip PDD</h3>
                <button onclick="tutupModalDrive()" style="background:none; border:none; color:#94a3b8; font-size:1.25rem; cursor:pointer;">&times;</button>
            </div>

            <form id="form-tambah-drive" action="{{ route('drive.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="tipe" id="input-pdd-tipe" value="drive">

                <div class="form-group">
                    <label>Judul Event / Nama Pamflet *</label>
                    <input type="text" name="judul" class="form-control" required placeholder="Contoh: Dokumentasi Pelantikan SEC 2026 / Pamflet English Fest H-1">
                </div>

                <div id="field-link-drive" class="form-group">
                    <label>Link Folder Google Drive</label>
                    <input type="url" name="link_drive" class="form-control" placeholder="https://drive.google.com/drive/folders/...">
                    <p style="font-size: 0.72rem; color: #94a3b8; margin-top: 0.25rem;">Pastikan akses link Drive disetel 'Anyone with the link can view'.</p>
                </div>

                <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label>Tanggal Pelaksanaan Event</label>
                        <input type="date" name="tanggal_event" class="form-control">
                    </div>
                    <div id="field-pamflet-tayang" class="form-group">
                        <label>Jadwal Naik Tayang (H-1)</label>
                        <input type="date" name="tanggal_tayang" class="form-control">
                    </div>
                </div>

                <div id="field-pamflet-status" class="form-group" style="display:none;">
                    <label>Status Tayang Pamflet</label>
                    <select name="status_tayang" class="form-control">
                        <option value="siap_tayang">Siap Tayang H-1</option>
                        <option value="sudah_tayang">Sudah Tayang</option>
                        <option value="draft">Draft / Sedang Didesain</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Keterangan / Detail Informasi</label>
                    <textarea name="deskripsi" class="form-control" rows="3" placeholder="Informasi materi, resolusi foto, atau instruksi caption publikasi..."></textarea>
                </div>

                <div class="form-group">
                    <label>Upload Gambar / Poster Pamflet (Opsional, JPG/PNG Maks 3MB)</label>
                    <input type="file" name="thumbnail" class="form-control" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
                </div>

                <div style="display:flex; justify-content:flex-end; gap:0.75rem; margin-top:1.5rem;">
                    <button type="button" onclick="tutupModalDrive()" class="btn btn-secondary">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    function tutupModalDrive() {
        const modal = document.getElementById('modal-tambah-drive');
        const form = document.getElementById('form-tambah-drive');
        if (form) {
            form.reset();
            // Explicitly clear file inputs (some browsers ignore form.reset() for file inputs)
            form.querySelectorAll('input[type="file"]').forEach(f => {
                try { f.value = ''; } catch(e) { /* IE */ }
                const newF = f.cloneNode(true);
                f.parentNode.replaceChild(newF, f);
            });
        }
        modal.style.display = 'none';
    }

    function bukaModalDrive(tipe) {
        const form = document.getElementById('form-tambah-drive');
        if (form) {
            form.reset();
            // Explicitly clear file inputs
            form.querySelectorAll('input[type="file"]').forEach(f => {
                try { f.value = ''; } catch(e) {}
                const newF = f.cloneNode(true);
                f.parentNode.replaceChild(newF, f);
            });
        }

        document.getElementById('input-pdd-tipe').value = tipe;
        const modal = document.getElementById('modal-tambah-drive');
        const title = document.getElementById('modal-pdd-title');
        const linkDriveField = document.getElementById('field-link-drive');
        const statusField = document.getElementById('field-pamflet-status');
        const tayangField = document.getElementById('field-pamflet-tayang');

        if (tipe === 'pamflet') {
            title.innerText = '🎨 Upload & Jadwalkan Pamflet H-1 (PDD)';
            linkDriveField.style.display = 'none';
            statusField.style.display = 'block';
            tayangField.style.display = 'block';
        } else {
            title.innerText = '📂 Simpan Link Folder Google Drive';
            linkDriveField.style.display = 'block';
            statusField.style.display = 'none';
            tayangField.style.display = 'none';
        }

        modal.style.display = 'flex';
    }
    </script>
</x-app-layout>
