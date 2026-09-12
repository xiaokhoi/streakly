<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
        public function edit(Request $request): View
    {
        $user = $request->user();

        $badges = Badge::orderBy('required_streak')->get();
        $earnedIds = $user->badges->pluck('id')->toArray();

        // ===== HEATMAP: hari-hari aktif 15 minggu terakhir =====
        $activeDays = \App\Models\CheckIn::where('user_id', $user->id)
            ->where('checked_at', '>=', now()->subDays(104)->startOfDay())
            ->selectRaw('DATE(checked_at) as day')
            ->distinct()
            ->pluck('day')
            ->flip(); // di-flip biar lookup $activeDays->has($date) super cepet

        return view('users.profile', [
            'user'          => $user,
            'badges'        => $badges,
            'earnedIds'     => $earnedIds,
            'habitsCount'   => $user->habits()->count(),
            'activeDays'    => $activeDays,
            'activeCount'   => $activeDays->count(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $user->fill($request->validated());

        $request->validate([
            'avatar' => 'nullable|in:sun,cat,robot,ghost,panda,alien',
        ]);

        if ($request->filled('avatar')) {
            $user->avatar = $request->avatar;
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        auth()->logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}