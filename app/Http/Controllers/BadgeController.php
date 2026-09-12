<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use Illuminate\Http\Request;

class BadgeController extends Controller
{
    public function index(Request $request)
    {
        $badges = Badge::orderBy('required_streak')->get();

        $earnedIds = $request->user()->badges->pluck('id')->toArray();

        return view('progress.badges', [
            'badges'    => $badges,
            'earnedIds' => $earnedIds,
        ]);
    }

    public function wear(Request $request, Badge $badge)
    {
        // cuma boleh nunggang badge yang udah didapet
        abort_unless($request->user()->badges->contains($badge->id), 403);

        $request->user()->update(['badge_id' => $badge->id]);

        return redirect()->route('progress.badges')->with('worn', $badge->name);
    }

    public function remove(Request $request)
    {
        $request->user()->update(['badge_id' => null]);

        return redirect()->route('progress.badges');
    }
}