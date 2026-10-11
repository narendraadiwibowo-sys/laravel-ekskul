<x-app-layout>
    <x-slot name="title">Tambah Pengurus</x-slot>

    <div class="card" style="max-width: 700px; margin: 0 auto;">
        <div class="card-header">
            <h2 class="card-title">+ Tambah Anggota Pengurus Baru</h2>
            <a href="{{ route('struktur.manage') }}" class="btn btn-secondary btn-sm">&larr; Kembali</a>
        </div>

        <form action="{{ route('struktur.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Nama Lengkap *</label>
                <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required placeholder="Contoh: Ravanelli Putra Maulana">
                @error('nama') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label>Divisi *</label>
                    <select name="divisi" class="form-control" required>
                        <option value="">-- Pilih Divisi --</option>
                        <option value="Inti" {{ old('divisi') == 'Inti' ? 'selected' : '' }}>Inti (Ketua / Wakil)</option>
                        <option value="Sekretaris" {{ old('divisi') == 'Sekretaris' ? 'selected' : '' }}>Sekretaris</option>
                        <option value="Bendahara" {{ old('divisi') == 'Bendahara' ? 'selected' : '' }}>Bendahara</option>
                        <option value="Humas" {{ old('divisi') == 'Humas' ? 'selected' : '' }}>Humas</option>
                        <option value="Acara" {{ old('divisi') == 'Acara' ? 'selected' : '' }}>Acara</option>
                        <option value="PDD" {{ old('divisi') == 'PDD' ? 'selected' : '' }}>PDD</option>
                        <option value="Perkap" {{ old('divisi') == 'Perkap' ? 'selected' : '' }}>Perkap</option>
                    </select>
                    @error('divisi') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Jabatan *</label>
                    <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan') }}" required placeholder="Contoh: Koordinator Humas / Anggota">
                    @error('jabatan') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label>Kelas</label>
                    <input type="text" name="kelas" class="form-control" value="{{ old('kelas') }}" placeholder="Contoh: XII AKL 1">
                    @error('kelas') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Username Instagram</label>
                    <input type="text" name="instagram" class="form-control" value="{{ old('instagram') }}" placeholder="Contoh: @ravv_putm">
                    @error('instagram') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label>Urutan Tampil (Angka)</label>
                    <input type="number" name="urutan" class="form-control" value="{{ old('urutan', 0) }}" placeholder="1, 2, 3..">
                </div>

                <div class="form-group">
                    <label>Periode</label>
                    <input type="text" name="periode" class="form-control" value="{{ old('periode', '2026/2027') }}">
                </div>
            </div>

            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; color: #fbbf24;">
                    <input type="checkbox" name="is_koordinator" value="1" {{ old('is_koordinator') ? 'checked' : '' }}>
                    Tandai sebagai Koordinator Divisi (Highlight Koor)
                </label>
            </div>

            <div class="form-group">
                <label>Foto Formal (JPG/PNG)</label>
                <input type="file" name="foto" class="form-control" accept="image/*">
                <p style="font-size: 0.75rem; color: #94a3b8; margin-top: 0.25rem;">Rekomendasi rasio portrait atau 3:4.</p>
                @error('foto') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div style="display: flex; gap: 0.75rem; justify-content: flex-end; margin-top: 1.5rem;">
                <a href="{{ route('struktur.manage') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Pengurus</button>
            </div>
        </form>
    </div>
</x-app-layout>
