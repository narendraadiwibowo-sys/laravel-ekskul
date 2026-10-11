<x-layouts.app title="Tulis Notulensi">
    <div class="card" style="max-width:720px;">
        <div class="card-header">
            <span class="card-title">+ Tulis Notulensi</span>
            <a href="{{ route("notulensi.index") }}" class="btn btn-secondary btn-sm">← Kembali</a>
        </div>
        <form action="{{ route("notulensi.store") }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Judul Notulensi *</label>
                <input type="text" name="judul" class="form-control" value="{{ old("judul") }}" required placeholder="Contoh: Notulensi Rapat Bulanan September 2026">
                @error("judul")<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Terkait Jadwal (opsional)</label>
                <select name="jadwal_kegiatan_id" class="form-control">
                    <option value="">— Tidak terkait jadwal tertentu —</option>
                    @foreach($jadwals as $j)
                    <option value="{{ $j->id }}" {{ old("jadwal_kegiatan_id") == $j->id ? "selected" : "" }}>
                        {{ $j->tanggal->format("d M Y") }} — {{ $j->judul }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Isi Notulensi *</label>
                <textarea name="isi" class="form-control" rows="12" required placeholder="Tulis rangkuman rapat, keputusan, agenda berikutnya, dll.">{{ old("isi") }}</textarea>
                @error("isi")<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-primary">💾 Simpan Notulensi</button>
        </form>
    </div>
</x-layouts.app>