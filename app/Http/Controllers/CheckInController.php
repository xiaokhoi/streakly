<?php

namespace App\Http\Controllers;

use App\Services\StreakService;
use Illuminate\Http\Request;

class CheckInController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'note' => 'nullable|string|max:140',
        ]);

        $milestone = StreakService::checkIn($request->user(), $request->note);

        return redirect()->route('dashboard')->with('milestone', $milestone);
    }

    public function recover(Request $request)
    {
        StreakService::recover($request->user());

        return redirect()->route('dashboard');
    }

    public function hardDay(Request $request)
    {
        $ok = StreakService::hardDay($request->user());

        return redirect()->route('dashboard')->with(
            $ok ? 'hardDayDone' : 'hardDayFailed',
            true
        );
    }
}