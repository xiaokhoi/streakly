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
        $badges = Badge::orderBy('required_streak')->get();
        $earnedIds = $request->user()->badges->pluck('id')->toArray();

        return view('profile.edit', [
            'user'          => $request->user(),
            'badges'        => $badges,
            'earnedIds'     => $earnedIds,
            'habitsCount'   => $request->user()->habits()->count(),
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