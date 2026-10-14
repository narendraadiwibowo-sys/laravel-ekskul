<?php

namespace App\Http\Controllers;

use App\Models\ArsipDrive;
use Illuminate\Http\Request;

class ArsipDriveController extends Controller
{
    public function index(Request $request)
    {
        $query = ArsipDrive::with('pembuat');

        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        if ($request->filled('status_tayang')) {
            $query->where('status_tayang', $request->status_tayang);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
            });
        }

        $items = $query->latest('tanggal_event')->latest('created_at')->paginate(12);

        // Stats PDD
        $totalDrive = ArsipDrive::where('tipe', 'drive')->count();
        $totalPamflet = ArsipDrive::where('tipe', 'pamflet')->count();
        $pamfletH1 = ArsipDrive::where('tipe', 'pamflet')
            ->where('status_tayang', 'siap_tayang')
            ->whereDate('tanggal_tayang', '<=', now()->addDay()->toDateString())
            ->get();

        return view('drive.index', compact('items', 'totalDrive', 'totalPamflet', 'pamfletH1'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'tipe' => 'required|in:drive,pamflet',
            'deskripsi' => 'nullable|string',
            'link_drive' => 'nullable|url|max:500',
            'tanggal_event' => 'nullable|date',
            'tanggal_tayang' => 'nullable|date',
            'status_tayang' => 'nullable|in:draft,siap_tayang,sudah_tayang',
            'thumbnail' => 'nullable|file|mimes:jpeg,png,jpg|max:3072',
        ]);

        if (empty($data['link_drive'])) {
            $data['link_drive'] = '#';
        }

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $cloudinaryUrl = \App\Services\CloudinaryService::upload($file, 'ekskul/thumbnails');

            if ($cloudinaryUrl) {
                $data['thumbnail'] = $cloudinaryUrl;
            } else {
                $dir = public_path('images/thumbnails');
                if (!file_exists($dir)) {
                    @mkdir($dir, 0755, true);
                }
                $nama = time() . '_' . str($data['judul'])->slug() . '.' . $file->getClientOriginalExtension();
                $file->move($dir, $nama);
                $data['thumbnail'] = $nama;
            }
        }

        $data['dibuat_oleh'] = auth()->id();
        ArsipDrive::create($data);

        $msg = $data['tipe'] === 'pamflet' 
            ? 'Desain Pamflet H-1 berhasil disimpan ke arsip PDD.' 
            : 'Link folder Google Drive berhasil diarsipkan.';

        return redirect()->route('drive.index')->with('success', $msg);
    }

    public function update(Request $request, ArsipDrive $drive)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'tipe' => 'required|in:drive,pamflet',
            'deskripsi' => 'nullable|string',
            'link_drive' => 'nullable|url|max:500',
            'tanggal_event' => 'nullable|date',
            'tanggal_tayang' => 'nullable|date',
            'status_tayang' => 'nullable|in:draft,siap_tayang,sudah_tayang',
            'thumbnail' => 'nullable|file|mimes:jpeg,png,jpg|max:3072',
        ]);

        if (empty($data['link_drive'])) {
            $data['link_drive'] = $drive->link_drive ?: '#';
        }

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $cloudinaryUrl = \App\Services\CloudinaryService::upload($file, 'ekskul/thumbnails');

            if ($cloudinaryUrl) {
                $data['thumbnail'] = $cloudinaryUrl;
            } else {
                $dir = public_path('images/thumbnails');
                if (!file_exists($dir)) {
                    @mkdir($dir, 0755, true);
                }
                if ($drive->thumbnail && !str_starts_with($drive->thumbnail, 'http') && file_exists($dir . '/' . $drive->thumbnail)) {
                    @unlink($dir . '/' . $drive->thumbnail);
                }
                $nama = time() . '_' . str($data['judul'])->slug() . '.' . $file->getClientOriginalExtension();
                $file->move($dir, $nama);
                $data['thumbnail'] = $nama;
            }
        }

        $drive->update($data);

        return redirect()->route('drive.index')->with('success', 'Data arsip PDD berhasil diperbarui.');
    }

    public function destroy(ArsipDrive $drive)
    {
        if ($drive->thumbnail && file_exists(public_path('images/thumbnails/' . $drive->thumbnail))) {
            @unlink(public_path('images/thumbnails/' . $drive->thumbnail));
        }
        $drive->delete();

        return redirect()->route('drive.index')->with('success', 'Arsip berhasil dihapus.');
    }
}
