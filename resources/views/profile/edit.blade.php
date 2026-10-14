<x-app-layout>
    <x-slot name="title">Pengaturan Akun & Profil Saya</x-slot>

    <div style="max-width: 720px; margin: 0 auto; display: flex; flex-direction: column; gap: 1.5rem;">

        {{-- HEADER --}}
        <div style="margin-bottom: 0.5rem;">
            <h1 style="font-size: 1.4rem; font-weight: 700; color: #f1f5f9; margin-bottom: 0.25rem;">⚙️ Pengaturan Profil</h1>
            <p style="font-size: 0.85rem; color: #94a3b8;">Perbarui nama, NIS, kelas, foto profil, dan kata sandi akun Anda.</p>
        </div>

        {{-- ======================= PROFIL INFO ======================= --}}
        <div class="card">
            <div class="card-header" style="margin-bottom: 1.25rem;">
                <h2 class="card-title" style="display: flex; align-items: center; gap: 0.5rem;">
                    <svg width="18" height="18" fill="none" stroke="#60a5fa" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Informasi Profil
                </h2>
            </div>

            <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('patch')

                {{-- FOTO PROFIL PREVIEW --}}
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label style="font-size: 0.8rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.75rem; display: block;">Foto Profil (JPG / PNG, Maks 3MB)</label>
                    <div style="display: flex; align-items: center; gap: 1.25rem;">
                        <img id="foto-preview" src="{{ $user->fotoUrl() }}" alt="{{ $user->name }}"
                            style="width: 72px; height: 72px; border-radius: 50%; object-fit: cover; border: 2px solid #3b82f6; flex-shrink: 0;">
                        <div style="flex: 1;">
                            <label for="foto" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; background: #1d4ed8; color: white; border-radius: 8px; font-size: 0.8rem; font-weight: 600; cursor: pointer; border: none; transition: background 0.2s;">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                Pilih Foto Baru
                            </label>
                            <input id="foto" name="foto" type="file" accept=".jpg,.jpeg,.png,image/jpeg,image/png,image/jpg"
                                style="display: none;"
                                onchange="previewFoto(this)">
                            <p style="font-size: 0.72rem; color: #64748b; margin-top: 0.4rem;">Format: JPG atau PNG. Ukuran maks 3 MB.</p>
                            <p id="foto-nama" style="font-size: 0.75rem; color: #94a3b8; margin-top: 0.2rem;"></p>
                        </div>
                    </div>
                    @error('foto') <span class="form-error" style="display: block; margin-top: 0.5rem;">{{ $message }}</span> @enderror
                </div>

                {{-- NAMA --}}
                <div class="form-group">
                    <label for="name" style="font-size: 0.8rem; font-weight: 600; color: #cbd5e1;">Nama Lengkap *</label>
                    <input id="name" name="name" type="text" class="form-control"
                        value="{{ old('name', $user->name) }}" required autofocus
                        placeholder="Nama lengkap Anda">
                    @error('name') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                {{-- NIS & KELAS --}}
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label for="nis" style="font-size: 0.8rem; font-weight: 600; color: #cbd5e1;">NIS (Nomor Induk Siswa)</label>
                        <input id="nis" name="nis" type="text" class="form-control"
                            value="{{ old('nis', $user->nis) }}" placeholder="Contoh: 11001">
                        @error('nis') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="kelas" style="font-size: 0.8rem; font-weight: 600; color: #cbd5e1;">Kelas</label>
                        <input id="kelas" name="kelas" type="text" class="form-control"
                            value="{{ old('kelas', $user->kelas) }}" placeholder="Contoh: XII PPLG 1">
                        @error('kelas') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- EMAIL --}}
                <div class="form-group">
                    <label for="email" style="font-size: 0.8rem; font-weight: 600; color: #cbd5e1;">Alamat Email *</label>
                    <input id="email" name="email" type="email" class="form-control"
                        value="{{ old('email', $user->email) }}" required autocomplete="username"
                        placeholder="email@sekolah.sch.id">
                    @error('email') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div style="display: flex; align-items: center; gap: 1rem; margin-top: 1.5rem;">
                    <button type="submit" class="btn btn-primary">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Profil
                    </button>
                    @if(session('status') === 'profile-updated')
                    <span style="font-size: 0.8rem; color: #34d399; display: flex; align-items: center; gap: 0.35rem;">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Profil berhasil diperbarui!
                    </span>
                    @endif
                </div>
            </form>
        </div>

        {{-- ======================= UBAH PASSWORD ======================= --}}
        <div class="card">
            <div class="card-header" style="margin-bottom: 1.25rem;">
                <h2 class="card-title" style="display: flex; align-items: center; gap: 0.5rem;">
                    <svg width="18" height="18" fill="none" stroke="#fbbf24" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                    Ubah Kata Sandi
                </h2>
            </div>
            <p style="font-size: 0.82rem; color: #94a3b8; margin-bottom: 1.25rem;">Gunakan kata sandi yang panjang dan acak agar akun Anda tetap aman.</p>

            <form method="post" action="{{ route('password.update') }}">
                @csrf
                @method('put')

                <div class="form-group">
                    <label for="update_password_current_password" style="font-size: 0.8rem; font-weight: 600; color: #cbd5e1;">Kata Sandi Saat Ini</label>
                    <input id="update_password_current_password" name="current_password" type="password" class="form-control" autocomplete="current-password" placeholder="••••••••">
                    @if($errors->updatePassword->get('current_password'))
                        <span class="form-error">{{ $errors->updatePassword->get('current_password')[0] }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="update_password_password" style="font-size: 0.8rem; font-weight: 600; color: #cbd5e1;">Kata Sandi Baru</label>
                    <input id="update_password_password" name="password" type="password" class="form-control" autocomplete="new-password" placeholder="Minimal 8 karakter">
                    @if($errors->updatePassword->get('password'))
                        <span class="form-error">{{ $errors->updatePassword->get('password')[0] }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="update_password_password_confirmation" style="font-size: 0.8rem; font-weight: 600; color: #cbd5e1;">Konfirmasi Kata Sandi Baru</label>
                    <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password" placeholder="Ulangi kata sandi baru">
                    @if($errors->updatePassword->get('password_confirmation'))
                        <span class="form-error">{{ $errors->updatePassword->get('password_confirmation')[0] }}</span>
                    @endif
                </div>

                <div style="display: flex; align-items: center; gap: 1rem; margin-top: 1.5rem;">
                    <button type="submit" class="btn btn-warning">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                        Perbarui Kata Sandi
                    </button>
                    @if(session('status') === 'password-updated')
                    <span style="font-size: 0.8rem; color: #34d399; display: flex; align-items: center; gap: 0.35rem;">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Kata sandi berhasil diperbarui!
                    </span>
                    @endif
                </div>
            </form>
        </div>

        {{-- ======================= HAPUS AKUN ======================= --}}
        <div class="card" style="border-color: rgba(239,68,68,0.3);">
            <div class="card-header" style="margin-bottom: 1.25rem;">
                <h2 class="card-title" style="display: flex; align-items: center; gap: 0.5rem; color: #f87171;">
                    <svg width="18" height="18" fill="none" stroke="#f87171" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Hapus Akun
                </h2>
            </div>
            <p style="font-size: 0.82rem; color: #94a3b8; margin-bottom: 1.25rem;">Setelah akun dihapus, semua data dan informasi terkait akan dihapus secara permanen. Pastikan Anda sudah menyimpan semua data yang diperlukan sebelum menghapus akun.</p>

            <button type="button" onclick="document.getElementById('modal-hapus-akun').style.display='flex'" class="btn btn-danger">
                Hapus Akun Saya
            </button>
        </div>
    </div>

    {{-- MODAL KONFIRMASI HAPUS AKUN --}}
    <div id="modal-hapus-akun" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.75); z-index:99; align-items:center; justify-content:center; padding:1rem;">
        <div style="background:#1e293b; border:1px solid rgba(239,68,68,0.4); border-radius:14px; max-width:480px; width:100%; padding:1.75rem;">
            <h3 style="font-size:1.1rem; font-weight:700; color:#f87171; margin-bottom:0.75rem;">⚠️ Hapus Akun Secara Permanen?</h3>
            <p style="font-size:0.85rem; color:#94a3b8; margin-bottom:1.25rem;">Setelah akun dihapus, semua data Anda akan hilang selamanya. Masukkan kata sandi untuk mengkonfirmasi.</p>
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')
                <div class="form-group">
                    <label style="font-size: 0.8rem; font-weight: 600; color: #cbd5e1;">Kata Sandi Anda</label>
                    <input id="password-hapus" name="password" type="password" class="form-control" placeholder="Masukkan kata sandi untuk konfirmasi">
                    @if($errors->userDeletion->get('password'))
                        <span class="form-error">{{ $errors->userDeletion->get('password')[0] }}</span>
                    @endif
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 0.75rem; margin-top: 1.25rem;">
                    <button type="button" onclick="document.getElementById('modal-hapus-akun').style.display='none'" class="btn btn-secondary">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Hapus Akun</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Auto show modal if there were userDeletion errors --}}
    @if($errors->userDeletion->isNotEmpty())
    <script>document.getElementById('modal-hapus-akun').style.display = 'flex';</script>
    @endif

    <script>
    function previewFoto(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            // Validate type
            const allowed = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!allowed.includes(file.type)) {
                alert('Hanya file JPG dan PNG yang diperbolehkan.');
                input.value = '';
                return;
            }
            // Validate size (3MB)
            if (file.size > 3 * 1024 * 1024) {
                alert('Ukuran file maksimal adalah 3 MB.');
                input.value = '';
                return;
            }
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('foto-preview').src = e.target.result;
            };
            reader.readAsDataURL(file);
            document.getElementById('foto-nama').textContent = '📎 ' + file.name + ' (' + (file.size / 1024).toFixed(0) + ' KB)';
        }
    }
    </script>
</x-app-layout>
