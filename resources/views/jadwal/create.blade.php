<x-layouts.app title="Tambah Jadwal">
    <div class="card" style="max-width:640px;">
        <div class="card-header">
            <span class="card-title">+ Tambah Jadwal Kegiatan</span>
            <a href="{{ route("jadwal.index") }}" class="btn btn-secondary btn-sm">← Kembali</a>
        </div>
        <form action="{{ route("jadwal.store") }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Judul Kegiatan *</label>
                <input type="text" name="judul" class="form-control" value="{{ old("judul") }}" required placeholder="Contoh: Rapat Rutin Minggu Ini">
                @error("judul")<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control" placeholder="Agenda, hal yang perlu dipersiapkan, dll.">{{ old("deskripsi") }}</textarea>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="form-group">
                    <label>Tanggal *</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ old("tanggal") }}" required>
                    @error("tanggal")<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Lokasi</label>
                    <input type="text" name="lokasi" class="form-control" value="{{ old("lokasi") }}" placeholder="Aula, Kelas XII RPL 1, dll.">
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="form-group">
                    <label>Waktu Mulai *</label>
                    <input type="time" name="waktu_mulai" class="form-control" value="{{ old("waktu_mulai") }}" required>
                </div>
                <div class="form-group">
                    <label>Waktu Selesai</label>
                    <input type="time" name="waktu_selesai" class="form-control" value="{{ old("waktu_selesai") }}">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">💾 Simpan Jadwal</button>
        </form>
    </div>
</x-layouts.app>