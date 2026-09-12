<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CommunityPost;
use App\Models\PostComment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    /** Dashboard admin: tab users */
    public function users()
    {
        Gate::authorize('admin');

        $users = User::withCount(['habits', 'checkIns'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.users', ['users' => $users]);
    }

    /** Hapus user (selain diri sendiri) */
    public function destroyUser(Request $request, User $user)
    {
        Gate::authorize('admin');

        abort_if($user->id === $request->user()->id, 422, 'Gak bisa hapus diri sendiri dari sini — pakai Pengaturan.');

        $user->delete();

        return back()->with('userDeleted', $user->name);
    }

    /** Tab komunitas: semua post terbaru */
    public function posts()
    {
        Gate::authorize('admin');

        $posts = CommunityPost::with(['user', 'category'])
            ->withCount('comments')
            ->latest()
            ->take(50)
            ->get();

        return view('admin.posts', ['posts' => $posts]);
    }

    /** Hapus post siapapun (moderasi) */
    public function destroyPost(Request $request, CommunityPost $post)
    {
        Gate::authorize('admin');

        $post->delete();

        return back()->with('postDeleted', true);
    }

    /** Hapus komentar siapapun (moderasi) */
    public function destroyComment(Request $request, PostComment $comment)
    {
        Gate::authorize('admin');

        $comment->delete();

        return back()->with('commentDeleted', true);
    }

    /** Tab kategori */
    public function categories()
    {
        Gate::authorize('admin');

        $categories = Category::withCount('habits')->orderBy('name')->get();

        return view('admin.categories', ['categories' => $categories]);
    }
    
        public function settings()
    {
        Gate::authorize('admin');

        $values = [];
        foreach (\App\Services\GameSettings::DEFS as $key => [$label, $default, $type]) {
            $values[$key] = \App\Models\Setting::get($key, $default);
        }

        return view('admin.settings', ['values' => $values]);
    }

    public function storeSettings(Request $request)
    {
        Gate::authorize('admin');

        foreach (\App\Services\GameSettings::DEFS as $key => [$label, $default, $type]) {
            $rules = match ($type) {
                'int'  => 'required|integer|min:0',
                'list' => 'required|string|regex:/^[0-9]+(,[0-9]+)*$/',
                default => 'required|string',
            };

            $request->validate([$key => $rules], [$key . '.regex' => "Format $label harus angka dipisah koma (contoh: 1,7,30)"]);

            \App\Models\Setting::set($key, $request->input($key));
        }

        return back()->with('settingsSaved', true);
    }

    public function storeCategory(Request $request)
    {
        Gate::authorize('admin');

        $request->validate([
            'name' => 'required|string|max:30|unique:categories,name',
            'icon' => 'required|string|max:4',
        ]);

        Category::create($request->only('name', 'icon'));

        return back()->with('categoryAdded', true);
    }
    
        /** Antrean laporan */
    public function reports()
    {
        Gate::authorize('admin');

        $reports = Report::with(['reporter', 'post', 'comment.user'])
            ->latest()
            ->get();

        return view('admin.reports', ['reports' => $reports]);
    }

    /** Abaikan laporan (konten dianggap oke) */
    public function dismissReport(Report $report)
    {
        Gate::authorize('admin');

        $report->delete();

        return back()->with('dismissed', true);
    }

    /** Terima laporan: hapus konten yang dilaporkan + hapus laporannya */
    public function resolveReport(Report $report)
    {
        Gate::authorize('admin');

        if ($report->post) {
            $report->post->delete();
        }
        if ($report->comment) {
            $report->comment->delete();
        }

        $report->delete();

        return back()->with('resolved', true);
    }

    // ===== AVATAR (yang kemarin, tetap di sini) =====

    public function avatars()
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
            'avatar' => 'required|image|mimes:png|max:2048',
        ]);

        $existing = collect(glob(public_path('avatars/avatar-*.png')))
            ->map(fn ($p) => (int) str_replace(['avatar-', '.png'], '', basename($p)))
            ->max();

        $next = $existing + 1;

        $request->file('avatar')->move(
            public_path('avatars'),
            sprintf('avatar-%02d.png', $next)
        );

        return back()->with('uploaded', sprintf('avatar-%02d.png', $next));
    }

    public function destroyAvatar(string $filename)
    {
        Gate::authorize('admin');

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