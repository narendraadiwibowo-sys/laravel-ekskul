<x-app-layout>
    <x-slot name="title">Timeline & Program Kerja (Divisi Acara)</x-slot>

    {{-- STATS GRID PROKER --}}
    <div class="stats-grid">
        <div class="stat-card blue">
            <span class="stat-label">Total Proker</span>
            <span class="stat-value">{{ $counts['total'] }}</span>
            <span class="stat-sub">Agenda kegiatan periode ini</span>
        </div>
        <div class="stat-card amber">
            <span class="stat-label">Dalam Perencanaan / Proposal</span>
            <span class="stat-value">{{ $counts['perencanaan'] + $counts['proposal'] }}</span>
            <span class="stat-sub">Tahap inisiasi konsep</span>
        </div>
        <div class="stat-card purple">
            <span class="stat-label">Persiapan & Berjalan</span>
            <span class="stat-value">{{ $counts['persiapan'] + $counts['berjalan'] }}</span>
            <span class="stat-sub">Siap eksekusi & aktif</span>
        </div>
        <div class="stat-card green">
            <span class="stat-label">Selesai Terlaksana</span>
            <span class="stat-value">{{ $counts['selesai'] }}</span>
            <span class="stat-sub">Program sukses</span>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div>
                <h2 class="card-title">Timeline Program Kerja Divisi Acara</h2>
                <p style="font-size: 0.8rem; color: #94a3b8; margin-top: 0.25rem;">
                    Pantau tahapan perencanaan, pembuatan proposal, hingga eksekusi program
                </p>
            </div>
            @can('proker.create')
            <button onclick="document.getElementById('modal-tambah-proker').style.display='flex'" class="btn btn-primary btn-sm">
                + Tambah Proker Baru
            </button>
            @endcan
        </div>

        {{-- FILTER STATUS --}}
        <div style="display: flex; gap: 0.5rem; margin-bottom: 1.25rem; flex-wrap: wrap;">
            <a href="{{ route('proker.index') }}" class="btn {{ !request('status') ? 'btn-primary' : 'btn-secondary' }} btn-sm">Semua</a>
            <a href="{{ route('proker.index', ['status' => 'perencanaan']) }}" class="btn {{ request('status') == 'perencanaan' ? 'btn-primary' : 'btn-secondary' }} btn-sm">Perencanaan</a>
            <a href="{{ route('proker.index', ['status' => 'pembuatan_proposal']) }}" class="btn {{ request('status') == 'pembuatan_proposal' ? 'btn-primary' : 'btn-secondary' }} btn-sm">Proposal</a>
            <a href="{{ route('proker.index', ['status' => 'persiapan']) }}" class="btn {{ request('status') == 'persiapan' ? 'btn-primary' : 'btn-secondary' }} btn-sm">Persiapan</a>
            <a href="{{ route('proker.index', ['status' => 'sedang_berjalan']) }}" class="btn {{ request('status') == 'sedang_berjalan' ? 'btn-primary' : 'btn-secondary' }} btn-sm">Sedang Berjalan</a>
            <a href="{{ route('proker.index', ['status' => 'selesai']) }}" class="btn {{ request('status') == 'selesai' ? 'btn-primary' : 'btn-secondary' }} btn-sm">Selesai</a>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Status Progress</th>
                        <th>Program Kerja</th>
                        <th>PIC (Penanggung Jawab)</th>
                        <th>Tanggal Pelaksanaan</th>
                        <th>Prioritas</th>
                        @canany(['proker.update', 'proker.delete'])
                        <th style="text-align: right;">Aksi</th>
                        @endcanany
                    </tr>
                </thead>
                <tbody>
                    @forelse($prokers as $proker)
                    <tr>
                        <td>
                            @php
                                $badgeClass = match($proker->status) {
                                    'perencanaan' => 'background: rgba(148, 163, 184, 0.2); color: #cbd5e1;',
                                    'pembuatan_proposal' => 'background: rgba(245, 158, 11, 0.2); color: #fbbf24;',
                                    'persiapan' => 'background: rgba(59, 130, 246, 0.2); color: #60a5fa;',
                                    'sedang_berjalan' => 'background: rgba(168, 85, 247, 0.2); color: #c084fc;',
                                    'selesai' => 'background: rgba(16, 185, 129, 0.2); color: #34d399;',
                                    default => 'background: rgba(239, 68, 68, 0.2); color: #f87171;'
                                };
                                $statusLabel = match($proker->status) {
                                    'perencanaan' => 'Perencanaan',
                                    'pembuatan_proposal' => 'Pembuatan Proposal',
                                    'persiapan' => 'Persiapan / Siap Eksekusi',
                                    'sedang_berjalan' => 'Sedang Berjalan',
                                    'selesai' => 'Selesai',
                                    default => 'Dibatalkan'
                                };
                            @endphp
                            <span class="badge" style="{{ $badgeClass }}">
                                {{ $statusLabel }}
                            </span>
                        </td>
                        <td>
                            <strong style="color: #f1f5f9; display: block; font-size: 0.95rem;">{{ $proker->judul }}</strong>
                            @if($proker->deskripsi)
                            <span style="font-size: 0.78rem; color: #94a3b8;">{{ Str::limit($proker->deskripsi, 60) }}</span>
                            @endif
                        </td>
                        <td>
                            <span style="color: #60a5fa; font-weight: 500;">{{ $proker->pic ?: '-' }}</span>
                        </td>
                        <td>
                            @if($proker->tanggal_mulai)
                                <span style="font-size: 0.8rem; color: #cbd5e1;">
                                    {{ \Carbon\Carbon::parse($proker->tanggal_mulai)->format('d M Y') }}
                                    @if($proker->tanggal_selesai && $proker->tanggal_selesai != $proker->tanggal_mulai)
                                        - {{ \Carbon\Carbon::parse($proker->tanggal_selesai)->format('d M Y') }}
                                    @endif
                                </span>
                            @else
                                <span style="color: #64748b;">Belum ditentukan</span>
                            @endif
                        </td>
                        <td>
                            @if($proker->prioritas == 'tinggi')
                                <span class="badge" style="background: rgba(239, 68, 68, 0.15); color: #f87171;">Tinggi</span>
                            @elseif($proker->prioritas == 'sedang')
                                <span class="badge" style="background: rgba(245, 158, 11, 0.15); color: #fbbf24;">Sedang</span>
                            @else
                                <span class="badge" style="background: rgba(148, 163, 184, 0.15); color: #94a3b8;">Rendah</span>
                            @endif
                        </td>
                        @canany(['proker.update', 'proker.delete'])
                        <td style="text-align: right;">
                            <div style="display: inline-flex; gap: 0.4rem;">
                                @can('proker.update')
                                <button onclick="editProker({{ json_encode($proker) }})" class="btn btn-warning btn-sm">Update</button>
                                @endcan
                                @can('proker.delete')
                                <form action="{{ route('proker.destroy', $proker) }}" method="POST" onsubmit="return confirm('Hapus proker ini?')">
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
                        <td colspan="6" style="text-align: center; color: #94a3b8; padding: 2.5rem;">
                            Belum ada program kerja yang terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 1rem;">
            {{ $prokers->links() }}
        </div>
    </div>

    {{-- MODAL TAMBAH PROKER --}}
    <div id="modal-tambah-proker" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.7); z-index:99; align-items:center; justify-content:center; padding: 1rem;">
        <div style="background:#1e293b; border:1px solid #334155; border-radius:14px; max-width:600px; width:100%; padding:1.5rem; max-height:90vh; overflow-y:auto;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.25rem;">
                <h3 style="font-size:1.1rem; font-weight:700; color:#f1f5f9;">+ Tambah Program Kerja Baru</h3>
                <button onclick="document.getElementById('modal-tambah-proker').style.display='none'" style="background:none; border:none; color:#94a3b8; font-size:1.25rem; cursor:pointer;">&times;</button>
            </div>

            <form action="{{ route('proker.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Nama / Judul Kegiatan *</label>
                    <input type="text" name="judul" class="form-control" required placeholder="Contoh: English Speech Contest 2026">
                </div>

                <div class="form-group">
                    <label>Deskripsi Singkat</label>
                    <textarea name="deskripsi" class="form-control" rows="3" placeholder="Tujuan, konsep acara, target peserta..."></textarea>
                </div>

                <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label>Status Progres *</label>
                        <select name="status" class="form-control" required>
                            <option value="perencanaan">Perencanaan</option>
                            <option value="pembuatan_proposal">Pembuatan Proposal</option>
                            <option value="persiapan">Persiapan / Siap Eksekusi</option>
                            <option value="sedang_berjalan">Sedang Berjalan</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Prioritas *</label>
                        <select name="prioritas" class="form-control" required>
                            <option value="sedang">Sedang</option>
                            <option value="tinggi">Tinggi (Urgent)</option>
                            <option value="rendah">Rendah</option>
                        </select>
                    </div>
                </div>

                <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label>Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label>Penanggung Jawab (PIC)</label>
                    <input type="text" name="pic" class="form-control" placeholder="Contoh: Fellisya (Koor Acara)">
                </div>

                <div class="form-group">
                    <label>Catatan Tambahan</label>
                    <textarea name="catatan" class="form-control" rows="2" placeholder="Kendala, sponsor, catatan perlengkapan..."></textarea>
                </div>

                <div style="display:flex; justify-content:flex-end; gap:0.75rem; margin-top:1.5rem;">
                    <button type="button" onclick="document.getElementById('modal-tambah-proker').style.display='none'" class="btn btn-secondary">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Proker</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL EDIT PROKER --}}
    <div id="modal-edit-proker" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.7); z-index:99; align-items:center; justify-content:center; padding: 1rem;">
        <div style="background:#1e293b; border:1px solid #334155; border-radius:14px; max-width:600px; width:100%; padding:1.5rem; max-height:90vh; overflow-y:auto;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.25rem;">
                <h3 style="font-size:1.1rem; font-weight:700; color:#f1f5f9;">Update Progress Program Kerja</h3>
                <button onclick="document.getElementById('modal-edit-proker').style.display='none'" style="background:none; border:none; color:#94a3b8; font-size:1.25rem; cursor:pointer;">&times;</button>
            </div>

            <form id="form-edit-proker" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Nama / Judul Kegiatan *</label>
                    <input type="text" name="judul" id="edit-judul" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Deskripsi Singkat</label>
                    <textarea name="deskripsi" id="edit-deskripsi" class="form-control" rows="3"></textarea>
                </div>

                <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label>Status Progres *</label>
                        <select name="status" id="edit-status" class="form-control" required>
                            <option value="perencanaan">Perencanaan</option>
                            <option value="pembuatan_proposal">Pembuatan Proposal</option>
                            <option value="persiapan">Persiapan / Siap Eksekusi</option>
                            <option value="sedang_berjalan">Sedang Berjalan</option>
                            <option value="selesai">Selesai</option>
                            <option value="dibatalkan">Dibatalkan</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Prioritas *</label>
                        <select name="prioritas" id="edit-prioritas" class="form-control" required>
                            <option value="sedang">Sedang</option>
                            <option value="tinggi">Tinggi (Urgent)</option>
                            <option value="rendah">Rendah</option>
                        </select>
                    </div>
                </div>

                <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label>Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" id="edit-tanggal-mulai" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" id="edit-tanggal-selesai" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label>Penanggung Jawab (PIC)</label>
                    <input type="text" name="pic" id="edit-pic" class="form-control">
                </div>

                <div class="form-group">
                    <label>Catatan Tambahan</label>
                    <textarea name="catatan" id="edit-catatan" class="form-control" rows="2"></textarea>
                </div>

                <div style="display:flex; justify-content:flex-end; gap:0.75rem; margin-top:1.5rem;">
                    <button type="button" onclick="document.getElementById('modal-edit-proker').style.display='none'" class="btn btn-secondary">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    function editProker(proker) {
        document.getElementById('form-edit-proker').action = '/proker/' + proker.id;
        document.getElementById('edit-judul').value = proker.judul;
        document.getElementById('edit-deskripsi').value = proker.deskripsi || '';
        document.getElementById('edit-status').value = proker.status;
        document.getElementById('edit-prioritas').value = proker.prioritas;
        document.getElementById('edit-tanggal-mulai').value = proker.tanggal_mulai ? proker.tanggal_mulai.substring(0,10) : '';
        document.getElementById('edit-tanggal-selesai').value = proker.tanggal_selesai ? proker.tanggal_selesai.substring(0,10) : '';
        document.getElementById('edit-pic').value = proker.pic || '';
        document.getElementById('edit-catatan').value = proker.catatan || '';
        document.getElementById('modal-edit-proker').style.display = 'flex';
    }
    </script>
</x-app-layout>
