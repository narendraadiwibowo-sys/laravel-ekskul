<x-app-layout>
    <x-slot name="title">Arsip Surat Menyurat (Divisi Sekretaris)</x-slot>

    {{-- STATS GRID SURAT --}}
    <div class="stats-grid">
        <div class="stat-card blue">
            <span class="stat-label">Total Arsip Surat</span>
            <span class="stat-value">{{ $surats->total() }}</span>
            <span class="stat-sub">Semua berkas persuratan</span>
        </div>
        <div class="stat-card green">
            <span class="stat-label">Surat Masuk</span>
            <span class="stat-value">{{ $totalMasuk }}</span>
            <span class="stat-sub">Dari sekolah / pihak luar / ekskul lain</span>
        </div>
        <div class="stat-card purple">
            <span class="stat-label">Surat Keluar</span>
            <span class="stat-value">{{ $totalKeluar }}</span>
            <span class="stat-sub">Undangan, permohonan izin, proposal</span>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div>
                <h2 class="card-title">Buku Agenda Surat Masuk & Keluar</h2>
                <p style="font-size: 0.8rem; color: #94a3b8; margin-top: 0.25rem;">
                    Pencatatan nomor urut surat resmi untuk memudahkan sekretaris melacak arsip
                </p>
            </div>
            @can('surat.create')
            <button onclick="document.getElementById('modal-tambah-surat').style.display='flex'" class="btn btn-primary btn-sm">
                + Catat Surat Baru
            </button>
            @endcan
        </div>

        {{-- FILTER & SEARCH --}}
        <form method="GET" action="{{ route('surat.index') }}" style="display: flex; gap: 0.75rem; flex-wrap: wrap; margin-bottom: 1.25rem;">
            <input type="text" name="search" class="form-control" placeholder="Cari nomor surat, perihal, atau instansi..." value="{{ request('search') }}" style="max-width: 350px;">
            <select name="jenis" class="form-control" style="max-width: 180px;">
                <option value="">-- Semua Jenis Surat --</option>
                <option value="masuk" {{ request('jenis') == 'masuk' ? 'selected' : '' }}>Surat Masuk</option>
                <option value="keluar" {{ request('jenis') == 'keluar' ? 'selected' : '' }}>Surat Keluar</option>
            </select>
            <button type="submit" class="btn btn-secondary btn-sm">Filter</button>
            @if(request()->anyFilled(['search', 'jenis']))
            <a href="{{ route('surat.index') }}" class="btn btn-secondary btn-sm">Reset</a>
            @endif
        </form>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Jenis</th>
                        <th>Nomor Surat</th>
                        <th>Perihal</th>
                        <th>Asal / Tujuan</th>
                        <th>Tanggal Surat</th>
                        <th>Tgl Diterima/Dikirim</th>
                        @canany(['surat.update', 'surat.delete'])
                        <th style="text-align: right;">Aksi</th>
                        @endcanany
                    </tr>
                </thead>
                <tbody>
                    @forelse($surats as $surat)
                    <tr>
                        <td>
                            @if($surat->jenis == 'masuk')
                                <span class="badge" style="background: rgba(16, 185, 129, 0.2); color: #34d399;">SURAT MASUK</span>
                            @else
                                <span class="badge" style="background: rgba(168, 85, 247, 0.2); color: #c084fc;">SURAT KELUAR</span>
                            @endif
                        </td>
                        <td>
                            <strong style="color: #60a5fa; font-family: monospace; font-size: 0.85rem;">{{ $surat->nomor_surat }}</strong>
                        </td>
                        <td>
                            <strong style="color: #f1f5f9;">{{ $surat->perihal }}</strong>
                            @if($surat->keterangan)
                            <div style="font-size: 0.75rem; color: #94a3b8;">{{ $surat->keterangan }}</div>
                            @endif
                        </td>
                        <td><span style="color: #cbd5e1;">{{ $surat->asal_tujuan }}</span></td>
                        <td>{{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d M Y') }}</td>
                        <td>{{ $surat->tanggal_terima_kirim ? \Carbon\Carbon::parse($surat->tanggal_terima_kirim)->format('d M Y') : '-' }}</td>
                        @canany(['surat.update', 'surat.delete'])
                        <td style="text-align: right;">
                            <div style="display: inline-flex; gap: 0.4rem;">
                                @can('surat.update')
                                <button onclick="editSurat({{ json_encode($surat) }})" class="btn btn-warning btn-sm">Edit</button>
                                @endcan
                                @can('surat.delete')
                                <form action="{{ route('surat.destroy', $surat) }}" method="POST" onsubmit="return confirm('Hapus arsip surat ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                                @endcan
                            </div>
                        </td>
                        @endcanany
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: #94a3b8; padding: 2.5rem;">
                            Belum ada arsip surat menyurat yang tercatat.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 1rem;">
            {{ $surats->links() }}
        </div>
    </div>

    {{-- MODAL TAMBAH SURAT --}}
    <div id="modal-tambah-surat" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.7); z-index:99; align-items:center; justify-content:center; padding: 1rem;">
        <div style="background:#1e293b; border:1px solid #334155; border-radius:14px; max-width:600px; width:100%; padding:1.5rem; max-height:90vh; overflow-y:auto;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.25rem;">
                <h3 style="font-size:1.1rem; font-weight:700; color:#f1f5f9;">+ Catat Surat Masuk / Keluar Baru</h3>
                <button onclick="document.getElementById('modal-tambah-surat').style.display='none'" style="background:none; border:none; color:#94a3b8; font-size:1.25rem; cursor:pointer;">&times;</button>
            </div>

            <form action="{{ route('surat.store') }}" method="POST">
                @csrf
                <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label>Jenis Surat *</label>
                        <select name="jenis" class="form-control" required>
                            <option value="masuk">Surat Masuk</option>
                            <option value="keluar">Surat Keluar</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Nomor Surat *</label>
                        <input type="text" name="nomor_surat" class="form-control" required placeholder="Contoh: 012/SEC-SMKN1/X/2026">
                    </div>
                </div>

                <div class="form-group">
                    <label>Perihal Surat *</label>
                    <input type="text" name="perihal" class="form-control" required placeholder="Contoh: Permohonan Izin Tempat Ruang Aula">
                </div>

                <div class="form-group">
                    <label>Asal / Tujuan Instansi *</label>
                    <input type="text" name="asal_tujuan" class="form-control" required placeholder="Contoh: Waka Kesiswaan / OSIS SMKN 1">
                </div>

                <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label>Tanggal Tertulis di Surat *</label>
                        <input type="date" name="tanggal_surat" class="form-control" required value="{{ date('Y-m-d') }}">
                    </div>

                    <div class="form-group">
                        <label>Tanggal Diterima / Dikirim</label>
                        <input type="date" name="tanggal_terima_kirim" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label>Keterangan / Posisi Fisik Berkas</label>
                    <textarea name="keterangan" class="form-control" rows="2" placeholder="Tersimpan di Binder Surat Masuk 2026, dll..."></textarea>
                </div>

                <div style="display:flex; justify-content:flex-end; gap:0.75rem; margin-top:1.5rem;">
                    <button type="button" onclick="document.getElementById('modal-tambah-surat').style.display='none'" class="btn btn-secondary">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Surat</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL EDIT SURAT --}}
    <div id="modal-edit-surat" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.7); z-index:99; align-items:center; justify-content:center; padding: 1rem;">
        <div style="background:#1e293b; border:1px solid #334155; border-radius:14px; max-width:600px; width:100%; padding:1.5rem;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.25rem;">
                <h3 style="font-size:1.1rem; font-weight:700; color:#f1f5f9;">Update Data Surat</h3>
                <button onclick="document.getElementById('modal-edit-surat').style.display='none'" style="background:none; border:none; color:#94a3b8; font-size:1.25rem; cursor:pointer;">&times;</button>
            </div>

            <form id="form-edit-surat" method="POST">
                @csrf
                @method('PUT')
                <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label>Jenis Surat *</label>
                        <select name="jenis" id="edit-jenis" class="form-control" required>
                            <option value="masuk">Surat Masuk</option>
                            <option value="keluar">Surat Keluar</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Nomor Surat *</label>
                        <input type="text" name="nomor_surat" id="edit-nomor" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Perihal Surat *</label>
                    <input type="text" name="perihal" id="edit-perihal" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Asal / Tujuan Instansi *</label>
                    <input type="text" name="asal_tujuan" id="edit-asal-tujuan" class="form-control" required>
                </div>

                <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label>Tanggal Tertulis di Surat *</label>
                        <input type="date" name="tanggal_surat" id="edit-tanggal-surat" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Diterima / Dikirim</label>
                        <input type="date" name="tanggal_terima_kirim" id="edit-tanggal-terima" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label>Keterangan</label>
                    <textarea name="keterangan" id="edit-keterangan-surat" class="form-control" rows="2"></textarea>
                </div>

                <div style="display:flex; justify-content:flex-end; gap:0.75rem; margin-top:1.5rem;">
                    <button type="button" onclick="document.getElementById('modal-edit-surat').style.display='none'" class="btn btn-secondary">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    function editSurat(s) {
        document.getElementById('form-edit-surat').action = '/surat/' + s.id;
        document.getElementById('edit-jenis').value = s.jenis;
        document.getElementById('edit-nomor').value = s.nomor_surat;
        document.getElementById('edit-perihal').value = s.perihal;
        document.getElementById('edit-asal-tujuan').value = s.asal_tujuan;
        document.getElementById('edit-tanggal-surat').value = s.tanggal_surat ? s.tanggal_surat.substring(0,10) : '';
        document.getElementById('edit-tanggal-terima').value = s.tanggal_terima_kirim ? s.tanggal_terima_kirim.substring(0,10) : '';
        document.getElementById('edit-keterangan-surat').value = s.keterangan || '';
        document.getElementById('modal-edit-surat').style.display = 'flex';
    }
    </script>
</x-app-layout>
