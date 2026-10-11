<x-app-layout>
    <x-slot name="title">Database Anggota & Manajemen Akun</x-slot>

    {{-- STATS GRID USERS --}}
    <div class="stats-grid">
        <div class="stat-card blue">
            <span class="stat-label">Total Anggota & Akun</span>
            <span class="stat-value">{{ $totalAnggota }}</span>
            <span class="stat-sub">Terdaftar di sistem SEC</span>
        </div>
        <div class="stat-card purple">
            <span class="stat-label">Peran Sistem (RBAC)</span>
            <span class="stat-value">{{ $roles->count() }}</span>
            <span class="stat-sub">Role dengan hak akses khusus</span>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div>
                <h2 class="card-title">Database Anggota & Manajemen Role (RBAC)</h2>
                <p style="font-size: 0.8rem; color: #94a3b8; margin-top: 0.25rem;">
                    Kelola data anggota, atur penugasan divisi (PDD, Humas, dll), dan reset password
                </p>
            </div>
            <button onclick="document.getElementById('modal-tambah-user').style.display='flex'" class="btn btn-primary btn-sm">
                + Tambah Akun / Anggota Baru
            </button>
        </div>

        {{-- FILTER & SEARCH --}}
        <form method="GET" action="{{ route('users.index') }}" style="display: flex; gap: 0.75rem; flex-wrap: wrap; margin-bottom: 1.25rem;">
            <input type="text" name="search" class="form-control" placeholder="Cari nama, email, kelas, NIS..." value="{{ request('search') }}" style="max-width: 320px;">
            <select name="role" class="form-control" style="max-width: 180px;">
                <option value="">-- Semua Role --</option>
                @foreach($roles as $r)
                <option value="{{ $r->name }}" {{ request('role') == $r->name ? 'selected' : '' }}>{{ ucfirst($r->name) }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-secondary btn-sm">Filter</button>
            @if(request()->anyFilled(['search', 'role']))
            <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">Reset</a>
            @endif
        </form>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Nama Anggota</th>
                        <th>NIS</th>
                        <th>Kelas</th>
                        <th>Email Login</th>
                        <th>Role / Divisi</th>
                        <th>Status Akun</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $u)
                    <tr>
                        <td>
                            <strong style="color: #f1f5f9;">{{ $u->name }}</strong>
                            @if($u->id === auth()->id())
                            <span class="badge" style="background: rgba(59,130,246,0.15); color: #60a5fa; margin-left: 0.3rem;">(Anda)</span>
                            @endif
                        </td>
                        <td>{{ $u->nis ?: '-' }}</td>
                        <td><span style="color: #60a5fa; font-weight: 500;">{{ $u->kelas ?: '-' }}</span></td>
                        <td><code style="font-size: 0.8rem; color: #94a3b8;">{{ $u->email }}</code></td>
                        <td>
                            @php
                                $roleName = $u->getRoleNames()->first() ?? 'anggota';
                                $roleColor = match($roleName) {
                                    'admin', 'ketua' => 'background: rgba(220, 38, 38, 0.2); color: #f87171;',
                                    'sekretaris' => 'background: rgba(16, 185, 129, 0.2); color: #34d399;',
                                    'bendahara' => 'background: rgba(245, 158, 11, 0.2); color: #fbbf24;',
                                    'humas' => 'background: rgba(236, 72, 153, 0.2); color: #f472b6;',
                                    'acara' => 'background: rgba(59, 130, 246, 0.2); color: #60a5fa;',
                                    'pdd' => 'background: rgba(139, 92, 246, 0.2); color: #a78bfa;',
                                    'perkap' => 'background: rgba(20, 184, 166, 0.2); color: #2dd4bf;',
                                    default => 'background: rgba(148, 163, 184, 0.2); color: #cbd5e1;'
                                };
                            @endphp
                            <span class="badge" style="{{ $roleColor }}">
                                {{ strtoupper($roleName) }}
                            </span>
                        </td>
                        <td>
                            @if($u->is_active ?? true)
                            <span class="badge badge-lunas">✅ Aktif</span>
                            @else
                            <span class="badge badge-belum">⛔ Nonaktif</span>
                            @endif
                        </td>
                        <td style="text-align: right;">
                            <div style="display: inline-flex; gap: 0.4rem; align-items: center;">
                                @if($u->id !== auth()->id())
                                <form action="{{ route('users.toggle-status', $u) }}" method="POST" style="margin:0;">
                                    @csrf
                                    <button type="submit" class="btn btn-secondary btn-sm" style="font-size: 0.72rem; padding: 0.25rem 0.5rem;" title="{{ ($u->is_active ?? true) ? 'Nonaktifkan Akun' : 'Approve / Aktifkan Akun' }}">
                                        {{ ($u->is_active ?? true) ? 'Nonaktifkan' : 'Approve / Aktifkan' }}
                                    </button>
                                </form>
                                @endif
                                <button onclick="editUser({{ json_encode($u) }}, '{{ $roleName }}')" class="btn btn-warning btn-sm">Edit / Role</button>
                                @if($u->id !== auth()->id())
                                <form action="{{ route('users.destroy', $u) }}" method="POST" onsubmit="return confirm('Hapus akun anggota ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: #94a3b8; padding: 2.5rem;">
                            Tidak ditemukan anggota.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 1rem;">
            {{ $users->links() }}
        </div>
    </div>

    {{-- MODAL TAMBAH USER --}}
    <div id="modal-tambah-user" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.7); z-index:99; align-items:center; justify-content:center; padding: 1rem;">
        <div style="background:#1e293b; border:1px solid #334155; border-radius:14px; max-width:550px; width:100%; padding:1.5rem; max-height:90vh; overflow-y:auto;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.25rem;">
                <h3 style="font-size:1.1rem; font-weight:700; color:#f1f5f9;">+ Daftarkan Anggota / Akun Baru</h3>
                <button onclick="document.getElementById('modal-tambah-user').style.display='none'" style="background:none; border:none; color:#94a3b8; font-size:1.25rem; cursor:pointer;">&times;</button>
            </div>

            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Nama Lengkap *</label>
                    <input type="text" name="name" class="form-control" required placeholder="Contoh: Ravanelli Putra Maulana">
                </div>

                <div class="form-group">
                    <label>Email Login *</label>
                    <input type="email" name="email" class="form-control" required placeholder="nama@email.com">
                </div>

                <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label>NIS (Nomor Induk Siswa)</label>
                        <input type="text" name="nis" class="form-control" placeholder="Contoh: 12345">
                    </div>
                    <div class="form-group">
                        <label>Kelas</label>
                        <input type="text" name="kelas" class="form-control" placeholder="Contoh: XII AKL 1">
                    </div>
                </div>

                <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label>Role / Divisi Akses *</label>
                        <select name="role" class="form-control" required>
                            @foreach($roles as $r)
                            <option value="{{ $r->name }}">{{ strtoupper($r->name) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Password Akun *</label>
                        <input type="password" name="password" class="form-control" required placeholder="Minimal 6 karakter" value="password">
                    </div>
                </div>

                <div style="display:flex; justify-content:flex-end; gap:0.75rem; margin-top:1.5rem;">
                    <button type="button" onclick="document.getElementById('modal-tambah-user').style.display='none'" class="btn btn-secondary">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Akun</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL EDIT USER --}}
    <div id="modal-edit-user" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.7); z-index:99; align-items:center; justify-content:center; padding: 1rem;">
        <div style="background:#1e293b; border:1px solid #334155; border-radius:14px; max-width:550px; width:100%; padding:1.5rem;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.25rem;">
                <h3 style="font-size:1.1rem; font-weight:700; color:#f1f5f9;">Update Data Anggota & Role</h3>
                <button onclick="document.getElementById('modal-edit-user').style.display='none'" style="background:none; border:none; color:#94a3b8; font-size:1.25rem; cursor:pointer;">&times;</button>
            </div>

            <form id="form-edit-user" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Nama Lengkap *</label>
                    <input type="text" name="name" id="edit-user-name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Email Login *</label>
                    <input type="email" name="email" id="edit-user-email" class="form-control" required>
                </div>

                <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label>NIS</label>
                        <input type="text" name="nis" id="edit-user-nis" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Kelas</label>
                        <input type="text" name="kelas" id="edit-user-kelas" class="form-control">
                    </div>
                </div>

                <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label>Role / Divisi Akses *</label>
                        <select name="role" id="edit-user-role" class="form-control" required>
                            @foreach($roles as $r)
                            <option value="{{ $r->name }}">{{ strtoupper($r->name) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Reset Password (Opsional)</label>
                        <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ganti">
                    </div>
                </div>

                <div style="display:flex; justify-content:flex-end; gap:0.75rem; margin-top:1.5rem;">
                    <button type="button" onclick="document.getElementById('modal-edit-user').style.display='none'" class="btn btn-secondary">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    function editUser(u, currentRole) {
        document.getElementById('form-edit-user').action = '/users/' + u.id;
        document.getElementById('edit-user-name').value = u.name;
        document.getElementById('edit-user-email').value = u.email;
        document.getElementById('edit-user-nis').value = u.nis || '';
        document.getElementById('edit-user-kelas').value = u.kelas || '';
        document.getElementById('edit-user-role').value = currentRole;
        document.getElementById('modal-edit-user').style.display = 'flex';
    }
    </script>
</x-app-layout>
