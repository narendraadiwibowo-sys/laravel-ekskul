<x-app-layout>
    <x-slot name="title">Manajemen Kontak & Link Resmi (Divisi Humas)</x-slot>

    <div class="card">
        <div class="card-header">
            <div>
                <h2 class="card-title" style="display: flex; align-items: center; gap: 0.5rem;">
                    <svg width="22" height="22" fill="none" stroke="#ec4899" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                    Daftar Kontak Penting & Tautan Resmi Ekskul
                </h2>
                <p style="font-size: 0.8rem; color: #94a3b8; margin-top: 0.25rem;">
                    Dikelola oleh Divisi Humas untuk narahubung pembina, pihak sekolah, sosial media, dan tautan organisasi
                </p>
            </div>
            @canany(['pengumuman.create', 'pengurus.manage'])
            <button onclick="document.getElementById('modal-tambah-kontak').style.display='flex'" class="btn btn-primary btn-sm" style="background: #ec4899;">
                + Tambah Kontak / Link Baru
            </button>
            @endcanany
        </div>

        {{-- FILTER & SEARCH --}}
        <form method="GET" action="{{ route('kontak.index') }}" style="display: flex; gap: 0.75rem; flex-wrap: wrap; margin-bottom: 1.5rem;">
            <input type="text" name="search" class="form-control" placeholder="Cari nama kontak, instansi, atau url..." value="{{ request('search') }}" style="max-width: 320px;">
            <select name="kategori" class="form-control" style="max-width: 200px;">
                <option value="">-- Semua Kategori --</option>
                <option value="pembina" {{ request('kategori') == 'pembina' ? 'selected' : '' }}>Pembina Ekskul</option>
                <option value="sekolah" {{ request('kategori') == 'sekolah' ? 'selected' : '' }}>Pihak Sekolah</option>
                <option value="sosmed" {{ request('kategori') == 'sosmed' ? 'selected' : '' }}>Sosial Media Resmi</option>
                <option value="grup_link" {{ request('kategori') == 'grup_link' ? 'selected' : '' }}>Grup & Tautan Penting</option>
                <option value="lainnya" {{ request('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
            </select>
            <button type="submit" class="btn btn-secondary btn-sm">Filter</button>
            @if(request()->anyFilled(['search', 'kategori']))
            <a href="{{ route('kontak.index') }}" class="btn btn-secondary btn-sm">Reset</a>
            @endif
        </form>

        {{-- GRID DAFTAR KONTAK --}}
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.25rem;">
            @forelse($kontaks as $k)
            @php
                $catColor = match($k->kategori) {
                    'pembina' => 'background: rgba(59, 130, 246, 0.2); color: #60a5fa;',
                    'sekolah' => 'background: rgba(16, 185, 129, 0.2); color: #34d399;',
                    'sosmed' => 'background: rgba(236, 72, 153, 0.2); color: #f472b6;',
                    'grup_link' => 'background: rgba(245, 158, 11, 0.2); color: #fbbf24;',
                    default => 'background: rgba(148, 163, 184, 0.2); color: #cbd5e1;'
                };
                $catLabel = match($k->kategori) {
                    'pembina' => 'Pembina Ekskul',
                    'sekolah' => 'Pihak Sekolah',
                    'sosmed' => 'Sosial Media',
                    'grup_link' => 'Grup / Link',
                    default => 'Lainnya'
                };
                $isUrl = str_starts_with($k->kontak_url, 'http://') || str_starts_with($k->kontak_url, 'https://');
            @endphp
            <div style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 12px; padding: 1.25rem; display: flex; flex-direction: column; justify-content: space-between; gap: 1rem;">
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem;">
                        <span class="badge" style="{{ $catColor }}">{{ $catLabel }}</span>
                        @canany(['pengumuman.create', 'pengurus.manage'])
                        <div style="display: flex; gap: 0.35rem;">
                            <button onclick="editKontak({{ json_encode($k) }})" class="btn btn-secondary btn-sm" style="padding: 0.2rem 0.5rem; font-size: 0.72rem;">Edit</button>
                            <form action="{{ route('kontak.destroy', $k) }}" method="POST" onsubmit="return confirm('Hapus kontak ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" style="padding: 0.2rem 0.5rem; font-size: 0.72rem;">Hapus</button>
                            </form>
                        </div>
                        @endcanany
                    </div>

                    <h3 style="font-size: 1.05rem; font-weight: 700; color: #f1f5f9; margin-bottom: 0.25rem;">
                        {{ $k->nama }}
                    </h3>

                    @if($k->keterangan)
                    <p style="font-size: 0.82rem; color: #94a3b8; line-height: 1.5; margin-bottom: 0.75rem;">
                        {{ $k->keterangan }}
                    </p>
                    @endif
                </div>

                <div style="padding-top: 0.75rem; border-top: 1px solid rgba(255, 255, 255, 0.06); display: flex; align-items: center; justify-content: space-between; gap: 0.5rem;">
                    @if($isUrl)
                    <a href="{{ $k->kontak_url }}" target="_blank" class="btn btn-primary btn-sm" style="flex: 1; justify-content: center; background: rgba(59, 130, 246, 0.2); color: #93c5fd; border: 1px solid rgba(59, 130, 246, 0.3);">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        Buka Tautan Resmi
                    </a>
                    @else
                    <div style="font-family: monospace; font-size: 0.9rem; color: #34d399; font-weight: 600;">
                        {{ $k->kontak_url }}
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div style="grid-column: 1 / -1; text-align: center; color: #94a3b8; padding: 3rem 1rem;">
                <p>Belum ada kontak atau link penting yang dicatat.</p>
            </div>
            @endforelse
        </div>

        <div style="margin-top: 1.5rem;">
            {{ $kontaks->links() }}
        </div>
    </div>

    {{-- MODAL TAMBAH KONTAK --}}
    <div id="modal-tambah-kontak" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.7); z-index:99; align-items:center; justify-content:center; padding: 1rem;">
        <div style="background:#1e293b; border:1px solid #334155; border-radius:14px; max-width:500px; width:100%; padding:1.5rem;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.25rem;">
                <h3 style="font-size:1.1rem; font-weight:700; color:#f1f5f9;">+ Tambah Kontak / Link Penting</h3>
                <button onclick="document.getElementById('modal-tambah-kontak').style.display='none'" style="background:none; border:none; color:#94a3b8; font-size:1.25rem; cursor:pointer;">&times;</button>
            </div>

            <form action="{{ route('kontak.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Nama Kontak / Judul Tautan *</label>
                    <input type="text" name="nama" class="form-control" required placeholder="Contoh: Pembina SEC (Dra. Siti Rahayu) / Instagram Official">
                </div>

                <div class="form-group">
                    <label>Kategori *</label>
                    <select name="kategori" class="form-control" required>
                        <option value="pembina">Pembina Ekskul</option>
                        <option value="sekolah">Pihak Sekolah / Kesiswaan</option>
                        <option value="sosmed" selected>Sosial Media Resmi</option>
                        <option value="grup_link">Grup / Tautan Penting</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Nomor Kontak / Alamat URL *</label>
                    <input type="text" name="kontak_url" class="form-control" required placeholder="https://instagram.com/sec_smkn1 atau 08123456789">
                </div>

                <div class="form-group">
                    <label>Keterangan Tambahan</label>
                    <textarea name="keterangan" class="form-control" rows="3" placeholder="Informasi jam kerja, deskripsi sosmed, dsb..."></textarea>
                </div>

                <div style="display:flex; justify-content:flex-end; gap:0.75rem; margin-top:1.5rem;">
                    <button type="button" onclick="document.getElementById('modal-tambah-kontak').style.display='none'" class="btn btn-secondary">Batal</button>
                    <button type="submit" class="btn btn-primary" style="background:#ec4899;">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL EDIT KONTAK --}}
    <div id="modal-edit-kontak" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.7); z-index:99; align-items:center; justify-content:center; padding: 1rem;">
        <div style="background:#1e293b; border:1px solid #334155; border-radius:14px; max-width:500px; width:100%; padding:1.5rem;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.25rem;">
                <h3 style="font-size:1.1rem; font-weight:700; color:#f1f5f9;">Update Kontak / Link</h3>
                <button onclick="document.getElementById('modal-edit-kontak').style.display='none'" style="background:none; border:none; color:#94a3b8; font-size:1.25rem; cursor:pointer;">&times;</button>
            </div>

            <form id="form-edit-kontak" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Nama Kontak / Judul Tautan *</label>
                    <input type="text" name="nama" id="edit-kontak-nama" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Kategori *</label>
                    <select name="kategori" id="edit-kontak-kategori" class="form-control" required>
                        <option value="pembina">Pembina Ekskul</option>
                        <option value="sekolah">Pihak Sekolah / Kesiswaan</option>
                        <option value="sosmed">Sosial Media Resmi</option>
                        <option value="grup_link">Grup / Tautan Penting</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Nomor Kontak / Alamat URL *</label>
                    <input type="text" name="kontak_url" id="edit-kontak-url" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Keterangan Tambahan</label>
                    <textarea name="keterangan" id="edit-kontak-keterangan" class="form-control" rows="3"></textarea>
                </div>

                <div style="display:flex; justify-content:flex-end; gap:0.75rem; margin-top:1.5rem;">
                    <button type="button" onclick="document.getElementById('modal-edit-kontak').style.display='none'" class="btn btn-secondary">Batal</button>
                    <button type="submit" class="btn btn-primary" style="background:#ec4899;">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    function editKontak(k) {
        document.getElementById('form-edit-kontak').action = '/kontak/' + k.id;
        document.getElementById('edit-kontak-nama').value = k.nama;
        document.getElementById('edit-kontak-kategori').value = k.kategori;
        document.getElementById('edit-kontak-url').value = k.kontak_url;
        document.getElementById('edit-kontak-keterangan').value = k.keterangan || '';
        document.getElementById('modal-edit-kontak').style.display = 'flex';
    }
    </script>
</x-app-layout>
