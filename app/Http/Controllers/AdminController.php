<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    public function index()
    {
        Gate::authorize('admin');

        $avatars = collect(glob(public_path('avatars/avatar-*.png')))
            ->map(fn ($path) => basename($path))
            ->sort()
            ->values();

        return view('admin.avatars', ['avatars' => $avatars]);
    }

    public function storeAvatar(Request $request)
    {
        Gate::authorize('admin');

        $request->validate([
            'avatar' => 'required|image|mimes:png|max:2048', // png, maks 2MB
        ]);

        // cari nomor berikutnya (avatar-00, avatar-01, ... -> 20, 21, dst)
        $existing = collect(glob(public_path('avatars/avatar-*.png')))
            ->map(fn ($p) => (int) str_replace(['avatar-', '.png'], '', basename($p)))
            ->max();

        $next = $existing + 1;

        // simpan file yang di-upload langsung ke folder avatars
        $request->file('avatar')->move(
            public_path('avatars'),
            sprintf('avatar-%02d.png', $next)
        );

        return back()->with('uploaded', sprintf('avatar-%02d.png', $next));
    }

    public function destroyAvatar(string $filename)
    {
        Gate::authorize('admin');

        // keamanan: cuma boleh hapus file avatar-XX.png, gak boleh path lain
        if (!preg_match('/^avatar-\d{2}\.png$/', $filename)) {
            abort(400);
        }

        $path = public_path('avatars/' . $filename);
        if (file_exists($path)) {
            unlink($path);
        }

        return back()->with('deleted', $filename);
    }
}