<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $user = $request->user();

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $cloudinaryUrl = \App\Services\CloudinaryService::upload($file, 'ekskul/users');

            if ($cloudinaryUrl) {
                $data['foto'] = $cloudinaryUrl;
            } else {
                // If Cloudinary fails, try local only if directory is writable (e.g. local Laragon)
                $dir = public_path('images/users');
                try {
                    if (!file_exists($dir)) {
                        @mkdir($dir, 0755, true);
                    }
                    if ($user->foto && !str_starts_with($user->foto, 'http') && file_exists($dir . '/' . $user->foto)) {
                        @unlink($dir . '/' . $user->foto);
                    }
                    $nama = time() . '_' . str($user->name)->slug() . '.' . $file->getClientOriginalExtension();
                    $file->move($dir, $nama);
                    $data['foto'] = $nama;
                } catch (\Throwable $e) {
                    return back()->withErrors(['foto' => 'Gagal mengunggah foto ke Cloud Storage. Pastikan format gambar valid (JPG/PNG).'])->withInput();
                }
            }
        }

        $user->fill($data);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
