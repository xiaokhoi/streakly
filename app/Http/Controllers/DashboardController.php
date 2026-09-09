<?php

namespace App\Http\Controllers;

use App\Models\CheckIn;
use App\Models\Category;
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

        $phrases = [
            'Blink! Senang liatmu 👋',
            'Jangan lupa check-in ya!',
            'Streak lu keren banget 🔥',
            'Aku kangen... makan 🥺',
            'Hari ini semangat ya!',
        ];

                return view('dashboard', [
            'pet'             => $user->pet,
            'habits'          => $user->habits()->latest()->get(),
            'checkedHabitIds' => $checkedHabitIds,
            'checkedToday'    => $user->last_check_in && Carbon::parse($user->last_check_in)->isToday(),
            'phrase'          => $phrases[now()->dayOfYear % count($phrases)],
            'milestone'       => session('milestone'),
            'categories'      => Category::orderBy('name')->get(), // <- tambahan baru
        ]);
    }
}