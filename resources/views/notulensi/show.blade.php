<x-layouts.app title="{{ $notulensi->judul }}">
    <div class="card" style="max-width:800px;">
        <div style="margin-bottom:1.25rem;">
            <a href="{{ route("notulensi.index") }}" class="btn btn-secondary btn-sm">← Kembali</a>
        </div>
        <h1 style="font-size:1.4rem;font-weight:700;color:#f1f5f9;margin-bottom:0.75rem;">{{ $notulensi->judul }}</h1>
        <div style="display:flex;gap:1rem;flex-wrap:wrap;margin-bottom:1.5rem;padding-bottom:1rem;border-bottom:1px solid var(--sidebar-border);">
            <span style="font-size:0.8rem;color:var(--text-muted);">✍️ {{ $notulensi->penulis?->name ?? "—" }}</span>
            <span style="font-size:0.8rem;color:var(--text-muted);">📅 {{ $notulensi->created_at->format("d M Y, H:i") }}</span>
            @if($notulensi->jadwal)
            <span style="font-size:0.8rem;color:var(--text-muted);">🗓️ Terkait: {{ $notulensi->jadwal->judul }}</span>
            @endif
        </div>
        <div style="font-size:0.9rem;color:#cbd5e1;line-height:1.8;white-space:pre-wrap;">{{ $notulensi->isi }}</div>
        @can("notulensi.update")
        <div style="margin-top:1.5rem;padding-top:1rem;border-top:1px solid var(--sidebar-border);display:flex;gap:0.5rem;">
            <a href="{{ route("notulensi.edit", $notulensi) }}" class="btn btn-warning btn-sm">✏️ Edit Notulensi</a>
        </div>
        @endcan
    </div>
</x-layouts.app>