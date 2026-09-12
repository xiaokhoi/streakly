<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CheckIn;
use App\Services\StreakService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        StreakService::refresh($user);

        $user->load('pet');

        $checkedHabitIds = CheckIn::where('user_id', $user->id)
            ->whereDate('checked_at', today())
            ->whereNotNull('habit_id')
            ->pluck('habit_id')
            ->toArray();

        // ===== KALENDER STREAK MINGGUAN (Senin-Minggu minggu ini) =====
        $weekStart = now()->startOfWeek();

        $activeDays = CheckIn::where('user_id', $user->id)
            ->whereBetween('checked_at', [$weekStart->copy()->startOfDay(), now()])
            ->selectRaw('DATE(checked_at) as day')
            ->distinct()
            ->pluck('day')
            ->flip();

        $dayLetters = ['M', 'S', 'S', 'R', 'K', 'J', 'S']; // Senin -> Minggu

        $weekDays = collect();
        for ($i = 0; $i < 7; $i++) {
            $d = $weekStart->copy()->addDays($i);
            $weekDays->push([
                'date'    => $d,
                'letter'  => $dayLetters[$i],
                'active'  => $activeDays->has($d->toDateString()),
                'isToday' => $d->isToday(),
            ]);
        }

        // ===== STATISTIK HABIT BULAN INI (ala pantau waktu bermain) =====
        $habitCounts = CheckIn::where('user_id', $user->id)
            ->whereBetween('checked_at', [now()->startOfMonth(), now()])
            ->whereNotNull('habit_id')
            ->selectRaw('habit_id, COUNT(*) as total')
            ->groupBy('habit_id')
            ->pluck('total', 'habit_id');

        $habits = $user->habits()->latest()->get();

        $monthTotal = $habitCounts->sum();

        $maxCount = $habitCounts->max() ?: 1;

        $habits->each(function ($habit) use ($habitCounts, $maxCount) {
            $habit->month_count = $habitCounts->get($habit->id, 0);
            $habit->bar_width = round(($habit->month_count / $maxCount) * 100);
        });

        $phrases = [
            'Blink! Senang liatmu 👋',
            'Jangan lupa check-in ya!',
            'Streak lu keren banget 🔥',
            'Aku kangen... makan 🥺',
            'Hari ini semangat ya!',
        ];

        return view('dashboard', [
            'pet'             => $user->pet,
            'habits'          => $habits,
            'checkedHabitIds' => $checkedHabitIds,
            'checkedToday'    => $user->last_check_in && Carbon::parse($user->last_check_in)->isToday(),
            'phrase'          => $phrases[now()->dayOfYear % count($phrases)],
            'milestone'       => session('milestone'),
            'categories'      => Category::orderBy('name')->get(),
            'weekDays'        => $weekDays,
            'monthTotal'      => $monthTotal,
        ]);
    }
}