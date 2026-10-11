<x-app-layout>
    <x-slot name="title">Edit Pengurus: {{ $pengurus->nama }}</x-slot>

    <div class="card" style="max-width: 700px; margin: 0 auto;">
        <div class="card-header">
            <h2 class="card-title">Edit Data Pengurus</h2>
            <a href="{{ route('struktur.manage') }}" class="btn btn-secondary btn-sm">&larr; Kembali</a>
        </div>

        <form action="{{ route('struktur.update', $pengurus) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nama Lengkap *</label>
                <input type="text" name="nama" class="form-control" value="{{ old('nama', $pengurus->nama) }}" required>
                @error('nama') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label>Divisi *</label>
                    <select name="divisi" class="form-control" required>
                        @foreach(['Inti', 'Sekretaris', 'Bendahara', 'Humas', 'Acara', 'PDD', 'Perkap'] as $div)
                        <option value="{{ $div }}" {{ old('divisi', $pengurus->divisi) == $div ? 'selected' : '' }}>
                            {{ $div }}
                        </option>
                        @endforeach
                    </select>
                    @error('divisi') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Jabatan *</label>
                    <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $pengurus->jabatan) }}" required>
                    @error('jabatan') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label>Kelas</label>
                    <input type="text" name="kelas" class="form-control" value="{{ old('kelas', $pengurus->kelas) }}">
                    @error('kelas') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Username Instagram</label>
                    <input type="text" name="instagram" class="form-control" value="{{ old('instagram', $pengurus->instagram) }}">
                    @error('instagram') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label>Urutan Tampil (Angka)</label>
                    <input type="number" name="urutan" class="form-control" value="{{ old('urutan', $pengurus->urutan) }}">
                </div>

                <div class="form-group">
                    <label>Periode</label>
                    <input type="text" name="periode" class="form-control" value="{{ old('periode', $pengurus->periode) }}">
                </div>
            </div>

            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; color: #fbbf24;">
                    <input type="checkbox" name="is_koordinator" value="1" {{ old('is_koordinator', $pengurus->is_koordinator) ? 'checked' : '' }}>
                    Tandai sebagai Koordinator Divisi (Highlight Koor)
                </label>
            </div>

            <div class="form-group">
                <label>Foto Saat Ini</label>
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem;">
                    <img src="{{ asset('images/pengurus/' . ($pengurus->foto ?: 'default.jpg')) }}" alt="{{ $pengurus->nama }}" style="width: 70px; height: 90px; object-fit: cover; border-radius: 8px;">
                    <div>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                        <span style="font-size: 0.75rem; color: #94a3b8;">Kosongkan bila tidak ingin mengubah foto.</span>
                    </div>
                </div>
                @error('foto') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div style="display: flex; gap: 0.75rem; justify-content: flex-end; margin-top: 1.5rem;">
                <a href="{{ route('struktur.manage') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</x-app-layout>
