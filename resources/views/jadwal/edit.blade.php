<x-layouts.app title="Edit Jadwal">
    <div class="card" style="max-width:640px;">
        <div class="card-header">
            <span class="card-title">✏️ Edit Jadwal Kegiatan</span>
            <a href="{{ route("jadwal.index") }}" class="btn btn-secondary btn-sm">← Kembali</a>
        </div>
        <form action="{{ route("jadwal.update", $jadwal) }}" method="POST">
            @csrf @method("PUT")
            <div class="form-group">
                <label>Judul Kegiatan *</label>
                <input type="text" name="judul" class="form-control" value="{{ old("judul", $jadwal->judul) }}" required>
                @error("judul")<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control">{{ old("deskripsi", $jadwal->deskripsi) }}</textarea>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="form-group">
                    <label>Tanggal *</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ old("tanggal", $jadwal->tanggal->format("Y-m-d")) }}" required>
                </div>
                <div class="form-group">
                    <label>Status *</label>
                    <select name="status" class="form-control">
                        <option value="upcoming" {{ old("status",$jadwal->status)=="upcoming"?"selected":"" }}>Upcoming</option>
                        <option value="ongoing" {{ old("status",$jadwal->status)=="ongoing"?"selected":"" }}>Ongoing</option>
                        <option value="completed" {{ old("status",$jadwal->status)=="completed"?"selected":"" }}>Completed</option>
                    </select>
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:1rem;">
                <div class="form-group">
                    <label>Lokasi</label>
                    <input type="text" name="lokasi" class="form-control" value="{{ old("lokasi",$jadwal->lokasi) }}">
                </div>
                <div class="form-group">
                    <label>Waktu Mulai *</label>
                    <input type="time" name="waktu_mulai" class="form-control" value="{{ old("waktu_mulai", substr($jadwal->waktu_mulai,0,5)) }}" required>
                </div>
                <div class="form-group">
                    <label>Waktu Selesai</label>
                    <input type="time" name="waktu_selesai" class="form-control" value="{{ old("waktu_selesai", $jadwal->waktu_selesai ? substr($jadwal->waktu_selesai,0,5) : "") }}">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">💾 Update Jadwal</button>
        </form>
    </div>
</x-layouts.app>