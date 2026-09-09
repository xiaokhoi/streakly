<?php

namespace App\Http\Controllers;

use App\Models\CheckIn;
use App\Models\XpEvent;
use Illuminate\Http\Request;

class RecapController extends Controller
{
    public function show(Request $request)
    {
        $user   = $request->user();
        $start  = now()->subWeek()->startOfWeek();  // Senin minggu lalu
        $end    = now()->subWeek()->endOfWeek();    // Minggu minggu lalu

        // ===== STATISTIK CHECK-IN =====
        $checkinDays = CheckIn::where('user_id', $user->id)
            ->whereBetween('checked_at', [$start, $end])
            ->selectRaw('DATE(checked_at) as day')
            ->distinct()
            ->pluck('day')
            ->count();

        // ===== XP MINGGUAN =====
        $weeklyXp = XpEvent::where('user_id', $user->id)
            ->whereBetween('created_at', [$start, $end])
            ->sum('amount');

                // ===== HABIT PALING SERING DILAKUKAN =====
        // ⚠️ di JOIN, kolom wajib disebut eksplisit: check_ins.user_id, dst.
        // karena habits JUGA punya kolom user_id -> kalau gak disebut, SQL bingung (ambiguous)
        $topHabit = CheckIn::where('check_ins.user_id', $user->id)
            ->whereBetween('check_ins.checked_at', [$start, $end])
            ->whereNotNull('check_ins.habit_id')
            ->join('habits', 'habits.id', '=', 'check_ins.habit_id')
            ->selectRaw('habits.name, COUNT(*) as total')
            ->groupBy('habits.name')
            ->orderByDesc('total')
            ->first();

        // ===== TIME CAPSULE PILIHAN =====
        $memory = CheckIn::where('user_id', $user->id)
            ->whereBetween('checked_at', [$start, $end])
            ->whereNotNull('note')
            ->where('note', '!=', '')
            ->inRandomOrder()
            ->first();

        return view('recap.show', [
            'checkinDays' => $checkinDays,
            'weeklyXp'    => $weeklyXp,
            'topHabit'    => $topHabit,
            'memory'      => $memory,
            'start'       => $start,
            'end'         => $end,
        ]);
    }
}