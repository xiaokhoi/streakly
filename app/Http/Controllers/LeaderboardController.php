<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaderboardController extends Controller
{
    public function index(Request $request)
    {
        $start = now()->startOfWeek();
        $end   = now()->endOfWeek();

                $ranked = User::select(
                'users.id',
                'users.name',
                'users.level',
                'users.badge_id',
                'users.avatar',
                DB::raw('SUM(xp_events.amount) as weekly_xp')
            )
            ->join('xp_events', 'xp_events.user_id', '=', 'users.id')
            ->whereBetween('xp_events.created_at', [$start, $end])
            ->groupBy('users.id', 'users.name', 'users.level', 'users.badge_id')
            ->get()
            ->sortByDesc('weekly_xp')
            ->values();

        $myPosition = $ranked->search(fn ($u) => $u->id === $request->user()->id);

        return view('leaderboard.index', [
            'top'        => $ranked->take(10),
            'myPosition' => $myPosition,           // index mulai 0, atau false
            'myXp'       => $myPosition !== false ? $ranked[$myPosition]->weekly_xp : 0,
            'total'      => $ranked->count(),
        ]);
    }
}