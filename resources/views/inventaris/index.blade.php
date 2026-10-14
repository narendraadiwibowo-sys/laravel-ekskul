<x-app-layout>
    <x-slot name="title">Inventaris & Perlengkapan (Divisi Perkap)</x-slot>

    {{-- STATS GRID PERKAP --}}
    <div class="stats-grid">
        <div class="stat-card blue">
            <span class="stat-label">Total Unit Barang</span>
            <span class="stat-value">{{ $totalBarang }}</span>
            <span class="stat-sub">Semua perlengkapan terdaftar</span>
        </div>
        <div class="stat-card green">
            <span class="stat-label">Kondisi Baik / Siap Pakai</span>
            <span class="stat-value">{{ $barangBaik }}</span>
            <span class="stat-sub">Tersedia untuk kegiatan</span>
        </div>
        <div class="stat-card red">
            <span class="stat-label">Barang Rusak / Hilang</span>
            <span class="stat-value">{{ $barangRusak }}</span>
            <span class="stat-sub">Perlu perbaikan / penggantian</span>
        </div>
        <div class="stat-card amber">
            <span class="stat-label">Sedang Dipinjam</span>
            <span class="stat-value">{{ $totalDipinjam }}</span>
            <span class="stat-sub">Dalam penggunaan anggota/eksternal</span>
        </div>
    </div>

    {{-- TABEL BARANG INVENTARIS --}}
    <div class="card" style="margin-bottom: 2rem;">
        <div class="card-header">
            <div>
                <h2 class="card-title">Daftar Inventaris Perlengkapan Ekskul</h2>
                <p style="font-size: 0.8rem; color: #94a3b8; margin-top: 0.25rem;">
                    Kelola ketersediaan alat, kondisi barang, dan kode inventaris
                </p>
            </div>
            @can('inventaris.create')
            <button onclick="document.getElementById('modal-tambah-barang').style.display='flex'" class="btn btn-primary btn-sm">
                + Tambah Barang Baru
            </button>
            @endcan
        </div>

        {{-- FILTER & SEARCH --}}
        <form method="GET" action="{{ route('inventaris.index') }}" style="display: flex; gap: 0.75rem; flex-wrap: wrap; margin-bottom: 1.25rem;">
            <input type="text" name="search" class="form-control" placeholder="Cari nama barang atau kode..." value="{{ request('search') }}" style="max-width: 280px;">
            <select name="kondisi" class="form-control" style="max-width: 180px;">
                <option value="">-- Semua Kondisi --</option>
                <option value="baik" {{ request('kondisi') == 'baik' ? 'selected' : '' }}>Baik</option>
                <option value="rusak_ringan" {{ request('kondisi') == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                <option value="rusak_berat" {{ request('kondisi') == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                <option value="hilang" {{ request('kondisi') == 'hilang' ? 'selected' : '' }}>Hilang</option>
            </select>
            <select name="kategori" class="form-control" style="max-width: 180px;">
                <option value="">-- Semua Kategori --</option>
                <option value="elektronik" {{ request('kategori') == 'elektronik' ? 'selected' : '' }}>Elektronik</option>
                <option value="properti" {{ request('kategori') == 'properti' ? 'selected' : '' }}>Properti</option>
                <option value="atk" {{ request('kategori') == 'atk' ? 'selected' : '' }}>ATK</option>
                <option value="lainnya" {{ request('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
            </select>
            <button type="submit" class="btn btn-secondary btn-sm">Filter</button>
            @if(request()->anyFilled(['search', 'kondisi', 'kategori']))
            <a href="{{ route('inventaris.index') }}" class="btn btn-secondary btn-sm">Reset</a>
            @endif
        </form>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Status Kondisi</th>
                        <th>Keterangan</th>
                        @canany(['peminjaman.catat', 'inventaris.update', 'inventaris.delete'])
                        <th style="text-align: right;">Aksi</th>
                        @endcanany
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                    <tr>
                        <td><code style="background: rgba(255,255,255,0.06); padding: 2px 6px; border-radius: 4px; font-size: 0.78rem;">{{ $item->kode ?: 'INV-'.$item->id }}</code></td>
                        <td><strong style="color: #f1f5f9;">{{ $item->nama_barang }}</strong></td>
                        <td><span style="text-transform: capitalize; color: #94a3b8; font-size: 0.8rem;">{{ $item->kategori }}</span></td>
                        <td><strong style="color: #60a5fa;">{{ $item->jumlah }} unit</strong></td>
                        <td>
                            @php
                                $badgeStyle = match($item->kondisi) {
                                    'baik' => 'background: rgba(16, 185, 129, 0.2); color: #34d399;',
                                    'rusak_ringan' => 'background: rgba(245, 158, 11, 0.2); color: #fbbf24;',
                                    'rusak_berat' => 'background: rgba(239, 68, 68, 0.2); color: #f87171;',
                                    default => 'background: rgba(148, 163, 184, 0.2); color: #94a3b8;'
                                };
                                $kondisiText = match($item->kondisi) {
                                    'baik' => 'Baik / Tersedia',
                                    'rusak_ringan' => 'Rusak Ringan',
                                    'rusak_berat' => 'Rusak Berat',
                                    default => 'Hilang'
                                };
                            @endphp
                            <span class="badge" style="{{ $badgeStyle }}">{{ $kondisiText }}</span>
                        </td>
                        <td style="font-size: 0.8rem; color: #94a3b8;">{{ $item->keterangan ?: '-' }}</td>
                        @canany(['peminjaman.catat', 'inventaris.update', 'inventaris.delete'])
                        <td style="text-align: right;">
                            <div style="display: inline-flex; gap: 0.4rem;">
                                @can('peminjaman.catat')
                                <button onclick="bukaPinjam({{ json_encode($item) }})" class="btn btn-primary btn-sm" style="background:#0284c7;">Pinjam</button>
                                @endcan
                                @can('inventaris.update')
                                <button onclick="editBarang({{ json_encode($item) }})" class="btn btn-warning btn-sm">Edit</button>
                                @endcan
                                @can('inventaris.delete')
                                <form action="{{ route('inventaris.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus barang ini?')">
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
                            Belum ada barang inventaris yang sesuai pencarian.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 1rem;">
            {{ $items->links() }}
        </div>
    </div>

    {{-- LOG RIWAYAT PEMINJAMAN (LOG SEDERHANA STATUS PINJAM) --}}
    <div class="card">
        <div class="card-header">
            <div>
                <h2 class="card-title">Log Peminjaman Barang</h2>
                <p style="font-size: 0.8rem; color: #94a3b8; margin-top: 0.25rem;">
                    Catatan peminjam, tanggal pinjam, dan status pengembalian
                </p>
            </div>
            <span class="badge" style="background: rgba(59,130,246,0.15); color: #60a5fa;">{{ $riwayatPinjam->count() }} Terkini</span>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Barang</th>
                        <th>Nama Peminjam</th>
                        <th>Jumlah</th>
                        <th>Tanggal Pinjam</th>
                        <th>Rencana Kembali</th>
                        <th>Status</th>
                        @can('peminjaman.catat')
                        <th style="text-align: right;">Aksi</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayatPinjam as $pinjam)
                    <tr>
                        <td><strong style="color: #f1f5f9;">{{ $pinjam->inventaris->nama_barang ?? '-' }}</strong></td>
                        <td>{{ $pinjam->peminjam->name ?? 'Anggota' }}</td>
                        <td>{{ $pinjam->jumlah_pinjam }} unit</td>
                        <td>{{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d M Y') }}</td>
                        <td>{{ $pinjam->tanggal_kembali_rencana ? \Carbon\Carbon::parse($pinjam->tanggal_kembali_rencana)->format('d M Y') : '-' }}</td>
                        <td>
                            @if($pinjam->status == 'dipinjam')
                                <span class="badge" style="background: rgba(245, 158, 11, 0.2); color: #fbbf24;">Sedang Dipinjam</span>
                            @else
                                <span class="badge badge-lunas">Sudah Kembali</span>
                            @endif
                        </td>
                        @can('peminjaman.catat')
                        <td style="text-align: right;">
                            @if($pinjam->status == 'dipinjam')
                            <form action="{{ route('peminjaman.kembalikan', $pinjam) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Setel Kembali</button>
                            </form>
                            @else
                            <span style="font-size: 0.75rem; color: #64748b;">Selesai ({{ \Carbon\Carbon::parse($pinjam->tanggal_kembali_aktual)->format('d/m/Y') }})</span>
                            @endif
                        </td>
                        @endcan
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: #94a3b8; padding: 2rem;">
                            Belum ada riwayat peminjaman barang.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL TAMBAH BARANG --}}
    <div id="modal-tambah-barang" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.7); z-index:99; align-items:center; justify-content:center; padding: 1rem;">
        <div style="background:#1e293b; border:1px solid #334155; border-radius:14px; max-width:550px; width:100%; padding:1.5rem; max-height:90vh; overflow-y:auto;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.25rem;">
                <h3 style="font-size:1.1rem; font-weight:700; color:#f1f5f9;">+ Tambah Inventaris Barang Baru</h3>
                <button onclick="tutupModalTambahBarang()" style="background:none; border:none; color:#94a3b8; font-size:1.25rem; cursor:pointer;">&times;</button>
            </div>

            <form id="form-tambah-barang" action="{{ route('inventaris.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Nama Barang *</label>
                    <input type="text" name="nama_barang" class="form-control" required placeholder="Contoh: Wireless Microphone Shure">
                </div>

                <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label>Kode Barang (Opsional)</label>
                        <input type="text" name="kode" class="form-control" placeholder="Contoh: SEC-MIC-01">
                    </div>
                    <div class="form-group">
                        <label>Kategori *</label>
                        <select name="kategori" class="form-control" required>
                            <option value="elektronik">Elektronik</option>
                            <option value="properti">Properti</option>
                            <option value="atk">ATK</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>
                </div>

                <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label>Jumlah Unit *</label>
                        <input type="number" name="jumlah" class="form-control" required value="1" min="1">
                    </div>
                    <div class="form-group">
                        <label>Status Kondisi *</label>
                        <select name="kondisi" class="form-control" required>
                            <option value="baik">Baik (Siap Pakai)</option>
                            <option value="rusak_ringan">Rusak Ringan</option>
                            <option value="rusak_berat">Rusak Berat</option>
                            <option value="hilang">Hilang</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Keterangan Tambahan</label>
                    <textarea name="keterangan" class="form-control" rows="2" placeholder="Letak lemari penyimpanan, kelengkapan kabel, dll..."></textarea>
                </div>

                <div style="display:flex; justify-content:flex-end; gap:0.75rem; margin-top:1.5rem;">
                    <button type="button" onclick="tutupModalTambahBarang()" class="btn btn-secondary">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Barang</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL PINJAM BARANG --}}
    <div id="modal-pinjam-barang" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.7); z-index:99; align-items:center; justify-content:center; padding: 1rem;">
        <div style="background:#1e293b; border:1px solid #334155; border-radius:14px; max-width:550px; width:100%; padding:1.5rem;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.25rem;">
                <h3 style="font-size:1.1rem; font-weight:700; color:#f1f5f9;">Pinjamkan Barang: <span id="pinjam-nama-barang" style="color:#60a5fa;"></span></h3>
                <button onclick="document.getElementById('modal-pinjam-barang').style.display='none'" style="background:none; border:none; color:#94a3b8; font-size:1.25rem; cursor:pointer;">&times;</button>
            </div>

            <form id="form-pinjam-barang" method="POST">
                @csrf
                <div class="form-group">
                    <label>Nama Anggota Peminjam *</label>
                    <select name="user_id" class="form-control" required>
                        <option value="">-- Pilih Anggota --</option>
                        @foreach($users as $u)
                        <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->kelas ?: 'Anggota' }})</option>
                        @endforeach
                    </select>
                </div>

                <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label>Jumlah Unit Dipinjam *</label>
                        <input type="number" name="jumlah_pinjam" class="form-control" required value="1" min="1" id="pinjam-max-unit">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Pinjam *</label>
                        <input type="date" name="tanggal_pinjam" class="form-control" required value="{{ date('Y-m-d') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label>Rencana Tanggal Pengembalian</label>
                    <input type="date" name="tanggal_kembali_rencana" class="form-control">
                </div>

                <div class="form-group">
                    <label>Keperluan Peminjaman</label>
                    <textarea name="keperluan" class="form-control" rows="2" placeholder="Contoh: Latihan persiapan lomba debat di aula sekolah"></textarea>
                </div>

                <div style="display:flex; justify-content:flex-end; gap:0.75rem; margin-top:1.5rem;">
                    <button type="button" onclick="tutupModalPinjam()" class="btn btn-secondary">Batal</button>
                    <button type="submit" class="btn btn-primary">Catat Peminjaman</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL EDIT BARANG --}}
    <div id="modal-edit-barang" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.7); z-index:99; align-items:center; justify-content:center; padding: 1rem;">
        <div style="background:#1e293b; border:1px solid #334155; border-radius:14px; max-width:550px; width:100%; padding:1.5rem;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.25rem;">
                <h3 style="font-size:1.1rem; font-weight:700; color:#f1f5f9;">Update Data Inventaris</h3>
                <button onclick="tutupModalEditBarang()" style="background:none; border:none; color:#94a3b8; font-size:1.25rem; cursor:pointer;">&times;</button>
            </div>

            <form id="form-edit-barang" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Nama Barang *</label>
                    <input type="text" name="nama_barang" id="edit-nama-barang" class="form-control" required>
                </div>

                <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label>Kode Barang</label>
                        <input type="text" name="kode" id="edit-kode" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Kategori *</label>
                        <select name="kategori" id="edit-kategori" class="form-control" required>
                            <option value="elektronik">Elektronik</option>
                            <option value="properti">Properti</option>
                            <option value="atk">ATK</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>
                </div>

                <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label>Jumlah Unit *</label>
                        <input type="number" name="jumlah" id="edit-jumlah" class="form-control" required min="1">
                    </div>
                    <div class="form-group">
                        <label>Status Kondisi *</label>
                        <select name="kondisi" id="edit-kondisi" class="form-control" required>
                            <option value="baik">Baik (Siap Pakai)</option>
                            <option value="rusak_ringan">Rusak Ringan</option>
                            <option value="rusak_berat">Rusak Berat</option>
                            <option value="hilang">Hilang</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Keterangan Tambahan</label>
                    <textarea name="keterangan" id="edit-keterangan" class="form-control" rows="2"></textarea>
                </div>

                <div style="display:flex; justify-content:flex-end; gap:0.75rem; margin-top:1.5rem;">
                    <button type="button" onclick="tutupModalEditBarang()" class="btn btn-secondary">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    function clearFileInputs(form) {
        if (!form) return;
        form.querySelectorAll('input[type="file"]').forEach(f => {
            try { f.value = ''; } catch(e) {}
            const newF = f.cloneNode(true);
            f.parentNode.replaceChild(newF, f);
        });
    }

    function tutupModalTambahBarang() {
        const form = document.getElementById('form-tambah-barang');
        if (form) { form.reset(); clearFileInputs(form); }
        document.getElementById('modal-tambah-barang').style.display = 'none';
    }

    function tutupModalPinjam() {
        const form = document.getElementById('form-pinjam-barang');
        if (form) { form.reset(); clearFileInputs(form); }
        document.getElementById('modal-pinjam-barang').style.display = 'none';
    }

    function tutupModalEditBarang() {
        const form = document.getElementById('form-edit-barang');
        if (form) { form.reset(); clearFileInputs(form); }
        document.getElementById('modal-edit-barang').style.display = 'none';
    }

    function bukaPinjam(item) {
        const form = document.getElementById('form-pinjam-barang');
        if (form) form.reset();
        form.action = '/inventaris/' + item.id + '/pinjam';
        document.getElementById('pinjam-nama-barang').innerText = item.nama_barang;
        document.getElementById('pinjam-max-unit').max = item.jumlah;
        document.getElementById('modal-pinjam-barang').style.display = 'flex';
    }

    function editBarang(item) {
        document.getElementById('form-edit-barang').action = '/inventaris/' + item.id;
        document.getElementById('edit-nama-barang').value = item.nama_barang;
        document.getElementById('edit-kode').value = item.kode || '';
        document.getElementById('edit-kategori').value = item.kategori;
        document.getElementById('edit-jumlah').value = item.jumlah;
        document.getElementById('edit-kondisi').value = item.kondisi;
        document.getElementById('edit-keterangan').value = item.keterangan || '';
        document.getElementById('modal-edit-barang').style.display = 'flex';
    }
    </script>
</x-app-layout>
