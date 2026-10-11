<x-app-layout>
    <x-slot name="title">Kelola Struktur Pengurus</x-slot>

    <div class="card" style="margin-bottom: 1.5rem;">
        <div class="card-header">
            <div>
                <h2 class="card-title">Manajemen Struktur Organisasi (Superadmin)</h2>
                <p style="font-size: 0.8rem; color: #94a3b8; margin-top: 0.25rem;">
                    Tambah, perbarui, dan atur koordinator serta foto kepengurusan
                </p>
            </div>
            <div style="display: flex; gap: 0.5rem;">
                <a href="{{ route('struktur.index') }}" class="btn btn-secondary btn-sm">
                    Lihat Bagan Visual
                </a>
                <a href="{{ route('struktur.create') }}" class="btn btn-primary btn-sm">
                    + Tambah Pengurus
                </a>
            </div>
        </div>

        @foreach($penguruses as $divisi => $items)
        <div style="margin-bottom: 2rem;">
            <div style="display: flex; align-items: center; justify-content: space-between; background: rgba(255,255,255,0.03); padding: 0.6rem 1rem; border-radius: 8px; margin-bottom: 0.75rem;">
                <span style="font-weight: 700; color: #60a5fa; font-size: 0.95rem;">
                    DIVISI: {{ strtoupper($divisi) }}
                </span>
                <span class="badge" style="background: rgba(59,130,246,0.15); color: #60a5fa;">{{ $items->count() }} orang</span>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 60px;">Foto</th>
                            <th>Nama Lengkap</th>
                            <th>Jabatan</th>
                            <th>Kelas</th>
                            <th>Koordinator?</th>
                            <th>Instagram</th>
                            <th>Urutan</th>
                            <th style="text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $p)
                        <tr>
                            <td>
                                <img src="{{ $p->fotoUrl() }}" alt="{{ $p->nama }}" style="width: 40px; height: 40px; border-radius: 8px; object-fit: cover;" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($p->nama) }}&size=100'">
                            </td>
                            <td style="font-weight: 600; color: #f1f5f9;">{{ $p->nama }}</td>
                            <td><span class="badge badge-upcoming">{{ $p->jabatan }}</span></td>
                            <td>{{ $p->kelas ?? '-' }}</td>
                            <td>
                                @if($p->is_koordinator)
                                    <span class="badge" style="background: rgba(245,158,11,0.2); color: #fbbf24;">Koordinator</span>
                                @else
                                    <span style="color: #64748b; font-size: 0.75rem;">Anggota</span>
                                @endif
                            </td>
                            <td>
                                @if($p->instagram)
                                    <a href="https://instagram.com/{{ ltrim($p->instagram, '@') }}" target="_blank" style="color: #f472b6; font-size: 0.8rem;">
                                        {{ '@' . ltrim($p->instagram, '@') }}
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $p->urutan }}</td>
                            <td style="text-align: right;">
                                <div style="display: inline-flex; gap: 0.4rem;">
                                    <a href="{{ route('struktur.edit', $p) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('struktur.destroy', $p) }}" method="POST" onsubmit="return confirm('Hapus pengurus ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach
    </div>
</x-app-layout>
