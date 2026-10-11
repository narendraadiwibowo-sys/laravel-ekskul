<x-layouts.app title="Notulensi">
    <div class="card">
        <div class="card-header">
            <span class="card-title">📋 Notulensi Rapat</span>
            @can("notulensi.create")
            <a href="{{ route("notulensi.create") }}" class="btn btn-primary btn-sm">+ Tulis Notulensi</a>
            @endcan
        </div>
        <div style="display:flex;flex-direction:column;gap:0.75rem;">
            @forelse($notulensis as $n)
            <div style="display:flex;flex-direction:column;gap:0.5rem;padding:1rem 1.25rem;background:rgba(255,255,255,0.04);border-radius:10px;border-left:3px solid #3b82f6;">
                <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;">
                    <div>
                        <a href="{{ route("notulensi.show", $n) }}" style="font-weight:600;color:#f1f5f9;text-decoration:none;font-size:0.95rem;">{{ $n->judul }}</a>
                        <div style="font-size:0.75rem;color:var(--text-muted);margin-top:0.25rem;">
                            ✍️ {{ $n->penulis?->name ?? "—" }} &nbsp;·&nbsp; 📅 {{ $n->created_at->format("d M Y H:i") }}
                            @if($n->jadwal) &nbsp;·&nbsp; 🗓️ {{ $n->jadwal->judul }} @endif
                        </div>
                    </div>
                    <div style="display:flex;gap:0.4rem;flex-shrink:0;">
                        <a href="{{ route("notulensi.show", $n) }}" class="btn btn-secondary btn-sm">Baca</a>
                        @can("notulensi.update")
                        <a href="{{ route("notulensi.edit", $n) }}" class="btn btn-warning btn-sm">Edit</a>
                        @endcan
                        @can("notulensi.delete")
                        <form action="{{ route("notulensi.destroy", $n) }}" method="POST" onsubmit="return confirm('Hapus notulensi ini?')" style="margin:0;">
                            @csrf @method("DELETE")
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                        @endcan
                    </div>
                </div>
                <p style="font-size:0.8rem;color:#94a3b8;margin:0;">{{ Str::limit(strip_tags($n->isi), 120) }}</p>
            </div>
            @empty
            <div style="text-align:center;padding:2rem;color:var(--text-muted);">Belum ada notulensi tersimpan.</div>
            @endforelse
        </div>
        <div style="margin-top:1rem;">{{ $notulensis->links() }}</div>
    </div>
</x-layouts.app>