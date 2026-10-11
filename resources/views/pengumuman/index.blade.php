<x-app-layout>
    <x-slot name="title">Papan Pengumuman & Broadcast Humas</x-slot>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.5rem; align-items: start;">
        
        {{-- KOLOM KIRI: FORM BROADCAST (HUMAS / ADMIN) --}}
        @can('pengumuman.create')
        <div class="card">
            <div class="card-header">
                <h2 class="card-title" style="display: flex; align-items: center; gap: 0.5rem;">
                    <svg width="20" height="20" fill="none" stroke="#ec4899" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                    Broadcast Pengumuman Baru
                </h2>
            </div>

            <form action="{{ route('pengumuman.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Judul Pengumuman *</label>
                    <input type="text" name="judul" class="form-control" placeholder="Contoh: Kumpul Rutin Hari Jumat, Latihan Drama" required value="{{ old('judul') }}">
                    @error('judul') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Isi Pesan / Instruksi *</label>
                    <textarea name="isi" class="form-control" rows="5" placeholder="Tuliskan detail pengumuman, tempat berkumpul, dress code, dll..." required>{{ old('isi') }}</textarea>
                    @error('isi') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Berlaku Sampai (Opsional)</label>
                    <input type="date" name="berlaku_sampai" class="form-control" value="{{ old('berlaku_sampai') }}">
                </div>

                <div class="form-group">
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; color: #f87171;">
                        <input type="checkbox" name="penting" value="1" {{ old('penting') ? 'checked' : '' }}>
                        Tandai sebagai <strong>URGENT / PENTING</strong> (akan di-highlight merah di dashboard)
                    </label>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; background: #ec4899;">
                    Sebarkan Pengumuman (Broadcast)
                </button>
            </form>
        </div>
        @endcan

        {{-- KOLOM KANAN: DAFTAR PENGUMUMAN AKTIF --}}
        <div class="card" style="{{ !auth()->user()->can('pengumuman.create') ? 'grid-column: 1 / -1;' : '' }}">
            <div class="card-header">
                <div>
                    <h2 class="card-title">Papan Informasi Terkini (Notice Board)</h2>
                    <p style="font-size: 0.8rem; color: #94a3b8; margin-top: 0.25rem;">
                        Pengumuman resmi dari Divisi Humas & Pengurus SEC
                    </p>
                </div>
                <span class="badge" style="background: rgba(236,72,153,0.15); color: #f472b6;">{{ $pengumumans->total() }} Pesan</span>
            </div>

            @forelse($pengumumans as $p)
            <div style="background: {{ $p->penting ? 'rgba(239, 68, 68, 0.08)' : 'rgba(255, 255, 255, 0.03)' }}; border: 1px solid {{ $p->penting ? 'rgba(239, 68, 68, 0.3)' : 'rgba(255, 255, 255, 0.08)' }}; border-radius: 12px; padding: 1.25rem; margin-bottom: 1rem;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem;">
                    <div>
                        @if($p->penting)
                        <span class="badge" style="background: #dc2626; color: white; margin-bottom: 0.4rem;">PENTING / URGENT</span>
                        @endif
                        <h3 style="font-size: 1.05rem; font-weight: 700; color: #f1f5f9; margin-bottom: 0.35rem;">
                            {{ $p->judul }}
                        </h3>
                        <div style="font-size: 0.75rem; color: #94a3b8; display: flex; gap: 1rem;">
                            <span>Oleh: <strong style="color: #cbd5e1;">{{ $p->pembuat->name ?? 'Pengurus' }}</strong></span>
                            <span>{{ $p->created_at->diffForHumans() }}</span>
                            @if($p->berlaku_sampai)
                            <span>Batas: {{ \Carbon\Carbon::parse($p->berlaku_sampai)->format('d M Y') }}</span>
                            @endif
                        </div>
                    </div>

                    @can('pengumuman.delete')
                    <form action="{{ route('pengumuman.destroy', $p) }}" method="POST" onsubmit="return confirm('Hapus pengumuman ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus Pengumuman">
                            Hapus
                        </button>
                    </form>
                    @endcan
                </div>

                <div style="margin-top: 0.75rem; font-size: 0.9rem; color: #e2e8f0; line-height: 1.6; white-space: pre-line;">
                    {{ $p->isi }}
                </div>
            </div>
            @empty
            <div style="text-align: center; padding: 3rem 1rem; color: #94a3b8;">
                <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin: 0 auto 1rem; opacity: 0.4;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                <p>Belum ada pengumuman yang aktif saat ini.</p>
            </div>
            @endforelse

            <div style="margin-top: 1rem;">
                {{ $pengumumans->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
